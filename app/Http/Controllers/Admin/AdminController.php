<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\Admin;
use App\Models\SubAdmin;
use App\Models\Company;
use App\Models\HumanResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    //
    public function getdashboard()
    {
        $total_human_resoures = HumanResource::count();
        $total_companies = Company::get()->count();
        $total_projects = HumanResource::get()->count();
        // dd([
        //     'admin' => Auth::guard('admin')->check(),
        //     'subadmin' => Auth::guard('subadmin')->check(),
        //         ]);

        return view('admin.index', compact('total_human_resoures', 'total_projects', 'total_companies'));
    }
    public function getProfile()
    {
        if (auth::guard('admin')->check()) {
            // return 'admin';
            $data = Admin::find(Auth::guard('admin')->id());
        }elseif(auth::guard('subadmin')->check()){
            // return "subadmin";
            $data = SubAdmin::find(Auth::guard('subadmin')->id());
        }
        return view('admin.auth.profile', compact('data'));
    }

    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        $data = $request->only(['name', 'email', 'phone']);
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/admin/assets/images/users/'), $filename);
            $data['image'] = 'public/admin/assets/images/users/' . $filename;
        }
        if (auth::guard('admin')->check()) {
            // return 'admin';
            Admin::find(Auth::guard('admin')->id())->update($data);
        }elseif(auth::guard('subadmin')->check()){
            SubAdmin::find(Auth::guard('subadmin')->id())->update($data);
        }
        return back()->with(['status' => true, 'message' => 'Profile Updated Successfully']);
    }
    public function forgetPassword()
    {
        return view('admin.auth.forgetPassword');
    }
    public function adminResetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            ]);

            $email = $request->email;

            $exists = DB::table('admins')->where('email', $email)->exists()
                    || DB::table('sub_admins')->where('email', $email)->exists();

            if (!$exists) {
                return back()->withErrors(['message' => 'This email does not exist']);
            }
        $exists = DB::table('password_resets')->where('email', $request->email)->first();
        if ($exists) {
            return back()->with('message', 'Reset Password link has been already sent');
        } else {
            $token = Str::random(30);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
            ]);

            $data['url'] = url('change_password', $token);
            Mail::to($request->email)->send(new ResetPasswordMail($data));
            return back()->with('message', 'Reset Password Link Send Successfully');
        }
    }
    public function change_password($id)
    {

        $user = DB::table('password_resets')->where('token', $id)->first();

        if (isset($user)) {
            return view('admin.auth.chnagePassword', compact('user'));
        }
    }

    public function resetPassword(Request $request)
    {

        $request->validate([
            'password' => 'required|min:8',
            'confirmed' => 'required',

        ]);
        if ($request->password != $request->confirmed) {

            return back()->with(['error' => 'Password not matched']);
        }
        $password = bcrypt($request->password);
        $tags_data = [
            'password' => bcrypt($request->password)
        ];
        if (Admin::where('email', $request->email)->update($tags_data) || SubAdmin::where('email', $request->email)->update($tags_data)) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return redirect('admin-login')->with('message','Password Reset Successfully!');
        }
    }
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('subadmin')->check()) {
            Auth::guard('subadmin')->logout();
        }   

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('admin-login')->with('message', 'Log Out Successfully');
    }

}
