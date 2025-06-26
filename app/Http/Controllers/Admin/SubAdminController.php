<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\SubAdmin;
use Illuminate\Http\Request;
use App\Mail\UserLoginPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;


class SubAdminController extends Controller
{
    public function index()
    {
        $subAdmins = SubAdmin::with('role')->orderBy('status', 'desc')->latest()->get();
        // return $subAdmin;
        return view('admin.subadmin.index', compact('subAdmins'));
    }

    public function create()
    {
        $roles = Role::all();
        // return $roles;
        return view('admin.subadmin.create', compact('roles'));
    }


    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sub_admins,email',
            'role_id' => 'required|integer',
            'status' => 'required|in:0,1',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('admin/assets/images/users/'), $filename);
            $image = 'public/admin/assets/images/users/' . $filename;
        } else {
            $image = 'public/admin/assets/images/avator.png';
        }

        /**generate random password */
        // $password = random_int(10000000, 99999999);
        $password = 12345678;

        // Create a new subadmin record
        SubAdmin::create([
            'name' => $request->name,
            'password' => bcrypt($password),
            'email' => $request->email,
            'role_id' => $request->role_id,
            'status' => $request->status,
            'image' => $image
        ]);

        $message['email'] = $request->email;
        $message['password'] = $password;

        // Mail::to($request->email)->send(new UserLoginPassword($message));

        // Return success message
        return redirect()->route('subadmin.index')->with(['message' => 'Sub-Admin Created Successfully']);
    }

    public function edit($id)
    {
        $roles = Role::all();

        $subAdmin = SubAdmin::find($id);
        // return $subAdmin;

        return view('admin.subadmin.edit', compact('roles', 'subAdmin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required',
            'status' => 'required',
        ]);

        $subAdmin = SubAdmin::findOrFail($id);

        if ($request->hasFile('image')) {
            $destination = 'public/admin/assets/img/users/' . $subAdmin->image;
            if (File::exists($destination)) {
                File::delete($destination);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('public/admin/assets/images/users', $filename);
            $image = 'public/admin/assets/images/users/' . $filename;
            $subAdmin->image = $image;
        }

        $subAdmin->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'status' => $request->status,
            // 'image' => $image,
        ]);

        return redirect()->route('subadmin.index')->with('message', 'Sub-Admin Updated Successfully');
    }

    public function destroy($id)
    {
        // return $id;
        SubAdmin::destroy($id);
        return redirect()->route('subadmin.index')->with(['message' => 'Sub-Admin Deleted Successfully']);
    }
}
