<?php

namespace App\Http\Controllers\Admin;

use App\Models\SubCraft;
use App\Models\MainCraft;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Mail\HumanResourceUserLoginPassword;

class HumanResourceController extends Controller
{
    public function index()
    {
        $HumanResources = HumanResource::where('status', '!=', 2)
            ->with('Crafts')
            ->with('SubCrafts')
            ->orderBy('status', 'asc')->latest()->get();

        // dd($HumanResources);
        return view('admin.humanresouce.index', compact('HumanResources'));
    }
    public function create()
    {
        $crafts = MainCraft::where('status', '=', 1)->latest()->get();
        // dd($crafts);
        $lastReg = HumanResource::pluck('registration')->toArray();
        $filteredValues = array_filter($lastReg, function ($value) {
            return !is_null($value); // Remove null values
        });
        $integerValues = array_map('intval', $filteredValues);
        $maxValue = !empty($integerValues) ? max($integerValues) : 1000;

        $registration = $maxValue >= 1000 ? $maxValue + 1 : 1001;
        // dd($maxValue);

        return view('admin.humanresouce.create', compact('crafts', 'registration'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'registration' => 'required|string|max:255',
            'application_date' => 'required|date',
            'status' => 'nullable|string',
            'experience' => 'nullable|string',
            'craft_id' => 'required|string|max:255',
            'sub_craft_id' => 'nullable|string|max:255',
            'approvals' => 'required|string|max:255',
            'medical_doc' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'son_of' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'blood_group' => 'required|string|max:3',
            'date_of_birth' => 'required|date',
            'city_of_birth' => 'required|string|max:255',
            'cnic' => 'required|string',
            'cnic_expiry_date' => 'required|date',
            'doi' => 'required|date',
            'doe' => 'required|date',
            'passport' => 'required|string|max:255',
            'passport_issue_place' => 'required|string|max:255',
            'religion' => 'required|string|max:255',
            'martial_status' => 'required|string|max:255',
            'next_of_kin' => 'required|string|max:255',
            'relation' => 'required|string|max:255',
            'kin_cnic' => 'required|string',
            'shoe_size' => 'required|string|max:255',
            'cover_size' => 'required|string|max:255',
            'acdemic_qualification' => 'required|string|max:255',
            'technical_qualification' => 'nullable|string|max:255',
            'profession' => 'required|string|max:255',
            'district_of_domicile' => 'required|string|max:255',
            'present_address' => 'required|string',
            'present_address_phone' => 'required|string',
            'present_address_mobile' => 'required|string',
            'email' => 'required|email|unique:human_resources,email',
            'present_address_city' => 'required|string|max:255',
            'permanent_address' => 'required|string',
            'permanent_address_phone' => 'required|string',
            'permanent_address_mobile' => 'required|string',
            'permanent_address_city' => 'required|string|max:255',
            'permanent_address_province' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'citizenship' => 'required|string|max:255',
            'refference' => 'nullable|string|max:255',
            'performance_appraisal' => 'nullable|string|max:255',
            'min_salary' => 'required|string|max:255',
            'comment' => 'nullable|string',
        ]);

        if ($request->hasfile('medical_doc')) {
            $file = $request->file('medical_doc');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/admin/assets/medical_doc/'), $filename);
            $medical_doc = 'public/admin/assets/medical_doc/' . $filename;
        }else{
            $medical_doc = null;
        }

        /**generate random password */
        $password = random_int(10000000, 99999999);

        // Create a new subadmin record
        HumanResource::create([
            'name' => $request->name,
            'password' => bcrypt($password),
            'status' => $request->status,
            'registration' => $request->registration,
            'application_date' => $request->application_date,
            'craft_id' => $request->craft_id,
            'sub_craft_id' => $request->sub_craft_id,
            'experience' => $request->experience,
            'approvals' => $request->approvals,
            'medical_doc' => $medical_doc,
            'son_of' => $request->son_of,
            'mother_name' => $request->mother_name,
            'blood_group' => $request->blood_group,
            'date_of_birth' => $request->date_of_birth,
            'city_of_birth' => $request->city_of_birth,
            'cnic' => $request->cnic,
            'cnic_expiry_date' => $request->cnic_expiry_date,
            'doi' => $request->doi,
            'doe' => $request->doe,
            'passport' => $request->passport,
            'passport_issue_place' => $request->passport_issue_place,
            'religion' => $request->religion,
            'martial_status' => $request->martial_status,
            'next_of_kin' => $request->next_of_kin,
            'relation' => $request->relation,
            'kin_cnic' => $request->kin_cnic,
            'shoe_size' => $request->shoe_size,
            'cover_size' => $request->cover_size,
            'acdemic_qualification' => $request->acdemic_qualification,
            'technical_qualification' => $request->technical_qualification,
            'profession' => $request->profession,
            'district_of_domicile' => $request->district_of_domicile,
            'present_address' => $request->present_address,
            'present_address_phone' => $request->present_address_phone,
            'present_address_mobile' => $request->present_address_mobile,
            'email' => $request->email,
            'present_address_city' => $request->present_address_city,
            'permanent_address' => $request->permanent_address,
            'permanent_address_phone' => $request->permanent_address_phone,
            'permanent_address_mobile' => $request->permanent_address_mobile,
            'permanent_address_city' => $request->permanent_address_city,
            'permanent_address_province' => $request->permanent_address_province,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'refference' => $request->refference,
            'performance_appraisal' => $request->performance_appraisal,
            'min_salary' => $request->min_salary,
            'comment' => $request->comment,
        ]);

        $message['email'] = $request->email;
        $message['password'] = $password;

        Mail::to($request->email)->send(new HumanResourceUserLoginPassword($message));

        // Return success message
        return redirect()->route('humanresource.index')->with(['message' => 'Human Resource Created Successfully']);
    }

    public function edit($id)
    {

        $Crafts = MainCraft::where('status', '=', 1)->orderBy('name', 'asc')->get();
        $HumanResource = HumanResource::find($id);
        // return $subAdmin;

        return view('admin.humanresouce.edit', compact('HumanResource', 'Crafts'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'registration' => 'nullable|string|max:255',
            'application_date' => 'nullable|date',
            'status' => 'nullable|string',
            'craft_id' => 'nullable|string|max:255',
            'sub_craft_id' => 'nullable|string|max:255',
            'approvals' => 'nullable|string|max:255',
            'medical_doc' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048',
            'experience' => 'nullable|string',
            'name' => 'required|string|max:255',
            'son_of' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:3',
            'date_of_birth' => 'nullable|date',
            'city_of_birth' => 'nullable|string|max:255',
            'cnic' => 'nullable|string',
            'cnic_expiry_date' => 'nullable|date',
            'doi' => 'nullable|date',
            'doe' => 'nullable|date',
            'passport' => 'nullable|string|max:255',
            'passport_issue_place' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'martial_status' => 'nullable|string|max:255',
            'next_of_kin' => 'nullable|string|max:255',
            'relation' => 'nullable|string|max:255',
            'kin_cnic' => 'nullable|string',
            'shoe_size' => 'nullable|string|max:255',
            'cover_size' => 'nullable|string|max:255',
            'acdemic_qualification' => 'nullable|string|max:255',
            'technical_qualification' => 'nullable|string|max:255',
            'profession' => 'nullable|string|max:255',
            'district_of_domicile' => 'nullable|string|max:255',
            'present_address' => 'nullable|string',
            'present_address_phone' => 'nullable|string',
            'present_address_mobile' => 'nullable|string',
            'present_address_city' => 'nullable|string|max:255',
            'permanent_address' => 'nullable|string',
            'permanent_address_phone' => 'nullable|string',
            'permanent_address_mobile' => 'nullable|string',
            'permanent_address_city' => 'nullable|string|max:255',
            'permanent_address_province' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'citizenship' => 'nullable|string|max:255',
            'refference' => 'nullable|string|max:255',
            'performance_appraisal' => 'nullable|string|max:255',
            'min_salary' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
        ]);
        // dd($request);

        $HumanResource = HumanResource::findOrFail($id);

        if ($request->hasFile('medical_doc')) {
            $destination = 'public/admin/assets/img/users/' . $HumanResource->medical_doc;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('medical_doc');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/medical_doc', $filename);
            $medical_doc = 'public/admin/assets/medical_doc/' . $filename;
        }else{
            $medical_doc = null;
        }

        $HumanResource->update([
            'registration' => $request->registration,
            'application_date' => $request->application_date,
            'craft_id' => $request->craft_id,
            'sub_craft_id' => $request->sub_craft_id,
            'approvals' => $request->approvals,
            'medical_doc' => $medical_doc,
            'experience' => $request->experience,
            'name' => $request->name,
            'status' => $request->status,
            'son_of' => $request->son_of,
            'mother_name' => $request->mother_name,
            'blood_group' => $request->blood_group,
            'date_of_birth' => $request->date_of_birth,
            'city_of_birth' => $request->city_of_birth,
            'cnic' => $request->cnic,
            'cnic_expiry_date' => $request->cnic_expiry_date,
            'doi' => $request->doi,
            'doe' => $request->doe,
            'passport' => $request->passport,
            'passport_issue_place' => $request->passport_issue_place,
            'religion' => $request->religion,
            'martial_status' => $request->martial_status,
            'next_of_kin' => $request->next_of_kin,
            'relation' => $request->relation,
            'kin_cnic' => $request->kin_cnic,
            'shoe_size' => $request->shoe_size,
            'cover_size' => $request->cover_size,
            'acdemic_qualification' => $request->acdemic_qualification,
            'technical_qualification' => $request->technical_qualification,
            'profession' => $request->profession,
            'district_of_domicile' => $request->district_of_domicile,
            'present_address' => $request->present_address,
            'present_address_phone' => $request->present_address_phone,
            'present_address_mobile' => $request->present_address_mobile,
            'present_address_city' => $request->present_address_city,
            'permanent_address' => $request->permanent_address,
            'permanent_address_phone' => $request->permanent_address_phone,
            'permanent_address_mobile' => $request->permanent_address_mobile,
            'permanent_address_city' => $request->permanent_address_city,
            'permanent_address_province' => $request->permanent_address_province,
            'gender' => $request->gender,
            'citizenship' => $request->citizenship,
            'refference' => $request->refference,
            'performance_appraisal' => $request->performance_appraisal,
            'min_salary' => $request->min_salary,
            'comment' => $request->comment,
        ]);

        return redirect()->route('humanresource.index')->with('message', 'Human Resource Updated Successfully');
    }

    public function destroy($id)
    {
        // return $id;
        HumanResource::destroy($id);
        return redirect()->route('humanresource.index')->with(['message' => 'Human Resource Deleted Successfully']);
    }

    
}
