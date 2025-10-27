<?php

namespace App\Exports;

use App\Models\HumanResource;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class HumanResourceExport implements FromCollection, WithHeadings, WithDrawings, WithEvents
{
    protected $filters;
    protected $data; // store collection for drawings

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Column B width for images
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(15);

                // Adjust row heights for all data rows
                $highestRow = $event->sheet->getHighestRow();
                for ($i = 2; $i <= $highestRow; $i++) {
                    $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(65);
                }

                // Optional: make headings bold
                $event->sheet->getStyle('A1:Z1')->getFont()->setBold(true);
            },
        ];
    }

    public function collection()
    {
        $request = collect($this->filters);

        $query = HumanResource::with([
            'Crafts',
            'SubCrafts',
            'hrSteps' => function($q) {
                $q->where('step_number', 4)->where('file_type', 'photo');
            },
            'jobHistory',
            'nominates.project'
        ])->latest();

   // ==========================
        // COMPANY / PROJECT / DEMAND / CRAFT FILTERS
        // ==========================
        if (
            !empty($request->get('company_id')) ||
            !empty($request->get('project_id')) ||
            !empty($request->get('demand_id')) ||
            !empty($request->get('craft_id'))
        ) {
            $query->whereHas('nominates', function ($q) use ($request) {
                if (!empty($request->get('project_id'))) {
                    $q->where('project_id', $request->get('project_id'));
                }
                if (!empty($request->get('demand_id'))) {
                    $q->where('demand_id', $request->get('demand_id'));
                }
                if (!empty($request->get('company_id'))) {
                    $q->whereHas('project', function ($subQ) use ($request) {
                        $subQ->where('company_id', $request->get('company_id'));
                    });
                }
                if (!empty($request->get('craft_id'))) {
                    $q->where('craft_id', $request->get('craft_id'));
                }
            });
        }

        // ==========================
        // HR STEP RELATED FILTERS
        // ==========================
        if (
            !empty($request->get('medically_fit')) ||
            !empty($request->get('visa_expiry')) ||
            !empty($request->get('visa_type')) ||
            !empty($request->get('flight_date')) ||
            !empty($request->get('cnic_taken')) ||
            !empty($request->get('passport_taken'))
        ) {
            $query->whereHas('hrSteps', function ($q) use ($request) {
                if (!empty($request->get('medically_fit'))) {
                    $q->where('step_number', 6)->where('medically_fit', $request->get('medically_fit'));
                }
                if (!empty($request->get('visa_type'))) {
                    $q->where('step_number', 6)->where('visa_type', $request->get('visa_type'));
                }
                if (!empty($request->get('flight_date'))) {
                    $date = Carbon::parse($request->get('flight_date'))->format('Y-m-d');
                    $q->where('step_number', 6)->whereDate('flight_date', $date);
                }
                if (!empty($request->get('visa_expiry'))) {
                    $value = $request->get('visa_expiry');
                    if ($value == 'Valid') {
                        $q->where('step_number', 6)->whereDate('visa_expiry_date', '>=', now());
                    } elseif ($value == 'Expired') {
                        $q->where('step_number', 6)->whereDate('visa_expiry_date', '<', now());
                    }
                }

                if (!empty($request->get('cnic_taken'))) {
                    $value = $request->get('cnic_taken');
                    if ($value == 'Taken') {
                        $q->where('step_number', 3)->where('file_type', 'cnic front')
                            ->whereNotNull('file_name');
                    } elseif ($value == 'Not Taken') {
                        $q->where('step_number', 3)->where('file_type', 'cnic front')
                            ->whereNull('file_name');
                    }
                }

                if (!empty($request->get('passport_taken'))) {
                    $value = $request->get('passport_taken');
                    if ($value == 'Taken') {
                        $q->where('step_number', 2)->where('file_type', 'passport front')
                            ->whereNotNull('file_name');
                    } elseif ($value == 'Not Taken') {
                        $q->where('step_number', 2)->where('file_type', 'passport front')
                            ->whereNull('file_name');
                    }
                }
            });
        }

        // ==========================
        // OTHER FILTERS
        // ==========================
        if (!empty($request->get('refference'))) {
            $query->where('refference', $request->get('refference'));
        }

        if (!empty($request->get('interview_location'))) {
            $query->where('city_of_interview', $request->get('interview_location'));
        }

        if (!empty($request->get('mobilized'))) {
            $value = $request->get('mobilized');
            $query->whereHas('jobHistory', function ($q) use ($value) {
                if ($value == 'Mobilized') {
                    $q->whereNotNull('mob_date')->where('mob_date', '!=', '');
                } elseif ($value == 'Not Yet Mobilized') {
                    $q->whereNull('mob_date');
                }
            });
        }

        if (!empty($request->get('cnic_expiry'))) {
            $value = $request->get('cnic_expiry');
            if ($value == 'Valid') {
                $query->whereDate('cnic_expiry_date', '>=', now());
            } elseif ($value == 'Expired') {
                $query->whereDate('cnic_expiry_date', '<', now());
            }
        }

        if (!empty($request->get('blood_group'))) {
            $query->where('blood_group', $request->get('blood_group'));
        }

        if (!empty($request->get('religion'))) {
            $query->where('religion', $request->get('religion'));
        }

        if (!empty($request->get('approvals'))) {
            $query->where('approvals', $request->get('approvals'));
        }

        if (!empty($request->get('passport_expiry'))) {
            $value = $request->get('passport_expiry');
            if ($value == 'Valid') {
                $query->whereDate('doe', '>=', now());
            } elseif ($value == 'Expired') {
                $query->whereDate('doe', '<', now());
            }
        }

        // ==========================
        // DATE RANGE FILTER
        // ==========================
        $dateFrom = $request->get('date_from');
        $dateTo   = $request->get('date_to');

        if ($dateFrom && $dateTo) {
            $query->whereBetween('application_date', [
                Carbon::parse($dateFrom)->startOfDay(),
                Carbon::parse($dateTo)->endOfDay()
            ]);
        } elseif ($dateFrom) {
            $query->whereDate('application_date', '>=', Carbon::parse($dateFrom)->format('Y-m-d'));
        } elseif ($dateTo) {
            $query->whereDate('application_date', '<=', Carbon::parse($dateTo)->format('Y-m-d'));
        }


        $data = $query->get();

        // Map collection and store photo path for WithDrawings
        $this->data = $data->map(function($hr) {
            $photoStep = $hr->hrSteps->first();
            $photo_path = $photoStep ? public_path($photoStep->file_name) : null;
            $clean = str_replace('public/public/', 'public/', $photo_path);
            $hr->photo_path = $clean;
            return [
                $hr->id ?? '',
                $hr->photo_path, // temporary, drawings will use this
                $hr->name ?? '',
                $hr->email ?? '',
                $hr->cnic ?? '',
                $hr->application_date ?? '',
                $hr->craft ?? '',
                $hr->sub_craft ?? '',
                $hr->approvals_no ?? '',
                $hr->city_of_interview ?? '',
                $hr->so ?? '',
                $hr->mother_name ?? '',
                $hr->dob ?? '',
                $hr->cnic_expiry_date ?? '',
                $hr->passport_issue_date ?? '',
                $hr->passport_expiry_date ?? '',
                $hr->passport_no ?? '',
                $hr->next_of_kin ?? '',
                $hr->relation ?? '',
                $hr->kin_cnic ?? '',
                $hr->shoe_size ?? '',
                $hr->cover_size ?? '',
                $hr->academic_qualification ?? '',
                $hr->technical_qualification ?? '',
                $hr->experience_local ?? '',
                $hr->experience_gulf ?? '',
                $hr->district_domicile ?? '',
                $hr->present_address ?? '',
                $hr->present_address_phone ?? '',
                $hr->present_address_mobile ?? '',
                $hr->permanent_address ?? '',
                $hr->present_address_city ?? '',
                $hr->permanent_address_phone ?? '',
                $hr->permanent_address_mobile ?? '',
                $hr->gender ?? '',
                $hr->blood_group ?? '',
                $hr->religion ?? '',
                $hr->permanent_address_city ?? '',
                $hr->permanent_address_province ?? '',
                $hr->citizenship ?? '',
                $hr->reference ?? '',
                $hr->performance_awarded ?? '',
                $hr->min_salary ?? '',
                $hr->visa_type ?? '',
                $hr->visa_status ?? '',
                $hr->visa_issue_date ?? '',
                $hr->visa_expiry_date ?? '',
                $hr->flight_date ?? '',
                $hr->flight_route ?? '',
                $hr->cnic_taken_status ?? '',
                $hr->passport_taken_status ?? '',
                $hr->comment ?? '',
                $hr->status ?? '',
            ];
        });

        return $this->data;
    }

    public function headings(): array
    {
        return [
            'Id No.',
            'Passport Image',
            'Name',
            'Email',
            'CNIC',
            'Application Date',
            'Application for Post Craft',
            'Sub-Craft',
            'Approvals #',
            'City Of Interview',
            'S/O',
            'Mother Name',
            'Date Of Birth',
            'CNIC Expiry Date',
            'Date Of Issue (Passport)',
            'Date Of Expiry (Passport)',
            'Passport #',
            'Next Of Kin',
            'Relation',
            'Kin CNIC',
            'Shoe Size',
            'Cover Size',
            'Academic Qualification',
            'Technical Qualification',
            'Experience (Local)',
            'Experience (Gulf)',
            'District Of Domicile',
            'Present Address',
            'Present Address Phone',
            'Present Address Mobile',
            'Permanent Address',
            'Present Address City',
            'Permanent Address Phone',
            'Permanent Address Mobile',
            'Gender',
            'Blood Group',
            'Religion',
            'Permanent Address City',
            'Permanent Address Province',
            'Citizenship',
            'Reference',
            'Performance-Appraisal Awarded %',
            'Min Acceptable Salary',
            'Visa Type',
            'Visa Status',
            'Visa Issue Date',
            'Visa Expiry Date',
            'Flight Date',
            'Flight Route',
            'CNIC Taken Status',
            'Passport Taken Status',
            'Comment',
            'Status',
        ];
    }

    public function drawings()
{
    $drawings = [];
    $rowIndex = 2; // Start from row 2 (row 1 is heading)

    foreach ($this->data as $row) {
        $photoPath = $row[1]; // Passport Image column
        if ($photoPath && file_exists($photoPath)) {
            $photoPath1 = str_replace('public/public/', 'public/', $photoPath);
            $drawing = new Drawing();
            $drawing->setName('Passport Photo');
            $drawing->setDescription('Passport Photo');
            $drawing->setPath($photoPath1);

            // Set dimensions (adjust as needed)
            $drawing->setHeight(80);  // Increase height for visibility
            $drawing->setWidth(60);

            // Place in column B + correct row
            $drawing->setCoordinates('B' . $rowIndex);

            // Optional: Set image offset (centering)
            $drawing->setOffsetX(10);
            $drawing->setOffsetY(5);

            $drawings[] = $drawing;
        }
        $rowIndex++;
    }
    return $drawings;}
}
