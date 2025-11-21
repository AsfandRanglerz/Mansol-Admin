<?php

namespace App\Http\Controllers\Admin;

use App\Models\HrStep;
use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;

class HrStepController extends Controller
{
    // public function submitStep(Request $request, $step)
    // {
		
    //     $humanResource = HumanResource::findOrFail($request->human_resource_id);

    //     // Array to store file names for the step
    //     $data = [];
    //     // these are steps from 1 to 5 at backend tabel and from forntend this is step 1
    //     if ($step == 1) {
    //         // Handle CV upload
    //         if ($request->hasFile('cv')) {
    //             $file = $request->file('cv');
    //             $filename = time() . '.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $filename);
    //             $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 1,
    //                     'file_type' => 'cv',
    //                 ],
    //                 [
    //                     'file_name' => $data['file_name']
    //                 ]
    //             );
    //         }

    //         // Handle Passport Images
    //         if ($request->hasFile('passport_image_1')) {
    //             $file = $request->file('passport_image_1');
    //             $filename = uniqid('passport_front_') . '.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $filename);
    //             $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 2,
    //                     'file_type' => 'passport front',
    //                 ],
    //                 [
    //                     'file_name' => $data['file_name']
    //                 ]
    //             );
    //         }

    //         if ($request->hasFile('passport_image_2')) {
    //             $file = $request->file('passport_image_2');
    //             $filename = uniqid('passport_back_') . '.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $filename);
    //             $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 2,
    //                     'file_type' => 'passport back',
    //                 ],
    //                 [
    //                     'file_name' => $data['file_name']
    //                 ]
    //             );
    //         }

    //         if ($request->hasFile('passport_image_3')) {
    //             $file = $request->file('passport_image_3');
    //             $filename = uniqid('passport_back_') . '.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $filename);
    //             $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 2,
    //                     'file_type' => 'passport third image',
    //                 ],
    //                 [
    //                     'file_name' => $data['file_name']
    //                 ]
    //             );
    //         }

    //         // Handle CNIC Images
    //         if ($request->hasFile('cnic_front')) {
    //             $file = $request->file('cnic_front');
    //             $filename = uniqid('cnic_front_') . '.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $filename);
    //             $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 3,
    //                     'file_type' => 'cnic front',
    //                 ],
    //                 [
    //                     'file_name' => $data['file_name']
    //                 ]
    //             );
    //         }

    //         if ($request->hasFile('cnic_back')) {
    //             $file = $request->file('cnic_back');
    //             $filename = uniqid('cnic_back_') . '.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $filename);
    //             $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 3,
    //                     'file_type' => 'cnic back',
    //                 ],
    //                 [
    //                     'file_name' => $data['file_name']
    //                 ]
    //             );
    //         }

    //         // Handle Passport-size Photo
    //         if ($request->hasFile('photo')) {
    //             $file = $request->file('photo');
    //             $photoFileName = time() . '_photo.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $photoFileName);
    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 4,
    //                     'file_type' => 'photo',
    //                 ],
    //                 [
    //                     'file_name' => 'public/admin/assets/humanResource/' . $photoFileName
    //                 ]
    //             );
    //         }

    //         if ($request->hasFile('police_verification')) {
    //             $file = $request->file('police_verification');
    //             $policeFileName = time() . '_police.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $policeFileName);
    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 4,
    //                     'file_type' => 'police verification',
    //                 ],
    //                 [
    //                     'file_name' => 'public/admin/assets/humanResource/' . $policeFileName
    //                 ]
    //             );
    //         }

    //         if ($request->hasFile('account_detail')) {
    //             $file = $request->file('account_detail');
    //             $accountFileName = time() . '_account.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $accountFileName);
    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 4,
    //                     'file_type' => 'account detail',
    //                 ],
    //                 [
    //                     'file_name' => 'public/admin/assets/humanResource/' . $accountFileName
    //                 ]
    //             );
    //         }

    //         if ($request->hasFile('update_appraisal')) {
    //             $file = $request->file('update_appraisal');
    //             $appraisalFileName = time() . '_appraisal.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $appraisalFileName);
    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 4,
    //                     'file_type' => 'update appraisal',
    //                 ],
    //                 [
    //                     'file_name' => 'public/admin/assets/humanResource/' . $appraisalFileName
    //                 ]
    //             );
    //         }

    //         // Handle NOK CNIC Images
    //         if ($request->hasFile('nok_cnic_front')) {
    //             $file = $request->file('nok_cnic_front');
    //             $filename = uniqid('nok_cnic_front_') . '.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $filename);
    //             $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 5,
    //                     'file_type' => 'nok cnic front',
    //                 ],
    //                 [
    //                     'file_name' => $data['file_name']
    //                 ]
    //             );
    //         }

    //         if ($request->hasFile('nok_cnic_back')) {
    //             $file = $request->file('nok_cnic_back');
    //             $filename = uniqid('nok_cnic_back_') . '.' . $file->getClientOriginalExtension();
    //             $file->move('public/admin/assets/humanResource', $filename);
    //             $data['file_name'] = 'public/admin/assets/humanResource/' . $filename;

    //             HrStep::updateOrCreate(
    //                 [
    //                     'human_resource_id' => $humanResource->id,
    //                     'step_number' => 5,
    //                     'file_type' => 'nok cnic back',
    //                 ],
    //                 [
    //                     'file_name' => $data['file_name']
    //                 ]
    //             );
    //         }
    //     }
    //    if ($step == 2) {
    //         try {
    //             $data = [];
    //             $dataToUpdate = [
    //                 'process_status' => $request->process_status,
    //                 'medically_fit' => $request->medically_fit,
    //                 'report_date' => $request->report_date,
    //                 'valid_until' => $request->valid_until,
    //                 'lab' => $request->lab,
    //                 'any_comments' => $request->any_comments,
    //                 'original_report_recieved' => $request->has('original_report_recieved') ? 'yes' : 'no',
    //                 'visa_type' => $request->visa_type,
    //                 'visa_issue_date' => $request->visa_issue_date,
    //                 'visa_expiry_date' => $request->visa_expiry_date,
    //                 'visa_receive_date' => $request->visa_receive_date,
    //                 'visa_issue_number' => $request->visa_issue_number,
    //                 'visa_endorsement_date' => $request->visa_endorsement_date,
    //                 'visa_status' => $request->visa_status,
    //                 'endorsement_checked' => $request->has('endorsement_checked') ? 'yes' : 'no',
    //                 'ticket_number' => $request->ticket_number,
    //                 'flight_number' => $request->flight_number,
    //                 'flight_route' => $request->flight_route,
    //                 'flight_date' => $request->flight_date,
    //                 'flight_etd' => $request->flight_etd,
    //                 'flight_eta' => $request->flight_eta,
    //                 ];

    //                 // Only include file_name if file is uploaded
    //                 if ($request->hasFile('medical_report')) {
    //                 $file = $request->file('medical_report');
    //                 $filename = time() . '.' . $file->getClientOriginalExtension();
    //                 $file->move(public_path('admin/assets/humanResource'), $filename);
    //                 $dataToUpdate['file_name'] = 'public/admin/assets/humanResource/' . $filename;
    //                 }

    //                 // Only include scanned_visa if file is uploaded
    //                 if ($request->hasFile('scanned_visa')) {
    //                 $file = $request->file('scanned_visa');
    //                 $filename = time() . '_visa.' . $file->getClientOriginalExtension();
    //                 $file->move(public_path('admin/assets/humanResource'), $filename);
    //                 $dataToUpdate['scanned_visa'] = 'public/admin/assets/humanResource/' . $filename;
    //                 }

    //                 // Only include upload_ticket if file is uploaded
    //                 if ($request->hasFile('upload_ticket')) {
    //                 $file = $request->file('upload_ticket');
    //                 $filename = time() . '_ticket.' . $file->getClientOriginalExtension();
    //                 $file->move(public_path('admin/assets/humanResource'), $filename);
    //                 $dataToUpdate['upload_ticket'] = 'public/admin/assets/humanResource/' . $filename;
    //                 }

    //                 // Save or update
    //                 try {
    //                 $test = HrStep::updateOrCreate(
    //                 [
    //                 'human_resource_id' => $humanResource->id,
    //                 'step_number' => 6,
    //                 'file_type' => 'medical_report',
    //                 ],
    //                 $dataToUpdate
    //                 );

    //                 return response()->json([
    //                 'success' => true,
    //                 'data' => $test
    //                 ]);
    //                 } catch (\Exception $e) {
    //                 \Log::error("HR Step update failed: " . $e->getMessage());
    //                 return response()->json([
    //                 'error' => true,
    //                 'message' => $e->getMessage()
    //                 ], 500);
    //                 }

    //         } catch (\Exception $e) {
    //             \Log::error('HR Step update failed: ' . $e->getMessage());
    //             return back()->with('error', 'An error occurred while processing the HR step. Please try again.');
    //         }
    //     }


    //     // in db its step no 7 but in front end its step no 3
    //     if ($step == 3 && $request->step_three_file) {
    //         HrStep::updateOrCreate(
    //             [ 
    //                 'human_resource_id' => $humanResource->id,
    //                 'step_number' => 7,
    //                 'file_type' => 'step 7 pdf',
    //             ],
    //             [ 
    //                 'file_name' => $request->step_three_file,
    //                 'amount_digits' => $request->amount_digits,
    //                 'amount_words' => $request->amount_words,
    //             ]
    //         );
    //     }

    //     // in db its step no 8 but in front end its step no 4
    //     if ($step == 4 && $request->step_four_file) {
    //         HrStep::updateOrCreate(
    //             [
    //                 'human_resource_id' => $humanResource->id,
    //                 'step_number' => 8,
    //                 'file_type' => 'step 8 pdf',
    //             ],
    //             [
    //                 'file_name' => $request->step_four_file,
    //                 'amount_digits' => $request->opf,
    //                 'amount_digits1' => $request->state_life_insurance,
    //             ]
    //         );
    //     }
    //     // in db its step no 9 but in front end its step no 5
    //     if ($step == 5 && $request->step_five_file) {
    //         HrStep::updateOrCreate(
    //             [
    //                 'human_resource_id' => $humanResource->id,
    //                 'step_number' => 9,
    //                 'file_type' => 'step 9 pdf',
    //             ],
    //             [
    //                 'file_name' => $request->step_five_file,
    //             ]
    //         );
    //     }
    //     // in db its step no 10 but in front end its step no 6
    //     if ($step == 6  && $request->step_six_file) {
    //         HrStep::updateOrCreate(
    //             [
    //                 'human_resource_id' => $humanResource->id,
    //                 'step_number' => 10,
    //                 'file_type' => 'step 10 pdf',
    //             ],
    //             [
    //                 'file_name' => $request->step_six_file,
    //             ]
    //         );
    //     }

    //     if ($step == 7 && $request->step_seven_file) {
    //         HrStep::updateOrCreate(
    //             [
    //                 'human_resource_id' => $humanResource->id,
    //                 'step_number' => 11,
    //                 'file_type' => 'step 10 pdf',
    //             ],
    //             [
    //                 'file_name' => $request->step_seven_file,
    //             ]
    //         );
    //     }

    //     return response()->json(['success' => true, 'message' => 'Step ' . $step . ' submitted successfully!']);
    // }
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
            $fileName = 'public/admin/assets/humanResource/' . $filename;
        }

        HrStep::updateOrCreate(
            [
                'human_resource_id' => $humanResource->id,
                'step_number' => 1,
                'file_type' => 'cv',
            ],
            [
                'file_name'         => $fileName ?? HrStep::where('human_resource_id', $humanResource->id)->where('step_number', 1)->where('file_type', 'cv')->value('file_name'),
                'received_physically' => $request->received_physically_cv ?? 'no',
            ]
        );

        // Handle Passport Images
// Handle passport image 1 upload
/// 1. Capture checkbox value first
$passportStatus = $request->received_physically_passport === 'yes' ? 'yes' : 'no';

// 2. Passport Image 1
if ($request->hasFile('passport_image_1')) {
    $file = $request->file('passport_image_1');
    $filename = uniqid('passport_front_') . '.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $filename);

    HrStep::updateOrCreate(
        [
            'human_resource_id' => $humanResource->id,
            'step_number' => 2,
            'file_type' => 'passport front',
        ],
        [
            'file_name' => "public/admin/assets/humanResource/$filename",
            'received_physically' => $passportStatus,
        ]
    );
}

// 3. Passport Image 2
if ($request->hasFile('passport_image_2')) {
    $file = $request->file('passport_image_2');
    $filename = uniqid('passport_back_') . '.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $filename);

    HrStep::updateOrCreate(
        [
            'human_resource_id' => $humanResource->id,
            'step_number' => 2,
            'file_type' => 'passport back',
        ],
        [
            'file_name' => "public/admin/assets/humanResource/$filename",
            'received_physically' => $passportStatus,
        ]
    );
}

// 4. Passport Image 3
if ($request->hasFile('passport_image_3')) {
    $file = $request->file('passport_image_3');
    $filename = uniqid('passport_third_') . '.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $filename);

    HrStep::updateOrCreate(
        [
            'human_resource_id' => $humanResource->id,
            'step_number' => 2,
            'file_type' => 'passport third image',
        ],
        [
            'file_name' => "public/admin/assets/humanResource/$filename",
            'received_physically' => $passportStatus,
        ]
    );
}

// 5. Always update passport status row
HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 2,
        'file_type' => 'passport status',
    ],
    [
        'received_physically' => $passportStatus,
        'file_name' => null,
    ]
);

        // Handle CNIC Images
  // Handle CNIC Images with individual received status
// CNIC Front
if ($request->hasFile('cnic_front')) {
    $file = $request->file('cnic_front');
    $filename = uniqid('cnic_front_') . '.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $filename);

    HrStep::updateOrCreate(
        [
            'human_resource_id' => $humanResource->id,
            'step_number' => 3,
            'file_type' => 'cnic front',
        ],
        [
            'file_name' => 'public/admin/assets/humanResource/' . $filename,
			 'received_physically' =>$request->received_physically_cnic_back ?? 'no'
        ]
    );
}


// CNIC Back
// Handle CNIC Back file upload
if ($request->hasFile('cnic_back')) {
    $file = $request->file('cnic_back');
     $filename = uniqid('cnic_back_') . '.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $filename);

    HrStep::updateOrCreate(
        [
            'human_resource_id' => $humanResource->id,
            'step_number' => 3,
            'file_type' => 'cnic back',
        ],
        [
            'file_name' => 'admin/assets/humanResource/' . $filename,
            'received_physically' => $request->received_physically_cnic_back ?? 'no',
        ]
    );
} else {
    // Agar file upload nahi hui, checkbox value update karein
    HrStep::updateOrCreate(
        [
            'human_resource_id' => $humanResource->id,
            'step_number' => 3,
            'file_type' => 'cnic back',
        ],
        [
            'received_physically' => $request->received_physically_cnic_back ?? 'no',
        ]
    );
}


   // Handle Passport-size Photo
// Step 4: Passport-size Photo
// Pehle existing row fetch karo (agar already hai)
$existingPhoto = HrStep::where('human_resource_id', $humanResource->id)
    ->where('step_number', 4)
    ->where('file_type', 'photo')
    ->first();

if ($request->hasFile('photo')) {
    $file = $request->file('photo');
    $photoFileName = time() . '_photo.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $photoFileName);
    $fileName = 'public/admin/assets/humanResource/' . $photoFileName;
} else if ($existingPhoto) {
    // Agar file upload nahi hui, lekin row exist karti hai to existing file preserve karo
    $fileName = $existingPhoto->file_name;
} else {
    // Na file upload hui, na row exist karti hai
    $fileName = null;
}

// Update ya create row
HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 4,
        'file_type' => 'photo',
    ],
    [
        'file_name' => $fileName,
        'received_physically' => $request->received_physically_photo ?? 'no',
    ]
);


		// Police Verification

        // Step 4: Police Verification Certificate
$existingPolice = HrStep::where('human_resource_id', $humanResource->id)
    ->where('step_number', 4)
    ->where('file_type', 'police verification')
    ->first();

if ($request->hasFile('police_verification')) {
    $file = $request->file('police_verification');
    $policeFileName = time() . '_police.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $policeFileName);
    $fileName = 'public/admin/assets/humanResource/' . $policeFileName;
} else if ($existingPolice) {
    $fileName = $existingPolice->file_name;
} else {
    $fileName = null;
}

HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 4,
        'file_type' => 'police verification',
    ],
    [
        'file_name' => $fileName,
        'received_physically' => $request->received_physically_police ?? 'no',
    ]
);
// Account Detail
// Step 4: Account Detail
$existingAccount = HrStep::where('human_resource_id', $humanResource->id)
    ->where('step_number', 4)
    ->where('file_type', 'account detail')
    ->first();

// File name handling
if ($request->hasFile('account_detail')) {
    $file = $request->file('account_detail');
    $accountFileName = time() . '_account.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $accountFileName);
    $filePath = 'public/admin/assets/humanResource/' . $accountFileName;
} elseif ($existingAccount) {
    $filePath = $existingAccount->file_name; // keep existing file if no new upload
} else {
    $filePath = null; // no file
}

// Update or create
HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 4,
        'file_type' => 'account detail',
    ],
    [
        'file_name' => $filePath,
        'received_physically' => $request->received_physically_account ?? 'no',
    ]
);

		// Update Appraisal
     // Step 4: Update Appraisal
$existingAppraisal = HrStep::where('human_resource_id', $humanResource->id)
    ->where('step_number', 4)
    ->where('file_type', 'update appraisal')
    ->first();

// File name handling
if ($request->hasFile('update_appraisal')) {
    $file = $request->file('update_appraisal');
    $appraisalFileName = time() . '_appraisal.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $appraisalFileName);
    $filePath = 'public/admin/assets/humanResource/' . $appraisalFileName;
} elseif ($existingAppraisal) {
    $filePath = $existingAppraisal->file_name; // keep existing file if no new upload
} else {
    $filePath = null; // no file uploaded
}

// Update or create
HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 4,
        'file_type' => 'update appraisal',
    ],
    [
        'file_name' => $filePath,
        'received_physically' => $request->received_physically_appraisal ?? 'no',
    ]
);

        // Handle NOK CNIC Images
       // Step 5: NOK CNIC Front
$existingNokFront = HrStep::where('human_resource_id', $humanResource->id)
    ->where('step_number', 5)
    ->where('file_type', 'nok cnic front')
    ->first();

if ($request->hasFile('nok_cnic_front')) {
    $file = $request->file('nok_cnic_front');
    $filename = uniqid('nok_cnic_front_') . '.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $filename);
    $filePathFront = 'public/admin/assets/humanResource/' . $filename;
} elseif ($existingNokFront) {
    $filePathFront = $existingNokFront->file_name; // keep existing file
} else {
    $filePathFront = null; // no file uploaded
}

HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 5,
        'file_type' => 'nok cnic front',
    ],
    [
        'file_name' => $filePathFront,
        'received_physically' => $request->received_physically_nok ?? 'no',
    ]
);

// Step 5: NOK CNIC Back
$existingNokBack = HrStep::where('human_resource_id', $humanResource->id)
    ->where('step_number', 5)
    ->where('file_type', 'nok cnic back')
    ->first();

if ($request->hasFile('nok_cnic_back')) {
    $file = $request->file('nok_cnic_back');
    $filename = uniqid('nok_cnic_back_') . '.' . $file->getClientOriginalExtension();
    $file->move('public/admin/assets/humanResource', $filename);
    $filePathBack = 'public/admin/assets/humanResource/' . $filename;
} elseif ($existingNokBack) {
    $filePathBack = $existingNokBack->file_name; // keep existing file
} else {
    $filePathBack = null;
}

HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 5,
        'file_type' => 'nok cnic back',
    ],
    [
        'file_name' => $filePathBack,
        'received_physically' => $request->received_physically_nok ?? 'no',
    ]
);


        // Save overall received_physically status for Step 1
        HrStep::updateOrCreate(
            [
                'human_resource_id' => $humanResource->id,
                'step_number' => 1,
                'file_type' => 'received_physically',
            ],
            [
                'received_physically' => $request->has('received_physically_step_1') ? 'yes' : 'no'
            ]
        );
    }

    if ($step == 2) {
   try {
    // Step 6: Medical Report + Visa + Air Ticket
    $dataToUpdate = [
        'process_status' => $request->process_status,
        'medically_fit' => $request->medically_fit,
        'report_date' => $request->report_date,
        'valid_until' => $request->valid_until,
        'lab' => $request->lab,
        'any_comments' => $request->any_comments,
        'original_report_recieved' => $request->has('original_report_received') ? 'yes' : 'no',
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
        // 'received_physically_medical' => $request->received_physically_medical ?? 'no',
        // 'received_physically_visa' => $request->received_physically_visa ?? 'no',
        // 'received_physically_ticket' => $request->received_physically_ticket ?? 'no',
    ];

    // Handle file uploads individually
    if ($request->hasFile('medical_report')) {
        $file = $request->file('medical_report');
        $filename = time() . '_medical.' . $file->getClientOriginalExtension();
        $file->move(public_path('admin/assets/humanResource'), $filename);
        $dataToUpdate['file_name'] = 'public/admin/assets/humanResource/' . $filename;
    }

    if ($request->hasFile('scanned_visa')) {
        $file = $request->file('scanned_visa');
        $filename = time() . '_visa.' . $file->getClientOriginalExtension();
        $file->move(public_path('admin/assets/humanResource'), $filename);
        $dataToUpdate['scanned_visa'] = 'public/admin/assets/humanResource/' . $filename;
    }

    if ($request->hasFile('upload_ticket')) {
        $file = $request->file('upload_ticket');
        $filename = time() . '_ticket.' . $file->getClientOriginalExtension();
        $file->move(public_path('admin/assets/humanResource'), $filename);
        $dataToUpdate['upload_ticket'] = 'public/admin/assets/humanResource/' . $filename;
    }

    // Update Step 6 (Medical Report + Visa + Air Ticket)
  $step6 = HrStep::updateOrCreate(
        [
            'human_resource_id' => $humanResource->id,
            'step_number' => 6,
            'file_type' => 'medical_report', // main type for step 6
        ],
        $dataToUpdate
    );

    // Update separate received_physically checkboxes individually for Step 2
   // Medical
HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 2,
        'file_type' => 'medical_received_physically',
    ],
    [
        'received_physically' => $request->received_physically_medical === 'yes' ? 'yes' : 'no',
    ]
);

// Visa
HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 2,
        'file_type' => 'visa_received_physically',
    ],
    [
        'received_physically' => $request->received_physically_visa === 'yes' ? 'yes' : 'no',
    ]
);

// Ticket
HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 2,
        'file_type' => 'ticket_received_physically',
    ],
    [
        'received_physically' => $request->received_physically_air === 'yes' ? 'yes' : 'no',
    ]
);



    return response()->json([
        'success' => true,
        'data' => $step6
    ]);

} catch (\Exception $e) {
    \Log::error("HR Step 2/6 update failed: " . $e->getMessage());
    return response()->json([
        'error' => true,
        'message' => 'An error occurred while updating Step 2/6: ' . $e->getMessage()
    ], 500);
}
	}
    // in db its step no 7 but in front end its step no 3
 if ($step == 3 && $request->step_three_file) {

    // Debug: log the incoming request
    \Log::info('Step 3 Request Data:', $request->all());

    // Optional: see output in browser during debug
    // dd($request->all());

    // Save PDF & amounts
		$step7 = HrStep::updateOrCreate(
			[
				'human_resource_id' => $humanResource->id,
				'step_number' => 7,
				'file_type' => 'step 7 pdf',
			],
			[
				'file_name' => $request->step_three_file,
				'amount_digits' => $request->amount_digits,
				'amount_words' => $request->amount_words,
        		'received_physically' => $request->received_physically_step_3 === 'yes' ? 'yes' : 'no',
			]
    );

    // Save received_physically status
    $step3Received = HrStep::updateOrCreate(
        [
            'human_resource_id' => $humanResource->id,
            'step_number' => 3,
            'file_type' => 'step 7 pdf',
        ],
        [
            'received_physically' => $request->received_physically_step_3 === 'yes' ? 'yes' : 'no'
        ]
    );

    // Debug: log after saving
    \Log::info('Step 3 received_physically saved:', ['id' => $step3Received->id, 'value' => $step3Received->received_physically]);

    return response()->json([
        'success' => true,
        'message' => 'Step 3 data saved successfully',
        'received_physically' => $step3Received->received_physically,
    ]);
}


    // in db its step no 8 but in front end its step no 4
 if ($step == 4 && $request->step_four_file) {

    // Save PDF & amounts
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
        'received_physically' => $request->received_physically_step_4 === 'yes' ? 'yes' : 'no',
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
       			 'received_physically' => $request->received_physically_step_5 === 'yes' ? 'yes' : 'no',
            ]
        );

        // Save received_physically status for Step 5
       
    }

    // in db its step no 10 but in front end its step no 6
    if ($step == 6 && $request->step_six_file) {
       HrStep::updateOrCreate(
    [
        'human_resource_id' => $humanResource->id,
        'step_number' => 10,
        'file_type' => 'step 10 pdf',
    ],
    [
        'file_name' => $request->step_six_file,
        // Capital Yes/No match frontend ke checkbox value ke saath
        'received_physically' => $request->received_physically_step_6 === 'Yes' ? 'Yes' : 'No',
    ]
);


        // Save received_physically status for Step 6
      
    }

    if ($step == 7 && $request->step_seven_file) {
        HrStep::updateOrCreate(
            [
                'human_resource_id' => $humanResource->id,
                'step_number' => 11,
                'file_type' => 'step 11 pdf',
            ],
            [
                'file_name' => $request->step_seven_file,
				'received_physically' => $request->received_physically_step_11 === 'yes' ? 'yes' : 'no',

            ]
        );

    }

    return response()->json(['success' => true, 'message' => 'Step ' . $step . ' submitted successfully!']);
}
}
