<?php

namespace App\Http\Controllers\HumanResouce;

use App\Models\SubCraft;
use App\Models\MainCraft;
use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HRProfileController extends Controller
{
    public function index()
    {
        $user = Auth::guard('humanresource')->user();
        $MainCraft = MainCraft::where('id', $user->craft_id)->first();
        $SubCraft = SubCraft::where('id', $user->sub_craft_id)->first();
        // dd($MainCraft);
        return view('humanresouce.myprofile.index', compact('user', 'MainCraft', 'SubCraft'));
    }
}
