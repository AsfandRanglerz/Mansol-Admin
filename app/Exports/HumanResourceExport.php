<?php

namespace App\Exports;

use App\Models\HumanResource;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;

class HumanResourceExport implements FromView
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        // Convert filters array to collection for easy access
        $request = collect($this->filters);

        $query = HumanResource::with(['Crafts', 'SubCrafts', 'hrSteps', 'jobHistory', 'nominates.project'])->latest();

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

        return view('admin.humanresouce.export', compact('data'));
    }
}
