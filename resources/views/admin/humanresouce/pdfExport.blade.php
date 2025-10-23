<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>MANSOLSOFT - HUMAN RESOURCES REPORT</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 4px; text-align: center; }
        th { background-color: #f0f0f0; }
        img { width: 60px; height: 60px; object-fit: cover; border-radius: 4px; }
        .logo {
            text-align: center;
            margin-bottom: 10px;
        }
        .logo img {
            width: 100px;
            height: auto;
        }
        h3 {
            text-align: center;
            margin: 5px 0 15px 0;
        }
    </style>
</head>
<body>
      <!-- ✅ Company Logo Centered -->
    <div class="logo">
        @php
            $logoPath = public_path('admin/assets/images/mansol-01.png'); // 👈 apna path yahan set karo
        @endphp
        @if(file_exists($logoPath))
            <img src="data:image/png;base64,{{ base64_encode(file_get_contents($logoPath)) }}" alt="Company Logo">
        @else
            <p><strong>MANSOLSOFT</strong></p>
        @endif
    </div>
    <h3 style="text-align:center;">MANSOLSOFT - HUMAN RESOURCES REPORT</h3>
    <table>
        <thead>
            <tr>
                {{-- <th>Sr.</th> --}}
                <th>Id No</th>
                <th>Passport Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>CNIC</th>
                <th>Application Date</th>
                <th>Craft</th>
                <th>Sub-Craft</th>
                <th>Approval #</th>
                <th>City Of Interview</th>
                <th>S/O</th>
                <th>Mother Name</th>
                <th>DOB</th>
                <th>CNIC Expiry</th>
                <th>Passport Issue</th>
                <th>Passport Expiry</th>
                <th>Passport #</th>
                <th>Next Of Kin</th>
                <th>Relation</th>
                <th>Kin CNIC</th>
                <th>Shoe Size</th>
                <th>Cover Size</th>
                <th>Academic Qualification</th>
                <th>Technical Qualification</th>
                <th>Experience (Local)</th>
                <th>Experience (Gulf)</th>
                <th>District</th>
                <th>Present Address</th>
                <th>Present Address Mobile</th>
                <th>Present Address Phone</th>
                <th>Permanent Address</th>
                <th>Permanent Address Phone</th>
                <th>Permanent Address Mobile</th>
                <th>Gender</th>
                <th>Blood Group</th>
                <th>Religion</th>
                <th>Permanent Address Province</th>
                <th>Permanent Address City</th>
                <th>Citizenship</th>
                <th>Reference</th>
                <th>Visa Type</th>
                <th>Visa Status</th>
                <th>Visa Issue Date</th>
                <th>Visa Expiry Date</th>
                <th>Flight Date</th>
                <th>Flight Route</th>
                <th>CNIC Taken Status</th>
                <th>Passport Taken Status</th>
                <th>Performance Appraisal Awarded</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $row)
                <tr>
                    {{-- <td>{{ $i + 1 }}</td> --}}
                    <td>{{ $row['registration'] }}</td>
                    <td>
                        @if($row['passport_photo_base64'])
                            <img src="{{ $row['passport_photo_base64'] }}" width="60" height="60" style="object-fit: cover; border-radius:4px;">
                        @else
                            N/A
                        @endif
                    </td>

                    <td>{{ $row['name'] }}</td>
                    <td>{{ $row['email'] }}</td>
                    <td>{{ $row['cnic'] }}</td>
                    <td>{{ $row['application_date'] }}</td>
                    <td>{{ $row['craft'] }}</td>
                    <td>{{ $row['sub_craft'] }}</td>
                    <td>{{ $row['approvals'] }}</td>
                    <td>{{ $row['interview_location'] }}</td>
                    <td>{{ $row['son_of'] }}</td>
                    <td>{{ $row['mother_name'] }}</td>
                    <td>{{ $row['date_of_birth'] }}</td>
                    <td>{{ $row['cnic_expiry_date'] }}</td>
                    <td>{{ $row['doi'] }}</td>
                    <td>{{ $row['doe'] }}</td>
                    <td>{{ $row['passport'] }}</td>
                    <td>{{ $row['next_of_kin'] }}</td>
                    <td>{{ $row['relation'] }}</td>
                    <td>{{ $row['kin_cnic'] }}</td>
                    <td>{{ $row['shoe_size'] }}</td>
                    <td>{{ $row['cover_size'] }}</td>
                    <td>{{ $row['acdemic_qualification'] }}</td>
                    <td>{{ $row['technical_qualification'] }}</td>
                    <td>{{ $row['experience_local'] }}</td>
                    <td>{{ $row['experience_gulf'] }}</td>
                    <td>{{ $row['district_of_domicile'] }}</td>
                    <td>{{ $row['present_address'] }}</td>
                    <td>{{ $row['present_address_mobile'] }}</td>
                    <td>{{ $row['present_address_phone'] }}</td>
                    <td>{{ $row['permanent_address'] }}</td>
                    <td>{{ $row['permanent_address_phone'] }}</td>
                    <td>{{ $row['permanent_address_mobile'] }}</td>
                    <td>{{ $row['gender'] }}</td>
                    <td>{{ $row['blood_group'] }}</td>
                    <td>{{ $row['religion'] }}</td>
                    <td>{{ $row['permanent_address_province'] }}</td>
                    <td>{{ $row['permanent_address_city'] }}</td>
                    <td>{{ $row['citizenship'] }}</td>
                    <td>{{ $row['refference'] }}</td>
                    <td>{{ $row['visa_type'] }}</td>
                    <td>{{ $row['visa_status'] }}</td>
                    <td>{{ $row['visa_issue_date'] }}</td>
                    <td>{{ $row['visa_expiry_date'] }}</td>
                    <td>{{ $row['flight_date'] }}</td>
                    <td>{{ $row['flight_route'] }}</td>
                    <td>{{ $row['cnic_taken_status'] }}</td>
                    <td>{{ $row['passport_taken_status'] }}</td>
                    <td>{{ $row['performance_appraisal'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
