<?php

namespace App\Http\Controllers\HumanResouce;

use App\Models\SubCraft;
use App\Models\MainCraft;
use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JobHistory;
use App\Models\HrStep;

class HRProfileController extends Controller
{
    public function index()
    {
        $user = Auth::guard('humanresource')->user();
        $MainCraft = MainCraft::where('id', $user->craft_id)->first();
        $SubCraft = SubCraft::where('id', $user->sub_craft_id)->first();
        // dd($MainCraft);
        $histories = JobHistory::with('humanResource','company','project','craft','subCraft')->where('human_resource_id', $user->id)->latest()->get();
        $hrSteps = HrStep::where('human_resource_id', $user->id)
            ->get();
        // return $hrSteps;
        return view('humanresouce.myprofile.index', compact('user', 'MainCraft', 'SubCraft','histories'));
    }
}
