<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Mail\CompanyLoginPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::orderBy('is_active', 'desc')->latest()->get();
        return view('admin.company.index', compact('companies'));
    }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'is_active' => 'nullable|in:0,1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('admin/assets/images/company/'), $filename);
            $image = 'public/admin/assets/images/company/' . $filename;
        } else {
            $image = 'public/admin/assets/images/company/1675332882.jpg';
        }

        /**generate random password */
        $password = random_int(10000000, 99999999);

        // Create a new subadmin record
        Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($password),
            'is_active' => $request->status,
            'image' => $image,
        ]);

        $message['email'] = $request->email;
        $message['password'] = $password;

        Mail::to($request->email)->send(new CompanyLoginPassword($message));

        // Return success message
        return redirect()->route('companies.index')->with(['message' => 'Company Created Successfully']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string',
            'is_active' => 'nullable|in:0,1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $Company = Company::findOrFail($id);

        if ($request->hasFile('image')) {

            if (File::exists($Company->image)) {
                File::delete($Company->image);
            }
            
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('admin/assets/images/company/'), $filename);
            $image = 'public/admin/assets/images/company/' . $filename;
        } else {
            $image = 'public/admin/assets/images/company/1675332882.jpg';
        }

        // Create a new subadmin record
        $Company->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'is_active' => $request->status,
            'image' => $image,
        ]);

        // Return success message
        return redirect()->route('companies.index')->with(['message' => 'Company Updated Successfully']);
    }

    public function destroy($id)
    {
        Company::destroy($id);
        return redirect()->route('companies.index')->with(['message' => 'Company Deleted Successfully']);
    }
}
