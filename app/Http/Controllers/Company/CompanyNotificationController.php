<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyNotificationController extends Controller
{
    public function index()
    {
        return view('companypanel.notification.index');
    }
}
