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
        // these are steps from 1 to 5 at backend tabel and from forntend this is step 1
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

            if ($request->hasFile('passport_image_3')) {
                $file = $request->file('passport_image_3');
                $filename = uniqid('passport_back_') . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $filename);
                $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 2,
                        'file_type' => 'passport third image',
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
                $photoFileName = time() . '_photo.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $photoFileName);
                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 4,
                        'file_type' => 'photo',
                    ],
                    [
                        'file_name' => 'public/admin/assets/humanResource/' . $photoFileName
                    ]
                );
            }

            if ($request->hasFile('police_verification')) {
                $file = $request->file('police_verification');
                $policeFileName = time() . '_police.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $policeFileName);
                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 4,
                        'file_type' => 'police verification',
                    ],
                    [
                        'file_name' => 'public/admin/assets/humanResource/' . $policeFileName
                    ]
                );
            }

            if ($request->hasFile('account_detail')) {
                $file = $request->file('account_detail');
                $accountFileName = time() . '_account.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $accountFileName);
                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 4,
                        'file_type' => 'account detail',
                    ],
                    [
                        'file_name' => 'public/admin/assets/humanResource/' . $accountFileName
                    ]
                );
            }

            if ($request->hasFile('update_appraisal')) {
                $file = $request->file('update_appraisal');
                $appraisalFileName = time() . '_appraisal.' . $file->getClientOriginalExtension();
                $file->move('public/admin/assets/humanResource', $appraisalFileName);
                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 4,
                        'file_type' => 'update appraisal',
                    ],
                    [
                        'file_name' => 'public/admin/assets/humanResource/' . $appraisalFileName
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
       if ($step == 2) {
            try {
                $data = [];
                $dataToUpdate = [
                    'process_status' => $request->process_status,
                    'medically_fit' => $request->medically_fit,
                    'report_date' => $request->report_date,
                    'valid_until' => $request->valid_until,
                    'lab' => $request->lab,
                    'any_comments' => $request->any_comments,
                    'original_report_recieved' => $request->has('original_report_recieved') ? 'yes' : 'no',
                    'visa_type' => $request->visa_type,
                    'visa_issue_date' => $request->visa_issue_date,
                    'visa_expiry_date' => $request->visa_expiry_date,
                    'visa_receive_date' => $request->visa_receive_date,
                    'visa_issue_number' => $request->visa_issue_number,
                    'visa_endorsement_date' => $request->visa_endorsement_date,
                    'visa_status' => $request->visa_status,
                    'endorsement_checked' => $request->has('endorsement_checked') ? 'yes' : 'no',
                    'ticket_number' => $request->ticket_number,
                    'flight_number' => $request->flight_number,
                    'flight_route' => $request->flight_route,
                    'flight_date' => $request->flight_date,
                    'flight_etd' => $request->flight_etd,
                    'flight_eta' => $request->flight_eta,
                    ];

                    // Only include file_name if file is uploaded
                    if ($request->hasFile('medical_report')) {
                    $file = $request->file('medical_report');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('admin/assets/humanResource'), $filename);
                    $dataToUpdate['file_name'] = 'public/admin/assets/humanResource/' . $filename;
                    }

                    // Only include scanned_visa if file is uploaded
                    if ($request->hasFile('scanned_visa')) {
                    $file = $request->file('scanned_visa');
                    $filename = time() . '_visa.' . $file->getClientOriginalExtension();
                    $file->move(public_path('admin/assets/humanResource'), $filename);
                    $dataToUpdate['scanned_visa'] = 'public/admin/assets/humanResource/' . $filename;
                    }

                    // Only include upload_ticket if file is uploaded
                    if ($request->hasFile('upload_ticket')) {
                    $file = $request->file('upload_ticket');
                    $filename = time() . '_ticket.' . $file->getClientOriginalExtension();
                    $file->move(public_path('admin/assets/humanResource'), $filename);
                    $dataToUpdate['upload_ticket'] = 'public/admin/assets/humanResource/' . $filename;
                    }

                    // Save or update
                    try {
                    $test = HrStep::updateOrCreate(
                    [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => 6,
                    'file_type' => 'medical_report',
                    ],
                    $dataToUpdate
                    );

                    return response()->json([
                    'success' => true,
                    'data' => $test
                    ]);
                    } catch (\Exception $e) {
                    \Log::error("HR Step update failed: " . $e->getMessage());
                    return response()->json([
                    'error' => true,
                    'message' => $e->getMessage()
                    ], 500);
                    }

            } catch (\Exception $e) {
                \Log::error('HR Step update failed: ' . $e->getMessage());
                return back()->with('error', 'An error occurred while processing the HR step. Please try again.');
            }
        }


        // in db its step no 7 but in front end its step no 3
        if ($step == 3 && $request->step_three_file) {
            HrStep::updateOrCreate(
                [ 
                    'human_resource_id' => $humanResource->id,
                    'step_number' => 7,
                    'file_type' => 'step 7 pdf',
                ],
                [ 
                    'file_name' => $request->step_three_file,
                    'amount_digits' => $request->amount_digits,
                    'amount_words' => $request->amount_words,
                ]
            );
        }

        // in db its step no 8 but in front end its step no 4
        if ($step == 4 && $request->step_four_file) {
            HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => 8,
                    'file_type' => 'step 8 pdf',
                ],
                [
                    'file_name' => $request->step_four_file,
                    'amount_digits' => $request->opf,
                    'amount_digits1' => $request->state_life_insurance,
                ]
            );
        }
        // in db its step no 9 but in front end its step no 5
        if ($step == 5 && $request->step_five_file) {
            HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => 9,
                    'file_type' => 'step 9 pdf',
                ],
                [
                    'file_name' => $request->step_five_file,
                ]
            );
        }
        // in db its step no 10 but in front end its step no 6
        if ($step == 6  && $request->step_six_file) {
            HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => 10,
                    'file_type' => 'step 10 pdf',
                ],
                [
                    'file_name' => $request->step_six_file,
                ]
            );
        }

        if ($step == 7 && $request->step_seven_file) {
            HrStep::updateOrCreate(
                [
                    'human_resource_id' => $humanResource->id,
                    'step_number' => 11,
                    'file_type' => 'step 10 pdf',
                ],
                [
                    'file_name' => $request->step_seven_file,
                ]
            );
        }

        return response()->json(['success' => true, 'message' => 'Step ' . $step . ' submitted successfully!']);
    }
}
