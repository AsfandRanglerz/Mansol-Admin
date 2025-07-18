<?php

namespace App\Http\Controllers\Admin;

use App\Models\HrStep;
use App\Models\JobHistory;
use App\Models\City;
use App\Models\Distric;
use App\Models\Province;
use App\Models\Country;
use App\Models\Demand;
use App\Models\Lab;
use App\Models\Company;
use App\Models\Project;
use App\Models\Nominate;
use App\Models\SubCraft;
use App\Models\MainCraft;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\QueryException;
use Facade\Ignition\QueryRecorder\Query;
use App\Mail\HumanResourceUserLoginPassword;
use Carbon\Carbon;

class HumanResourceController extends Controller
{
    // public function index(Request $request)
    //     {
    //             // Static dropdown data 
    //             $companies = Company::where('is_active', '=', '1')->orderBy('name', 'asc')->get();
    //             $projects = Project::where('is_active', '=', '1')->orderBy('project_name', 'asc')->get();

    //             $demands = Demand::where('project_id', $request->project_id)->where('is_active', '=', '1')->orderBy('manpower', 'asc')->get();
    //             // Append concatenated name to each demand
    //             $demands->transform(function ($demand) {
    //                 $demand->full_name = $demand->manpower . ' - ' . $demand->craft?->name;
    //                 return $demand;
    //             });


    //             // Check if any filter is present
    //             $hasFilters = $request->filled('company_id') ||
    //                         $request->filled('project_id') ||
    //                         $request->filled('demand_id') ||
    //                         $request->filled('medically_fit') ||
    //                         $request->filled('visa_expiry') ||
    //                         $request->filled('cnic_expiry') ||
    //                         $request->filled('passport_expiry');

    //             if ($hasFilters) {
    //                 // Base query
    //                 $query = HumanResource::with(['Crafts', 'SubCrafts', 'hrSteps'])
    //                     ->orderByRaw("FIELD(status, 1, 3, 2, 0)")
    //                     ->latest();

    //                 // Filters via 'nominates' relation
    //                 if (
    //                     $request->filled('company_id') ||
    //                     $request->filled('project_id') ||
    //                     $request->filled('demand_id')
    //                 ) {
    //                     $query->whereHas('nominates', function ($q) use ($request) {
    //                         // Filter by project
    //                         if ($request->filled('project_id')) {
    //                             $q->where('project_id', $request->project_id);
    //                         }
    //                         // Filter by demand
    //                         if ($request->filled('demand_id')) {
    //                             $q->where('demand_id', $request->demand_id);
    //                         }
    //                         // Filter by company through project
    //                         if ($request->filled('company_id')) {
    //                             $q->whereHas('project', function ($subQ) use ($request) {
    //                                 $subQ->where('company_id', $request->company_id);
    //                             });
    //                         }
    //                     });
    //                 }

    //                 // Filters via 'hrSteps' relation
    //                 if (
    //                     $request->filled('medically_fit') ||
    //                     $request->filled('visa_expiry')
    //                 ) {
    //                     $query->whereHas('hrSteps', function ($q) use ($request) {
    //                         if ($request->filled('medically_fit')) {
    //                             $q->where('step_number',6)->where('medically_fit', $request->medically_fit);
    //                         }
    //                         if ($request->filled('visa_expiry')) {
    //                             $value = $request->input('passport_expiry');
    //                             if($value == 'Valid'){
    //                                 $q->where('step_number',6)->whereDate('visa_expiry_date', '>=', now());
    //                             } elseif($value == 'Expired'){
    //                                 $q->where('step_number',6)->whereDate('visa_expiry_date', '<', now());
    //                             }
    //                         }
    //                     });
    //                 }

    //                 if ($request->filled('cnic_expiry')) {
    //                     $value = $request->input('cnic_expiry');
    //                     if($value == 'Valid'){
    //                         $query->whereDate('cnic_expiry_date', '>=', now());
    //                     } elseif($value == 'Expired'){
    //                         $query->whereDate('cnic_expiry_date', '<', now());
    //                     }
    //                 }

    //                 if ($request->filled('passport_expiry')) {
    //                     $value = $request->input('passport_expiry');
    //                     if($value == 'Valid'){
    //                         $query->whereDate('doe', '>=', now());
    //                     } elseif($value == 'Expired'){
    //                         $query->whereDate('doe', '<', now());
    //                     }
    //                 }

    //                 $HumanResources = $query->get();
    //                 $count = $query->whereIn('status', [1, 3, 2, 0])->count();
    //             } else {
    //                 // No filters: get all HumanResources and count
    //                 $HumanResources = HumanResource::with(['Crafts', 'SubCrafts', 'hrSteps'])
    //                     ->orderByRaw("FIELD(status, 1, 3, 2, 0)")
    //                     ->latest()
    //                     ->get();
    //                 $count = HumanResource::whereIn('status', [1, 3, 2, 0])->count();
    //             }

    //             $medically_fit = $request->input('medically_fit') ? $request->input('medically_fit') : null;
    //             return view('admin.humanresouce.index', compact(
    //                 'HumanResources',
    //                 'companies',
    //                 'projects',
    //                 'demands',
    //                 'count',
    //                 'medically_fit'
    //             ));
    //     }


    public function ajax(Request $request)
    {
        $columns = [
            'registration',
            'passport_photo',
            'id',
            'name',
            'email',
            'cnic',
            'application_date',
            'craft',
            'sub_craft',
            'approvals',
            'approvals_document',
            'son_of',
            'mother_name',
            'date_of_birth',
            'cnic_expiry_date',
            'doi',
            'doe',
            'passport',
            'next_of_kin',
            'relation',
            'kin_cnic',
            'shoe_size',
            'cover_size',
            'acdemic_qualification',
            'technical_qualification',
            'experience_local',
            'experience_gulf',
            'district_of_domicile',
            'present_address',
            'present_address_phone',
            'present_address_mobile',
            'permanent_address',
            'present_address_city',
            'permanent_address_phone',
            'permanent_address_mobile',
            'gender',
            'permanent_address_city',
            'permanent_address_province',
            'citizenship',
            'refference',
            'performance_appraisal',
            'min_salary',
            'comment',
            'status',
            'id',
            'visa_type',
            'visa_status',
            'visa_expiry_date',
            'visa_issue_date',
            'flight_route',
            'flight_date',
            'passport_taken_status',
            'cnic_taken_status',
            'blood_group',
            'religion',
            'interview_location'
        ];

        // Always get the total count (without filters)
        $totalData = HumanResource::count();

        $query = HumanResource::with(['Crafts', 'SubCrafts', 'hrSteps'])->latest();

        // Filtering
        if (
            $request->filled('company_id') ||
            $request->filled('project_id') ||
            $request->filled('demand_id') ||
            $request->filled('craft_id')
        ) {
            $query->whereHas('nominates', function ($q) use ($request) {
                if ($request->filled('project_id')) {
                    $q->where('project_id', $request->project_id);
                }
                if ($request->filled('demand_id')) {
                    $q->where('demand_id', $request->demand_id);
                }
                if ($request->filled('company_id') && $request->filled('project_id') && $request->filled('demand_id')) {
                    if ($request->filled('craft_id')) {
                        $q->where('craft_id', $request->craft_id);
                    }
                }
                if ($request->filled('company_id')) {
                    $q->whereHas('project', function ($subQ) use ($request) {
                        $subQ->where('company_id', $request->company_id);
                    });
                }
            });
        }

        if (
            $request->filled('medically_fit') ||
            $request->filled('visa_expiry') ||
            $request->filled('visa_type') ||
            $request->filled('flight_date') ||
            $request->filled('cnic_taken') ||
            $request->filled('passport_taken')
        ) {
            $query->whereHas('hrSteps', function ($q) use ($request) {
                if ($request->filled('medically_fit')) {
                    $q->where('step_number', 6)->where('medically_fit', $request->medically_fit);
                }
                if ($request->filled('visa_type')) {
                    $q->where('step_number', 6)->where('visa_type', $request->visa_type);
                }
                if ($request->filled('flight_date')) {
                    $date = Carbon::parse($request->flight_date)->format('Y-m-d');
                    $q->where('step_number', 6)->whereDate('flight_date', $date);
                    // return $date;
                }
                if ($request->filled('visa_expiry')) {
                    $value = $request->input('passport_expiry');
                    if ($value == 'Valid') {
                        $q->where('step_number', 6)->whereDate('visa_expiry_date', '>=', now());
                    } elseif ($value == 'Expired') {
                        $q->where('step_number', 6)->whereDate('visa_expiry_date', '<', now());
                    }
                }
                if ($request->filled('cnic_taken')) {
                    $value = $request->input('cnic_taken');
                    if ($value == 'Taken') {
                        $q->where('step_number', 3)->where('file_type', 'cnic front')
                            ->where('file_name', '!=', null);
                        // $q->where('step_number', 3)->where('file_type','cnic back')
                        // ->where('file_name', '!=', null);
                    } elseif ($value == 'Not Taken') {
                        $q->where('step_number', 3)->where('file_type', 'cnic front')
                            ->whereNull('file_name');
                        // $q->where('step_number', 3)->where('file_type','cnic back')
                        // ->whereNull('file_name');
                    }
                }
                if ($request->filled('passport_taken')) {
                    $value = $request->input('passport_taken');
                    if ($value == 'Taken') {
                        $q->where('step_number', 2)->where('file_type', 'passport front')
                            ->where('file_name', '!=', null);
                        // $q->where('step_number', 2)->where('file_type','passport back')
                        // ->where('file_name', '!=', null);
                        // $q->where('step_number', 2)->where('file_type','passport third image')
                        // ->where('file_name', '!=', null);
                    } elseif ($value == 'Not Taken') {
                        $q->where('step_number', 2)->where('file_type', 'passport front')
                            ->whereNull('file_name');
                        // $q->where('step_number', 2)->where('file_type','passport back')
                        // ->whereNull('file_name');
                        //  $q->where('step_number', 2)->where('file_type','passport third image')
                        // ->whereNull('file_name');
                    }
                }
            });
        }

        if ($request->filled('refference')) {
            $value = $request->input('refference');
            $query->where('refference', $value);
        }
        if ($request->filled('craft_id')) {
            $value = $request->input('craft_id');
            $query->where('craft_id', $value);
        }
        if ($request->filled('interview_location')) {
            $value = $request->input('interview_location');
            $query->where('city_of_interview', $value);
        }
        if ($request->filled('mobilized')) {
            $value = $request->input('mobilized');
            if ($value == 'Mobilized') {
                $query->whereHas('jobHistory', function ($q) {
                    $q->where('mob_date', '!=', null)
                        ->where('mob_date', '!=', '');
                });
            } elseif ($value == 'Not Yet Mobilized') {
                $query->whereHas('jobHistory', function ($q) {
                    $q->whereNull('mob_date');
                });
            }
        }
        if ($request->filled('cnic_expiry')) {
            $value = $request->input('cnic_expiry');
            if ($value == 'Valid') {
                $query->whereDate('cnic_expiry_date', '>=', now());
            } elseif ($value == 'Expired') {
                $query->whereDate('cnic_expiry_date', '<', now());
            }
        }
        if ($request->filled('blood_group')) {
            $value = $request->input('blood_group');
            $query->where('blood_group', $value);
        }

        if ($request->filled('religion')) {
            $value = $request->input('religion');
            $query->where('religion', $value);
        }
        if ($request->filled('approvals')) {
            $value = $request->input('approvals');
            $query->where('approvals', $value);
        }

        if ($request->filled('passport_expiry')) {
            $value = $request->input('passport_expiry');
            if ($value == 'Valid') {
                $query->whereDate('doe', '>=', now());
            } elseif ($value == 'Expired') {
                $query->whereDate('doe', '<', now());
            }
        }
        // Extract raw inputs once
        $dateFromRaw = $request->input('date_from');
        $dateToRaw   = $request->input('date_to');
        if ($dateFromRaw && $dateToRaw) {
            $query->whereBetween('application_date', [
                Carbon::parse($dateFromRaw)->startOfDay(),
                Carbon::parse($dateToRaw)->endOfDay()
            ]);
        } elseif ($dateFromRaw) {
            $query->whereDate(
                'application_date',
                '>=',
                Carbon::parse($dateFromRaw)->format('Y-m-d')
            );
        } elseif ($dateToRaw) {
            $query->whereDate(
                'application_date',
                '<=',
                Carbon::parse($dateToRaw)->format('Y-m-d')
            );
        }
        // Searching
        $search = $request->input('search.value');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name',                     'like', "%{$search}%")
                    ->orWhere('registration',           'like', "%{$search}%")
                    ->orWhere('email',                  'like', "%{$search}%")
                    ->orWhere('cnic',                   'like', "%{$search}%")
                    ->orWhere('application_date',       'like', "%{$search}%")
                    ->orWhere('approvals',              'like', "%{$search}%")
                    ->orWhere('passport',               'like', "%{$search}%")
                    ->orWhere('gender',                 'like', "%{$search}%")
                    ->orWhere('permanent_address_city', 'like', "%{$search}%")
                    ->orWhere('permanent_address_province', 'like', "%{$search}%")
                    ->orWhere('citizenship',            'like', "%{$search}%")
                    ->orWhere('refference',             'like', "%{$search}%")
                    ->orWhere('performance_appraisal',  'like', "%{$search}%")
                    ->orWhere('min_salary',             'like', "%{$search}%")
                    ->orWhereHas('Crafts', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Get filtered count before pagination
        $filteredQuery = clone $query;
        $totalFiltered = $filteredQuery->count();

        // Ordering
        $orderColIndex = $request->input('order.0.column', 0);
        $orderCol = $columns[$orderColIndex] ?? 'id';
        $orderDir = $request->input('order.0.dir', 'asc');
        if (in_array($orderCol, ['name', 'registration', 'email', 'cnic'])) {
            $query->orderBy($orderCol, $orderDir);
        } else {
            $query->latest();
        }

        // Pagination
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        if ($length != -1) {
            $query->skip($start)->take($length);
        }

        $data = $query->get();

        // Format data for DataTables (plain data, no HTML)
        $result = [];
        foreach ($data as $row) {
            $step4 = $row->hrSteps->firstWhere('step_number', 4);
            $step6 = $row->hrSteps->firstWhere('step_number', 6);
            $cnic_front = $row->hrSteps->where('step_number', 3)->where('file_type', 'cnic front')
                ->where('file_name', '!=', null)->first();
            $cnic_back = $row->hrSteps->where('step_number', 3)->where('file_type', 'cnic back')
                ->where('file_name', '!=', null)->first();
            $passport_front = $row->hrSteps->where('step_number', 2)->where('file_type', 'passport front')
                ->where('file_name', '!=', null)->first();
            $passport_back = $row->hrSteps->where('step_number', 2)->where('file_type', 'passport back')
                ->where('file_name', '!=', null)->first();
            $passport_third_image = $row->hrSteps->where('step_number', 2)->where('file_type', 'passport third image')
                ->where('file_name', '!=', null)->first();
            $visa_status = 'N/A';
            if ($step6 && $step6->visa_expiry_date !== null) {
                $visa_status = $step6->visa_expiry_date >= now() ? 'Valid' : 'Expired';
            }
            $result[] = [
                'registration' => $row->registration ?? '',
                'passport_photo' => $step4 ? $step4->file_name : '',
                'visa_type' => $step6 ? $step6->visa_type : '',
                'visa_status' => $visa_status,
                'visa_issue_date' => $step6 ? $step6->visa_issue_date : '',
                'visa_expiry_date' => $step6 ? $step6->visa_expiry_date : '',
                'flight_date' => $step6 ? $step6->flight_date : '',
                'flight_route' => $step6 ? $step6->flight_route : '',
                'cnic_taken_status' => ($cnic_front && $cnic_back) ? 'Taken' : 'Not Taken',
                'passport_taken_status' => ($passport_front && $passport_back && $passport_third_image) ? 'Taken' : 'Not Taken',
                'id' => $row->id,
                'name' => $row->name ?? '',
                'email' => $row->email ?? '',
                'cnic' => $row->cnic ?? '',
                'application_date' => $row->application_date ?? '',
                'craft' => $row->Crafts->name ?? '',
                'sub_craft' => $row->SubCrafts->name ?? '',
                'approvals' => $row->approvals ?? '',
                'approvals_document' => $row->medical_doc ?? '',
                'son_of' => $row->son_of ?? '',
                'mother_name' => $row->mother_name ?? '',
                'date_of_birth' => $row->date_of_birth ?? '',
                'cnic_expiry_date' => $row->cnic_expiry_date ?? '',
                'doi' => $row->doi ?? '',
                'doe' => $row->doe ?? '',
                'passport' => $row->passport ?? '',
                'next_of_kin' => $row->next_of_kin ?? '',
                'relation' => $row->relation ?? '',
                'kin_cnic' => $row->kin_cnic ?? '',
                'shoe_size' => $row->shoe_size ?? '',
                'cover_size' => $row->cover_size ?? '',
                'acdemic_qualification' => $row->acdemic_qualification ?? '',
                'technical_qualification' => $row->technical_qualification ?? '',
                'experience_local' => $row->experience_local ?? '',
                'experience_gulf' => $row->experience_gulf ?? '',
                'district_of_domicile' => $row->district_of_domicile ?? '',
                'present_address' => $row->present_address ?? '',
                'present_address_phone' => $row->present_address_phone ?? '',
                'present_address_mobile' => $row->present_address_mobile ?? '',
                'permanent_address' => $row->permanent_address ?? '',
                'present_address_city' => $row->present_address_city ?? '',
                'permanent_address_phone' => $row->permanent_address_phone ?? '',
                'permanent_address_mobile' => $row->permanent_address_mobile ?? '',
                'gender' => $row->gender ?? '',
                'blood_group' => $row->blood_group ?? '',
                'religion' => $row->religion ?? '',
                'permanent_address_city' => $row->permanent_address_city ?? '',
                'permanent_address_province' => $row->permanent_address_province ?? '',
                'citizenship' => $row->citizenship ?? '',
                'refference' => $row->refference ?? '',
                'interview_location' => $row->city_of_interview ?? '',
                'performance_appraisal' => $row->performance_appraisal ?? '',
                'min_salary' => $row->min_salary ?? '',
                'comment' => $row->comment ?? '',
                'status' => $row->status ?? '',
            ];
        }
        $project = null;
        if ($request->input('project_id')) {
            $project = Project::find($request->input('project_id'));
        }
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalFiltered,
            'data' => $result,
            'project ' => $project,
        ]);
    }
    public function index(Request $request)
    {
        // Only load dropdown/filter data and count, not all records
        $companies = Company::where('is_active', '=', '1')->orderBy('name', 'asc')->get();
        $projects = Project::where('is_active', '=', '1')->orderBy('project_name', 'asc')->get();
        $demands = Demand::where('project_id', $request->project_id)->where('is_active', '=', '1')->orderBy('manpower', 'asc')->get();
        $demands->transform(function ($demand) {
            $demand->full_name = $demand->manpower . ' - ' . $demand->craft?->name;
            return $demand;
        });

        $cities = City::orderBy('name')->get();
        $crafts = MainCraft::where('status', '=', 1)->where('name', '!=', '')->latest()->get();
        $count = HumanResource::whereIn('status', [1, 3, 2, 0])->count();
        $HumanResources = HumanResource::with(['Crafts', 'SubCrafts', 'hrSteps'])
            ->orderByRaw("FIELD(status, 1, 3, 2, 0)")
            ->latest()
            ->get();
        $references = HumanResource::select('refference')
            ->whereNotNull('refference')
            ->where('refference', '!=', '')
            ->distinct()
            ->get()
            ->pluck('refference')
            ->toArray();
        // return $references;
        $medically_fit = $request->input('medically_fit') ? $request->input('medically_fit') : null;
        return view('admin.humanresouce.index', compact(
            'companies',
            'HumanResources',
            'projects',
            'demands',
            'count',
            'medically_fit',
            'references',
            'cities',
            'crafts'
        ));
    }

    public function create()
    {
        $crafts = MainCraft::where('status', '=', 1)->latest()->get();
        // dd($crafts);
        $lastReg = HumanResource::pluck('registration')->toArray();
        $filteredValues = array_filter($lastReg, function ($value) {
            return !is_null($value); // Remove null values
        });
        $integerValues = array_map('intval', $filteredValues);
        $maxValue = !empty($integerValues) ? max($integerValues) : 1000;

        $registration = $maxValue >= 1000 ? $maxValue + 1 : 1001;
        // dd($maxValue);

        $companies = Company::where('is_active', '=', '1')->orderBy('name', 'asc')->get();
        // dd($companies);

        $provinces = Province::orderBy('name')->get();
        // dd($provinces);
        $districts = Distric::orderBy('name')->get();
        // dd($districts);
        $cities = City::orderBy('name')->get();
        // dd($cities);
        $curencies = Country::orderBy('title')->get();
        // dd($curencies);
        return view('admin.humanresouce.create', compact('provinces', 'districts', 'cities', 'crafts', 'registration', 'companies', 'curencies'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // return $request;
        $request->validate([
            'city_of_interview' => 'nullable',
            'craft_id' => 'nullable',
            'registration' => 'nullable|string|max:255',
            'application_date' => 'nullable|date',
            'status' => 'nullable|string',
            'experience_local' => 'nullable|string',
            'experience_gulf' => 'nullable|string',
            'approvals' => 'nullable|string|max:255',
            'medical_doc' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'son_of' => 'required|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:3',
            'date_of_birth' => [
                'nullable',
                'before_or_equal:' . now()->subYears(21)->format('Y-m-d'),
            ],
            'city_of_birth' => 'nullable|string|max:255',
            'cnic' => 'required|string',
            'cnic_expiry_date' => 'nullable|date',
            'doi' => 'nullable|date',
            'doe' => 'nullable|date',
            'passport' => 'nullable|string|max:255|unique:human_resources,passport',
            'passport_issue_place' => 'nullable|string|max:255',
            'religion' => 'required|string|max:255',
            'martial_status' => 'required|string|max:255',
            'next_of_kin' => 'nullable|string|max:255',
            'relation' => 'nullable|string|max:255',
            'kin_cnic' => 'nullable|string',
            'shoe_size' => 'nullable|string|max:255',
            'cover_size' => 'nullable|string|max:255',
            'acdemic_qualification' => 'required|string|max:255',
            'technical_qualification' => 'required|string|max:255',
            'district_of_domicile' => 'nullable|string|max:255',
            'present_address' => 'nullable|string',
            'present_address_phone' => 'nullable|string',
            'present_address_mobile' => 'nullable|string',
            'email' => 'nullable|email|unique:human_resources,email',
            'present_address_city' => 'required|string|max:255',
            'permanent_address' => 'nullable|string',
            'permanent_address_phone' => 'nullable|string',
            'permanent_address_mobile' => 'nullable|string',
            'permanent_address_city' => 'nullable|string|max:255',
            'permanent_address_province' => 'nullable|string|max:255',
            'gender' => 'required|string|max:255',
            'citizenship' => 'required|string|max:255',
            'refference' => 'nullable|string|max:255',
            'performance_appraisal' => 'nullable|string|max:255',
            'min_salary' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'experience_local' => 'nullable',
            'experience_gulf' => 'required',
        ]);

        // dd($request->all());
        if ($request->hasfile('medical_doc')) {
            $file = $request->file('medical_doc');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/admin/assets/medical_doc/'), $filename);
            $medical_doc = 'public/admin/assets/medical_doc/' . $filename;
        } else {
            $medical_doc = null;
        }

        /**generate random password */
        // $password = random_int(10000000, 99999999);
        $password = 12345678;
        $lastReg = HumanResource::pluck('registration')->toArray();
        $filteredValues = array_filter($lastReg, function ($value) {
            return !is_null($value); // Remove null values
        });
        $integerValues = array_map('intval', $filteredValues);
        $maxValue = !empty($integerValues) ? max($integerValues) : 1000;

        $registration = $maxValue >= 1000 ? $maxValue + 1 : 1001;
        // Create a new subadmin record
        $data = [
            'name' => $request->name,
            'password' => bcrypt($password),
            'status' => $request->status,
            'registration' => $registration,
            'application_date' => $request->application_date,
            'experience_local' => $request->experience_local,
            'experience_gulf' => $request->experience_gulf,
            'approvals' => $request->approvals,
            'medical_doc' => $medical_doc,
            'son_of' => $request->son_of,
            'mother_name' => $request->mother_name,
            'blood_group' => $request->blood_group,
            'date_of_birth' => $request->date_of_birth,
            'city_of_birth' => $request->city_of_birth,
            'city_of_interview' => $request->city_of_interview,
            'cnic' => $request->cnic,
            'currancy' => $request->currancy,
            'cnic_expiry_date' => $request->cnic_expiry_date,
            'doi' => $request->doi,
            'doe' => $request->doe,
            'passport' => $request->passport,
            'passport_issue_place' => $request->passport_issue_place,
            'religion' => $request->religion,
            'martial_status' => $request->martial_status,
            'next_of_kin' => $request->next_of_kin,
            'relation' => $request->relation,
            'kin_cnic' => $request->kin_cnic,
            'shoe_size' => $request->shoe_size,
            'cover_size' => $request->cover_size,
            'acdemic_qualification' => $request->acdemic_qualification,
            'technical_qualification' => $request->technical_qualification,
            'district_of_domicile' => $request->district_of_domicile,
            'present_address' => $request->present_address,
            'present_address_phone' => $request->present_address_phone,
            'present_address_mobile' => $request->present_address_mobile,
            'email' => $request->email,
            'present_address_city' => $request->present_address_city,
            'permanent_address' => $request->permanent_address,
            'permanent_address_phone' => $request->permanent_address_phone,
            'permanent_address_mobile' => $request->permanent_address_mobile,
            'permanent_address_city' => $request->permanent_address_city,
            'permanent_address_province' => $request->permanent_address_province,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'refference' => $request->refference,
            'performance_appraisal' => $request->performance_appraisal,
            'min_salary' => $request->min_salary,
            'comment' => $request->comment,
            'image' => 'public/admin/assets/images/users/avatar.png',
        ];

        // if (empty($request->input('company_id'))) {
        $data['craft_id'] = $request->craft_id;
        $data['sub_craft_id'] = $request->sub_craft_id;
        // }
        // dd($data);
        $HumanResource =  HumanResource::create($data);
        // return $HumanResource;

        if (!empty($request->input('company_id'))) {
            $HR = HumanResource::where('registration', $registration)->first();
            $craft = Demand::find($request->demand_id);

            $HR->craft_id = $craft->craft_id;
            $HR->status = 3;
            $HR->save();

            Nominate::create([
                'craft_id' => $craft->craft_id,
                'human_resource_id' => $HR->id,
                'demand_id' => $request->demand_id,
                'project_id' => $request->project_id,
            ]);
        }

        $message['email'] = $request->email;
        $message['password'] = $password;

        // Mail::to($request->email)->send(new HumanResourceUserLoginPassword($message));
        if (!empty($request->input('company_id'))) {
            $history = JobHistory::create([
                'human_resource_id' => $HumanResource->id,
                'company_id'        => $request->company_id ?? null,
                'project_id'        => $request->project_id ?? null,
                'demand_id'         => $request->demand_id ?? null,
                'craft_id'          => $request->craft_id ?? null,
                'sub_craft_id'      => $request->sub_craft_id ?? null,
                'application_date'        => $request->application_date ?? null,
                'city_of_interview'        => $request->city_of_interview ?? null,
            ]);
        }

        // Return success message
        return redirect()->route('humanresource.index')->with(['message' => 'Human Resource Created Successfully']);
    }

    public function edit($id)
    {
        $HumanResource = HumanResource::find($id);

        if (!$HumanResource) {
            abort(404, 'Human Resource not found');
        }

        $craft = MainCraft::find($HumanResource->craft_id);
        $nominates = Nominate::where('human_resource_id', $id)->first();
        // return $nominates;
        $subCraft = SubCraft::find($HumanResource->sub_craft_id);
        $companies = Company::where('is_active', '=', '1')->latest()->get();
        $crafts = MainCraft::where('status', 1)->latest()->get();
        $subCrafts = SubCraft::where('status', 1)->latest()->get();

        $project = null;
        $company = null;
        $demand = null;

        if ($nominates) {
            $project = Project::find($nominates->project_id);
            $company = $project ? Company::find($project->company_id) : null;
            $demand = $nominates->demand_id ? Demand::find($nominates->demand_id) : null;
        }
        $nominat = JobHistory::where('human_resource_id', $id)
            ->whereNull('demobe_date')
            ->exists();

        // dd($nominat);   

        $histories = JobHistory::with('humanResource', 'company', 'project', 'craft', 'subCraft')->where('human_resource_id', $id)->latest()->get();
        $provinces = Province::orderBy('name')->get();
        $districts = Distric::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $curencies = Country::orderBy('title')->get();
        // return $histories;
        return view('admin.humanresouce.edit', compact(
            'nominat',
            'HumanResource',
            'crafts',
            'subCrafts',
            'companies',
            'craft',
            'project',
            'demand',
            'company',
            'subCraft',
            'histories',
            'provinces',
            'districts',
            'cities',
            'curencies',
        ));
    }


    public function update(Request $request, $id)
    {
        $HumanResource = HumanResource::findOrFail($id);

        $request->validate([
            'experience_gulf' => 'required|string',
            'name' => 'required|string|max:255',
            'son_of' => 'required|string|max:255',
            'cnic' => 'required|string',
            'passport' => 'nullable|string|max:255|unique:human_resources,passport,' . $HumanResource->id,
            'religion' => 'required|string|max:255',
            'acdemic_qualification' => 'required|string|max:255',
            'technical_qualification' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'citizenship' => 'required|string|max:255',
        ]);

        try {
            // $HumanResource = HumanResource::findOrFail($id);

            if ($request->hasFile('medical_doc')) {
                $destination = 'public/admin/assets/img/users/' . $HumanResource->medical_doc;
                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file = $request->file('medical_doc');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;
                $file->move('public/admin/assets/medical_doc', $filename);
                $medical_doc = 'public/admin/assets/medical_doc/' . $filename;
            } else {
                $medical_doc = $HumanResource->medical_doc;
            }

            $HumanResource->update([
                'registration' => $request->registration,
                'application_date' => $request->application_date,
                'approvals' => $request->approvals,
                'medical_doc' => $medical_doc,
                'experience_local' => $request->experience_local,
                'experience_gulf' => $request->experience_gulf,
                'name' => $request->name,
                'status' => $request->status,
                'son_of' => $request->son_of,
                'mother_name' => $request->mother_name,
                'blood_group' => $request->blood_group,
                'date_of_birth' => $request->date_of_birth,
                'city_of_birth' => $request->city_of_birth,
                'city_of_interview' => $request->city_of_interview,
                'cnic' => $request->cnic,
                'email' => $request->email,
                'cnic_expiry_date' => $request->cnic_expiry_date,
                'doi' => $request->doi,
                'doe' => $request->doe,
                'currancy' => $request->currancy,
                'passport' => $request->passport,
                'passport_issue_place' => $request->passport_issue_place,
                'religion' => $request->religion,
                'martial_status' => $request->martial_status,
                'next_of_kin' => $request->next_of_kin,
                'relation' => $request->relation,
                'kin_cnic' => $request->kin_cnic,
                'shoe_size' => $request->shoe_size,
                'cover_size' => $request->cover_size,
                'acdemic_qualification' => $request->acdemic_qualification,
                'technical_qualification' => $request->technical_qualification,
                'district_of_domicile' => $request->district_of_domicile,
                'present_address' => $request->present_address,
                'present_address_phone' => $request->present_address_phone,
                'present_address_mobile' => $request->present_address_mobile,
                'present_address_city' => $request->present_address_city,
                'permanent_address' => $request->permanent_address,
                'permanent_address_phone' => $request->permanent_address_phone,
                'permanent_address_mobile' => $request->permanent_address_mobile,
                'permanent_address_city' => $request->permanent_address_city,
                'permanent_address_province' => $request->permanent_address_province,
                'gender' => $request->gender,
                'citizenship' => $request->citizenship,
                'refference' => $request->refference,
                'performance_appraisal' => $request->performance_appraisal,
                'min_salary' => $request->min_salary,
                'comment' => $request->comment,
            ]);

            // JobHistory::create([
            //     'human_resource_id' => $HumanResource->id,
            //     'company_id' => $request->company_id,
            //     'craft_id' => $request->craft_id,
            //     'sub_craft_id' => $request->sub_craft_id,
            //     'start_date' => $request->application_date,
            // ]);

            return redirect()->route('humanresource.index')->with('message', 'Human Resource Updated Successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating Human Resource: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }


    public function destroy($id)
    {
        try {
            HumanResource::destroy($id);
            return redirect()->route('humanresource.index')->with(['message' => 'Human Resource Deleted Successfully']);
        } catch (QueryException $e) {
            return redirect()->route('humanresource.index')->with(['error' => 'Cannot delete because this Human Resource is associated with Company']);
        }
    }

    public function getJobHistory($id)
    {
        $histories = JobHistory::where('id', $id)->first();
        return response()->json($histories);
    }

    public function mobDemob(Request $request)
    {
        $history = JobHistory::findOrFail($request->id);
        $history->mob_date = $request->start_date;
        $history->demobe_date = $request->end_date;
        $history->save();
        return redirect()->back()->with(['message' => 'Human Resource has been Mob/Demob Successfully']);
    }

    public function getMobData(Request $request)
    {
        $history = JobHistory::find($request->id);
        if ($history) {
            return response()->json($history);
        } else {
            return response()->json(['status' => 'error']);
        }
    }

    public function updateHistory(Request $request)
    {
        // return $request;
        $HumanResource = HumanResource::findOrFail($request->human_resource_id);
        if ($HumanResource) {
            $HumanResource->craft_id = $request->craft_id;
            $HumanResource->sub_craft_id = $request->sub_craft_id;
            $HumanResource->status = 3;
            $HumanResource->save();
        }
        if (!empty($request->input('company_id'))) {
            // $HumanResource = HumanResource::where('email', $request->email)->first();
            $craft = Demand::find($request->demand_id);
            // return $craft->craft_id;
            $data = Nominate::updateOrCreate(
                [
                    'human_resource_id' => $HumanResource->id,
                    'project_id' => $request->project_id,
                ],
                [
                    'craft_id' => $craft->craft_id,
                    'demand_id' => $request->demand_id,
                ]
            );

            // return $data;
        }
        if (!empty($request->input('company_id'))) {
            $history = JobHistory::create([
                'human_resource_id' => $HumanResource->id,
                'company_id'        => $request->company_id ?? null,
                'project_id'        => $request->project_id ?? null,
                'demand_id'         => $request->demand_id ?? null,
                'craft_id'          => $request->craft_id ?? null,
                'sub_craft_id'      => $request->sub_craft_id ?? null,
                'application_date'        => $request->application_date ?? null,
                'city_of_interview'        => $request->city_of_interview ?? null,
            ]);
        }
        return redirect()->back()->with(['message' => 'Human Resource has been Assigned Successfully']);
    }


    public function validateStep(Request $request, $step)
    {
        if ($step == 2) { // Step 2 now includes Medical Report, Visa Form, and Air Booking
            $request->validate([
                // Medical Report
                'process_status' => 'required|string',
                'medically_fit' => 'required|string',
                'report_date' => 'nullable|date',
                'valid_until' => 'nullable|date',
                'lab' => 'required|string',
                'any_comments' => 'nullable|string',
                'medical_report' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'original_report_received' => 'nullable|boolean',

                // Visa Form
                'visa_type' => 'required|string',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date',
                'receive_date' => 'nullable|date',
                'visa_status' => 'nullable|string',
                'scanned_visa' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

                // Air Booking
                'ticket_number' => 'required|string',
                'flight_number' => 'required|string',
                'flight_route' => 'required|string',
                'flight_date' => 'required|date',
                'etd' => 'required|string',
                'eta' => 'required|string',
                'upload_ticket' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
        }

        if ($step == 3) { // Previously Step 7
            $request->validate([
                'amount_digits' => 'required|numeric',
                'amount_words' => 'required|string',
                'step_three_file' => 'nullable|file|mimes:pdf|max:2048',
            ]);
        }

        if ($step == 4) { // Previously Step 8
            $request->validate([
                'opf' => 'required|numeric',
                'state_life_insurance' => 'required|numeric',
                'step_four_file' => 'nullable|file|mimes:pdf|max:2048',
            ]);
        }

        if ($step == 5) { // Previously Step 9
            $request->validate([
                'step_five_file' => 'nullable|file|mimes:pdf|max:2048',
            ]);
        }

        if ($step == 6) { // Previously Step 10
            $request->validate([
                'step_six_file' => 'nullable|file|mimes:pdf|max:2048',
            ]);
        }

        if ($step == 7) { // Previously Step 11
            $request->validate([
                'step_seven_file' => 'nullable|file|mimes:pdf|max:2048',
            ]);
        }

        if ($step == 8) { // Previously Step 12
            $request->validate([
                'visa_type' => 'required|string',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date',
                'receive_date' => 'nullable|date',
                'visa_status' => 'nullable|string',
                'endorsed_date' => 'nullable|date',
                'scanned_visa' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
        }

        if ($step == 9) { // Previously Step 13
            $request->validate([
                'ticket_number' => 'required|string',
                'flight_number' => 'required|string',
                'flight_route' => 'required|string',
                'flight_date' => 'required|date',
                'etd' => 'required|string',
                'eta' => 'required|string',
                'upload_ticket' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
        }

        // ...existing code...
    }

    public function getModalContent(Request $request)
    {
        $HumanResource = HumanResource::with('hrSteps')->findOrFail($request->id);
        $labs = Lab::latest()->get();
        return view('admin.humanresouce.partials.modal', compact('HumanResource', 'labs'))->render(); // partial blade file
    }
}
