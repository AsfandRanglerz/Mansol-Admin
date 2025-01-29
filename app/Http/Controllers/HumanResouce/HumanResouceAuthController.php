<?php

namespace App\Http\Controllers\HumanResouce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HumanResouceAuthController extends Controller
{
    public function getHrLoginPage()
    {
        return view('humanresouce.auth.login');
    }
    public function loginHR(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (!auth()->guard('humanresource')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->with('error', 'Invalid email or password');
        }
        $request->session()->regenerate();
        return redirect('human-resouce/dashboard')->with('message', 'Login Successfully!');
    }
}
