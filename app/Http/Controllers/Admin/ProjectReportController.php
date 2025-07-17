<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Demand;
use App\Models\Project;
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
            return datatables()->of([])->make(true);
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

        $demands = $query->withCount([
            'nominations as selected_count' => fn($q) => $q->whereNotNull('human_resource_id')
        ])->get();

        $data = $demands->map(function ($demand) {
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
                    if ($job->mob_date) {
                        $mob++;
                        break;
                    }
                }
            }

            return [
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

        return datatables()->of($data)
            ->addIndexColumn()
            ->make(true);
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
        return view('admin.flight_reports.index');
    }

    public function getFlights(Request $request)
    {
        if (!$request->filled('flight_date')) {
            return response()->json(['data' => []]);
        }

        $query = HrStep::with(['humanResource:id,name,passport,craft_id', 'humanResource.crafts'])
            ->where('step_number', 6)
            ->where('flight_date', $request->flight_date);

        $hrSteps = $query->get();


        $data = $hrSteps->map(function ($row, $index) {
            return [
                'sr' => $index + 1,
                'name' => $row->humanResource->name ?? 'N/A',
                'approved_for_craft' => $row->humanResource->crafts->name ?? 'N/A',
                'passport' => $row->humanResource->passport ?? 'N/A',
                'flight_route' => $row->flight_route ?? 'N/A',
                'flight_date' => $row->flight_date ?? 'N/A', 
            ];
        });

        return response()->json(['data' => $data]);
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
