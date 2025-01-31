<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HumanResource;
use App\Models\Nominate;
use App\Models\Project;

class NominateController extends Controller
{
    public function index($craft_id, $demand_id, $project_id)
    {
        $humanRecources = HumanResource::where('craft_id', $craft_id)->where('status', '=', 2)->get();

        $project = Project::findOrFail($project_id);
        // $nominates = HumanResource::where('craft_id', $craft_id)->where('status', '=', 3)->get();

        $nominates = Nominate::where('craft_id', $craft_id)->where('project_id', $project_id)->where('demand_id', $demand_id)->with('humanResource')->get();
        // dd($nominates);

        return view('admin.nominate.index', compact('craft_id', 'demand_id', 'humanRecources', 'nominates', 'project_id', 'project'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'craft_id' => 'required',
            'demand_id' => 'required',
            'project_id' => 'required',
            'human_resource_id' => 'required',
        ]);
        
        $humanResource = HumanResource::findOrFail($request->human_resource_id);
        $humanResource->update(['status' => 3]);

        Nominate::create([
            'craft_id' => $request->craft_id,
            'demand_id' => $request->demand_id,
            'project_id' => $request->project_id,
            'human_resource_id' => $request->human_resource_id,
        ]);

        return redirect()->route('nominate.index', ['craft_id' => $request->craft_id, 'demand_id' => $request->demand_id, 'project_id' => $request->project_id])->with(['message' => 'Human Resource Assign Successfully']);
    }

    public function destroy(Request $request, $id)
    {
        // dd($id);
        $humanResource = HumanResource::findOrFail($request->human_resource_id);
        $humanResource->update(['status' => 2]);
        // dd($humanResource);  

        Nominate::destroy($id);

        return redirect()->route('nominate.index', ['craft_id' => $request->craft_id, 'demand_id' => $request->demand_id, 'project_id' => $request->project_id])->with(['message' => 'Human Resource Un-Assign Successfully']);
    }
}
