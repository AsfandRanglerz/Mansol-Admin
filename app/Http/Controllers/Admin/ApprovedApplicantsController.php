<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;

class ApprovedApplicantsController extends Controller
{
    public function index()
    {
        $HumanResources = HumanResource::where('status', 2)
        ->latest('updated_at')->get();
        // dd($HumanResources);
        return view('admin.approvedApplicants.index', compact('HumanResources'));
    }

    public function destroy($id)
    {
        // return $id;
        // HumanResource::destroy($id);
        $data = HumanResource::findOrFail($id);
        if (!$data) {
            $data->update(['delete_by_admin' => 1]); // Mark as deleted
        }
        return redirect()->route('approved.applicants.index')->with(['message' => 'Assigned Resource Deleted Successfully']);
    }
}
