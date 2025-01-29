<?php

namespace App\Http\Controllers\Admin;

use App\Models\Demand;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MainCraft;

class DemandsController extends Controller
{
    public function index($id)
    {
        // dd($id);
        $project_id = $id;
        $project_name = Project::find($id)->project_name;
        // dd($project_name);
        $crafts = MainCraft::where('status', 1)->get();
        $demands = Demand::with(['project','craft'])->where('project_id', $id)->orderBy('is_active', 'desc')->latest()->get();
        // dd($demands);
        return view('admin.demands.index', compact('crafts', 'demands', 'project_id', 'project_name'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'project_id' => 'required',
            'craft_id' => 'required',
            'manpower' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'mobilization' => 'required|string|max:255',
            'demobilization' => 'required|string|max:255',
            'is_active' => 'required|string|max:255',
        ]);

        Demand::create([
            'project_id' => $request->project_id,
            'craft_id' => $request->craft_id,
            'manpower' => $request->manpower,
            'salary' => $request->salary,
            'mobilization' => $request->mobilization,
            'demobilization' => $request->demobilization,
            'is_active' => $request->is_active,
        ]);

        // Return success message
        return redirect()->route('demands.index', ['id' => $request->project_id])
            ->with(['message' => 'Demand Created Successfully!']);
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        $request->validate([
            'project_id' => 'required',
            'craft_id' => 'required',
            'manpower' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'mobilization' => 'required|string|max:255',
            'demobilization' => 'required|string|max:255',
            'is_active' => 'required|string|max:255',
        ]);
        // dd($request);

        $Demand = Demand::findOrFail($id);

        $Demand->update([
            'project_id' => $request->project_id,
            'craft_id' => $request->craft_id,
            'manpower' => $request->manpower,
            'salary' => $request->salary,
            'mobilization' => $request->mobilization,
            'demobilization' => $request->demobilization,
            'is_active' => $request->is_active,
        ]);

        // Return success message
        return redirect()->route('demands.index', ['id' => $request->project_id])->with(['message' => 'Demand Updated Successfully']);
    }

    public function destroy(Request $request, $id)
    {
        // dd($request);
        Demand::destroy($id);

        return redirect()->route('demands.index', ['id' => $request->project_id])->with(['message' => 'Demand Deleted Successfully']);
    }
}
