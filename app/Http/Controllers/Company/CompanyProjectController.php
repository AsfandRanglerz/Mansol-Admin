<?php

namespace App\Http\Controllers\Company;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyProjectController extends Controller
{
    public function index()
    {
        $user_id = auth()->guard('company')->user()->id;
        $projects = Project::where('company_id', $user_id)->latest()->get();
        return view('companypanel.projects.index');
    }
}
