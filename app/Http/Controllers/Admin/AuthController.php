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
    public function Login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (!auth()->guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->with('error', 'Invalid email or password');
        }
        $request->session()->regenerate();
        return redirect('admin/dashboard')->with('message', 'Login Successfully!');
    }
}
