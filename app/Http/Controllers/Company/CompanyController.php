<?php

namespace App\Http\Controllers\Company;

use App\Models\Company;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CompanyController extends Controller
{
    public function getdashboard()
    {
        $user_id = auth()->guard('company')->user()->id;
        $projects = Project::where('company_id', $user_id)->latest()->get();
        $projects_count = Project::where('company_id', $user_id)->count();
        // dd($company);
        return view('companypanel.index', compact('projects', 'projects_count'));
    }
    public function getProfile()
    {
        $data = Company::find(Auth::guard('company')->id());
        return view('companypanel.auth.profile', compact('data'));
    }

    public function update_profile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
        $data = $request->only(['name', 'email', 'phone']);
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); // getting image extension
            $filename = time() . '.' . $extension;
            $file->move(public_path('/admin/assets/images/users/'), $filename);
            $data['image'] = 'public/admin/assets/images/users/' . $filename;
        }
        Company::find(Auth::guard('company')->id())->update($data);
        return back()->with(['status' => true, 'message' => 'Profile Updated Successfully']);
    }
    public function forgetPassword()
    {
        return view('companypanel.auth.forgetPassword');
    }
    public function adminResetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:companies,email',
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

            $data['url'] = url('company-change_password', $token);
            Mail::to($request->email)->send(new ResetPasswordMail($data));
            return back()->with('message', 'Reset Password Link Send Successfully');
        }
    }
    public function change_password($id)
    {

        $user = DB::table('password_resets')->where('token', $id)->first();

        if (isset($user)) {
            return view('companypanel.auth.chnagePassword', compact('user'));
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
        if (Company::where('email', $request->email)->update($tags_data)) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return redirect('company')->with('message', 'Password Reset Successfully!');
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('company')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('company')->with('message', 'Log Out Successfully');
    }
}
