<table border="1">
    <thead>
        <tr>
            <th>Id No.</th>
            <th>Name</th>
            <th>Email</th>
            <th>CNIC</th>
            <th>Application Date</th>
            <th>Application for Post Craft</th>
            <th>Sub-Craft</th>
            <th>Approvals #</th>
            <th>City Of Interview</th>
            <th>S/O</th>
            <th>Mother Name</th>
            <th>Date Of Birth</th>
            <th>CNIC Expiry Date</th>
            <th>Date Of Issue (Passport)</th>
            <th>Date Of Expiry (Passport)</th>
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
            <th>District Of Domicile</th>
            <th>Present Address</th>
            <th>Present Address Phone</th>
            <th>Present Address Mobile</th>
            <th>Permanent Address</th>
            <th>Present Address City</th>
            <th>Permanent Address Phone</th>
            <th>Permanent Address Mobile</th>
            <th>Gender</th>
            <th>Blood Group</th>
            <th>Religion</th>
            <th>Permanent Address City</th>
            <th>Permanent Address Province</th>
            <th>Citizenship</th>
            <th>Reference</th>
            <th>Performance-Appraisal Awarded %</th>
            <th>Min Acceptable Salary</th>
            <th>Visa Type</th>
            <th>Visa Status</th>
            <th>Visa Issue Date</th>
            <th>Visa Expiry Date</th>
            <th>Flight Date</th>
            <th>Flight Route</th>
            <th>CNIC Taken Status</th>
            <th>Passport Taken Status</th>
            <th>Comment</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $row)
            <tr>
                <td>{{ $row->id ?? '' }}</td>
                <td>{{ $row->name ?? '' }}</td>
                <td>{{ $row->email ?? '' }}</td>
                <td>{{ $row->cnic ?? '' }}</td>
                <td>{{ $row->application_date ?? '' }}</td>
                <td>{{ $row->craft ?? '' }}</td>
                <td>{{ $row->sub_craft ?? '' }}</td>
                <td>{{ $row->approvals_no ?? '' }}</td>
                <td>{{ $row->city_of_interview ?? '' }}</td>
                <td>{{ $row->so ?? '' }}</td>
                <td>{{ $row->mother_name ?? '' }}</td>
                <td>{{ $row->dob ?? '' }}</td>
                <td>{{ $row->cnic_expiry ?? '' }}</td>
                <td>{{ $row->passport_issue_date ?? '' }}</td>
                <td>{{ $row->passport_expiry_date ?? '' }}</td>
                <td>{{ $row->passport_no ?? '' }}</td>
                <td>{{ $row->next_of_kin ?? '' }}</td>
                <td>{{ $row->relation ?? '' }}</td>
                <td>{{ $row->kin_cnic ?? '' }}</td>
                <td>{{ $row->shoe_size ?? '' }}</td>
                <td>{{ $row->cover_size ?? '' }}</td>
                <td>{{ $row->academic_qualification ?? '' }}</td>
                <td>{{ $row->technical_qualification ?? '' }}</td>
                <td>{{ $row->experience_local ?? '' }}</td>
                <td>{{ $row->experience_gulf ?? '' }}</td>
                <td>{{ $row->district_domicile ?? '' }}</td>
                <td>{{ $row->present_address ?? '' }}</td>
                <td>{{ $row->present_address_phone ?? '' }}</td>
                <td>{{ $row->present_address_mobile ?? '' }}</td>
                <td>{{ $row->permanent_address ?? '' }}</td>
                <td>{{ $row->present_address_city ?? '' }}</td>
                <td>{{ $row->permanent_address_phone ?? '' }}</td>
                <td>{{ $row->permanent_address_mobile ?? '' }}</td>
                <td>{{ $row->gender ?? '' }}</td>
                <td>{{ $row->blood_group ?? '' }}</td>
                <td>{{ $row->religion ?? '' }}</td>
                <td>{{ $row->permanent_address_city ?? '' }}</td>
                <td>{{ $row->permanent_address_province ?? '' }}</td>
                <td>{{ $row->citizenship ?? '' }}</td>
                <td>{{ $row->reference ?? '' }}</td>
                <td>{{ $row->performance_awarded ?? '' }}</td>
                <td>{{ $row->min_salary ?? '' }}</td>
                <td>{{ $row->visa_type ?? '' }}</td>
                <td>{{ $row->visa_status ?? '' }}</td>
                <td>{{ $row->visa_issue_date ?? '' }}</td>
                <td>{{ $row->visa_expiry_date ?? '' }}</td>
                <td>{{ $row->flight_date ?? '' }}</td>
                <td>{{ $row->flight_route ?? '' }}</td>
                <td>{{ $row->cnic_taken_status ?? '' }}</td>
                <td>{{ $row->passport_taken_status ?? '' }}</td>
                <td>{{ $row->comment ?? '' }}</td>
                <td>{{ $row->status ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
