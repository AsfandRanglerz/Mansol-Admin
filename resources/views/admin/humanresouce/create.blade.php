@extends('admin.layout.app')
@section('title', 'Create Human Resource')
@section('content')


<div class="main-content" style="min-height: 562px;">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <a class="btn btn-primary mb-3 text-white" href="{{ route('humanresource.index') }}">
                        Back
                    </a>
                    <div class="card">
                        <div class="card-header">
                            <div class="col-12 d-flex justify-content-between align-items-center">
                                <h4>Add Human Resource</h4>
                                
                            </div>
                        </div>
                        <div class="card-body table-striped table-bordered table-responsive">
                            <form id="createSubadminForm" action="{{ route('humanresource.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="registration">Id No.</label>
                                            <input type="number" class="form-control" id="registration"
                                                name="registration" value="{{ $registration }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="city_of_interview">Interview Location</label>
                                            <select name="city_of_interview" class="form-control" id="cityOfInterview" >
                                                <option value="" selected disabled>Select location</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ strtolower($city->name) }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            
                                            @error('city_of_interview')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="company_id">Company</label>
                                            <select name="company_id" id="company_id" class="form-control">
                                                <option value="">Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-none" id="project-group">
                                        <div class="form-group">
                                            <label class="text-danger" for="project_id">Project</label>
                                            <select name="project_id" id="project_id" class="form-control">
                                                <option value="" selected disabled>Select Project</option>
                                            </select>
                                            @error('project_id')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 d-none" id="demand-group">
                                        <div class="form-group">
                                            <label class="text-danger" for="demand_id">Demand</label>
                                            <select name="demand_id" id="demand_id" class="form-control">
                                                <option value="" selected disabled>Select Demand</option>
                                            </select>
                                            @error('demand_id')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="craft">Application for Post</label>
                                            <select name="craft_id" class="form-control" id="craft">
                                                <option value="" selected disabled>Select Craft</option>
                                                @foreach ($crafts as $craft)
                                                <option value="{{ $craft->id }}">{{ $craft->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('craft_id')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="sub_craft">Sub-Craft</label>
                                            <select name="sub_craft_id" class="form-control" id="sub_craft">
                                                <option value="" selected disabled>Select Sub-Craft</option>
                                            </select>
                                            @error('sub_craft')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="application_date">Application Date</label>
                                            <input type="date" class="form-control" id="application_date"
                                                name="application_date" value="{{ date('Y-m-d') }}"  readonly>
                                            @error('application_date')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="approvals">Approvals</label>
                                            <select name="approvals" id="" class="form-control">
                                                <option value="">Select Company</option>
                                                @foreach (['ARAMCO', 'SABIC', 'PDO', 'ADNOC', 'Shell', 'Dolphin', 'Q Con', 'Qatar Gas', 'Oryx', 'Oxchem'] as $company)
                                                <option value="{{ strtolower($company) }}">{{ $company }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('approvals')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="medical_doc">Approval Document</label>
                                            <input type="file" class="form-control" id="medical_doc" name="medical_doc">
                                            @error('medical_doc')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                   <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="name">Name *</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name') }}"  placeholder="name">
                                            @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="son_of">S/O *</label>
                                            <input type="text" class="form-control" id="son_of" name="son_of"
                                                value="{{ old('son_of') }}" placeholder="Father Name" >
                                            @error('son_of')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="mother_name">Mother Name</label>
                                            <input type="text" class="form-control" id="mother_name" name="mother_name"
                                                value="{{ old('mother_name') }}" placeholder="Mother Name" >
                                            @error('mother_name')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="blood_group">Blood Group</label>
                                            <select name="blood_group" class="form-control" >
                                                <option value="" selected disabled>Select Blood Group</option>
                                                @foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $blood)
                                                <option value="{{ strtolower($blood) }}">{{ $blood }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('blood_group')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="date_of_birth">Date Of Birth</label>
                                            <input type="date" class="form-control" id="date_of_birth"
                                                name="date_of_birth" value="{{ old('date_of_birth') }}" >
                                                <div class="text-danger" id="dob-error" style="display: none;">Age should not be less than 21 years</div>
                                            @error('date_of_birth')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="city_of_birth">City Of Birth</label>
                                            <select name="city_of_birth" class="form-control" id="citySelect" >
                                                <option value="" selected disabled>Select City</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ strtolower($city->name) }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            
                                            @error('city_of_birth')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="cnic">CNIC *</label>
                                            <input type="number" class="form-control" id="cnic" name="cnic"
                                                value="{{ old('cnic') }}" placeholder="XXXXX-XXXXXXX-X" >
                                            @error('cnic')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="cnic_expiry_date">CNIC Expiry Date</label>
                                            <input type="date" class="form-control" id="cnic_expiry_date"
                                                name="cnic_expiry_date" value="{{ old('cnic_expiry_date') }}" >
                                            @error('cnic_expiry_date')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="passport">Passport #</label>
                                            <input type="text" class="form-control" id="passport" name="passport"
                                                value="{{ old('passport') }}" >
                                            @error('passport')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="passport_issue_place">Passport Place Of Issue</label>
                                                <select name="passport_issue_place" class="form-control" >
                                                    <option value="" selected disabled>Select City</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{ strtolower($city->name) }}"
                                                            {{ old('passport_issue_place') == strtolower($city->name) ? 'selected' : '' }}>
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                
                                            @error('passport_issue_place')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="doi">Data Of Issue/Passport</label>
                                            <input type="date" class="form-control" id="doi" name="doi"
                                                value="{{ old('doi') }}" >
                                            @error('doi')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="doe">Data Of Expiry/Passport</label>
                                            <input type="date" class="form-control" id="doe" name="doe"
                                                value="{{ old('doe') }}" >
                                            @error('doe')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="religion">Religion *</label>
                                            <select name="religion" class="form-control" >
                                                <option value="" selected disabled>Select Religion</option>
                                                @foreach (['Muslim', 'Hindu', 'Christian', 'Buddhist', 'Jewish', 'Sikh']
                                                as $religion)
                                                <option value="{{ strtolower($religion) }}" {{ old('religion',
                                                    strtolower($religion))}}>
                                                    {{ $religion }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('religion')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="martial_status">Marital Status *</label>
                                            <select name="martial_status" class="form-control" >
                                                <option value="" selected disabled>Select Marital</option>
                                                <option value="single">Single</option>
                                                <option value="married">Married</option>
                                                <option value="divorced">Divorced</option>
                                                <option value="widowed">Widowed</option>
                                                <option value="separated">Separated</option>
                                            </select>
                                            @error('martial_status')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="next_of_kin">Next Of Kin</label>
                                            <input type="text" class="form-control" id="next_of_kin" name="next_of_kin"
                                                value="{{ old('next_of_kin') }}" >
                                            @error('next_of_kin')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="relation">Relation</label>
                                            <select class="form-control" id="relation" name="relation" >
                                                <option value="">Select Relation</option>
                                                @foreach (['Father', 'Mother', 'Brother', 'Sister', 'Spouse', 'Friend',
                                                'Other'] as $relation)
                                                <option value="{{ strtolower($relation) }}" {{ old('relation',
                                                    strtolower($relation))}}>
                                                    {{ $relation }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @error('relation')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="kin_cnic">Kin CNIC</label>
                                            <input type="number" class="form-control" id="kin_cnic" name="kin_cnic"
                                                value="{{ old('kin_cnic') }}" placeholder="XXXXX-XXXXXXX-X" >
                                            @error('kin_cnic')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="shoe_size">Shoe Size</label>
                                            <select name="shoe_size" class="form-control" >
                                                <option value="" selected disabled>Select Shoe Size</option>
                                                <option value="small">Small</option>
                                                <option value="medium">Medium</option>
                                                <option value="large">Large</option>
                                                <option value="extra large">Extra Large</option>
                                            </select>
                                            @error('shoe_size')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="cover_size">Cover Size</label>
                                            <select name="cover_size" class="form-control" >
                                                <option value="" selected disabled>Select Cover Size</option>
                                                @for ($i = 36; $i <= 46; $i++) <option value="{{ $i }}">{{ $i }}
                                                    </option>
                                                    @endfor
                                            </select>
                                            @error('cover_size')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="acdemic_qualification">Academic
                                                Qualification *</label>
                                            <select name="acdemic_qualification" class="form-control" >
                                                <option value="" selected disabled>Select Qualification</option>
                                                <option value="no_formal_education">No Formal Education</option>
                                                <option value="primary">Primary Education</option>
                                                <option value="secondary">Secondary Education</option>
                                                <option value="high_school">High School Diploma</option>
                                                <option value="bachelor">Bachelor's Degree</option>
                                                <option value="master">Master's Degree</option>
                                                <option value="doctorate">Doctorate (PhD)</option>
                                                <option value="professional_certification">Professional Certification
                                                </option>
                                                <option value="other">Other</option>
                                            </select>
                                            @error('acdemic_qualification')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="technical_qualification">Technical
                                                Qualification *</label>

                                            <select name="technical_qualification" id="qualification"
                                                class="form-control">
                                                <option value="" selected disabled>Select Qualification</option>

                                                <optgroup label="Academic Degrees">
                                                <optgroup label="Bachelor's Degrees">
                                                    <option value="Bachelor of Mechanical Engineering">Bachelor of
                                                        Mechanical Engineering</option>
                                                    <option value="Bachelor of Electrical Engineering">Bachelor of
                                                        Electrical Engineering</option>
                                                    <option value="Bachelor of Civil Engineering">Bachelor of Civil
                                                        Engineering</option>
                                                    <option value="Bachelor of Chemical Engineering">Bachelor of
                                                        Chemical Engineering</option>
                                                    <option value="Bachelor of Petroleum Engineering">Bachelor of
                                                        Petroleum Engineering</option>
                                                    <option value="Bachelor of Environmental Sciences">Bachelor of
                                                        Environmental Sciences</option>
                                                    <option value="Bachelor of Mechatronics Engineering">Bachelor of
                                                        Mechatronics Engineering</option>
                                                    <option value="Bachelor of Mining Engineering">Bachelor of Mining
                                                        Engineering</option>
                                                    <option value="Bachelor of Sustainable Energy Engineering">Bachelor
                                                        of Sustainable Energy Engineering</option>
                                                    <option value="Bachelor of Architecture Engineering">Bachelor of
                                                        Architecture Engineering</option>
                                                    <option value="Bachelor of Computer Sciences">Bachelor of Computer
                                                        Sciences</option>
                                                    <option value="Bachelor of Information Technology">Bachelor of
                                                        Information Technology</option>
                                                    <option value="Bachelor of Telecommunication Engineering">Bachelor
                                                        of Telecommunication Engineering</option>
                                                    <option value="Bachelor of Business Administration">Bachelor of
                                                        Business Administration</option>
                                                    <option value="Bachelor of Business Management">Bachelor of
                                                        Business Management</option>
                                                    <option value="Bachelor of Commerce">Bachelor of Commerce</option>
                                                    <option value="Bachelor of Accounts & Finance">Bachelor of Accounts
                                                        & Finance</option>
                                                    <option value="Bachelor of Marketing & International Marketing">
                                                        Bachelor of Marketing & International Marketing</option>
                                                    <option value="Bachelor of Political Science">Bachelor of Political
                                                        Science</option>
                                                    <option value="Bachelor of HRM">Bachelor of HRM</option>
                                                </optgroup>
                                                <optgroup label="Master's Degrees">
                                                    <option value="Master in Physics">Master in Physics</option>
                                                    <option value="Master in Public Administration">Master in Public
                                                        Administration</option>
                                                </optgroup>
                                                <optgroup label="Diplomas">
                                                    <option value="3-Yrs Diploma in Electrical Engineering">3-Yrs
                                                        Diploma in Electrical Engineering</option>
                                                    <option value="3-Yrs Diploma in Mechanical Engineering">3-Yrs
                                                        Diploma in Mechanical Engineering</option>
                                                    <option value="Diploma in Business Administration">Diploma in
                                                        Business Administration</option>
                                                    <option value="Diploma in Health and Safety Management">Diploma in
                                                        Health and Safety Management</option>
                                                    <option value="Diploma in DHMS (4 Yrs)">Diploma in DHMS (4 Yrs)
                                                    </option>
                                                    <option value="Diploma in Optical Fiber Cables">Diploma in Optical
                                                        Fiber Cables</option>
                                                    <option value="Welding Diploma">Welding Diploma</option>
                                                    <option value="Diploma - G.Fitter">Diploma - G.Fitter</option>
                                                    <option value="Diploma - Mechanical">Diploma - Mechanical</option>
                                                    <option value="DAE Electronic">DAE Electronic</option>
                                                    <option value="Two Year Diploma">Two Year Diploma</option>
                                                </optgroup>
                                                <optgroup label="1-Yr Diploma">
                                                    <option value="DTI SAFETY INSPECTOR">DTI SAFETY INSPECTOR</option>
                                                    <option value="DTI WELDER (3G)">DTI WELDER (3G)</option>
                                                    <option value="DTI ADVANCE WELDER (6G)">DTI ADVANCE WELDER (6G)
                                                    </option>
                                                    <option value="DTI MAINTENANCE FITTER">DTI MAINTENANCE FITTER
                                                    </option>
                                                    <option value="DTI SAFETY ASSISTANT">DTI SAFETY ASSISTANT</option>
                                                </optgroup>
                                                </optgroup>

                                                <optgroup label="Technical & Vocational Training">
                                                    <option value="Apprenticeship Training">Apprenticeship Training
                                                    </option>
                                                    <option value="Trade Test Qualified">Trade Test Qualified</option>
                                                    <option value="Technical Training For Abu Dhabi Industries">
                                                        Technical Training For Abu Dhabi Industries</option>
                                                    <option value="MCITP (Microsoft Certified IT Professionals)">MCITP
                                                        (Microsoft Certified IT Professionals)</option>
                                                    <option value="IGC NEBOSH">IGC NEBOSH</option>
                                                    <option value="IOSH Management Safety">IOSH Management Safety
                                                    </option>
                                                    <option value="OSHA SAFETY AND HEALTH COURSES">OSHA SAFETY AND
                                                        HEALTH COURSES</option>

                                                <optgroup label="MTTI Certifications">
                                                    <option value="FABRICATOR PIPE (MTTI) CERTIFIED">FABRICATOR PIPE
                                                        (MTTI) CERTIFIED</option>
                                                    <option value="PIPE & PLATE FABRICATOR (MTTI) CERTIFIED">PIPE &
                                                        PLATE FABRICATOR (MTTI) CERTIFIED</option>
                                                    <option value="FITTER GENERAL (MTTI) CERTIFIED">FITTER GENERAL
                                                        (MTTI) CERTIFIED</option>
                                                    <option value="PIPE WELDER 6G (MTTI) CERTIFIED">PIPE WELDER 6G
                                                        (MTTI) CERTIFIED</option>
                                                    <option value="PLATE WELDER 3G (MTTI) CERTIFIED">PLATE WELDER 3G
                                                        (MTTI) CERTIFIED</option>
                                                    <option value="RIGGER (MTTI) CERTIFIED">RIGGER (MTTI) CERTIFIED
                                                    </option>
                                                    <option value="SAFETY ASSISTANT (MTTI) CERTIFIED">SAFETY ASSISTANT
                                                        (MTTI) CERTIFIED</option>
                                                    <option value="SAFETY INSPECTOR (MTTI) CERTIFIED">SAFETY INSPECTOR
                                                        (MTTI) CERTIFIED</option>
                                                    <option value="SCAFOLDER (MTTI) CERTIFIED">SCAFOLDER (MTTI)
                                                        CERTIFIED</option>
                                                </optgroup>

                                                <optgroup label="Other Certifications">
                                                    <option value="ELECTRICIAN COURSE">ELECTRICIAN COURSE</option>
                                                    <option value="PLUMBER COURSE">PLUMBER COURSE</option>
                                                    <option value="FRONT OFFICE MANAGEMENT COURSE">FRONT OFFICE
                                                        MANAGEMENT COURSE</option>
                                                    <option value="COMPUTER SHORT COURSE">COMPUTER SHORT COURSE
                                                    </option>
                                                </optgroup>

                                                <optgroup label="Specific Skills">
                                                    <option value="Welder">Welder</option>
                                                    <option value="Fitter">Fitter</option>
                                                    <option value="General Fitter">General Fitter</option>
                                                    <option value="Pipe Fitter">Pipe Fitter</option>
                                                    <option value="Rigger">Rigger</option>
                                                    <option value="Steel Fixure">Steel Fixure</option>
                                                    <option value="Fabricator">Fabricator</option>
                                                    <option value="Millwright">Millwright</option>
                                                    <option value="K Technician">K Technician</option>
                                                    <option value="Instrument Technician">Instrument Technician
                                                    </option>
                                                </optgroup>
                                                </optgroup>

                                                <optgroup label="Other">
                                                    <option value="NO TECHNICAL EDUCATION">NO TECHNICAL EDUCATION
                                                    </option>
                                                    <option value="Electronic / Electrical">Electronic / Electrical
                                                    </option>
                                                    <option value="Mechanical">Mechanical</option>
                                                    <option value="Auto Mobile">Auto Mobile</option>
                                                </optgroup>

                                            </select>
                                            @error('technical_qualification')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="experience">Years of Experience (Local)</label>
                                            <input type="number" name="experience_local" class="form-control" min="0"
                                                placeholder="Enter Years of Experience" >
                                            @error('experience_local')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="experience">Years of Experience (Gulf) *</label>
                                            <input type="number" name="experience_gulf" class="form-control" min="0"
                                                placeholder="Enter Years of Experience" >
                                            @error('experience_gulf')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="present_address">Present Address</label>
                                            <textarea class="form-control" id="present_address"
                                                name="present_address" >{{ old('present_address') }}</textarea>
                                            @error('present_address')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row col-md-8">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger" for="present_address_phone">Phone</label>
                                                <input type="tel" class="form-control" id="present_address_phone"
                                                    name="present_address_phone"
                                                    value="{{ old('present_address_phone') }}" >
                                                @error('present_address_phone')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger" for="present_address_mobile">Mobile</label>
                                                <input type="tel" class="form-control" id="present_address_mobile"
                                                    name="present_address_mobile"
                                                    value="{{ old('present_address_mobile') }}" >
                                                @error('present_address_mobile')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger" for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ old('email') }}" >
                                                @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger" for="present_address_city">Present Address
                                                    City *</label>
                                                    <select name="present_address_city" id="present_address_city" class="form-control" >
                                                        <option value="" disabled {{ old('present_address_city', $HumanResource->present_address_city ?? '') == '' ? 'selected' : '' }}>
                                                            Select City
                                                        </option>
                                                        @foreach($cities as $city)
                                                            <option value="{{ strtolower($city->name) }}"
                                                                {{ old('present_address_city', $HumanResource->present_address_city ?? '') == strtolower($city->name) ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>                                                    
                                                @error('present_address_city')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="permanent_address">Permanent
                                                Address</label>
                                            <textarea class="form-control" id="permanent_address"
                                                name="permanent_address" >{{ old('permanent_address') }}</textarea>
                                            @error('permanent_address')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row col-md-8">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger" for="permanent_address_phone">Phone</label>
                                                <input type="phone" class="form-control" id="permanent_address_phone"
                                                    name="permanent_address_phone"
                                                    value="{{ old('permanent_address_phone') }}" >
                                                @error('permanent_address_phone')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger" for="permanent_address_mobile">Mobile</label>
                                                <input type="tel" class="form-control" id="permanent_address_mobile"
                                                    name="permanent_address_mobile"
                                                    value="{{ old('permanent_address_mobile') }}" >
                                                @error('permanent_address_mobile')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger" for="permanent_address_city">Permanent
                                                    Address City</label>
                                                    <select name="permanent_address_city" id="permanent_address_city" class="form-control" >
                                                        <option value="" disabled {{ old('permanent_address_city', $HumanResource->permanent_address_city ?? '') == '' ? 'selected' : '' }}>
                                                            Select City
                                                        </option>
                                                        @foreach($cities as $city)
                                                            <option value="{{ strtolower($city->name) }}"
                                                                {{ old('permanent_address_city', $HumanResource->permanent_address_city ?? '') == strtolower($city->name) ? 'selected' : '' }}>
                                                                {{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    
                                                @error('permanent_address_city')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>


                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger" for="permanent_address_province">Permanent
                                                    Address Province</label>
                                                    <select name="permanent_address_province" class="form-control" >
                                                        <option value="" selected disabled>Select Province</option>
                                                        @foreach($provinces as $data)
                                                            <option value="{{ $data->name }}">{{ $data->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    
                                                @error('permanent_address_province')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                {{-- <div class="row col-md-12"> --}}

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="citizenship">Citizenship *</label>
                                            <select name="citizenship" class="form-control" >
                                                <option value="" selected disabled>Select Citizenship</option>
                                                <option value="Pakistani">Pakistani</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            @error('citizenship')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="district_of_domicile">District Of
                                                Domicile</label>
                                                <select name="district_of_domicile" id="district_of_domicile" class="form-control" >
                                                    <option value="" selected disabled>Select District</option>
                                                    @foreach($districts as $district)
                                                        <option value="{{ $district->name }}"
                                                            {{ old('district_of_domicile', $HumanResource->district_of_domicile ?? '') == $district->name ? 'selected' : '' }}>
                                                            {{ $district->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                
                                            @error('district_of_domicile')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="gender">Gender *</label>
                                            <select name="gender" class="form-control" >
                                                <option value="" selected disabled>Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="non_binary">Non-Binary</option>
                                                <option value="prefer_not_to_say">Prefer Not to Say</option>
                                                <option value="other">Other</option>
                                            </select>
                                            @error('gender')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                {{-- </div> --}}
                                {{-- <div class="row col-md-12"> --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="refference">Reference</label>
                                            <input type="text" class="form-control" id="refference" name="refference"
                                                value="{{ old('refference') }}">
                                            @error('refference')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="performance_appraisal">Performance-Appraisal
                                                Awarded %</label>
                                            <input type="text" class="form-control" id="performance_appraisal"
                                                name="performance_appraisal" value="{{ old('performance_appraisal') }}">
                                            @error('performance_appraisal')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="min_salary">Min Acceptable Salary %</label>
                                            <div class="input-group">
                                                <!-- Currency Dropdown -->
                                                <select name="currancy" class="form-control" id="currancy" >
                                                    <option value="" selected disabled> Currency</option>
                                                    @foreach($curencies as $country)
                                                        <option value="{{ $country->currency_symbol }}"
                                                            {{ old('currancy', $HumanResource->currancy ?? '') == strtolower($country->currency_symbol) ? 'selected' : '' }}>
                                                            {{ $country->currency_symbol }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                        
                                                <!-- Salary Input -->
                                                <input type="number" class="form-control" id="min_salary" name="min_salary" value="{{ old('min_salary') }}" >
                                            </div>
                                            @error('min_salary')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                    </div>
                                {{-- </div> --}}
                                {{-- <div class="row col-md-12"> --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="comment">Comment</label>
                                            <input type="text" class="form-control" id="comment" name="comment"
                                                value="{{ old('comment') }}">
                                            @error('comment')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="status">Status</label>
                                            <select name="status" class="form-control" id="status" >
                                                <option value="" selected disabled>Select Status</option>
                                                <option value="1">Pending</option>
                                                <option value="2">Approved</option>
                                            </select>
                                            @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                {{-- </div> --}}

                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>




@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#createSubadminForm').on('submit', function(event) {
            var dob = new Date($('#date_of_birth').val());
            var today = new Date();
            var age = today.getFullYear() - dob.getFullYear();
            var monthDifference = today.getMonth() - dob.getMonth();
            if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            if (age < 21) {
                event.preventDefault();
                $('#dob-error').show();
                $('html, body').animate({
                    scrollTop: $('#date_of_birth').offset().top - 100
                }, 'smooth');
            } else {
                $('#dob-error').hide();
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('#table_id_events').DataTable()

    })
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script type="text/javascript">
    $('.show_confirm').click(function (event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: `Are you sure you want to delete this record?`,
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>
{{-- <script>
    $(document).ready(function () {
        $('#craft').on('change', function () {
            var craftId = $(this).val();

            $.ajax({
                url: "{{ route('get-sub-crafts') }}",
                type: "GET",
                data: {
                    craft_id: craftId
                },
                success: function (data) {
                    $('#sub_craft').empty();
                    $('#sub_craft').append(
                        '<option value="" selected disabled>Select Sub-Craft</option>');
                    

                    $.each(data, function (key, value) {
                        $('#sub_craft').append('<option value="' + value.id +
                            '">' + value.name + '</option>');
                    });
                }
            });
        });

        $('#company_id').on('change', function () {
            var companyId = $(this).val();

            if (companyId) {
                $('#project-group').removeClass('d-none');
                $('#demand-group').removeClass('d-none');
            } else {
                $('#project-group').addClass('d-none');
                $('#demand-group').addClass('d-none');

                // Load all crafts when no company is selected
                $('#craft').empty().append('<option value="" selected disabled>Select Craft</option>');
                $('#sub_craft').empty().append('<option value="" selected disabled>Select Sub-Craft</option>');

                $.ajax({
                    url: "{{ route('get-all-crafts') }}", // Backend route to fetch all crafts
                    type: "GET",
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#craft').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }

            // Reset dependent fields
            $('#project_id').empty().append('<option value="" selected disabled>Select Project</option>');
            $('#demand_id').empty().append('<option value="" selected disabled>Select Demand</option>');
        });

        $('#project_id').on('change', function () {
            var projectId = $(this).val();

            $.ajax({
                url: "{{ route('get-demand') }}",
                type: "GET",
                data: {
                    project_id: projectId
                },
                success: function (data) {
                    $('#demand_id').empty();
                    $('#demand_id').append(
                        '<option value="" selected disabled>Select Demand</option>');

                    $.each(data, function (key, value) {
                        $('#demand_id').append('<option value="' + value.id +
                            '">Man Power - ' + value.full_name + '</option>');
                    });
                }
            });
        });
    });


    $(document).ready(function() {
        $('#company_id').change(function() {
            var selectedCompany = $(this).val();
            if (selectedCompany) {
                // $('#craft').closest('.col-md-4').addClass('d-none');
                // $('#sub_craft').closest('.col-md-4').addClass('d-none');
                $('#project-group').removeClass('d-none');
                $('#demand-group').removeClass('d-none');
            } else {
                $('#craft').closest('.col-md-4').removeClass('d-none');
                $('#sub_craft').closest('.col-md-4').removeClass('d-none');
                $('#project-group').addClass('d-none');
                $('#demand-group').addClass('d-none');
            }
        });
    });
</script> --}}
<script>
    $(document).ready(function () {
        // When company is selected
        $('#company_id').on('change', function () {
            var companyId = $(this).val();

            if (companyId) {
                $('#project-group').removeClass('d-none');
                $('#demand-group').removeClass('d-none');
            } else {
                $('#project-group').addClass('d-none');
                $('#demand-group').addClass('d-none');
                $('#craft').closest('.col-md-4').removeClass('d-none');
                $('#sub_craft').closest('.col-md-4').removeClass('d-none');
            }

            // Reset dependent fields
            $('#project_id').empty().append('<option value="" selected disabled>Select Project</option>');
            $('#demand_id').empty().append('<option value="" selected disabled>Select Demand</option>');
            $('#craft').empty().append('<option value="" selected disabled>Select Craft</option>');
            $('#sub_craft').empty().append('<option value="" selected disabled>Select Sub-Craft</option>');

            if (companyId) {
                $.ajax({
                    url: "{{ route('get-projects') }}",
                    type: "GET",
                    data: { company_id: companyId },
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#project_id').append('<option value="' + value.id + '">' + value.project_name + '</option>');
                        });
                    }
                });
            }
        });

        // When project is selected
        $('#project_id').on('change', function () {
            var projectId = $(this).val();

            $('#demand_id').empty().append('<option value="" selected disabled>Select Demand</option>');
            $('#craft').empty().append('<option value="" selected disabled>Select Craft</option>');
            $('#sub_craft').empty().append('<option value="" selected disabled>Select Sub-Craft</option>');

            if (projectId) {
                $.ajax({ 
                    url: "{{ route('get-demand') }}",
                    type: "GET", 
                    data: { project_id: projectId },
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#demand_id').append('<option value="' + value.id + '">Man Power - ' + value.full_name + '</option>');
                        });
                    }
                });
            }
        });

        // When demand is selected
        $('#demand_id').on('change', function () {
            var demandId = $(this).val();

            $('#craft').empty().append('<option value="" selected disabled>Select Craft</option>');
            $('#sub_craft').empty().append('<option value="" selected disabled>Select Sub-Craft</option>');

            if (demandId) {
                $.ajax({
                    url: "{{ route('get-crafts-by-demand') }}",
                    type: "GET",
                    data: { demand_id: demandId },
                    success: function (data) {
                        if (data.length > 0) {
                            $.each(data, function (key, value) {
                                $('#craft').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                            // Automatically select the first craft
                            $('#craft').val(data[0].id).trigger('change');
                        }
                    }
                });
            }
        });

        // When craft is selected
        $('#craft').on('change', function () {
            var craftId = $(this).val();

            $('#sub_craft').empty().append('<option value="" selected disabled>Select Sub-Craft</option>');

            if (craftId) {
                $.ajax({
                    url: "{{ route('get-sub-crafts') }}",
                    type: "GET",
                    data: { craft_id: craftId },
                    success: function (data) {
                        $.each(data, function (key, value) {
                            $('#sub_craft').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            }
        });
    });
</script>

@endsection