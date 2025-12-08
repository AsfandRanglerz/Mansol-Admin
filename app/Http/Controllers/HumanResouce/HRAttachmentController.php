<?php

namespace App\Http\Controllers\HumanResouce;

use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;

class HRAttachmentController extends Controller
{
    public function index()
    {
        $HumanResource = HumanResource::with('hrSteps')->where('id', auth()->guard('humanresource')->id())->first();
        return view('humanresouce.specific_attachments.index', compact('HumanResource'));
    }
}
