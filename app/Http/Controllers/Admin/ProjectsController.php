<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Project;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index($id)
    {
        // dd($id);
        $company_id = $id;
        // dd($company_id);
        $company_name = Company::find($id)->name;
        $projects = Project::where('company_id', $company_id)->orderBy('is_active', 'desc')->latest()->get();

        $lastReg = Project::pluck('project_code')->toArray();
        $filteredValues = array_filter($lastReg, function ($value) {
            return !is_null($value); // Remove null values
        });
        $integerValues = array_map('intval', $filteredValues);
        $maxValue = !empty($integerValues) ? max($integerValues) : 2000;

        $registration = $maxValue >= 2000 ? $maxValue + 1 : 2001;


        return view('admin.company.project', compact('company_id', 'projects', 'company_name', 'registration'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'company_id' => 'required',
            'draft_id' => 'nullable',
            // 'client_id' => 'nullable|string|max:255',
            'is_ongoing' => 'nullable|string|max:255',
            'project_code' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'project_currency' => 'required|string|max:255',
            'project_location' => 'required|string|max:255',
            'manpower_location' => 'required|string|max:255',
            'project_start_date' => 'required|date',
            'project_end_date' => 'nullable|date',
            'permission' => 'nullable|string|max:255',
            'permission_date' => 'nullable|date',
            'poa_received' => 'nullable|string',
            'demand_letter_received' => 'nullable|string',
            'permission_letter_received' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'is_active' => 'nullable|string',
        ]);
        
        // dd($request);
        Project::create([
            'company_id' => $request->input('company_id'),
            'draft_id' => $request->input('draft_id'),
            // 'client_id' => $request->input('client_id'),
            'is_ongoing' => $request->input('is_ongoing', 'unchecked'),
            'project_code' => $request->input('project_code'),
            'project_name' => $request->input('project_name'),
            'project_currency' => $request->input('project_currency'),
            'project_location' => $request->input('project_location'),
            'manpower_location' => $request->input('manpower_location'),
            'project_start_date' => $request->input('project_start_date'),
            'project_end_date' => $request->input('project_end_date'),
            'permission' => $request->input('permission'),
            'permission_date' => $request->input('permission_date'),
            'poa_received' => $request->input('poa_received', 'unchecked'),
            'demand_letter_received' => $request->input('demand_letter_received', 'unchecked'),
            'permission_letter_received' => $request->input('permission_letter_received', 'unchecked'),
            'is_active' => $request->input('is_active'),
            'additional_notes' => $request->input('additional_notes'),
        ]);

        // Return success message
        return redirect()->route('project.index', ['id' => $request->input('company_id')])
            ->with(['message' => 'Project Created Successfully!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'client_id' => 'nullable|string|max:255',
            'is_ongoing' => 'nullable|string|max:255',
            'project_code' => 'required|string|max:255',
            'project_name' => 'required|string|max:255',
            'project_currency' => 'required|string|max:255',
            'project_location' => 'required|string|max:255',
            'manpower_location' => 'required|string|max:255',
            'project_start_date' => 'required|date',
            'project_end_date' => 'nullable|date',
            'permission' => 'nullable|string|max:255',
            'permission_date' => 'nullable|date',
            'poa_received' => 'nullable|string',
            'demand_letter_received' => 'nullable|string',
            'permission_letter_received' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'is_active' => 'nullable|string',
        ]);
        // dd($request);

        $Project = Project::findOrFail($id);

        $Project->update([
            // 'client_id' => $request->input('client_id'),
            'is_ongoing' => $request->input('is_ongoing', 'unchecked'),
            'project_code' => $request->input('project_code'),
            'project_name' => $request->input('project_name'),
            'project_currency' => $request->input('project_currency'),
            'project_location' => $request->input('project_location'),
            'manpower_location' => $request->input('manpower_location'),
            'project_start_date' => $request->input('project_start_date'),
            'project_end_date' => $request->input('project_end_date'),
            'permission' => $request->input('permission'),
            'permission_date' => $request->input('permission_date'),
            'poa_received' => $request->input('poa_received', 'unchecked'),
            'demand_letter_received' => $request->input('demand_letter_received', 'unchecked'),
            'permission_letter_received' => $request->input('permission_letter_received', 'unchecked'),
            'is_active' => $request->input('is_active'),
            'additional_notes' => $request->input('additional_notes'),
        ]);

        // Return success message
        return redirect()->route('project.index', ['id' => $request->input('company_id')])->with(['message' => 'Project Updated Successfully']);
    }

    public function destroy($id, Request $request)
    {
        try{
            Project::destroy($id);
            return redirect()->route('project.index', ['id' => $request->company_id])->with(['message' => 'Project Deleted Successfully']);
        } catch(QueryException $e){
            return redirect()->route('project.index', ['id' => $request->company_id])->with(['error' => 'This Project cannot be deleted because it has assigned nominees.']);
        }
    }
}
