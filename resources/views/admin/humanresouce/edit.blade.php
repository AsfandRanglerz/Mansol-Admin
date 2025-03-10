@extends('admin.layout.app')
@section('title', 'Edit Human Resource')
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
                                <div class="col-12">
                                    <h4>Edit Human Resource</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                <form action="{{ route('humanresource.update', $HumanResource->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="registration">Id No.</label>
                                                <input type="number" class="form-control" id="registration"
                                                    name="registration"
                                                    value="{{ old('registration', $HumanResource->registration) }}"
                                                    readonly>
                                                @error('registration')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ old('name', $HumanResource->name) }}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        @if ($company)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="company_id">Company</label>
                                                {{-- <select name="company_id" id="company_id" class="form-control">
                                                    <option value="">Select Company</option>
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company->id }}" {{ $company->id == $company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                                                    @endforeach
                                                </select> --}}
                                                <input type="text" value="{{ $company->name }}" readonly class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="project-group">
                                            <div class="form-group">
                                                <label class="text-danger" for="project_id">Project</label>
                                                {{-- <select name="project_id" id="project_id" class="form-control">
                                                    <option value="" selected disabled>Select Project</option>
                                                </select> --}}
                                                <input type="text" value="{{ $project->project_name }}" readonly class="form-control">
                                                @error('project_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="demand-group">
                                            <div class="form-group">
                                                <label class="text-danger" for="demand_id">Demand</label>
                                                {{-- <select name="demand_id" id="demand_id" class="form-control">
                                                    <option value="" selected disabled>Select Demand</option>
                                                </select> --}}
                                                <input type="text" value="Man Power - {{ $demand->manpower }}" readonly class="form-control">
                                                @error('demand_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        @endif
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="craft">Application for Post</label>
                                                {{-- <select name="craft_id" class="form-control" id="craft">
                                                    <option value="" selected disabled>Select Craft</option>
                                                    @foreach ($crafts as $craft)
                                                        <option value="{{ $craft->id }}" {{ $craft->id == $HumanResource->craft_id ? 'selected' : '' }}>{{ $craft->name }}</option>
                                                    @endforeach
                                                </select> --}}
                                                <input type="text" value="{{ $craft->name }}" readonly class="form-control">
                                                @error('craft')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <input type="hidden" name="craft_id" value="{{ $craft->id ?? null }}">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="sub_craft">Sub-Craft</label>
                                                {{-- <select name="sub_craft_id" class="form-control" id="sub_craft">
                                                    <option value="" selected disabled>Select Sub-Craft</option>
                                                </select> --}}
                                                <input type="text" value="{{ $subCraft->name ?? null }}" readonly class="form-control">
                                                @error('sub_craft')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" name="sub_craft_id" value="{{ $subCraft->id ?? null }}">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="application_date">Application Date</label>
                                                <input type="date" class="form-control" id="application_date"
                                                    name="application_date"
                                                    value="{{ old('application_date', $HumanResource->application_date) }}">
                                                @error('application_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="approvals">Approvals</label>
                                                <select name="approvals" class="form-control">
                                                    <option value="">Select Company</option>
                                                    @foreach (['ARAMCO', 'SABIC', 'PDO', 'ADNOC', 'Shell', 'Dolphin', 'Q Con', 'Qatar Gas', 'Oryx', 'Oxchem'] as $approvals)
                                                        <option value="{{ strtolower($approvals) }}"
                                                            {{ old('approvals', $HumanResource->approvals) == strtolower($approvals) ? 'selected' : '' }}>
                                                            {{ $approvals }}
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
                                                <label class="text-danger" for="son_of">S/O</label>
                                                <input type="text" class="form-control" id="son_of" name="son_of"
                                                    value="{{ old('son_of', $HumanResource->son_of) }}">
                                                <div class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="mother_name">Mother Name</label>
                                                <input type="text" class="form-control" id="mother_name"
                                                    name="mother_name"
                                                    value="{{ old('mother_name', $HumanResource->mother_name) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="blood_group">Blood Group</label>
                                                <select name="blood_group" class="form-control">
                                                    <option value="" selected disabled>Select Blood Group</option>
                                                    @foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $blood)
                                                        <option value="{{ strtolower($blood) }}"
                                                            {{ old('blood_group', $HumanResource->blood_group) == strtolower($blood) ? 'selected' : '' }}>
                                                            {{ $blood }}
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
                                                    name="date_of_birth"
                                                    value="{{ old('date_of_birth', $HumanResource->date_of_birth) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="city_of_birth">City Of Birth</label>
                                                <select name="city_of_birth" class="form-control" id="citySelect">
                                                    <option value="" selected disabled>Select City</option>
                                                    @foreach (['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Faisalabad', 'Multan', 'Peshawar', 'Quetta'] as $city)
                                                        <option value="{{ strtolower($city) }}"
                                                            {{ old('city_of_birth', strtolower($HumanResource->city_of_birth ?? '')) == strtolower($city) ? 'selected' : '' }}>
                                                            {{ $city }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('city_of_birth')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="cnic">CNIC</label>
                                                <input type="number" class="form-control" id="cnic" name="cnic"
                                                    value="{{ old('cnic', $HumanResource->cnic) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="cnic_expiry_date">CNIC Expiry
                                                    Date</label>
                                                <input type="date" class="form-control" id="cnic_expiry_date"
                                                    name="cnic_expiry_date"
                                                    value="{{ old('cnic_expiry_date', $HumanResource->cnic_expiry_date) }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="passport">Passport #</label>
                                                <input type="text" class="form-control" id="passport"
                                                    name="passport"
                                                    value="{{ old('passport', $HumanResource->passport) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="passport_issue_place">Passport Place Of
                                                    Issue</label>
                                                    <select name="passport_issue_place" class="form-control">
                                                        <option value="" selected disabled>Select City</option>
                                                        @foreach (['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Faisalabad', 'Multan', 'Peshawar', 'Quetta'] as $city)
                                                            <option value="{{ strtolower($city) }}"
                                                                {{ old('passport_issue_place', strtolower($HumanResource->passport_issue_place ?? '')) == strtolower($city) ? 'selected' : '' }}>
                                                                {{ $city }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="doi">Data Of Issue/Passport</label>
                                                <input type="date" class="form-control" id="doi" name="doi"
                                                    value="{{ old('doi', $HumanResource->doi) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="doe">Data Of Expiry/Passport</label>
                                                <input type="date" class="form-control" id="doe" name="doe"
                                                    value="{{ old('doe', $HumanResource->doe) }}">
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="relation">Religion</label>
                                                <select name="religion" class="form-control">
                                                    <option value="" selected disabled>Select Religion</option>
                                                    @foreach (['Muslim', 'Hindu', 'Christian', 'Buddhist', 'Jewish', 'Sikh'] as $religion)
                                                        <option value="{{ strtolower($religion) }}"
                                                            {{ old('religion', strtolower($HumanResource->religion ?? '')) == strtolower($religion) ? 'selected' : '' }}>
                                                            {{ $religion }}
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
                                                <label class="text-danger" for="martial_status">Marital Status</label>
                                                <select name="martial_status" id="martial_status" class="form-control">
                                                    <option value="" disabled
                                                        {{ old('martial_status', $HumanResource->martial_status ?? '') == '' ? 'selected' : '' }}>
                                                        Select Marital</option>
                                                    <option value="single"
                                                        {{ old('martial_status', $HumanResource->martial_status ?? '') == 'single' ? 'selected' : '' }}>
                                                        Single</option>
                                                    <option value="married"
                                                        {{ old('martial_status', $HumanResource->martial_status ?? '') == 'married' ? 'selected' : '' }}>
                                                        Married</option>
                                                    <option value="divorced"
                                                        {{ old('martial_status', $HumanResource->martial_status ?? '') == 'divorced' ? 'selected' : '' }}>
                                                        Divorced</option>
                                                    <option value="widowed"
                                                        {{ old('martial_status', $HumanResource->martial_status ?? '') == 'widowed' ? 'selected' : '' }}>
                                                        Widowed</option>
                                                    <option value="separated"
                                                        {{ old('martial_status', $HumanResource->martial_status ?? '') == 'separated' ? 'selected' : '' }}>
                                                        Separated</option>
                                                </select>
                                                @error('martial_status')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="next_of_kin">Next Of Kin</label>
                                                <input type="text" class="form-control" id="next_of_kin"
                                                    name="next_of_kin"
                                                    value="{{ old('next_of_kin', $HumanResource->next_of_kin) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="relation">Relation</label>
                                                <select class="form-control" id="relation" name="relation">
                                                    <option value="">Select Relation</option>
                                                    @foreach (['Father', 'Mother', 'Brother', 'Sister', 'Spouse', 'Friend', 'Other'] as $relation)
                                                        <option value="{{ strtolower($relation) }}"
                                                            {{ old('relation', strtolower($HumanResource->relation ?? '')) == strtolower($relation) ? 'selected' : '' }}>
                                                            {{ $relation }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="kin_cnic">Kin CNIC</label>
                                                <input type="number" class="form-control" id="kin_cnic"
                                                    name="kin_cnic"
                                                    value="{{ old('kin_cnic', $HumanResource->kin_cnic) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="shoe_size">Shoe Size</label>
                                                <select name="shoe_size" class="form-control">
                                                    <option value="" selected disabled>Select Shoe Size</option>
                                                    @foreach (['small', 'medium', 'large', 'extra large'] as $size)
                                                        <option value="{{ strtolower($size) }}"
                                                            {{ old('shoe_size', strtolower($HumanResource->shoe_size ?? '')) == strtolower($size) ? 'selected' : '' }}>
                                                            {{ ucwords($size) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('shoe_size')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="cover_size">Cover Size</label>
                                                <select name="cover_size" id="cover_size" class="form-control">
                                                    <option value="" disabled
                                                        {{ old('cover_size', $HumanResource->cover_size ?? '') == '' ? 'selected' : '' }}>
                                                        Select Cover Size</option>
                                                    @for ($i = 36; $i <= 46; $i++)
                                                        <option value="{{ $i }}"
                                                            {{ old('cover_size', $HumanResource->cover_size ?? '') == $i ? 'selected' : '' }}>
                                                            {{ $i }}</option>
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
                                                    Qualification</label>
                                                <select name="acdemic_qualification" id="acdemic_qualification"
                                                    class="form-control">
                                                    <option value="" disabled
                                                        {{ old('acdemic_qualification', $HumanResource->acdemic_qualification ?? '') == '' ? 'selected' : '' }}>
                                                        Select Qualification</option>
                                                    <option value="no_formal_education"
                                                        {{ old('acdemic_qualification', $HumanResource->acdemic_qualification ?? '') == 'no_formal_education' ? 'selected' : '' }}>
                                                        No Formal Education</option>
                                                    <option value="primary"
                                                        {{ old('acdemic_qualification', $HumanResource->acdemic_qualification ?? '') == 'primary' ? 'selected' : '' }}>
                                                        Primary Education</option>
                                                    <option value="secondary"
                                                        {{ old('acdemic_qualification', $HumanResource->acdemic_qualification ?? '') == 'secondary' ? 'selected' : '' }}>
                                                        Secondary Education</option>
                                                    <option value="high_school"
                                                        {{ old('acdemic_qualification', $HumanResource->acdemic_qualification ?? '') == 'high_school' ? 'selected' : '' }}>
                                                        High School Diploma</option>
                                                    <option value="bachelor"
                                                        {{ old('acdemic_qualification', $HumanResource->acdemic_qualification ?? '') == 'bachelor' ? 'selected' : '' }}>
                                                        Bachelor's Degree</option>
                                                    <option value="master"
                                                        {{ old('acdemic_qualification', $HumanResource->acdemic_qualification ?? '') == 'master' ? 'selected' : '' }}>
                                                        Master's Degree</option>
                                                    <option value="doctorate"
                                                        {{ old('acdemic_qualification', $HumanResource->acdemic_qualification ?? '') == 'doctorate' ? 'selected' : '' }}>
                                                        Doctorate (PhD)</option>
                                                    <option value="professional_certification"
                                                        {{ old('acdemic_qualification', $HumanResource->acdemic_qualification ?? '') == 'professional_certification' ? 'selected' : '' }}>
                                                        Professional Certification</option>
                                                    <option value="other"
                                                        {{ old('acdemic_qualification', $HumanResource->acdemic_qualification ?? '') == 'other' ? 'selected' : '' }}>
                                                        Other</option>
                                                </select>
                                                @error('acdemic_qualification')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="technical_qualification">Technical Qualification</label>
                                                <select name="technical_qualification" id="qualification" class="form-control">
                                                    <option value="" selected disabled>Select Qualification</option>
                                            
                                                    <optgroup label="Academic Degrees">
                                                        <optgroup label="Bachelor's Degrees">
                                                            @foreach ([
                                                                'Bachelor of Mechanical Engineering',
                                                                'Bachelor of Electrical Engineering',
                                                                'Bachelor of Civil Engineering',
                                                                'Bachelor of Chemical Engineering',
                                                                'Bachelor of Petroleum Engineering',
                                                                'Bachelor of Environmental Sciences',
                                                                'Bachelor of Mechatronics Engineering',
                                                                'Bachelor of Mining Engineering',
                                                                'Bachelor of Sustainable Energy Engineering',
                                                                'Bachelor of Architecture Engineering',
                                                                'Bachelor of Computer Sciences',
                                                                'Bachelor of Information Technology',
                                                                'Bachelor of Telecommunication Engineering',
                                                                'Bachelor of Business Administration',
                                                                'Bachelor of Business Management',
                                                                'Bachelor of Commerce',
                                                                'Bachelor of Accounts & Finance',
                                                                'Bachelor of Marketing & International Marketing',
                                                                'Bachelor of Political Science',
                                                                'Bachelor of HRM'
                                                            ] as $qualification)
                                                                <option value="{{ $qualification }}" 
                                                                    {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                    {{ $qualification }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                            
                                                        <optgroup label="Master's Degrees">
                                                            @foreach ([
                                                                'Master in Physics',
                                                                'Master in Public Administration'
                                                            ] as $qualification)
                                                                <option value="{{ $qualification }}" 
                                                                    {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                    {{ $qualification }}
                                                                </option>
                                                            @endforeach
                                                        </optgroup>
                                                    </optgroup>
                                            
                                                    <optgroup label="Diplomas">
                                                        @foreach ([
                                                            '3-Yrs Diploma in Electrical Engineering',
                                                            '3-Yrs Diploma in Mechanical Engineering',
                                                            'Diploma in Business Administration',
                                                            'Diploma in Health and Safety Management',
                                                            'Diploma in DHMS (4 Yrs)',
                                                            'Diploma in Optical Fiber Cables',
                                                            'Welding Diploma',
                                                            'Diploma - G.Fitter',
                                                            'Diploma - Mechanical',
                                                            'DAE Electronic',
                                                            'Two Year Diploma'
                                                        ] as $qualification)
                                                            <option value="{{ $qualification }}" 
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                            
                                                    <optgroup label="1-Yr Diploma">
                                                        @foreach ([
                                                            'DTI SAFETY INSPECTOR',
                                                            'DTI WELDER (3G)',
                                                            'DTI ADVANCE WELDER (6G)',
                                                            'DTI MAINTENANCE FITTER',
                                                            'DTI SAFETY ASSISTANT'
                                                        ] as $qualification)
                                                            <option value="{{ $qualification }}" 
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                            
                                                    <optgroup label="Technical & Vocational Training">
                                                        @foreach ([
                                                            'Apprenticeship Training',
                                                            'Trade Test Qualified',
                                                            'Technical Training For Abu Dhabi Industries',
                                                            'MCITP (Microsoft Certified IT Professionals)',
                                                            'IGC NEBOSH',
                                                            'IOSH Management Safety',
                                                            'OSHA SAFETY AND HEALTH COURSES'
                                                        ] as $qualification)
                                                            <option value="{{ $qualification }}" 
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                            
                                                    <optgroup label="MTTI Certifications">
                                                        @foreach ([
                                                            'FABRICATOR PIPE (MTTI) CERTIFIED',
                                                            'PIPE & PLATE FABRICATOR (MTTI) CERTIFIED',
                                                            'FITTER GENERAL (MTTI) CERTIFIED',
                                                            'PIPE WELDER 6G (MTTI) CERTIFIED',
                                                            'PLATE WELDER 3G (MTTI) CERTIFIED',
                                                            'RIGGER (MTTI) CERTIFIED',
                                                            'SAFETY ASSISTANT (MTTI) CERTIFIED',
                                                            'SAFETY INSPECTOR (MTTI) CERTIFIED',
                                                            'SCAFOLDER (MTTI) CERTIFIED'
                                                        ] as $qualification)
                                                            <option value="{{ $qualification }}" 
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                            
                                                    <optgroup label="Other Certifications">
                                                        @foreach ([
                                                            'ELECTRICIAN COURSE',
                                                            'PLUMBER COURSE',
                                                            'FRONT OFFICE MANAGEMENT COURSE',
                                                            'COMPUTER SHORT COURSE'
                                                        ] as $qualification)
                                                            <option value="{{ $qualification }}" 
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                            
                                                    <optgroup label="Specific Skills">
                                                        @foreach ([
                                                            'Welder',
                                                            'Fitter',
                                                            'General Fitter',
                                                            'Pipe Fitter',
                                                            'Rigger',
                                                            'Steel Fixure',
                                                            'Fabricator',
                                                            'Millwright',
                                                            'K Technician',
                                                            'Instrument Technician'
                                                        ] as $qualification)
                                                            <option value="{{ $qualification }}" 
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                            
                                                    <optgroup label="Other">
                                                        @foreach ([
                                                            'NO TECHNICAL EDUCATION',
                                                            'Electronic / Electrical',
                                                            'Mechanical',
                                                            'Auto Mobile'
                                                        ] as $qualification)
                                                            <option value="{{ $qualification }}" 
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
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
                                                <input type="number" name="experience_local" class="form-control"
                                                       min="0" 
                                                       placeholder="Enter Years of Experience"
                                                       value="{{ old('experience', $HumanResource->experience_local ?? '') }}">
                                                @error('experience')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="experience">Years of Experience (Gulf)</label>
                                                <input type="number" name="experience_gulf" class="form-control"
                                                       min="0" 
                                                       placeholder="Enter Years of Experience"
                                                       value="{{ old('experience', $HumanResource->experience_gulf ?? '') }}">
                                                @error('experience')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                            <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="district_of_domicile">District Of
                                                Domicile</label>
                                                <select name="district_of_domicile" id="district_of_domicile" class="form-control">
                                                    <option value="" selected disabled>Select District</option>
                                                    @foreach ([
                                                        'Abbottabad', 'AJK', 'Astore', 'Attock', 'Bahawalnagar', 'Bahawalpur', 'Bannu', 'Bhakhar', 'Bhakkar', 'Bhimber', 'Buner',
                                                        'Chakwal', 'Charsadda', 'Chitral', 'Dadu', 'D.G. Khan', 'Dir Lower', 'Dir Upper', 'Faisalabad', 'Fateh Jang', 'Gujranwala',
                                                        'Gujrat', 'Gujar Khan', 'Hafizabad', 'Haripur', 'Hyderabad', 'Islamabad', 'Jacobabad', 'Jaffarabad', 'Jhang', 'Jhelum',
                                                        'Jiwani', 'Karachi', 'Kashmore', 'Kasur', 'Kech', 'Khanewal', 'Khanpur', 'Khyber', 'Khyber Agency', 'Kohat', 'Kohlu',
                                                        'Lahore', 'Lakki Marwat', 'Larkana', 'Lasbela', 'Layyah', 'Lodhran', 'Lower Dir', 'Lower Kohistan', 'Malakand', 'Mandi Bahauddin',
                                                        'Mansehra', 'Mardan', 'Mastung', 'Matiari', 'Mirpur', 'Mirpur Khas', 'Muzaffarabad', 'Muzaffargarh', 'Nawabshah', 'Nowshera',
                                                        'Okara', 'Pakpattan', 'Peshawar', 'Quetta', 'Rahim Yar Khan', 'Rajanpur', 'Rawalpindi', 'Sahiwal', 'Sargodha', 'Sawat',
                                                        'Sialkot', 'Shikarpur', 'Sindh', 'Sirkot', 'Skardu', 'Sukkur', 'Swabi', 'Swat', 'Tando Allahyar', 'Tando Muhammad Khan',
                                                        'Tank', 'Thatta', 'Toba Tek Singh', 'Upper Dir', 'Upper Kohistan', 'Vehari', 'Zhob'
                                                    ] as $district)
                                                        <option value="{{ $district }}" 
                                                            {{ old('district_of_domicile', $HumanResource->district_of_domicile ?? '') == $district ? 'selected' : '' }}>
                                                            {{ $district }}
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
                                                <label class="text-danger" for="present_address">Present Address</label>
                                                <textarea type="text" class="form-control" id="present_address" name="present_address">{{ old('present_address', $HumanResource->present_address) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row col-md-8">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-danger" for="present_address_phone">Phone</label>
                                                    <input type="tel" class="form-control" id="present_address_phone"
                                                        name="present_address_phone"
                                                        value="{{ old('present_address_phone', $HumanResource->present_address_phone) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-danger" for="present_address_mobile">Mobile</label>
                                                    <input type="tel" class="form-control"
                                                        id="present_address_mobile" name="present_address_mobile"
                                                        value="{{ old('present_address_mobile', $HumanResource->present_address_mobile) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-danger" for="email">Email</label>
                                                    <input type="email" class="form-control"
                                                        value="{{ $HumanResource->email }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-danger" for="present_address_city">Present Address
                                                        City</label>
                                                    <select name="present_address_city" id="present_address_city"
                                                        class="form-control">
                                                        <option value="" disabled
                                                            {{ old('present_address_city', $HumanResource->present_address_city ?? '') == '' ? 'selected' : '' }}>
                                                            Select City</option>
                                                        <option value="lahore"
                                                            {{ old('present_address_city', $HumanResource->present_address_city ?? '') == 'lahore' ? 'selected' : '' }}>
                                                            Lahore</option>
                                                        <option value="karachi"
                                                            {{ old('present_address_city', $HumanResource->present_address_city ?? '') == 'karachi' ? 'selected' : '' }}>
                                                            Karachi</option>
                                                        <option value="islamabad"
                                                            {{ old('present_address_city', $HumanResource->present_address_city ?? '') == 'islamabad' ? 'selected' : '' }}>
                                                            Islamabad</option>
                                                        <option value="peshawar"
                                                            {{ old('present_address_city', $HumanResource->present_address_city ?? '') == 'peshawar' ? 'selected' : '' }}>
                                                            Peshawar</option>
                                                        <option value="quetta"
                                                            {{ old('present_address_city', $HumanResource->present_address_city ?? '') == 'quetta' ? 'selected' : '' }}>
                                                            Quetta</option>
                                                        <option value="multan"
                                                            {{ old('present_address_city', $HumanResource->present_address_city ?? '') == 'multan' ? 'selected' : '' }}>
                                                            Multan</option>
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
                                                <textarea type="text" class="form-control" id="permanent_address" name="permanent_address">{{ old('permanent_address', $HumanResource->permanent_address) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row col-md-8">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-danger" for="permanent_address_phone">Phone</label>
                                                    <input type="tel" class="form-control"
                                                        id="permanent_address_phone" name="permanent_address_phone"
                                                        value="{{ old('permanent_address_phone', $HumanResource->permanent_address_phone) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-danger"
                                                        for="permanent_address_mobile">Mobile</label>
                                                    <input type="tel" class="form-control"
                                                        id="permanent_address_mobile" name="permanent_address_mobile"
                                                        value="{{ old('permanent_address_mobile', $HumanResource->permanent_address_mobile) }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-danger" for="permanent_address_city">Permanent
                                                        Address City</label>
                                                    <select name="permanent_address_city" id="permanent_address_city"
                                                        class="form-control">
                                                        <option value="" disabled
                                                            {{ old('permanent_address_city', $HumanResource->permanent_address_city ?? '') == '' ? 'selected' : '' }}>
                                                            Select City</option>
                                                        <option value="lahore"
                                                            {{ old('permanent_address_city', $HumanResource->permanent_address_city ?? '') == 'lahore' ? 'selected' : '' }}>
                                                            Lahore</option>
                                                        <option value="karachi"
                                                            {{ old('permanent_address_city', $HumanResource->permanent_address_city ?? '') == 'karachi' ? 'selected' : '' }}>
                                                            Karachi</option>
                                                        <option value="islamabad"
                                                            {{ old('permanent_address_city', $HumanResource->permanent_address_city ?? '') == 'islamabad' ? 'selected' : '' }}>
                                                            Islamabad</option>
                                                        <option value="peshawar"
                                                            {{ old('permanent_address_city', $HumanResource->permanent_address_city ?? '') == 'peshawar' ? 'selected' : '' }}>
                                                            Peshawar</option>
                                                        <option value="quetta"
                                                            {{ old('permanent_address_city', $HumanResource->permanent_address_city ?? '') == 'quetta' ? 'selected' : '' }}>
                                                            Quetta</option>
                                                        <option value="multan"
                                                            {{ old('permanent_address_city', $HumanResource->permanent_address_city ?? '') == 'multan' ? 'selected' : '' }}>
                                                            Multan</option>
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
                                                        <select name="permanent_address_province" class="form-control">
                                                            <option value="" selected disabled>Select Province</option>
                                                            <option value="Punjab" 
                                                                {{ old('permanent_address_province', $HumanResource->permanent_address_province ?? '') == 'Punjab' ? 'selected' : '' }}>
                                                                Punjab
                                                            </option>
                                                            <option value="Sindh" 
                                                                {{ old('permanent_address_province', $HumanResource->permanent_address_province ?? '') == 'Sindh' ? 'selected' : '' }}>
                                                                Sindh
                                                            </option>
                                                            <option value="Khyber Pakhtunkhwa" 
                                                                {{ old('permanent_address_province', $HumanResource->permanent_address_province ?? '') == 'Khyber Pakhtunkhwa' ? 'selected' : '' }}>
                                                                Khyber Pakhtunkhwa
                                                            </option>
                                                            <option value="Balochistan" 
                                                                {{ old('permanent_address_province', $HumanResource->permanent_address_province ?? '') == 'Balochistan' ? 'selected' : '' }}>
                                                                Balochistan
                                                            </option>
                                                            <option value="Gilgit-Baltistan" 
                                                                {{ old('permanent_address_province', $HumanResource->permanent_address_province ?? '') == 'Gilgit-Baltistan' ? 'selected' : '' }}>
                                                                Gilgit-Baltistan
                                                            </option>
                                                            <option value="Islamabad Capital Territory" 
                                                                {{ old('permanent_address_province', $HumanResource->permanent_address_province ?? '') == 'Islamabad Capital Territory' ? 'selected' : '' }}>
                                                                Islamabad Capital Territory
                                                            </option>
                                                            <option value="Azad Jammu & Kashmir" 
                                                                {{ old('permanent_address_province', $HumanResource->permanent_address_province ?? '') == 'Azad Jammu & Kashmir' ? 'selected' : '' }}>
                                                                Azad Jammu & Kashmir
                                                            </option>
                                                        </select>
                                                        
                                                </div>
                                            </div>
                                        </div>


                                        

                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="citizenship">Citizenship</label>
                                                <select name="citizenship" class="form-control">
                                                    <option value="" selected disabled>Select Citizenship</option>
                                                    <option value="Pakistani" 
                                                        {{ old('citizenship', $HumanResource->citizenship ?? '') == 'Pakistani' ? 'selected' : '' }}>
                                                        Pakistani
                                                    </option>
                                                    <option value="Other" 
                                                        {{ old('citizenship', $HumanResource->citizenship ?? '') == 'Other' ? 'selected' : '' }}>
                                                        Other
                                                    </option>
                                                </select>
                                                @error('citizenship')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="gender">Gender</label>
                                                <select name="gender" id="gender" class="form-control">
                                                    <option value="" disabled
                                                        {{ old('gender', $HumanResource->gender ?? '') == '' ? 'selected' : '' }}>
                                                        Select Gender</option>
                                                    <option value="male"
                                                        {{ old('gender', $HumanResource->gender ?? '') == 'male' ? 'selected' : '' }}>
                                                        Male</option>
                                                    <option value="female"
                                                        {{ old('gender', $HumanResource->gender ?? '') == 'female' ? 'selected' : '' }}>
                                                        Female</option>
                                                    <option value="non_binary"
                                                        {{ old('gender', $HumanResource->gender ?? '') == 'non_binary' ? 'selected' : '' }}>
                                                        Non-Binary</option>
                                                    <option value="prefer_not_to_say"
                                                        {{ old('gender', $HumanResource->gender ?? '') == 'prefer_not_to_say' ? 'selected' : '' }}>
                                                        Prefer Not to Say</option>
                                                    <option value="other"
                                                        {{ old('gender', $HumanResource->gender ?? '') == 'other' ? 'selected' : '' }}>
                                                        Other</option>
                                                </select>
                                                @error('gender')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="refference">Reference</label>
                                                <input type="text" class="form-control" id="refference"
                                                    name="refference"
                                                    value="{{ old('refference', $HumanResource->refference) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger"
                                                    for="performance_appraisal">Performance-Appraisal Awarded %</label>
                                                <input type="text" class="form-control" id="performance_appraisal"
                                                    name="performance_appraisal"
                                                    value="{{ old('performance_appraisal', $HumanResource->performance_appraisal) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="min_salary">Min Acceptable Salary
                                                    %</label>
                                                <input type="number" class="form-control" id="min_salary"
                                                    name="min_salary"
                                                    value="{{ old('min_salary', $HumanResource->min_salary) }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="comment">Comment</label>
                                                <input type="text" class="form-control" id="comment" name="comment"
                                                    value="{{ old('comment', $HumanResource->comment) }}">
                                            </div>
                                        </div>
                                        
                                        @if (is_null($company))
                                            
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="status">Status</label>
                                                <select name="status" class="form-control">
                                                    <option value="" disabled
                                                        {{ old('status', $HumanResource->status) === null ? 'selected' : '' }}>
                                                        Select Status</option>
                                                    <option value="1"
                                                        {{ old('status', $HumanResource->status) == 1 ? 'selected' : '' }}>
                                                        Pending</option>
                                                    <option value="2"
                                                        {{ old('status', $HumanResource->status) == 2 ? 'selected' : '' }}>
                                                        Approved</option>
                                                    <option value="0"
                                                        {{ old('status', $HumanResource->status) == 0 ? 'selected' : '' }}>
                                                        Rejected</option>
                                                </select>
                                                @error('status')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        @endif
                                        @if ($company)
                                        <input type="hidden" name="status" value="3">
                                        @endif
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
    @if (\Illuminate\Support\Facades\Session::has('message'))
        <script>
            toastr.success('{{ \Illuminate\Support\Facades\Session::get('message') }}');
        </script>
    @endif

    {{-- <script>
        $(document).ready(function() {
            // Check if company_id is selected on page load
            var selectedCompany = "{{ $HumanResource->company_id }}";
    
            if (selectedCompany) {
                // If company is selected, show project and demand fields
                $('#project-group').removeClass('d-none');
                $('#demand-group').removeClass('d-none');
                $('#craft').closest('.col-md-4').addClass('d-none');
                $('#sub_craft').closest('.col-md-4').addClass('d-none');
                loadProjects(selectedCompany); // Load the projects for the selected company
            } else {
                // If no company is selected, show craft and sub-craft fields
                $('#project-group').addClass('d-none');
                $('#demand-group').addClass('d-none');
                $('#craft').closest('.col-md-4').removeClass('d-none');
                $('#sub_craft').closest('.col-md-4').removeClass('d-none');
            }
    
            // When company changes
            $('#company_id').on('change', function() {
                var companyId = $(this).val();
                if (companyId) {
                    // Show project and demand fields if company is selected
                    $('#project-group').removeClass('d-none');
                    $('#demand-group').removeClass('d-none');
                    $('#craft').closest('.col-md-4').addClass('d-none');
                    $('#sub_craft').closest('.col-md-4').addClass('d-none');
                    loadProjects(companyId); // Load the projects for the selected company
                } else {
                    // Otherwise, show craft and sub-craft fields
                    $('#project-group').addClass('d-none');
                    $('#demand-group').addClass('d-none');
                    $('#craft').closest('.col-md-4').removeClass('d-none');
                    $('#sub_craft').closest('.col-md-4').removeClass('d-none');
                }
            });
    
            // When project changes
            $('#project_id').on('change', function() {
                var projectId = $(this).val();
                loadDemands(projectId); // Load the demands for the selected project
            });
    
            // Function to load projects based on company
            function loadProjects(companyId) {
                $.ajax({
                    url: "{{ route('get-projects') }}",
                    type: "GET",
                    data: { company_id: companyId },
                    success: function(data) {
                        $('#project_id').empty().append('<option value="" disabled>Select Project</option>');
                        $.each(data, function(key, value) {
                            $('#project_id').append(`<option value="${value.id}">${value.project_name}</option>`);
                        });
                    }
                });
            }
    
            // Function to load demands based on project
            function loadDemands(projectId) {
                $.ajax({
                    url: "{{ route('get-demand') }}",
                    type: "GET",
                    data: { project_id: projectId },
                    success: function(data) {
                        $('#demand_id').empty().append('<option value="" disabled>Select Demand</option>');
                        $.each(data, function(key, value) {
                            $('#demand_id').append(`<option value="${value.id}">Man Power ${value.manpower}</option>`);
                        });
                    }
                });
            }
        });
    </script> --}}
    
    
    
@endsection
