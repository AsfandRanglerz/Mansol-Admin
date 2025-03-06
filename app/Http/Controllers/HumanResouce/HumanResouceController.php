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

    // Form 7 PDF Generator
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

    // Form 8 PDF Generator
    public function generateForm8()
    {
        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        
        // Set the source PDF file
        $path = public_path('admin/assets/NBP_Blank.pdf'); 
        $pdf->setSourceFile($path);
        
        // Import first page
        $pdf->AddPage();
        $tplId1 = $pdf->importPage(1);
        $pdf->useTemplate($tplId1, 10, 10, 200);
        
        // Set font and text color
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        
        // Depositor Copy
        $pdf->SetFont('Helvetica', 'B', 6);
        $pdf->SetXY(155, 32.6);  
        $pdf->Write(10, "-297466");  // Slip no.

        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetXY(129, 45.8);
        $idCardNumber = "06-03-2025";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // Date

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(52, 56);  
        $pdf->Write(10, "AMIR AZIZ");  // Slip no.

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetXY(52, 61);  
        $pdf->Write(10, "03244257417");  // Mobile Number

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetXY(104, 55.7);
        $idCardNumber = "35202-2974669-1";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // CNIC

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 71);  
        $pdf->Write(10, "Rs 4000/-");  // OPF Welfare Fund

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 76);  
        $pdf->Write(10, "Rs 2500/-");  // State Life

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(167, 81);  
        $pdf->Write(10, "Rs 200/-");  // OEC Emigrant Fund it remain fixed

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(165, 86.2);  
        $pdf->Write(10, "Rs 6700/-");  // Total price

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(44, 86.4);  
        $pdf->Write(10, "SIX THOUSAND SEVEN HUNDRED RUPESS");  // Price in words
        
        // BE & OE Copy
        $pdf->SetFont('Helvetica', 'B', 6);
        $pdf->SetXY(155, 137);  
        $pdf->Write(10, "-297466");  // Slip no.

        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetXY(129, 149.2);
        $idCardNumber = "06-03-2025";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // Date

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(52, 160.2);  
        $pdf->Write(10, "AMIR AZIZ");  // Slip no.

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetXY(52, 165.2);  
        $pdf->Write(10, "03244257417");  // Mobile Number

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetXY(104, 159.9);
        $idCardNumber = "35202-2974669-1";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // CNIC

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 175.2);  
        $pdf->Write(10, "Rs 4000/-");  // OPF Welfare Fund

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 180.2);  
        $pdf->Write(10, "Rs 2500/-");  // State Life

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(167, 185.2);  
        $pdf->Write(10, "Rs 200/-");  // OEC Emigrant Fund it remain fixed

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(165, 190.4);  
        $pdf->Write(10, "Rs 6700/-");  // Total price

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(44, 190.2);  
        $pdf->Write(10, "SIX THOUSAND SEVEN HUNDRED RUPESS");  // Price in words 

        // Import second page
        $pdf->AddPage();
        $tplId2 = $pdf->importPage(2);
        $pdf->useTemplate($tplId2, 10, 10, 200);
        
        // Set font and text color
        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        
        // Repeat the same content for the second page if needed
        // Bank Copy
        $pdf->SetFont('Helvetica', 'B', 6);
        $pdf->SetXY(155, 31);  
        $pdf->Write(10, "-297466");  // Slip no.

        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetXY(129, 43.8);
        $idCardNumber = "06-03-2025";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // Date

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(52, 54);  
        $pdf->Write(10, "AMIR AZIZ");  // Slip no.

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetXY(52, 59);  
        $pdf->Write(10, "03244257417");  // Mobile Number

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetXY(104, 53.7);
        $idCardNumber = "35202-2974669-1";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // CNIC

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 69);  
        $pdf->Write(10, "Rs 4000/-");  // OPF Welfare Fund

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 74);  
        $pdf->Write(10, "Rs 2500/-");  // State Life

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(167, 79);  
        $pdf->Write(10, "Rs 200/-");  // OEC Emigrant Fund it remain fixed

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(165, 84.2);  
        $pdf->Write(10, "Rs 6700/-");  // Total price

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(44, 84.4);  
        $pdf->Write(10, "SIX THOUSAND SEVEN HUNDRED RUPESS");  // Price in words
        
        // Bank Copy
        $pdf->SetFont('Helvetica', 'B', 6);
        $pdf->SetXY(155, 135);  
        $pdf->Write(10, "-297466");  // Slip no.

        $pdf->SetFont('Helvetica', '', 9);
        $pdf->SetXY(129, 147.2);
        $idCardNumber = "06-03-2025";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // Date

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(52, 157.9);  
        $pdf->Write(10, "AMIR AZIZ");  // Slip no.

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetXY(52, 163.2);  
        $pdf->Write(10, "03244257417");  // Mobile Number

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetXY(104, 157.9);
        $idCardNumber = "35202-2974669-1";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // CNIC

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 173.2);  
        $pdf->Write(10, "Rs 4000/-");  // OPF Welfare Fund

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 178.2);  
        $pdf->Write(10, "Rs 2500/-");  // State Life

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(167, 183.2);  
        $pdf->Write(10, "Rs 200/-");  // OEC Emigrant Fund it remain fixed

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(165, 188.4);  
        $pdf->Write(10, "Rs 6700/-");  // Total price

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(44, 188.2);
        $pdf->Write(10, "SIX THOUSAND SEVEN HUNDRED RUPESS");  // Price in words 

        // Save filled PDF to public folder
        $pdfPath = 'admin/assets/form-8.pdf';
        $pdf->Output(public_path($pdfPath), 'F'); 
        
        // Return JSON response with URL
        return response()->json([
            'pdf_url' => asset($pdfPath) // Generates correct URL
        ]);
    }
    
    // Form 9 PDF Generator
    public function generateForm9()
    {
        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->AddPage();
    
        // Set the source PDF file for Form 9
        $path = public_path('admin/assets/State_Life_Blank.pdf'); 
        $pdf->setSourceFile($path);
    
        // Import first page
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 10, 10, 200);
    
        // Set font and text color
        $pdf->SetFont('Times', '', 9);
        $pdf->SetTextColor(0, 0, 0);
    
        
        $pdf->SetXY(86, 66.4);
        $pdf->Write(10, "TALIB HUUSAIN"); // Name

        $pdf->SetXY(86, 71.4);
        $pdf->Write(10, "ALLAH DINO"); // Father name

        $pdf->SetXY(86, 76.4);
        $pdf->Write(10, "06 / 03 / 2025"); // Date

        $pdf->SetXY(87, 81.6);
        $idCardNumber = "4350304643339";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5.5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // NIC Number

        
        $pdf->SetXY(92.2, 87);
        $pdf->Write(10, "LT6913331"); // Number

        $pdf->SetXY(94.2, 91.3);
        $pdf->Write(10, "Apr 26, 2023"); // Date

        $pdf->SetXY(102.2, 97.5);
        $pdf->Write(10, "Job"); // Occupation

        $pdf->SetXY(131.2, 87);
        $pdf->Write(10, "Apr 26, 2023"); // Issued Date

        $pdf->SetXY(131.2, 92);
        $pdf->Write(10, "KASHMORE"); // Place

        $pdf->SetXY(86.2, 105.5);
        $pdf->MultiCell(90, 10, "VILLAGE FAQEER MUHAMMAD KHAN CHAKRANI\nPOKAND KOT KHUJAL TEHSIL KAND KOT DISTT KASHMORE", 0, 'L', 0, 1); // Postal Address

        $pdf->SetXY(86.2, 118);
        $pdf->MultiCell(90, 10, "Adrees", 0, 'L', 0, 1); // Address Abroad

        $pdf->SetXY(86.2, 123);
        $pdf->MultiCell(90, 10, "Adrees", 0, 'L', 0, 1); // Address Abroad of Employer

        $pdf->SetXY(95.2, 125.5);
        $pdf->Write(10, "AZMIYA"); // Particular person name

        $pdf->SetXY(87, 132);
        $idCardNumber = "4350304643339";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // NIC Number

        $pdf->SetXY(119, 137.5);
        $pdf->Write(10, "Wife"); // Wife

        $pdf->SetXY(87, 147);
        $pdf->Write(10, "Rs. 1,000,000/-(Rupees One Million Only)"); // Price

        $pdf->SetXY(87, 152);
        $pdf->Write(10, "Two years"); // Time Period

        $pdf->SetXY(87, 158);
        $pdf->Write(10, "Apr 26, 2023"); // Date of renewal of insurance

        $pdf->SetXY(87, 165.5);
        $pdf->Write(10, "Rs. 2500/- (Rupees Two Thousand Five Hundred only)"); // Amount Of Premium Paid 
        // Save filled PDF to public folder
        $pdfPath = 'admin/assets/form-9.pdf';
        $pdf->Output(public_path($pdfPath), 'F'); 
    
        // Return JSON response with URL
        return response()->json([
            'pdf_url' => asset($pdfPath) // Generates correct URL
        ]);
    }

    // Form 10 PDF Generator
    public function generateForm10()
    {
        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->AddPage();
    
        // Set the source PDF file for Form 10
        $path = public_path('admin/assets/FSA_Blank.pdf'); 
        $pdf->setSourceFile($path);
    
        // Import first page
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 10, 10, 200);
    
        // Set font and text color
        $pdf->SetFont('Times', '', 9);
        $pdf->SetTextColor(0, 0, 0);
    
        
        $pdf->SetXY(86, 66.4);
        $pdf->Write(10, "TALIB HUUSAIN"); // Name

        $pdf->SetXY(86, 71.4);
        $pdf->Write(10, "ALLAH DINO"); // Father name

        $pdf->SetXY(86, 76.4);
        $pdf->Write(10, "06 / 03 / 2025"); // Date

        $pdf->SetXY(87, 81.6);
        $idCardNumber = "4350304643339";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5.5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // NIC Number

        
        $pdf->SetXY(92.2, 87);
        $pdf->Write(10, "LT6913331"); // Number

        $pdf->SetXY(94.2, 91.3);
        $pdf->Write(10, "Apr 26, 2023"); // Date

        $pdf->SetXY(102.2, 97.5);
        $pdf->Write(10, "Job"); // Occupation

        $pdf->SetXY(131.2, 87);
        $pdf->Write(10, "Apr 26, 2023"); // Issued Date

        $pdf->SetXY(131.2, 92);
        $pdf->Write(10, "KASHMORE"); // Place

        $pdf->SetXY(86.2, 105.5);
        $pdf->MultiCell(90, 10, "VILLAGE FAQEER MUHAMMAD KHAN CHAKRANI\nPOKAND KOT KHUJAL TEHSIL KAND KOT DISTT KASHMORE", 0, 'L', 0, 1); // Postal Address

        
        // Save filled PDF to public folder
        $pdfPath = 'admin/assets/form-10.pdf';
        $pdf->Output(public_path($pdfPath), 'F'); 
    
        // Return JSON response with URL
        return response()->json([
            'pdf_url' => asset($pdfPath) // Generates correct URL
        ]);
    }

}
