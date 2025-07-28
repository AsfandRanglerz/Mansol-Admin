<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Demand;
use App\Models\Project;
use App\Models\Nominate;
use App\Models\Hr;
use App\Models\HrStep;
use DataTables;
use Illuminate\Http\Request;
use App\Exports\FlightReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ProjectReportController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::where('is_active', '=', '1')->orderBy('name')->get();
        $projects = Project::where('is_active', '=', '1')->get();

        return view('admin.project_reports.index', compact('companies', 'projects'));
    }

   public function ajaxData(Request $request)
    {
        // If no filters applied, return empty dataset
        if (!$request->filled('company_id') && !$request->filled('project_id')) {
            return response()->json(['data' => []]);
        }

        $query = Demand::with([
            'project',
            'craft',
            'nominations.humanResource.hrSteps' => fn($q) => $q->where('step_number', 6),
            'nominations.humanResource.jobHistory',
        ])->where('is_active', 1);

        if ($request->project_id) {
            $query->where('project_id', $request->project_id);
        } elseif ($request->company_id) {
            $projectIds = Project::where('company_id', $request->company_id)->pluck('id');
            $query->whereIn('project_id', $projectIds);
        }

        $demands = $query->get();

        foreach ($demands as $demand) {
            $demand->selected_count = $demand->nominations
                ->where('project_id', $demand->project_id)
                ->where('demand_id', $demand->id)
                ->where('craft_id', $demand->craft_id)
                ->whereNotNull('human_resource_id')
                ->pluck('human_resource_id')
                ->unique()
                ->count();
        }


        // Transforming the data before returning it
        $data = $demands->map(function ($demand, $index) {
            $fit = $repeat = $unfit = $visa = $mob = 0;

            foreach ($demand->nominations as $n) {
                $hr = $n->humanResource;
                $step6 = $hr?->hrSteps?->first();

                if ($step6) {
                    match ($step6->medically_fit) {
                        'Fit' => $fit++,
                        'Repeat' => $repeat++,
                        'Unfit' => $unfit++,
                        default => null,
                    };

                    if ($step6->visa_receive_date) $visa++;
                }

                foreach ($hr?->jobHistory ?? [] as $job) {
                    if ($demand->project->company_id === $job->company_id && $demand->project_id === $job->project_id 
                        && $demand->id === $job->demand_id && $demand->craft_id === $job->craft_id && $job->mob_date && !($job->demobe_date)) {
                        $mob++;
                        break;
                    }
                }
            }

            // Include the serial number (`sr`) and map it into the return structure
            return [
                'sr' => $index + 1, // This adds the serial number
                'project' => $demand->project->project_name ?? 'N/A',
                'craft' => $demand->craft->name ?? 'N/A',
                'requirements' => $demand->manpower,
                'selected' => $demand->selected_count ?? 0,
                'fit' => $fit,
                'repeat' => $repeat,
                'unfit' => $unfit,
                'visa_received' => $visa,
                'mobilized' => $mob,
            ];
        });


        // Returning the response in the desired format
        return response()->json(['data' => $data]);
    }



    public function getProjects(Request $request)
    {
        $projects = Project::where('company_id', $request->company_id)
            ->where('is_active', 1)
            ->orderBy('project_name')
            ->get();

        return response()->json($projects);
    }

    // flight reports 
    public function flightReportIndex(Request $request)
    {
        $companies = Company::where('is_active', '=', '1')->orderBy('name')->get();
        $projects = Project::where('is_active', '=', '1')->get();
        return view('admin.flight_reports.index',compact('companies', 'projects'));
    }

    public function getFlights(Request $request)
    {
        if (!$request->filled('flight_date')) {
            return response()->json(['data' => []]);
        }
        // $projectIds = Project::where('company_id', $request->company_id)->pluck('id');
        $hrIds = Nominate::where('project_id',$request->project_id)->pluck('human_resource_id');   
        $query = HrStep::with(['humanResource:id,name,passport,craft_id', 'humanResource.crafts'])
            // ->where('step_number', 6)
            ->whereIn('human_resource_id', $hrIds)
            ->where('flight_date', $request->flight_date);

        $hrSteps = $query->get();


        $data = $hrSteps->map(function ($row, $index) {
            $step6 = $row->humanResource->hrSteps->firstWhere('step_number', 6);
            $step4 = $row->humanResource->hrSteps->firstWhere('step_number', 4);
            $passportPhotoPath = $step4 ? $step4->file_name : null;
            if ($passportPhotoPath && file_exists($passportPhotoPath)) {
                $passportPhotoBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($passportPhotoPath));
            } else {
                $passportPhotoBase64 = null;
            }
            return [
                'sr' => $index + 1,
                'name' => $row->humanResource->name ?? 'N/A',
                'approved_for_craft' => $row->humanResource->crafts->name ?? 'N/A',
                'passport' => $row->humanResource->passport ?? 'N/A',
                'flight_route' => $step6->flight_route ?? 'N/A',
                'flight_date' => $step6->flight_date ?? 'N/A', 
                'passport_photo' => $passportPhotoPath, 
                'passport_photo_base64' => $passportPhotoBase64, 
            ];
        });

        return response()->json(['data' => $data,'hrIds', $hrIds]);
    }


    //     public function exportFlightReport(Request $request)
    // {
    //     $flightDate = $request->flight_date;

    //     // Return empty Excel if no date is provided
    //     if (!$flightDate) {
    //         return Excel::download(collect([]), 'Flight_Reports.xlsx');
    //     }

    //     return Excel::download(new FlightReportExport($flightDate), 'Flight_Reports.xlsx');
    // }


}
