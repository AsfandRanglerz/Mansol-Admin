<?php

namespace App\Http\Controllers\HumanResouce;

use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HRProfileController extends Controller
{
    public function index()
    {
        $user = Auth::guard('humanresource')->user();
        // dd($user);
        return view('humanresouce.myprofile.index', compact('user'));
    }
}
