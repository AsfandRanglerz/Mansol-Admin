<?php

namespace App\Http\Controllers\HumanResouce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HRNotificationController extends Controller
{
    public function index()
    {
        return view('humanresouce.notification.index');
    }
}
