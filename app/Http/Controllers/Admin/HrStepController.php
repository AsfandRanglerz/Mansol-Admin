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
        $humanResource = HumanResource::findOrFail($request->human_resource_id);

        // Array to store file names for the step
        $data = [];

        if ($step == 1) {
            // Handle CV upload
            if ($request->hasFile('cv')) {
                $file = $request->file('cv');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $filename);
                $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 1,
                        'file_type' => 'cv',
                    ],
                    [
                        'file_name' => $data['file_name']
                    ]
                );
            }

            // Handle Passport Images
            if ($request->hasFile('passport_image_1')) {
                $file = $request->file('passport_image_1');
                $filename = uniqid('passport_front_') . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $filename);
                $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 2,
                        'file_type' => 'passport front',
                    ],
                    [
                        'file_name' => $data['file_name']
                    ]
                );
            }

            if ($request->hasFile('passport_image_2')) {
                $file = $request->file('passport_image_2');
                $filename = uniqid('passport_back_') . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $filename);
                $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 2,
                        'file_type' => 'passport back',
                    ],
                    [
                        'file_name' => $data['file_name']
                    ]
                );
            }

            // Handle CNIC Images
            if ($request->hasFile('cnic_front')) {
                $file = $request->file('cnic_front');
                $filename = uniqid('cnic_front_') . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $filename);
                $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 3,
                        'file_type' => 'cnic front',
                    ],
                    [
                        'file_name' => $data['file_name']
                    ]
                );
            }

            if ($request->hasFile('cnic_back')) {
                $file = $request->file('cnic_back');
                $filename = uniqid('cnic_back_') . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $filename);
                $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 3,
                        'file_type' => 'cnic back',
                    ],
                    [
                        'file_name' => $data['file_name']
                    ]
                );
            }

            // Handle Passport-size Photo
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $filename);
                $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 4,
                        'file_type' => 'photo',
                    ],
                    [
                        'file_name' => $data['file_name']
                    ]
                );
            }

            // Handle NOK CNIC Images
            if ($request->hasFile('nok_cnic_front')) {
                $file = $request->file('nok_cnic_front');
                $filename = uniqid('nok_cnic_front_') . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $filename);
                $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 5,
                        'file_type' => 'nok cnic front',
                    ],
                    [
                        'file_name' => $data['file_name']
                    ]
                );
            }

            if ($request->hasFile('nok_cnic_back')) {
                $file = $request->file('nok_cnic_back');
                $filename = uniqid('nok_cnic_back_') . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $filename);
                $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 5,
                        'file_type' => 'nok cnic back',
                    ],
                    [
                        'file_name' => $data['file_name']
                    ]
                );
            }
        }

        if ($request->hasFile('medical_report') && $step == 6) {
            $file = $request->file('medical_report');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/humanResource', $filename);
            $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

            HrStep::updateOrCreate(
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
        }

        if ($step == 7 && $request->step_seven_file) {
            HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'step 7 pdf',
                ],
                [
                    'file_name' => $request->step_seven_file,
                    'amount_digits' => $request->amount_digits,
                    'amount_words' => $request->amount_words,
                ]
            );
        }

        if ($step == 8 && $request->step_eight_file) {
            HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'step 8 pdf',
                ],
                [
                    'file_name' => $request->step_eight_file,
                    'amount_digits' => $request->opf,
                    'amount_digits1' => $request->state_life_insurance,
                ]
            );
        }

        if ($step == 9 && $request->step_nine_file) {
            HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'step 9 pdf',
                ],
                [
                    'file_name' => $request->step_nine_file,
                ]
            );
        }

        if ($step == 10 && $request->step_ten_file) {
            HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'step 10 pdf',
                ],
                [
                    'file_name' => $request->step_ten_file,
                ]
            );
        }

        if ($step == 11 && $request->step_eleven_file) {
            HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => $step,
                    'file_type' => 'step 10 pdf',
                ],
                [
                    'file_name' => $request->step_eleven_file,
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Step ' . $step . ' submitted successfully!']);
    }
}
