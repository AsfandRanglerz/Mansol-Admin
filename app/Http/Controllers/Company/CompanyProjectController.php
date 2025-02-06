<?php

namespace App\Http\Controllers\Company;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Demand;
use App\Models\MainCraft;
use App\Models\Nominate;

class CompanyProjectController extends Controller
{
    public function index()
    {
        $user_id = auth()->guard('company')->user()->id;
        $projects = Project::where('company_id', $user_id)->orderBy('is_active', 'desc')->latest()->get();
        // dd($projects);
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

        $project = Project::where('id', $nominees->first()->project->id)->first();
        $craft = MainCraft::where('id', $nominees->first()->craft->id)->first();

        // dd($craft);
        return view('companypanel.nominees.index', compact('nominees', 'project', 'craft'));
    }
}
