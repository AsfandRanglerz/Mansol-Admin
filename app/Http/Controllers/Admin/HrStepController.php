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
        // dd($request->all());
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
            $file = $request->file('cv');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/humanResource', $filename);
            $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;
            // $data['file_name'] = $request->file('cv')->store('cv_files', 'public');
            // Store the data in the `hr_steps` table
            $hrStep = HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'cv',
                ],
                [
                    'file_name' => $data['file_name']
                ]
            );            
        }
        if ($request->hasFile('passport_image_1') && $step == 2) {
            $file = $request->file('passport_image_1');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/humanResource', $filename);
            $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;
            // $data['file_name'] = $request->file('passport_image_1')->store('passport_images', 'public');
            // Store the data in the `hr_steps` table
            $hrStep = HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'passport front',
                ],
                [
                    'file_name' => $data['file_name']
                ]
            ); 
        }
        if ($request->hasFile('passport_image_2') && $step == 2) {
            $file = $request->file('passport_image_2');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/humanResource', $filename);
            $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;
            // $data['file_name'] = $request->file('passport_image_2')->store('passport_images', 'public');
            // Store the data in the `hr_steps` table
            $hrStep = HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'passport back',
                ],
                [
                    'file_name' => $data['file_name']
                ]
            ); 
        }
        if ($request->hasFile('cnic_front') && $step == 3) {
            $file = $request->file('cnic_front');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/humanResource', $filename);
            $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;
            // Store the data in the `hr_steps` table
            $hrStep = HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'cnic front',
                ],
                [
                    'file_name' => $data['file_name']
                ]
            ); 
        }
        if ($request->hasFile('cnic_back') && $step == 3) {
            $file = $request->file('cnic_back');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/humanResource', $filename);
            $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;
            // Store the data in the `hr_steps` table
            $hrStep = HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'cnic back',
                ],
                [
                    'file_name' => $data['file_name']
                ]
            ); 
        }
        if ($request->hasFile('photo') && $step == 4) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/humanResource', $filename);
            $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;
            // Store the data in the `hr_steps` table
            $hrStep = HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'photo',
                ],
                [
                    'file_name' => $data['file_name']
                ]
            ); 
            // $data['file_name'] = $request->file('photo')->store('photos', 'public');
        }
        if ($request->hasFile('nok_cnic_front') && $step == 5) {
            $file = $request->file('nok_cnic_front');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/humanResource', $filename);
            $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;
            // Store the data in the `hr_steps` table
            $hrStep = HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'nok cnic front',
                ],
                [
                    'file_name' => $data['file_name']
                ]
            ); 
            // $data['file_name'] = $request->file('nok_cnic_front')->store('nok_cnic_images', 'public');
        }
        if ($request->hasFile('nok_cnic_back') && $step == 5) {
            $file = $request->file('nok_cnic_back');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/humanResource', $filename);
            $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;
            // Store the data in the `hr_steps` table
            $hrStep = HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'nok cnic back',
                ],
                [
                    'file_name' => $data['file_name']
                ]
            );
            // $data['file_name'] = $request->file('nok_cnic_back')->store('nok_cnic_images', 'public');
        }
        if ($request->hasFile('medical_report') && $step == 6) {
            $file = $request->file('medical_report');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/humanResource', $filename);
            $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;
            // Store the data in the `hr_steps` table
            $hrStep = HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'medical_report',
                ],
                [
                    'file_name' => $data['file_name'],
                    'process_status' => $request->process_status,
                    'medically_fit' => $request->medically_fit,
                    'report_date' => $request->report_date,
                    'valid_until' => $request->valid_until,
                    'lab' => $request->lab,
                    'any_comments' => $request->any_comments,
                    'original_report_recieved' => $request->original_report_recieved,

                ]
            );
            // $data['file_name'] = $request->file('medical_report')->store('medical_reports', 'public');
        }

        

        return response()->json(['success' => true, 'message' => 'Step ' . $step . ' submitted successfully!']);
    }
}
