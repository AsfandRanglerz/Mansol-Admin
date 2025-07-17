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

                                        {{-- @if ($company)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="company_id">Company</label>
                                                <input type="text" value="{{ $company->name }}" readonly class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="project-group">
                                            <div class="form-group">
                                                <label class="text-danger" for="project_id">Project</label>
                                                <input type="text" value="{{ $project->project_name ?? 'N/A' }}" readonly class="form-control">
                                                @error('project_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4" id="demand-group">
                                            <div class="form-group">
                                                <label class="text-danger" for="demand_id">Demand</label>
                                                <input type="text" value="{{ $demand ? 'Man Power - ' . $demand->manpower : 'N/A' }}" readonly class="form-control">
                                                @error('demand_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        @endif --}}
                                        @if (empty($company) && $histories->isEmpty())
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="text-danger" for="craft">Application for Post</label>
                                                    <input type="text" value="{{ optional($craft)->name }}" readonly
                                                        class="form-control">
                                                    @error('craft')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <input type="hidden" name="craft_id" value="{{ $craft->id ?? null }}">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="text-danger" for="sub_craft">Sub-Craft</label>
                                                    <input type="text" value="{{ $subCraft->name ?? null }}" readonly
                                                        class="form-control">
                                                    @error('sub_craft')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <input type="hidden" name="sub_craft_id" value="{{ $subCraft->id ?? null }}">
                                        @endif
                                        {{-- <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="application_date">Application Date</label>
                                                <input type="date" class="form-control" id="application_date"
                                                    name="application_date"
                                                    value="{{ old('application_date', $HumanResource->application_date) }}">
                                                @error('application_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div> --}}

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

                                                <div class="input-group">
                                                    {{-- File Input --}}
                                                    <input type="file" class="form-control" id="medical_doc"
                                                        name="medical_doc"
                                                        accept=".pdf,application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">

                                                    {{-- Eye Button if file exists --}}
                                                    @if (!empty($HumanResource->medical_doc))
                                                        <div class="input-group-append">
                                                            <a href="{{ asset('/' . $HumanResource->medical_doc) }}"
                                                                target="_blank" class="btn btn-danger"
                                                                title="View Document">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- Error --}}
                                                @error('medical_doc')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="name">Name *</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ old('name', $HumanResource->name) }}">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="son_of">S/O *</label>
                                                <input type="text" class="form-control" id="son_of" name="son_of"
                                                    value="{{ old('son_of', $HumanResource->son_of) }}">
                                                  @error('son_of')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
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
                                                    @foreach ($cities as $city)
                                                        <option value="{{ strtolower($city->name) }}"
                                                            {{ old('city_of_birth', strtolower($HumanResource->city_of_birth ?? '')) == strtolower($city->name) ? 'selected' : '' }}>
                                                            {{ $city->name }}
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
                                                <label class="text-danger" for="cnic">CNIC *</label>
                                                <input type="number" class="form-control" id="cnic" name="cnic"
                                                    value="{{ old('cnic', $HumanResource->cnic) }}">
                                                    @error('cnic')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
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
                                                    @foreach ($cities as $city)
                                                        <option value="{{ strtolower($city->name) }}"
                                                            {{ old('passport_issue_place', strtolower($HumanResource->passport_issue_place ?? '')) == strtolower($city->name) ? 'selected' : '' }}>
                                                            {{ $city->name }}
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
                                                <label class="text-danger" for="relation">Religion *</label>
                                                <select name="religion" class="form-control">
                                                    <option value="" selected disabled>Select Religion</option>
                                                    @foreach (['Muslim', 'Hindu', 'Christian', 'Buddhist', 'Jewish', 'Sikh'] as $religion)
                                                        <option value="{{ strtolower($religion) }}"
                                                            {{ old('religion', strtolower($HumanResource->religion ?? '')) == strtolower($religion) ? 'selected' : '' }}>
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
                                                    Qualification *</label>
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
                                                <label class="text-danger" for="technical_qualification">Technical
                                                    Qualification *</label>
                                                <select name="technical_qualification" id="qualification"
                                                    class="form-control">
                                                    <option value="" selected disabled>Select Qualification</option>

                                                    <optgroup label="Academic Degrees">
                                                    <optgroup label="Bachelor's Degrees">
                                                        @foreach (['Bachelor of Mechanical Engineering', 'Bachelor of Electrical Engineering', 'Bachelor of Civil Engineering', 'Bachelor of Chemical Engineering', 'Bachelor of Petroleum Engineering', 'Bachelor of Environmental Sciences', 'Bachelor of Mechatronics Engineering', 'Bachelor of Mining Engineering', 'Bachelor of Sustainable Energy Engineering', 'Bachelor of Architecture Engineering', 'Bachelor of Computer Sciences', 'Bachelor of Information Technology', 'Bachelor of Telecommunication Engineering', 'Bachelor of Business Administration', 'Bachelor of Business Management', 'Bachelor of Commerce', 'Bachelor of Accounts & Finance', 'Bachelor of Marketing & International Marketing', 'Bachelor of Political Science', 'Bachelor of HRM'] as $qualification)
                                                            <option value="{{ $qualification }}"
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>

                                                    <optgroup label="Master's Degrees">
                                                        @foreach (['Master in Physics', 'Master in Public Administration'] as $qualification)
                                                            <option value="{{ $qualification }}"
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                    </optgroup>

                                                    <optgroup label="Diplomas">
                                                        @foreach (['3-Yrs Diploma in Electrical Engineering', '3-Yrs Diploma in Mechanical Engineering', 'Diploma in Business Administration', 'Diploma in Health and Safety Management', 'Diploma in DHMS (4 Yrs)', 'Diploma in Optical Fiber Cables', 'Welding Diploma', 'Diploma - G.Fitter', 'Diploma - Mechanical', 'DAE Electronic', 'Two Year Diploma'] as $qualification)
                                                            <option value="{{ $qualification }}"
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>

                                                    <optgroup label="1-Yr Diploma">
                                                        @foreach (['DTI SAFETY INSPECTOR', 'DTI WELDER (3G)', 'DTI ADVANCE WELDER (6G)', 'DTI MAINTENANCE FITTER', 'DTI SAFETY ASSISTANT'] as $qualification)
                                                            <option value="{{ $qualification }}"
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>

                                                    <optgroup label="Technical & Vocational Training">
                                                        @foreach (['Apprenticeship Training', 'Trade Test Qualified', 'Technical Training For Abu Dhabi Industries', 'MCITP (Microsoft Certified IT Professionals)', 'IGC NEBOSH', 'IOSH Management Safety', 'OSHA SAFETY AND HEALTH COURSES'] as $qualification)
                                                            <option value="{{ $qualification }}"
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>

                                                    <optgroup label="MTTI Certifications">
                                                        @foreach (['FABRICATOR PIPE (MTTI) CERTIFIED', 'PIPE & PLATE FABRICATOR (MTTI) CERTIFIED', 'FITTER GENERAL (MTTI) CERTIFIED', 'PIPE WELDER 6G (MTTI) CERTIFIED', 'PLATE WELDER 3G (MTTI) CERTIFIED', 'RIGGER (MTTI) CERTIFIED', 'SAFETY ASSISTANT (MTTI) CERTIFIED', 'SAFETY INSPECTOR (MTTI) CERTIFIED', 'SCAFOLDER (MTTI) CERTIFIED'] as $qualification)
                                                            <option value="{{ $qualification }}"
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>

                                                    <optgroup label="Other Certifications">
                                                        @foreach (['ELECTRICIAN COURSE', 'PLUMBER COURSE', 'FRONT OFFICE MANAGEMENT COURSE', 'COMPUTER SHORT COURSE'] as $qualification)
                                                            <option value="{{ $qualification }}"
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>

                                                    <optgroup label="Specific Skills">
                                                        @foreach (['Welder', 'Fitter', 'General Fitter', 'Pipe Fitter', 'Rigger', 'Steel Fixure', 'Fabricator', 'Millwright', 'K Technician', 'Instrument Technician'] as $qualification)
                                                            <option value="{{ $qualification }}"
                                                                {{ old('technical_qualification', $HumanResource->technical_qualification ?? '') == $qualification ? 'selected' : '' }}>
                                                                {{ $qualification }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>

                                                    <optgroup label="Other">
                                                        @foreach (['NO TECHNICAL EDUCATION', 'Electronic / Electrical', 'Mechanical', 'Auto Mobile'] as $qualification)
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
                                                <label class="text-danger" for="experience">Years of Experience
                                                    (Local)</label>
                                                <input type="number" name="experience_local" class="form-control"
                                                    min="0" placeholder="Enter Years of Experience"
                                                    value="{{ old('experience', $HumanResource->experience_local ?? '') }}">
                                                @error('experience')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="experience">Years of Experience (Gulf)
                                                    *</label>
                                                <input type="number" name="experience_gulf" class="form-control"
                                                    min="0" placeholder="Enter Years of Experience"
                                                    value="{{ old('experience', $HumanResource->experience_gulf ?? '') }}">
                                                @error('experience_gulf')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="district_of_domicile">District Of
                                                    Domicile</label>
                                                <select name="district_of_domicile" id="district_of_domicile"
                                                    class="form-control">
                                                    <option value="" selected disabled>Select District</option>
                                                    @foreach ($districts as $district)
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
                                                        value="{{ $HumanResource->email }}" name="email">
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
                                                            Select City
                                                        </option>
                                                        @foreach ($cities as $city)
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
                                                            Select City
                                                        </option>
                                                        @foreach ($cities as $city)
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
                                                    <select name="permanent_address_province" class="form-control">
                                                        <option value="" selected disabled>Select Province</option>
                                                        @foreach ($provinces as $data)
                                                            <option value="{{ $data->name }}"
                                                                {{ $data->name == $HumanResource->permanent_address_province ? 'selected' : '' }}>
                                                                {{ $data->name }}</option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                        </div>





                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="text-danger" for="citizenship">Citizenship *</label>
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
                                                <label class="text-danger" for="gender">Gender *</label>
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
                                                <div class="input-group">
                                                    <!-- Currency Dropdown -->
                                                    <select name="currancy" class="form-control" id="currancy">
                                                        <option value="" selected disabled> Currency</option>
                                                        @foreach ($curencies as $country)
                                                            <option value="{{ $country->currency_code }}"
                                                                {{ strtolower(old('currancy', $HumanResource->currancy ?? '')) == strtolower($country->currency_code) ? 'selected' : '' }}>
                                                                {{ $country->currency_code }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <!-- Salary Input -->
                                                    <input type="number" class="form-control" id="min_salary"
                                                        name="min_salary" value="{{ $HumanResource->min_salary }}">
                                                </div>
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
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header text-center d-flex justify-content-between align-items-center">
                        @if ($nominat)
                            <a class="btn btn-primary" disabled title="Please Demob" onclick="showToaster()">Assign</a>
                        @else
                            <a class="btn btn-primary"
                                onclick="showUserModel('createDriverModel', {{ $HumanResource->id }})">Assign</a>
                        @endif
                        <h4 class="flex-grow-1 text-center m-0">Job History</h4>
                        <div style="width: 75px;"></div> <!-- Empty space to balance the button width -->
                    </div>


                    <div class="card-body table-striped table-bordered table-responsive">
                        <table class="table responsive" id="table_id_events">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Company</th>
                                    <th>Interview Location</th>
                                    <th>Project</th>
                                    <th>Craft</th>
                                    <th>Sub-Craft</th>
                                    <th>Application Date</th>
                                    <th>Mob-Date</th>
                                    <th>Demob-Date</th>
                                    <th scope="col-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($histories as $data)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $data->company->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->city_of_interview ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->project->project_name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->craft->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->subCraft->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->application_date ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->mob_date ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->demobe_date ?? 'N/A' }}
                                        </td>
                                        <td class="">
                                            <div class="row m-1">
                                                <div class="col-md-6 mb-2">
                                                    <button type="button" class="btn btn-primary editDriverBtn"
                                                        data-id="{{ $data->id }}"><span
                                                            class="fa fa-edit"></span></button>
                                                </div>
                                                {{-- <div class="col-md-6 mb-2">
                                                    <form action="{{ route('humanresource.destroy', $data->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-flat show_confirm"
                                                            data-toggle="tooltip"><span
                                                                class="fa fa-trash"></span></button>
                                                    </form>
                                                </div> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- add Hobby Modal -->
        <div class="modal fade" id="createDriverModel" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5 class="modal-title text-center" id="exampleModalLabel">Add Job History</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createDriverForm" enctype="multipart/form-data"
                            action="{{ route('history.update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="human_resource_id" id="human_resource_id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Company</label>
                                        <select name="company_id" id="company_id" class="form-control">
                                            <option value="">Select Company</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select> 
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="city_of_interview">Interview Location</label>
                                        <select name="city_of_interview" class="form-control" id="cityOfInterview">
                                            <option value="" selected disabled>Select Location</option>
                                            @foreach ($cities as $city)
                                                <option value="{{ strtolower($city->name) }}">{{ $city->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('city_of_interview')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="project_id">Project</label>
                                        <select name="project_id" id="project_id" class="form-control">
                                            <option value="" selected disabled>Select Project</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="demand_id">Demand</label>
                                        <select name="demand_id" id="demand_id" class="form-control">
                                            <option value="" selected disabled>Select Demand</option>
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Craft</label>
                                        <select name="craft_id" id="craft" class="form-control">
                                            <option value="">Select Craft</option>
                                            @foreach ($crafts as $craft)
                                                <option value="{{ $craft->name }}">{{ $craft->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="" for="sub_craft">Sub-Craft (Optional)</label>
                                        <select name="sub_craft_id" class="form-control" id="sub_craft">
                                            <option value="" selected disabled>Select Sub-Craft</option>
                                        </select>
                                        @error('sub_craft')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date">Application Date</label>
                                        <input type="date" class="form-control" id="editStartDate"
                                            name="application_date" value="{{ date('Y-m-d') }}" readonly>

                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary create-ethnicity">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Hobby Modal -->
        <div class="modal fade" id="editDriverModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" id="mymodal" role="document">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <h5 class="modal-title" id="exampleModalLabel">Demob</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editDriverForm" enctype="multipart/form-data"
                            action="{{ route('jobHistory.update') }}" method="POST">
                            @csrf
                            <input type="hidden" id="editDriverId" name="id">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">Mob Date</label>
                                        <input type="date" class="form-control" id="mobDate" name="start_date">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date">Demob Date</label>
                                        <input type="date" class="form-control" id="deMobDate" name="end_date">
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn btn-primary update-history">Update</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script>
        function showToaster() {
            toastr.warning("Please demobilize the current job before assigning!", "Action Blocked");
        }
    </script>
    <script>
        $(document).ready(function() {

            $('#table_id_events').DataTable()
        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
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
    {{-- @if (\Illuminate\Support\Facades\Session::has('message'))
        <script>
            toastr.success('{{ \Illuminate\Support\Facades\Session::get('message') }}');
        </script>
    @endif --}}
    <script>
        $(document).on('click', '#craft', function() {
            var craftId = $(this).val();
            $.ajax({
                url: "{{ route('get-sub-crafts') }}",
                type: "GET",
                data: {
                    craft_id: craftId
                },
                success: function(data) {
                    $('#sub_craft').empty();
                    $('#sub_craft').append(
                        '<option value="" selected disabled>Select Sub-Craft</option>');


                    $.each(data, function(key, value) {
                        $('#sub_craft').append('<option value="' + value.id +
                            '">' + value.name + '</option>');
                    });
                }
            });
        });
        //add 
        function showUserModel(id, humanResourceId) {
            $(`#${id}`).modal('show');
            $('#createDriverModel').find('input, textarea, select').val('');
            $('#clonedInputsContainer').empty();
            $('#createDriverForm')[0].reset(); // Reset the form after successful submission
            $('#human_resource_id').val(humanResourceId);
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            if (csrfToken) {
                if (!$('input[name="_token"]').length) {
                    $('#createDriverForm').prepend(`<input type="hidden" name="_token" value="${csrfToken}">`);
                } else {
                    $('input[name="_token"]').val(csrfToken);
                }
            }
        };

        function getDemobData(id) {
            $.ajax({
                url: "{{ route('get-demob-data') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data.demobe_date);
                    $('#mobDate').val(data.mob_date);
                    $('#deMobDate').val(data.demobe_date);
                }
            });
        }

        $(document).on('click', '.editDriverBtn', function() {
            var id = $(this).data('id');
            $('#editDriverId').val(id);
            $('.update-history').attr('data', id);
            $('#editDriverModel').modal('show');
            getDemobData(id); // Now this will work
        });
        // $('#company_id').on('change', function() {
        //     var companyId = $(this).val();

        //     $.ajax({
        //         url: "{{ route('get-projects') }}",
        //         type: "GET",
        //         data: {
        //             company_id: companyId
        //         },
        //         success: function(data) {
        //             $('#project_id').empty();
        //             $('#demand_id').empty();
        //             $('#sub_craft').empty();
        //             $('#project_id').append(
        //                 '<option value="" selected disabled>Select Project</option>');
        //             $('#demand_id').append(
        //                 '<option value="" selected disabled>Select Demand</option>');
        //             $('#sub_craft').append(
        //                 '<option value="" selected disabled>Select Sub-Craft</option>');

        //             $.each(data, function(key, value) {
        //                 $('#project_id').append('<option value="' + value.id +
        //                     '">' + value.project_name + '</option>');
        //             });

        //             if ($('#status option[value="3"]').length === 0) {
        //                 $('#status').empty().append('<option value="3" selected>Assign</option>');
        //             } else {
        //                 $('#status').val('3');
        //             }
        //         }
        //     });
        // });

        // $('#project_id').on('change', function() {
        //     var projectId = $(this).val();

        //     $.ajax({
        //         url: "{{ route('get-demand') }}",
        //         type: "GET",
        //         data: {
        //             project_id: projectId
        //         },
        //         success: function(data) {
        //             $('#demand_id').empty();
        //             $('#demand_id').append(
        //                 '<option value="" selected disabled>Select Demand</option>');

        //             $.each(data, function(key, value) {
        //                 $('#demand_id').append('<option value="' + value.id +
        //                     '">Man Power - ' + value.full_name + '</option>');
        //             });
        //         }
        //     });
        // });
    </script>
    <script>
        $(document).ready(function() {
            // When company is selected
            $('#company_id').on('change', function() {
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
                $('#project_id').empty().append(
                    '<option value="" selected disabled>Select Project</option>');
                $('#demand_id').empty().append('<option value="" selected disabled>Select Demand</option>');
                $('#craft').empty().append('<option value="" selected disabled>Select Craft</option>');
                $('#sub_craft').empty().append(
                    '<option value="" selected disabled>Select Sub-Craft</option>');

                if (companyId) {
                    $.ajax({
                        url: "{{ route('get-projects') }}",
                        type: "GET",
                        data: {
                            company_id: companyId
                        },
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#project_id').append('<option value="' + value.id +
                                    '">' + value.project_name + '</option>');
                            });
                        }
                    });
                }
            });

            // When project is selected
            $('#project_id').on('change', function() {
                var projectId = $(this).val();

                $('#demand_id').empty().append('<option value="" selected disabled>Select Demand</option>');
                $('#craft').empty().append('<option value="" selected disabled>Select Craft</option>');
                $('#sub_craft').empty().append(
                    '<option value="" selected disabled>Select Sub-Craft</option>');

                if (projectId) {
                    $.ajax({
                        url: "{{ route('get-demand') }}",
                        type: "GET",
                        data: {
                            project_id: projectId
                        },
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#demand_id').append('<option value="' + value.id +
                                    '">Man Power - ' + value.manpower + '</option>');
                            });
                        }
                    });
                }
            });

            // When demand is selected
            $('#demand_id').on('change', function() {
                var demandId = $(this).val();

                $('#craft').empty().append('<option value="" selected disabled>Select Craft</option>');
                $('#sub_craft').empty().append(
                    '<option value="" selected disabled>Select Sub-Craft</option>');

                if (demandId) {
                    $.ajax({
                        url: "{{ route('get-crafts-by-demand') }}",
                        type: "GET",
                        data: {
                            demand_id: demandId
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#craft').append('<option value="' + value.id +
                                        '">' + value.name + '</option>');
                                });
                                // Automatically select the first craft
                                $('#craft').val(data[0].id).trigger('change');
                            }
                        }
                    });
                }
            });

            // When craft is selected
            $('#craft').on('change', function() {
                var craftId = $(this).val();

                $('#sub_craft').empty().append(
                    '<option value="" selected disabled>Select Sub-Craft</option>');

                if (craftId) {
                    $.ajax({
                        url: "{{ route('get-sub-crafts') }}",
                        type: "GET",
                        data: {
                            craft_id: craftId
                        },
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#sub_craft').append('<option value="' + value.id +
                                    '">' + value.name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
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
