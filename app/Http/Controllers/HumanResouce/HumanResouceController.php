<?php

namespace App\Http\Controllers\HumanResouce;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HumanResource;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HumanResouceController extends Controller
{
    public function getdashboard()
    {
        $user = Auth::guard('humanresource')->user();
        return view('humanresouce.index', compact('user'));
    }
    public function getProfile()
    {
        $data = HumanResource::find(Auth::guard('humanresource')->id());
        return view('humanresouce.auth.profile', compact('data'));
    }

    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            // 'email' => 'required',
            'present_address_mobile' => 'required'
        ]);
        $data = $request->only(['name', 'email', 'present_address_mobile']);
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/admin/assets/images/users/'), $filename);
            $data['image'] = 'public/admin/assets/images/users/' . $filename;
        }
        HumanResource::find(Auth::guard('humanresource')->id())->update($data);
        return back()->with(['status' => true, 'message' => 'Profile Updated Successfully']);
    }
    public function forgetPassword()
    {
        return view('humanresouce.auth.forgetPassword');
    }
    public function adminResetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:human_resources,email',
        ]);
        $exists = DB::table('password_resets')->where('email', $request->email)->first();
        if ($exists) {
            return back()->with('message', 'Reset Password link has been already sent');
        } else {
            $token = Str::random(30);
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $token,
            ]);

            $data['url'] = url('human-resouce-change_password', $token);
            Mail::to($request->email)->send(new ResetPasswordMail($data));
            return back()->with('message', 'Reset Password Link Send Successfully');
        }
    }
    public function change_password($id)
    {

        $user = DB::table('password_resets')->where('token', $id)->first();

        if (isset($user)) {
            return view('humanresouce.auth.chnagePassword', compact('user'));
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
        if (HumanResource::where('email', $request->email)->update($tags_data)) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return redirect('human-resouce')->with('message', 'Password Reset Successfully!');
        }
    }
    
    public function logout(Request $request)
    {
        Auth::guard('humanresource')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('human-resouce')->with('message', 'Log Out Successfully');
    }
}
