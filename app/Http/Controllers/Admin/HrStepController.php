<?php

namespace App\Http\Controllers\Admin;

use App\Models\HrStep;
use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;

class HrStepController extends Controller
{
    public function submitStep(Request $request, $step)
    {
        dd($request->all());
        $request->validate([
            'cv' => $step == 1 ? 'required|mimes:pdf|max:2048' : '',
            'passport_image_1' => $step == 2 ? 'required|image|mimes:jpeg,png,jpg|max:2048' : '',
            'passport_image_2' => $step == 2 ? 'required|image|mimes:jpeg,png,jpg|max:2048' : '',
            'cnic_front' => $step == 3 ? 'required|image|mimes:jpeg,png,jpg|max:2048' : '',
            'cnic_back' => $step == 3 ? 'required|image|mimes:jpeg,png,jpg|max:2048' : '',
            'photo' => $step == 4 ? 'required|image|mimes:jpeg,png,jpg|max:2048' : '',
            'nok_cnic_front' => $step == 5 ? 'required|image|mimes:jpeg,png,jpg|max:2048' : '',
            'nok_cnic_back' => $step == 5 ? 'required|image|mimes:jpeg,png,jpg|max:2048' : '',
            'medical_report' => $step == 6 ? 'required|mimes:pdf,jpeg,png,jpg|max:2048' : '',
        ]);

        $humanResource = HumanResource::findOrFail($request->human_resource_id);

        // Array to store file names for the step
        $data = [];

        if ($request->hasFile('cv') && $step == 1) {
            $data['file_name'] = $request->file('cv')->store('cv_files', 'public');
        }
        if ($request->hasFile('passport_image_1') && $step == 2) {
            $data['file_name'] = $request->file('passport_image_1')->store('passport_images', 'public');
        }
        if ($request->hasFile('passport_image_2') && $step == 2) {
            $data['file_name'] = $request->file('passport_image_2')->store('passport_images', 'public');
        }
        if ($request->hasFile('cnic_front') && $step == 3) {
            $data['file_name'] = $request->file('cnic_front')->store('cnic_images', 'public');
        }
        if ($request->hasFile('cnic_back') && $step == 3) {
            $data['file_name'] = $request->file('cnic_back')->store('cnic_images', 'public');
        }
        if ($request->hasFile('photo') && $step == 4) {
            $data['file_name'] = $request->file('photo')->store('photos', 'public');
        }
        if ($request->hasFile('nok_cnic_front') && $step == 5) {
            $data['file_name'] = $request->file('nok_cnic_front')->store('nok_cnic_images', 'public');
        }
        if ($request->hasFile('nok_cnic_back') && $step == 5) {
            $data['file_name'] = $request->file('nok_cnic_back')->store('nok_cnic_images', 'public');
        }
        if ($request->hasFile('medical_report') && $step == 6) {
            $data['file_name'] = $request->file('medical_report')->store('medical_reports', 'public');
        }

        // Store the data in the `hr_steps` table
        $hrStep = HrStep::create([
            'human_resource_id' => $humanResource->id,
            'step_number' => $step,
            'file_name' => $data['file_name'],
        ]);

        return response()->json(['success' => true, 'message' => 'Step ' . $step . ' submitted successfully!']);
    }
}
