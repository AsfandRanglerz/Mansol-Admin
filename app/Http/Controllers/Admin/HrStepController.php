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
          $passportReceived = $request->input('received_physically_passport', 'no');
            
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
                        'file_name' => $data['file_name'],
                        'received_physically' => $passportReceived
                    ]
                );
            } else {
                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 2,
                        'file_type' => 'passport front',
                    ],
                    [
                        'received_physically' => $passportReceived
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
                        'file_name' => $data['file_name'],
                        'received_physically' => $passportReceived
                    ]
                );
            } else {
                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 2,
                        'file_type' => 'passport back',
                    ],
                    [
                        'received_physically' => $passportReceived
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
                        'file_name' => $data['file_name'],
                        'received_physically' => $passportReceived
                    ]
                );
            } else {
                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 2,
                        'file_type' => 'passport third image',
                    ],
                    [
                        'received_physically' => $passportReceived
                    ]
                );
            }   
            // Handle CNIC Images
           // Handle CNIC Images
            $cnicReceivedFront = $request->input('received_physically_cnic_front', 'no');
            
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
                        'file_name' => $data['file_name'],
                        'received_physically' => $cnicReceivedFront
                    ]
                );
            } else {
                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 3,
                        'file_type' => 'cnic front',
                    ],
                    [
                        'received_physically' => $cnicReceivedFront
                    ]
                );
            }

            $cnicReceivedBack = $request->input('received_physically_cnic_back', 'no');
            
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
                        'file_name' => $data['file_name'],
                        'received_physically' => $cnicReceivedBack
                    ]
                );
            } else {
                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 3,
                        'file_type' => 'cnic back',
                    ],
                    [
                        'received_physically' => $cnicReceivedBack
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

            // Handle Police Verification
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
                        'file_name' => 'public/admin/assets/humanResource/' . $policeFileName,
                        'received_physically' => $request->input('received_physically_police_verification', 'no')
                    ]
                );
            } else {
                HrStep::updateOrCreate(
                    [
                        'human_resource_id' => $humanResource->id,
                        'step_number' => 4,
                        'file_type' => 'police verification',
                    ],
                    [
                        'received_physically' => $request->input('received_physically_police_verification', 'no')
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
        $humanResourceId = $humanResource->id;

        // ===== MEDICAL REPORT ===== (file_type: 'medical_report')
        $medicalData = [
            'process_status' => $request->process_status,
            'medically_fit' => $request->medically_fit,
            'report_date' => $request->report_date,
            'valid_until' => $request->valid_until,
            'lab' => $request->lab,
            'any_comments' => $request->any_comments,
            'original_report_recieved' =>$request->has('original_report_received') ? 'yes' : 'no',
            'received_physically' => $request->input('received_physically_medical_report', 'no')
        ];

        // Medical report file upload
        if ($request->hasFile('medical_report')) {
            $file = $request->file('medical_report');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/assets/humanResource'), $filename);
            $medicalData['file_name'] = 'public/admin/assets/humanResource/' . $filename;
        }

        // Save Medical Report
        HrStep::updateOrCreate(
            [
                'human_resource_id' => $humanResourceId,
                'step_number' => 6,
                'file_type' => 'medical_report',
            ],
            $medicalData
        );

        // ===== VISA FORM ===== (file_type: 'visa')
        $visaData = [
            'visa_type' => $request->visa_type,
            'visa_issue_date' => $request->visa_issue_date,
            'visa_expiry_date' => $request->visa_expiry_date,
            'visa_receive_date' => $request->visa_receive_date,
            'visa_issue_number' => $request->visa_issue_number,
            'visa_endorsement_date' => $request->visa_endorsement_date,
            'visa_status' => $request->visa_status,
            'endorsement_checked' => $request->has('endorsement_checked') ? 'yes' : 'no',
            'received_physically' => $request->input('received_physically_visa', 'no')
        ];

        // Scanned visa file upload
        if ($request->hasFile('scanned_visa')) {
            $file = $request->file('scanned_visa');
            $filename = time() . '_visa.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/assets/humanResource'), $filename);
            $visaData['scanned_visa'] = 'public/admin/assets/humanResource/' . $filename;
        }

        // Save Visa Form
        HrStep::updateOrCreate(
            [
                'human_resource_id' => $humanResourceId,
                'step_number' => 6,
                'file_type' => 'visa',
            ],
            $visaData
        );

        // ===== AIR BOOKING ===== (file_type: 'air_booking')
        $airBookingData = [
            'ticket_number' => $request->ticket_number,
            'flight_number' => $request->flight_number,
            'flight_route' => $request->flight_route,
            'flight_date' => $request->flight_date,
            'flight_etd' => $request->flight_etd,
            'flight_eta' => $request->flight_eta,
            'received_physically' => $request->input('received_physically_air_booking', 'no')
        ];

        // Upload ticket file
        if ($request->hasFile('upload_ticket')) {
            $file = $request->file('upload_ticket');
            $filename = time() . '_ticket.' . $file->getClientOriginalExtension();
            $file->move(public_path('admin/assets/humanResource'), $filename);
            $airBookingData['upload_ticket'] = 'public/admin/assets/humanResource/' . $filename;
        }

        // Save Air Booking
        HrStep::updateOrCreate(
            [
                'human_resource_id' => $humanResourceId,
                'step_number' => 7, // Note: Air Booking ka step_number 7 hai frontend ke according
                'file_type' => 'air_booking',
            ],
            $airBookingData
        );

        return response()->json([
            'success' => true,
            'message' => 'Step 2 data saved successfully.'
        ]);

    } catch (\Exception $e) {
        \Log::error('HR Step update failed: ' . $e->getMessage());
        return response()->json([
            'error' => true,
            'message' => $e->getMessage()
        ], 500);
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
