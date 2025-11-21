<?php

namespace App\Http\Controllers\HumanResouce;

use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;

class HRAttachmentController extends Controller
{
    public function index()
    {
        $HumanResource = HumanResource::with('hrSteps')->first();

        return view('humanresouce.specific_attachments.index', compact('HumanResource'));
    }
}
