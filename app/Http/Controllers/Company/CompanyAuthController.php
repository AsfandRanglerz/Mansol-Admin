<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyAuthController extends Controller
{
    public function getCompanyLoginPage()
    {
        return view('companypanel.auth.login');
    }
    public function companyLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (!auth()->guard('company')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->with('error', 'Invalid email or password');
        }
        $request->session()->regenerate();
        return redirect('company/dashboard')->with('message', 'Login Successfully!');
    }
}
