<?php

namespace App\Http\Controllers\Company;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Demand;
use App\Models\MainCraft;
use App\Models\Nominate;
use App\Models\HumanResource;
use App\Models\JobHistory;
use App\Models\City;
use App\Models\Distric;
use App\Models\Province;
use App\Models\Country;
use App\Models\Company;
use App\Models\SubCraft;

class CompanyProjectController extends Controller
{
    public function index()
    {
        $user_id = auth()->guard('company')->user()->id;
        $projects = Project::where('company_id', $user_id)->orderBy('is_active', 'desc')->latest()->get();
        // return $projects;
        return view('companypanel.projects.index', compact('projects'));
    } 

    public function demands($id)
    {
        $demands = Demand::where('project_id', $id)->with(['craft', 'project'])->orderBy('is_active', 'desc')->latest()->get();
        $project = Project::find($id);
        // dd($project);
        return view('companypanel.demands.index', compact('demands', 'project'));
    }

    public function nominees($id)
    {
        $nominees = Nominate::where('demand_id', $id)->with(['humanResource', 'project', 'craft'])->latest()->get();
        // return $nominees;
        if ($nominees->isEmpty()) {
            // Handle empty case — return back, error message, or default values
            return back()->with('error', 'No Humanresource found for this Demand');
        }
        $project = Project::where('id', $nominees->first()->project->id)->first();
        $craft = MainCraft::where('id', $nominees->first()->craft->id)->first();

        // dd($craft);
        return view('companypanel.nominees.index', compact('nominees', 'project', 'craft'));
    }

    public function details($id)
    {
        $HumanResource = HumanResource::find($id);
    
        if (!$HumanResource) {
            abort(404, 'Human Resource not found');
        }
    
        $craft = MainCraft::find($HumanResource->craft_id);
        $nominates = Nominate::where('human_resource_id', $id)->first();
        $subCraft = SubCraft::find($HumanResource->sub_craft_id);
        $companies = Company::latest()->get();
        $crafts = MainCraft::latest()->get();
        $subCrafts = SubCraft::latest()->get();
    
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

        $histories = JobHistory::with('humanResource','company','project','craft','subCraft')->where('human_resource_id', $id)->latest()->get();
        $provinces = Province::orderBy('name')->get();
        $districts = Distric::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $curencies = Country::orderBy('title')->get();
        // return $histories;
        return view('companypanel.nominees.details', compact(
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
}
