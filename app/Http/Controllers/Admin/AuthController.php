<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubAdmin;
class AuthController extends Controller
{
    public function getLoginPage()
    {
        return view('admin.auth.login');
    }
    // public function Login(Request $request)
    // {

    //     $request->validate([
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);
    //     if (!auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
    //         return back()->with('error', 'Invalid email or password');
    //     }
    //     $request->session()->regenerate();
    //     return redirect('admin/dashboard')->with('message', 'Login Successfully!');
    // }

    public function login(Request $request)
    {
        if (auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            auth()->guard('subadmin')->logout(); // logout other guard if active
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard')->with('message', 'Admin Login Successfully');
        }
        $subadmin = SubAdmin::where('email', $request->email)->first();
        if ($subadmin) {
            if ($subadmin->status == 1) {
                if (auth()->guard('subadmin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    auth()->guard('admin')->logout(); // logout other guard if active
                    $request->session()->regenerate();
                    return redirect()->intended('admin/dashboard')->with('message', 'Sub-Admin Login Successfully');
                } else {
                    return back()->with('error', 'Invalid credentials');
                }
            } else {
                return back()->with('error', 'Your Account has been Blocked by Admin');
            }
        } else {
            return back()->with('error', 'No Sub-Admin found with this Email');
        }
        return back()->with('error', 'Invalid Email or Password');
    }
}
