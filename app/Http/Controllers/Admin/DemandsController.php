<?php

namespace App\Http\Controllers\Admin;

use App\Models\Demand;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\MainCraft;
use Illuminate\Database\QueryException;

class DemandsController extends Controller
{
    public function index($id)
    {
        // dd($id);
        $project_id = $id;
        $project = Project::find($id);

        $company = Company::where('id', $project->company_id)->first();
        // dd($company); 
        $assignedCraftIds = Demand::where('project_id', $id)->pluck('craft_id');
        $crafts = MainCraft::where('status', 1)
            ->whereNotIn('id', $assignedCraftIds)
            ->get();

        $demands = Demand::with(['project', 'craft'])->where('project_id', $id)->orderBy('is_active', 'desc')->latest()->get();
        // dd($demands);
        return view('admin.demands.index', compact('crafts', 'demands', 'project_id', 'project', 'company'));
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
        try{
            Demand::destroy($id);
            return redirect()->route('demands.index', ['id' => $request->project_id])->with(['message' => 'Demand Deleted Successfully']);
        } catch(QueryException $e){
            return redirect()->route('demands.index', ['id' => $request->project_id])->with(['error' => 'This Demand cannot be deleted because it has assigned nominees.']);
        }
    }

    public function getDemand(Request $request)
    { 
        $demands = Demand::where('project_id', $request->project_id)->orderBy('manpower', 'asc')->get();
         // Append concatenated name to each demand
        $demands->transform(function ($demand) {
            $demand->full_name = $demand->manpower . ' - ' . $demand->craft?->name;
            return $demand;
        });
        return response()->json($demands);
    }

    public function getCrafts(Request $request)
    {
        $demand = Demand::where('id', $request->demand_id)->first();
        $craft = MainCraft::where('id', $demand->craft_id)->latest()->get();
        return response()->json($craft);
    }
}
