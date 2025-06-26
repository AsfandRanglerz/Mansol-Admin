<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

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
        $company = Company::where('email', $request->email)->first();
         // Check if the account is active
        if ($company->is_active != 1) {
            return back()->with('error', 'Your Account is blocked by Admin');
        }
        if (!auth()->guard('company')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return back()->with('error', 'Invalid email or password');
        }
        $request->session()->regenerate();
        return redirect('company/dashboard')->with('message', 'Login Successfully!');
    }
}
