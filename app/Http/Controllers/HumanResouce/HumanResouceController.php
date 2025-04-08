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
   public function generateForm7(Request $request)
   {
       $data = $request->all();
       $hr = HumanResource::find($data['human_resource_id']);
        //    $pdfPath = 'admin/assets/humanresource/'.$hr->id.'/form-7.pdf';
        //    $test = $data['amount_words'];
        //    $ys =  $test."/-";
        //    return [$data];
        //    return $hr;
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
       $pdf->Write(10, $hr->name);  // Name
   
       $pdf->SetFont('Helvetica', '', 8);
       $pdf->SetXY(50, 78);
       $pdf->Write(10, $hr->present_address_phone . $hr->present_address_mobile); // Contact Number

       $pdf->SetFont('Helvetica', 'B', 8);
       $pdf->SetXY(122, 72);
       $pdf->Write(10, $hr->son_of); // S/O

       $pdf->SetFont('Helvetica', '', 8);
       $pdf->SetXY(121, 78);
       $idCardNumber = $hr->cnic;
       foreach (str_split($idCardNumber) as $char) {
           $pdf->Cell(3.7, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
       } // ID Card Number

       $pdf->SetFont('Helvetica', '', 8);
       $pdf->SetXY(50, 84);
       $pdf->Write(10, $hr->present_address); // Address

       $pdf->SetFont('Helvetica', '', 8);
       $pdf->SetXY(50, 90);
       $pdf->Write(10, "PAKISTAN"); // Country

       $pdf->SetFont('Helvetica', '', 8);
       $pdf->SetXY(122, 90);
       $pdf->Write(10, $hr->passport); // Passport Number

       // Overseas Employment Section

       $pdf->SetFont('Helvetica', 'B', 8);
       $pdf->SetXY(49, 104);
       $pdf->Write(10, "MANSOL MANPOWER SOLUTIONS"); // Name

       $pdf->SetFont('Helvetica', '', 7);
       $pdf->SetXY(49, 111.6);
       $pdf->Write(7, "OFFICE NO. 123, 1ST FLOOR, DIVINE MEGA-2, NEW AIRPORT ROAD, LAHORE CANTT, PAKISTAN."); // Address

       $pdf->SetFont('Helvetica', '', 8);
       $pdf->SetXY(49, 116);
       $pdf->Write(10, "Pakistan"); // Country

       $pdf->SetFont('Helvetica', '', 8);
       $pdf->SetXY(142, 116);
       $pdf->Write(10, "3054/LHR"); // O.E.P. License Number

       // Deposit Details

    //    $pdf->SetFont('Helvetica', '', 8);
    //    $pdf->SetXY(55, 129.2);
    //    $idCardNumber = "3103461677457234";
    //    foreach (str_split($idCardNumber) as $char) {
    //        $pdf->Cell(3.1, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
    //    } // Account Number

    //    $pdf->SetFont('Helvetica', '', 8);
    //    $pdf->SetXY(126, 129.2);
    //    $idCardNumber = "12345678";
    //    foreach (str_split($idCardNumber) as $char) {
    //        $pdf->Cell(3.1, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
    //    } // Cheque Number

       
       $pdf->SetFont('Helvetica', 'B', 8);
       $pdf->SetXY(68, 142.4);
       $pdf->Write(10, $data['amount_digits']. "/-"); // Amount in figures
   
       $pdf->SetFont('Helvetica', 'B', 8);
       $pdf->SetXY(65, 146);
       $pdf->Write(10, $data['amount_words']);

       // Save filled PDF to public folder
       $pdfPath = 'admin/assets/humanresource/'.$hr->id.'-form-7.pdf';
       $pdf->Output(public_path($pdfPath), 'F'); 
       $pdfPath1 = 'public/admin/assets/humanresource/'.$hr->id.'-form-7.pdf';
   
       // Return JSON response with URL
       return response()->json([
            'hr'=>$hr,
           'request'=>$data,
           'pdf_url' => asset($pdfPath1), // Generates correct URL
           'url' => $pdfPath1, // Generates correct URL
       ]);
   }

//    public function generateForm7(Request $request)
//     {
//         $data = $request->all();
//         $hr = HumanResource::find($data['human_resource_id']);
//         $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
//         $pdf->AddPage();
    
//         // Set the source PDF file
//         $path = public_path('admin/assets/Allied_Blank.pdf'); 
//         $pdf->setSourceFile($path);
    
//         // Import first page
//         $tplId = $pdf->importPage(1);
//         $pdf->useTemplate($tplId, 10, 10, 200);
    
//         // Set font and text color
//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetTextColor(0, 0, 0);
    
//         // Date

//         $pdf->SetXY(157, 32.6);  
//         $pdf->Write(10, "05/03/2025");  // Name

//         // Depositor Details

//         $pdf->SetXY(49, 51);  
//         $pdf->Write(10, "MUHAMMAD ATIF SHAHZAD");  // Name
    
//         $pdf->SetXY(49, 58);
//         $pdf->Write(10, "0333 - 0324 (4257417)"); // Contact Number

//         $pdf->SetXY(119, 51);
//         $pdf->Write(10, "MUHAMMAD IBRAHIM"); // S/O

//         $pdf->SetXY(118, 58);
//         $idCardNumber = "35201-1229593-1";
//         foreach (str_split($idCardNumber) as $char) {
//             $pdf->Cell(3.7, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
//         } // ID Card Number

//         // Intending Emigrant

//         $pdf->SetFont('Helvetica', 'B', 8);
//         $pdf->SetXY(50, 72);  
//         $pdf->Write(10, "FAISAL TARIQ");  // Name
    
//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetXY(50, 78);
//         $pdf->Write(10, "03027619611 03067614351"); // Contact Number

//         $pdf->SetFont('Helvetica', 'B', 8);
//         $pdf->SetXY(122, 72);
//         $pdf->Write(10, "MUHAMMAD TARIQ"); // S/O

//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetXY(121, 78);
//         $idCardNumber = "3103461677457";
//         foreach (str_split($idCardNumber) as $char) {
//             $pdf->Cell(3.7, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
//         } // ID Card Number

//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetXY(50, 84);
//         $pdf->Write(10, "Lahore, Pakistan"); // Address

//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetXY(50, 90);
//         $pdf->Write(10, "PAKISTAN"); // Country

//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetXY(122, 90);
//         $pdf->Write(10, " CS7967453"); // Passport Number

//         // Overseas Employment Section

//         $pdf->SetFont('Helvetica', 'B', 8);
//         $pdf->SetXY(49, 104);
//         $pdf->Write(10, "WORKWEB"); // Name

//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetXY(49, 110);
//         $pdf->Write(10, "WORKWEB"); // Address

//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetXY(49, 116);
//         $pdf->Write(10, "Pakistan"); // Country

//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetXY(142, 116);
//         $pdf->Write(10, "WORKWEB"); // O.E.P. License Number

//         // Deposit Details

//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetXY(55, 129.2);
//         $idCardNumber = "3103461677457234";
//         foreach (str_split($idCardNumber) as $char) {
//             $pdf->Cell(3.1, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
//         } // Account Number

//         $pdf->SetFont('Helvetica', '', 8);
//         $pdf->SetXY(126, 129.2);
//         $idCardNumber = "12345678";
//         foreach (str_split($idCardNumber) as $char) {
//             $pdf->Cell(3.1, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
//         } // Cheque Number

        
//         $pdf->SetFont('Helvetica', 'B', 8);
//         $pdf->SetXY(68, 142.4);
//         $pdf->Write(10, "15000 /-"); // Amount in figures

//         $pdf->SetFont('Helvetica', 'B', 8);
//         $pdf->SetXY(65, 146);
//         $pdf->Write(10, "FIFTEEN THOUSAND ONLY"); // Amount in words

//         // Save filled PDF to public folder
//         $pdfPath = 'admin/assets/form-7.pdf';
//         $pdf->Output(public_path($pdfPath), 'F'); 
    
//         // Return JSON response with URL
//         return response()->json([
//             'pdf_url' => asset($pdfPath) // Generates correct URL
//         ]);
//     }

    // Form 8 PDF Generator
    public function generateForm8(Request $request)
    {
        $data = $request->all();
       $hr = HumanResource::find($data['human_resource_id']);
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
        $pdf->Write(10, $hr->name);  // Slip no.

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetXY(52, 61);  
        $pdf->Write(10, $hr->present_address_mobile);  // Mobile Number

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetXY(104, 55.7);
        $idCardNumber = $hr->cnic;
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // CNIC

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 71);  
        $pdf->Write(10, $data['opf'].' /-');  // OPF Welfare Fund

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 76);  
        $pdf->Write(10, $data['state_life'].' /-');  // State Life

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(167, 81);  
        $pdf->Write(10, "Rs 200/-");  // OEC Emigrant Fund it remain fixed

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(165, 86.2);  
        $pdf->Write(10, $data['total_amount'].' /-');  // Total price

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(44, 86.4);  
        $pdf->Write(10, $data['total_amount_words']);  // Price in words
        
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
        $pdf->Write(10, $hr->name);  // Slip no.

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetXY(52, 165.2);  
        $pdf->Write(10, $hr->present_address_mobile);  // Mobile Number

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetXY(104, 159.9);
        $idCardNumber = $hr->cnic;
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // CNIC

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 175.2);  
        $pdf->Write(10, $data['opf'].' /-');  // OPF Welfare Fund

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 180.2);  
        $pdf->Write(10, $data['state_life'].' /-');  // State Life

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(167, 185.2);  
        $pdf->Write(10, "Rs 200/-");  // OEC Emigrant Fund it remain fixed

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(165, 86.2);  
        $pdf->Write(10, $data['total_amount'].' /-');  // Total price

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(44, 86.4);  
        $pdf->Write(10, $data['total_amount_words']);  // Price in words

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
        $pdf->Write(10, $hr->name);  // Slip no.

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetXY(52, 59);  
        $pdf->Write(10, $hr->present_address_mobile);  // Mobile Number

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetXY(104, 53.7);
        $idCardNumber = $hr->cnic;
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // CNIC

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 69);  
        $pdf->Write(10, $data['opf'].' /-');  // OPF Welfare Fund

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 74);  
        $pdf->Write(10, $data['state_life'].' /-');  // State Life

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(167, 79);  
        $pdf->Write(10, "Rs 200/-");  // OEC Emigrant Fund it remain fixed

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(165, 84.2);  
        $pdf->Write(10,  $data['total_amount'].' /-');  // Total price

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(44, 84.4);  
        $pdf->Write(10, $data['total_amount_words'] );  // Price in words
        
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
        $pdf->Write(10, $hr->name);  // Slip no.

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetXY(52, 163.2);  
        $pdf->Write(10, $hr->present_address_mobile);  // Mobile Number

        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetXY(104, 157.9);
        $idCardNumber = $hr->cnic;
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5, 10, $char, 0, 0, 'C'); // Adjust the width (5) as needed
        } // CNIC

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 173.2);  
        $pdf->Write(10, $data['opf'].' /-');  // OPF Welfare Fund

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(165, 178.2);  
        $pdf->Write(10, $data['state_life'].' /-');  // State Life

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(167, 183.2);  
        $pdf->Write(10, "Rs 200/-");  // OEC Emigrant Fund it remain fixed

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->SetXY(165, 188.4);  
        $pdf->Write(10,  $data['total_amount'].' /-');  // Total price

        $pdf->SetFont('Helvetica', '', 8);
        $pdf->SetXY(44, 188.2);
        $pdf->Write(10, $data['total_amount_words']);  // Price in words 

        // Save filled PDF to public folder
        // $pdfPath = 'admin/assets/nbp-form.pdf';
        // $pdf->Output(public_path($pdfPath), 'F'); 
        $pdfPath = 'admin/assets/humanresource/'.$hr->id.'-nbp-form.pdf';
        $pdf->Output(public_path($pdfPath), 'F'); 
        $pdfPath1 = 'public/admin/assets/humanresource/'.$hr->id.'-nbp-form.pdf';
        
        // Return JSON response with URL
        // Return JSON response with URL
        return response()->json([
            // 'hr'=>$hr,
            // 'request'=>$data,
            'pdf_url' => asset($pdfPath1), // Generates correct URL
            'url' => $pdfPath1, // Generates correct URL
        ]);
    }

     // Form 9 PDF Generator
     public function generateForm9(Request $request)
    {
        $data = $request->all();
        $hr = HumanResource::find($data['human_resource_id']);
        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->AddPage();
    
        // Set the source PDF file for Form 9
        $path = public_path('admin/assets/Challan-92-Blank.pdf'); 
        $pdf->setSourceFile($path);
    
        // Import first page
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 10, 10, 200);
    
        // Set font and text color
        $pdf->SetFont('Helvetica', '', 6);
        $pdf->SetTextColor(0, 0, 0);
    
        $pdf->SetFont('Helvetica', 'B', 6);
        $pdf->SetXY(57.2, 51.6);
        $pdf->Write(10, $hr->name); // Name

        $pdf->SetFont('Helvetica', 'B', 6);
        $pdf->SetXY(57.2, 69.2);
        $pdf->Write(10, "3054/LHR"); // Liecense Number

        $pdf->SetFont('Helvetica', 'B', 6);
        $pdf->SetXY(57.2, 126.2);
        $pdf->Write(10, $hr->name); // Name

        $pdf->SetFont('Helvetica', 'B', 6);
        $pdf->SetXY(57.2, 144.2);
        $pdf->Write(10, "3054/LHR"); // Liecense Number

        $pdf->SetFont('Helvetica', 'B', 6);
        $pdf->SetXY(57.2, 201);
        $pdf->Write(10, $hr->name); // Name

        $pdf->SetFont('Helvetica', 'B', 6);
        $pdf->SetXY(57.2, 219);
        $pdf->Write(10, "3054/LHR"); // Liecense Number

        
        // Save filled PDF to public folder
        $pdfPath = 'admin/assets/humanresource/'.$hr->id.'-Challan-92.pdf';
        $pdf->Output(public_path($pdfPath), 'F'); 
        $pdfPath1 = 'public/admin/assets/humanresource/'.$hr->id.'-Challan-92.pdf';
        // Return JSON response with URL
        return response()->json([
            'pdf_url' => asset($pdfPath1), // Generates correct URL
            'url' => $pdfPath1, // Generates correct URL
        ]);
    }
    
    // Form 10 PDF Generator
    public function generateForm10(Request $request)
    {
        $data = $request->all();
        $hr = HumanResource::find($data['human_resource_id']);
        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        $pdf->AddPage();
    
        // Set the source PDF file for Form 10
        $path = public_path('admin/assets/State_Life_Blank.pdf'); 
        $pdf->setSourceFile($path);
    
        // Import first page
        $tplId = $pdf->importPage(1);
        $pdf->useTemplate($tplId, 10, 10, 200);
    
        // Set font and text color
        $pdf->SetFont('Times', '', 9);
        $pdf->SetTextColor(0, 0, 0);
    
        
        $pdf->SetXY(86, 66.4);
        $pdf->Write(10, $hr->name); // Name

        $pdf->SetXY(86, 71.4);
        $pdf->Write(10, $hr->son_of); // Father name

        $pdf->SetXY(86, 76.4);
        $pdf->Write(10, $hr->date_of_birth); // Date

        $pdf->SetXY(87, 81.6);
        $idCardNumber = $hr->cnic;
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
        $pdfPath = 'admin/assets/life-insurance.pdf';
        $pdf->Output(public_path($pdfPath), 'F'); 
    
        $pdfPath = 'admin/assets/humanresource/'.$hr->id.'-life-insurance.pdf';
        $pdf->Output(public_path($pdfPath), 'F'); 
        $pdfPath1 = 'public/admin/assets/humanresource/'.$hr->id.'-life-insurance.pdf';
        // Return JSON response with URL
        return response()->json([
            'pdf_url' => asset($pdfPath1), // Generates correct URL
            'url' => $pdfPath1, // Generates correct URL
        ]);
    }

    // Form 11 PDF Generator
    public function generateForm11(Request $request)
    {
        $data = $request->all();
        $hr = HumanResource::find($data['human_resource_id']);
        $pdf = new \setasign\Fpdi\Tcpdf\Fpdi();
        
        // Set the source PDF file for Form 10
        $path = public_path('admin/assets/FSA_Blank.pdf'); 
        $pdf->setSourceFile($path);
        
        // Import and use the first page
        $pdf->AddPage();
        $tplId1 = $pdf->importPage(1);
        $pdf->useTemplate($tplId1, 10, 10, 200);
        
        // Set font and text color
        $pdf->SetFont('Times', '', 9);
        $pdf->SetTextColor(0, 0, 0);
        
        // Add content to the first page
       
        $pdf->SetXY(60, 44);
        $idCardNumber = "26-02-2025";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5.7, 10, $char, 0, 0, 'C');
        } // Date

        $pdf->SetFont('Times', 'B', 11);
        $pdf->SetXY(60, 53);
        $pdf->Write(10, "MANSOL MANPOWER SOLUTIONS"); // Name of agency

        $pdf->SetFont('Times', '', 9);
        $pdf->SetXY(60, 58);
        $idCardNumber = "LHR 3054";
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(7.2, 10, $char, 0, 0, 'C');
        } // License Number

        $pdf->SetFont('Times', '', 9);
        $pdf->SetXY(60, 76);
        $idCardNumber = $hr->name;
        $maxCharsPerLine = 14;
        $currentLine = 0;

        foreach (str_split($idCardNumber) as $index => $char) {
            if ($index > 0 && $index % $maxCharsPerLine == 0) {
                $currentLine++;
                $pdf->SetXY(60, 76 + ($currentLine * 4)); // Move to the next line
            }
            $pdf->Cell(7.2, 3, $char, 0, 0, 'C');
        } // Emigrant Name

        $pdf->SetFont('Times', '', 9);
        $pdf->SetXY(60, 82.4);
        $pdf->Write(10, $hr->son_of); // Name of father

        $pdf->SetXY(60, 88.5);
        $idCardNumber = $hr->cnic;
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5.7, 10, $char, 0, 0, 'C');
        } // CNIC

        $pdf->SetXY(60, 101);
        $idCardNumber = $hr->present_address_phone ;
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(7.2, 10, $char, 0, 0, 'C');
        } // Cell no

        $pdf->SetFont('Times', '', 5);
        $pdf->SetXY(59.5, 116);
        $idCardNumber = $hr->permanent_address;
        $charWidth = 1.7; // Adjust width per character
        $charHeight = 4;  // Adjust height per character
        $maxCharsPerRow = 57; // Number of characters that fit in one row
        $currentLine = 0;

        foreach (str_split($idCardNumber) as $index => $char) {
            // Move to the next row if the limit is reached
            if ($index > 0 && $index % $maxCharsPerRow == 0) {
                $currentLine++;
                $pdf->SetXY(59.5, 116 + ($currentLine * $charHeight));
            }
            
            // Print each character in a separate cell without a border
            $pdf->Cell($charWidth, $charHeight, $char, 0, 0, 'C'); 
        }

        $pdf->SetFont('Times', '', 9);
        $pdf->SetXY(60, 122);
        $pdf->Write(10, $hr->permanent_address_city); // City

        $pdf->SetFont('Times', '', 9);
        $pdf->SetXY(128, 122);
        $pdf->Write(10, $hr->district_of_domicile); // District

        $pdf->SetFont('Times', '', 9);
        $pdf->SetXY(60, 129);
        $pdf->Write(10, $hr->permanent_address_province); // Province

        $pdf->SetFont('Times', '', 9);
        $pdf->SetXY(60, 138);
        $pdf->Write(10, $hr->acdemic_qualification); // Qualification

        $pdf->SetXY(60, 147.3);
        $idCardNumber = $hr->passport;
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(7.2, 10, $char, 0, 0, 'C');
        } // Cell no

        $pdf->SetFont('Times', '', 9);
        $pdf->SetXY(60, 152);
        $pdf->Write(10, $hr->passport_issue_place); // Place of issue
        
        $pdf->SetXY(127.5, 152);
        $idCardNumber = $hr->doi;
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(3.4, 10, $char, 0, 0, 'C');
        } // Date of issue

        $pdf->SetFont('Times', '', 9);
        $pdf->SetXY(60, 162);
        $pdf->Write(10, $hr->next_of_kin); // Name of Nominance
        
        $pdf->SetXY(60, 167);
        $idCardNumber = $hr->kin_cnic;
        foreach (str_split($idCardNumber) as $char) {
            $pdf->Cell(5.7, 10, $char, 0, 0, 'C');
        } // CNIC no

        $pdf->SetFont('Times', '', 9);
        $pdf->SetXY(60, 173);
        $pdf->Write(10, $hr->relation); // Name of Nominance
        
        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(53.5, 187);
        $pdf->Write(10, "4350304643339"); // Recipt no

        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(53.5, 206.3);
        $pdf->Write(10, "OEC FEE"); // OEC FEE

        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(95, 197);
        $pdf->Write(10, "MODEL TOWN"); // NBP Branch

        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(95, 201);
        $pdf->Write(10, "New Airport Road"); // ABP Branch

        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(150, 191);
        $pdf->Write(10, "2000"); // Welfare Fund 

        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(150, 194);
        $pdf->Write(10, "2500"); // Insurance Fund 

        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(150, 197);
        $pdf->Write(10, "500"); // Insurance Fund 

        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(150, 201);
        $pdf->Write(10, "6000"); // Bank Certificate/Service

        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(150, 206.5);
        $pdf->Write(10, "200"); // OEC

        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(150, 210);
        $pdf->Write(10, "10"); // Adhesive Fee

        // Import and use the second page
        $pdf->AddPage();
        $tplId2 = $pdf->importPage(2);
        $pdf->useTemplate($tplId2, 10, 10, 200);

        // Add content to the second page
        $pdf->SetFont('Times', '', 9);
        $pdf->SetTextColor(0, 0, 0);

        

        // Save filled PDF to public folder
        // $pdfPath = 'admin/assets/fsa-form.pdf';
        // $pdf->Output(public_path($pdfPath), 'F'); 

        $pdfPath = 'admin/assets/humanresource/'.$hr->id.'-fsa-form.pdf';
        $pdf->Output(public_path($pdfPath), 'F'); 
        $pdfPath1 = 'public/admin/assets/humanresource/'.$hr->id.'-fsa-form.pdf';
        // Return JSON response with URL
        return response()->json([
            'pdf_url' => asset($pdfPath1), // Generates correct URL
            'url' => $pdfPath1, // Generates correct URL
        ]);
    }

}
