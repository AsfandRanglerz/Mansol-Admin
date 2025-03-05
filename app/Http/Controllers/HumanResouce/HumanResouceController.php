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
// Pdf module
use setasign\Fpdi\Tcpdf\Fpdi;

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

    // Pdf module function
    public function generateForm7()
    {
        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->AddPage();
    
        // Set the source PDF file
        $path = public_path('admin/assets/Allied_Blank.pdf'); 
        $pdf->setSourceFile($path);
    
        // Import first page
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 10, 10, 200);
    
        // Set font and text color
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(0, 0, 0);
    
        // Date

        $pdf->SetXY(157, 32.6);  
        $pdf->Write(10, "05/03/2025");  // Name

        // Depositor Details

        $pdf->SetXY(49, 51);  
        $pdf->Write(10, "MUHAMMAD ATIF SHAHZAD");  // Name
    
        $pdf->SetXY(49, 58);
        $pdf->Write(10, "0333 - 0324 (4257417)"); // Contact Number

        $pdf->SetXY(119, 51);
        $pdf->Write(10, "MUHAMMAD IBRAHIM"); // S/O

        $pdf->SetXY(118, 58);
        $idCardNumber = "35201-1229593-1";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(3.7, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // ID Card Number

        // Intending Emigrant

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(50, 72);  
        $pdf->Write(10, "FAISAL TARIQ");  // Name
    
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(50, 78);
        $pdf->Write(10, "03027619611 03067614351"); // Contact Number

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(122, 72);
        $pdf->Write(10, "MUHAMMAD TARIQ"); // S/O

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(121, 78);
        $idCardNumber = "3103461677457";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(3.7, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // ID Card Number

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(50, 84);
        $pdf->Write(10, "Lahore, Pakistan"); // Address

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(50, 90);
        $pdf->Write(10, "PAKISTAN"); // Country

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(122, 90);
        $pdf->Write(10, " CS7967453"); // Passport Number

        // Overseas Employment Section

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(49, 104);
        $pdf->Write(10, "WORKWEB"); // Name

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(49, 110);
        $pdf->Write(10, "WORKWEB"); // Address

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(49, 116);
        $pdf->Write(10, "Pakistan"); // Country

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(142, 116);
        $pdf->Write(10, "WORKWEB"); // O.E.P. License Number

        // Deposit Details

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(55, 129.2);
        $idCardNumber = "3103461677457234";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(3.1, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // Account Number

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(126, 129.2);
        $idCardNumber = "12345678";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(3.1, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // Cheque Number

        
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(68, 142.4);
        $pdf->Write(10, "15000 /-"); // Amount in figures

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(65, 146);
        $pdf->Write(10, "FIFTEEN THOUSAND ONLY"); // Amount in words

        // Save filled PDF to public folder
        $pdfPath = 'admin/assets/form-7.pdf';
        $pdf->Output(public_path($pdfPath), 'F'); 
    
        // Return JSON response with URL
        return response()->json([
            'pdf_url' => asset($pdfPath) // Generates correct URL
        ]);
    }
    

}
