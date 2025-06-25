<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            return redirect()->intended('admin/dashboard')->with('message', 'Admin Login Successfully!');
        }
        if (auth()->guard('subadmin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            auth()->guard('admin')->logout(); // logout other guard if active
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard')->with('message', 'SubAdmin Login Successfully!');
        }
        return back()->with('error', 'Invalid email or password');
    }
}
