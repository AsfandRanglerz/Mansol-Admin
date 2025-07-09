<style>
    .steps {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .step {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: lightgray;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 12px;
        font-weight: bold;
        margin: 0 10px;
        position: relative;
    }

    .step.active {
        cursor: pointer;
        background-color: var(--theme-color);
        color: white;
    }

    .line {
        height: 2px;
        width: 40px;
        margin-bottom: 1.8rem;
        background-color: lightgray;
    }

    .line.active {
        background-color: var(--theme-color);
    }

    .buttons {
        margin-top: 50px;
    }

    .step-text {
        color: lightgray;
    }

    .step-text.active {
        cursor: pointer;
        color: var(--theme-color);
    }

    .form-section {
        display: none;
    }

    .form-section.active {
        display: block;
    }

    .preview-box {
        margin: 0 auto;

        width: 100%;

        height: 300px;

        border: 1px solid #ddd;

        display: flex;

        justify-content: center;

        align-items: center;

        overflow: hidden;
    }

    .preview-box img {
        object-fit: cover;

        max-width: 100%;

        max-height: 100%;
    }

    .tick-mark {
        background-color: white;

        border-radius: 50%;

        overflow: hidden;

        color: rgb(84 202 104);

        top: 0;

        right: 10px;

        font-size: 0.8rem;
    }

    .step-8 {
        color: black !important;
    }

    .step-8 .main-header {
        font-size: 24px;

        text-align: center;

        margin-bottom: 25px;

        font-weight: bold;
    }

    .step-8 .dashed-divider {
        border-bottom: 2px dashed #000;

        margin: 20px 0;
    }

    .data-copy-section div {
        margin: 3px 0;
    }

    .step-8 .number-grid {
        display: inline-flex;

        align-items: center;

        gap: 0;
    }

    .step-8 .number-cell {
        width: 20px;

        height: 22px;

        border: 1px solid black;

        display: inline-block;

        text-align: center;

        margin: 0 1px;

        font-size: 14px;
    }

    .step-8 table {
        width: 100%;

        border-collapse: collapse;

        margin: 12px 0;
    }

    .step-8 td,
    .step-8 th {
        border: 1px solid #000;

        padding: 6px 8px;

        vertical-align: top;
    }

    .step-8 .signature-grid {
        display: grid;

        grid-template-columns: 1fr 1fr 1fr;

        gap: 15px;

        margin-top: 25px;
    }

    .step-8 .dotted-line {
        border-bottom: 1px dotted #000;

        margin: 30px 0 15px 0;
    }

    .step-8 .notes {
        margin-top: 20px;

        font-size: 14px;
    }

    .step-8 .bold {
        font-weight: bold;
    }

    .step-8 .copy-spacer {
        margin-top: 60px;
    }

    .bank-logo {
        max-width: 6rem;
    }

    .step-8 .border-black {
        border-color: black !important;
    }

    .step-8 .border-bottom-black {
        border-bottom: 3px solid black;
    }

    .download-btn {
        top: 0.5rem;
        right: 0rem;
    }

    .photo-download-btn {
        top: 0.5rem;
        left: 13%;
        right: auto;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- Create Human Resource Model --}}


                <div class="steps mb-5">
                    @for ($i = 1; $i <= 7; $i++)
                        {{-- Adjusted to reflect the new total steps --}}
                        <div style="cursor: pointer;"
                            class="d-flex flex-column align-items-center position-relative step-container">
                            <div class="step {{ $i == 1 ? 'active' : '' }}" data-step="{{ $i }}">
                                {{ $i }}
                            </div>

                            <p class="m-0 step-text {{ $i == 1 ? 'active' : '' }}">
                                Step {{ $i }}
                            </p>

                            <span class="fa-solid fa-circle-check position-absolute top-0 tick-mark d-none"></span>
                        </div>

                        @if ($i < 7)
                            <div class="line"></div>
                        @endif
                    @endfor
                </div>

                {{-- Step 1: Combined Form --}}
                <div class="form-section active" data-step="1">
                    <form id="form-step-1" action="{{ route('submit.step', ['step' => 1]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="human_resource_id" value="{{ $HumanResource->id }}" />

                        {{-- Latest Resume --}}
                        <h5>Latest Resume</h5>
                        <div class="form-group">
                            <label>Upload CV (PDF only)</label>
                            @php
                                $cv = optional(
                                    $HumanResource->hrSteps->where('step_number', 1)->where('file_type', 'cv')->first(),
                                )->file_name;
                            @endphp
                            <input type="file" class="form-control" name="cv" accept=".pdf"
                                onchange="previewPDF(this, 'cvPreview-{{ $HumanResource->id }}')" />
                            <iframe id="cvPreview-{{ $HumanResource->id }}" class="border-0 mt-2 {{ $cv ? '' : 'd-none' }}"
                                src="{{ $cv ? asset($cv) : '' }}" width="100%" height="300px"></iframe>
                        </div>

                        {{-- Passport Images --}}
                        <h5>Valid Passport</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <label>Passport Image 1</label>
                                @php
                                    $passportFront = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 2)
                                            ->where('file_type', 'passport front')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="passport_image_1" accept="image/*"
                                    onchange="previewImage(this, 'passportFrontPreview-{{ $HumanResource->id }}')" />
                                <div class="position-relative">
                                    <img id="passportFrontPreview-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $passportFront ? '' : 'd-none' }}"
                                        src="{{ $passportFront ? asset($passportFront) : '' }}"
                                        style="width: 100%; height: 5.5cm; object-fit: contain;" />
                                    <button class="btn btn-primary position-absolute download-btn">
                                        <span class="fa-solid fa-download"></span>
                                    </button>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <label>Passport Image 2</label>
                                @php
                                    $passportBack = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 2)
                                            ->where('file_type', 'passport back')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="passport_image_2" accept="image/*"
                                    onchange="previewImage(this, 'passportBackPreview-{{ $HumanResource->id }}')" />
                                <div class="position-relative"><img id="passportBackPreview-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $passportBack ? '' : 'd-none' }}"
                                        src="{{ $passportBack ? asset($passportBack) : '' }}"
                                        style="width: 100%; height: 5.5cm; object-fit: contain;" /><button
                                        class="btn btn-primary position-absolute download-btn">
                                        <span class="fa-solid fa-download"></span>
                                    </button>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <label>Passport Image 3</label>
                                @php
                                    $passportImageThree = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 2)
                                            ->where('file_type', 'passport third image')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="passport_image_3" accept="image/*"
                                    onchange="previewImage(this, 'passportPreviewThree-{{ $HumanResource->id }}')" />
                                <div class="position-relative"><img id="passportPreviewThree-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $passportImageThree ? '' : 'd-none' }}"
                                        src="{{ $passportImageThree ? asset($passportImageThree) : '' }}"
                                        style="width: 100%; height: 5.5cm; object-fit: contain;" /><button
                                        class="btn btn-primary position-absolute download-btn">
                                        <span class="fa-solid fa-download"></span>
                                    </button>
                                </div>

                            </div>
                        </div>

                        {{-- CNIC --}}
                        <h5 class="mt-4">CNIC</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label>CNIC Front</label>
                                @php
                                    $cnicFront = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 3)
                                            ->where('file_type', 'cnic front')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="cnic_front" accept="image/*"
                                    onchange="previewImage(this, 'cnicFrontPreview-{{ $HumanResource->id }}')" />
                                <div class="position-relative">
                                    <img id="cnicFrontPreview-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $cnicFront ? '' : 'd-none' }}"
                                        src="{{ $cnicFront ? asset($cnicFront) : '' }}"
                                        style="width: 100%; height: 5.5cm; object-fit: contain;" />
                                    <button class="btn btn-primary position-absolute download-btn">
                                        <span class="fa-solid fa-download"></span>
                                    </button>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <label>CNIC Back</label>
                                @php
                                    $cnicBack = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 3)
                                            ->where('file_type', 'cnic back')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="cnic_back" accept="image/*"
                                    onchange="previewImage(this, 'cnicBackPreview-{{ $HumanResource->id }}')" />
                                <div class="position-relative">
                                    <img id="cnicBackPreview-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $cnicBack ? '' : 'd-none' }}"
                                        src="{{ $cnicBack ? asset($cnicBack) : '' }}"
                                        style="width: 100%; height: 5.5cm; object-fit: contain;" />
                                    <button class="btn btn-primary position-absolute download-btn">
                                        <span class="fa-solid fa-download"></span>
                                    </button>
                                </div>

                            </div>
                        </div>
                    <div class="row mt-4">
                        {{-- Passport-size Photograph --}}
                        <div class="col-md-6">
                            <h5 class="mt-4">Passport-size Photograph</h5>
                            <div class="form-group">
                                <label>Upload Photo</label>
                                @php
                                    $photo = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 4)
                                            ->where('file_type', 'photo')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="photo" accept="image/*"
                                    onchange="previewImage(this, 'photoPreview-{{ $HumanResource->id }}')" />
                                <div class="position-relative">
                                    <img id="photoPreview-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $photo ? '' : 'd-none' }}"
                                        src="{{ $photo ? asset($photo) : '' }}"
                                        style="width: 3.5cm; height: 4.5cm; object-fit: contain;" />
                                    {{-- @if ($photo) --}}
                                        <button class="btn btn-primary position-absolute download-btn">
                                            <span class="fa-solid fa-download"></span>
                                        </button>
                                    {{-- @endif --}}
                                </div>

                            </div>
                        </div>

                          {{-- Police Verification Certificate --}}
                        <div class="col-md-6">
                            <h5 class="mt-4">Police Verification Certificate</h5>
                            <div class="form-group">
                                <label>Upload Photo</label>
                                @php
                                    $policePhoto = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 4)
                                            ->where('file_type', 'police verification')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="police_verification" accept="image/*"
                                    onchange="previewImage(this, 'policeCertificate-{{ $HumanResource->id }}')" />
                                <div class="position-relative">
                                    <img id="policeCertificate-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $policePhoto ? '' : 'd-none' }}"
                                        src="{{ $policePhoto ? asset($policePhoto) : '' }}"
                                        style="width: 3.5cm; height: 4.5cm; object-fit: contain;" />
                                    {{-- @if ($photo) --}}
                                        <button class="btn btn-primary position-absolute download-btn">
                                            <span class="fa-solid fa-download"></span>
                                        </button>
                                    {{-- @endif --}}
                                </div>

                            </div>
                        </div>

                          {{-- Account Detail --}}
                        <div class="col-md-6">
                            <h5 class="mt-4">Account Detail</h5>
                            <div class="form-group">
                                <label>Upload Photo</label>
                                @php
                                    $accountPhoto = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 4)
                                            ->where('file_type', 'account detail')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="account_detail" accept="image/*"
                                    onchange="previewImage(this, 'accountDetail-{{ $HumanResource->id }}')" />
                                <div class="position-relative">
                                    <img id="accountDetail-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $accountPhoto ? '' : 'd-none' }}"
                                        src="{{ $accountPhoto ? asset($accountPhoto) : '' }}"
                                        style="width: 3.5cm; height: 4.5cm; object-fit: contain;" />
                                    {{-- @if ($photo) --}}
                                        <button class="btn btn-primary position-absolute download-btn">
                                            <span class="fa-solid fa-download"></span>
                                        </button>
                                    {{-- @endif --}}
                                </div>

                            </div>
                        </div>

                          {{-- Updated Appraisal Image --}}
                        <div class="col-md-6">
                            <h5 class="mt-4">Updated Appraisal Image</h5>
                            <div class="form-group">
                                <label>Upload Photo</label>
                                @php
                                    $appraisalPhoto = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 4)
                                            ->where('file_type', 'update appraisal')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="update_appraisal" accept="image/*"
                                    onchange="previewImage(this, 'updatedAppraisal-{{ $HumanResource->id }}')" />
                                <div class="position-relative">
                                    <img id="updatedAppraisal-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $appraisalPhoto ? '' : 'd-none' }}"
                                        src="{{ $appraisalPhoto ? asset($appraisalPhoto) : '' }}"
                                        style="width: 3.5cm; height: 4.5cm; object-fit: contain;" />
                                    {{-- @if ($photo) --}}
                                        <button class="btn btn-primary position-absolute download-btn">
                                            <span class="fa-solid fa-download"></span>
                                        </button>
                                    {{-- @endif --}}
                                </div>

                            </div>
                        </div>
                    </div>


                        {{-- NOK CNIC --}}
                        <h5 class="mt-4">Next of Kin (NOK) CNIC</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <label>NOK CNIC Front</label>
                                @php
                                    $nokCnicFront = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 5)
                                            ->where('file_type', 'nok cnic front')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="nok_cnic_front" accept="image/*"
                                    onchange="previewImage(this, 'nokCnicFrontPreview-{{ $HumanResource->id }}')" />
                                <div class="position-relative">
                                    <img id="nokCnicFrontPreview-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $nokCnicFront ? '' : 'd-none' }}"
                                        src="{{ $nokCnicFront ? asset($nokCnicFront) : '' }}"
                                        style="width: 100%; height: 5.5cm; object-fit: contain;" />
                                    <button class="btn btn-primary position-absolute download-btn">
                                        <span class="fa-solid fa-download"></span>
                                    </button>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <label>NOK CNIC Back</label>
                                @php
                                    $nokCnicBack = optional(
                                        $HumanResource->hrSteps
                                            ->where('step_number', 5)
                                            ->where('file_type', 'nok cnic back')
                                            ->first(),
                                    )->file_name;
                                @endphp
                                <input type="file" class="form-control" name="nok_cnic_back" accept="image/*"
                                    onchange="previewImage(this, 'nokCnicBackPreview-{{ $HumanResource->id }}')" />
                                <div class="position-relative">
                                    <button class="btn btn-primary position-absolute download-btn">
                                        <span class="fa-solid fa-download"></span>
                                    </button>
                                    <img id="nokCnicBackPreview-{{ $HumanResource->id }}"
                                        class="img-fluid mt-2 border rounded {{ $nokCnicBack ? '' : 'd-none' }}"
                                        src="{{ $nokCnicBack ? asset($nokCnicBack) : '' }}"
                                        style="width: 100%; height: 5.5cm; object-fit: contain;" />
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
 
                {{-- Step 2: Medical Report (Previously Step 6) + Visa Form (Previously Step 8) + Air Booking (Previously Step 9) --}}
                <div class="form-section" data-step="2">
                    <form id="form-step-2" action="{{ route('submit.step', ['step' => 2]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="human_resource_id" value="{{ $HumanResource->id }}" />

                        {{-- Medical Report --}}
                        <h5>Medical Report</h5>
                        @php
                            $step = optional($HumanResource->hrSteps->where('step_number', 6)->first());
                            // {{$step}}
                            $medical_report = $step->file_name ? asset($step->file_name) : null;
                            $process_status = $step->process_status ?? '';
                            $medically_fit = $step->medically_fit ?? '';
                            $report_date = $step->report_date ?? '';
                            $valid_until = $step->valid_until ?? '';
                            $lab = $step->lab ?? '';
                            $any_comments = $step->any_comments ?? '';
                            $original_report_received = $step->original_report_received ?? false;
                        @endphp
                        <div class="row">
                            {{-- Medical Report Number --}}
                            {{-- Process Status --}}
                            <div class="col-md-6">
                                <label>Process Status</label>
                                <select name="process_status" class="form-control" required>
                                    <option value="" disabled {{ !$process_status ? 'selected' : '' }}>Select an
                                        Option</option>
                                    <option value="Yet to appear"
                                        {{ $process_status == 'Yet to appear' ? 'selected' : '' }}>Yet to appear
                                    </option>
                                    <option value="Appeared" {{ $process_status == 'Appeared' ? 'selected' : '' }}>
                                        Appeared</option>
                                    <option value="Waiting" {{ $process_status == 'Waiting' ? 'selected' : '' }}>
                                        Waiting</option>
                                    <option value="Result Available"
                                        {{ $process_status == 'Result Available' ? 'selected' : '' }}>Result Available
                                    </option>
                                </select>
                            </div>
                            {{-- Medically Fit --}}
                            <div class="col-md-6">
                                <label>Medically Fit</label>
                                <select name="medically_fit" class="form-control" required>
                                    <option value="" disabled {{ !$medically_fit ? 'selected' : '' }}>Select an
                                        Option</option>
                                    <option value="Repeat" {{ $medically_fit == 'Repeat' ? 'selected' : '' }}>Repeat
                                    </option>
                                    <option value="Fit" {{ $medically_fit == 'Fit' ? 'selected' : '' }}>Fit
                                    </option>
                                    <option value="Unfit" {{ $medically_fit == 'Unfit' ? 'selected' : '' }}>Unfit
                                    </option>
                                </select>
                            </div>
                            {{-- Report Date --}}
                            <div class="col-md-6 mt-3">
                                <label>Report Date</label>
                                <input type="date" class="form-control" name="report_date"
                                    value="{{ $report_date }}" />
                            </div>
                            {{-- Valid Until --}}
                            <div class="col-md-6 mt-3">
                                <label>Valid Until</label>
                                <input type="date" class="form-control" name="valid_until"
                                    value="{{ $valid_until }}" />
                            </div>
                            {{-- Lab --}}
                            <div class="col-md-6 mt-3">
                                <label>Lab</label>
                                <select name="lab" class="form-control" required>
                                    <option value="" disabled {{ !$lab ? 'selected' : '' }}>Select an Option
                                    </option>
                                    <option value="Lab 1" {{ $lab == 'Lab 1' ? 'selected' : '' }}>Lab 1</option>
                                    <option value="Lab 2" {{ $lab == 'Lab 2' ? 'selected' : '' }}>Lab 2</option>
                                    <option value="Lab 3" {{ $lab == 'Lab 3' ? 'selected' : '' }}>Lab 3</option>
                                </select>
                            </div>
                            {{-- Comments --}}
                            <div class="col-md-6 mt-3">
                                <label>Any Comments on Medical Report</label>
                                <input type="text" class="form-control" name="any_comments"
                                    value="{{ $any_comments }}" />
                            </div>
                            {{-- Upload Medical Report --}}
                            <div class="col-md-6 mt-3">
                                <label>Upload Medical Report</label>
                                <input type="file" class="form-control" name="medical_report"
                                    accept=".pdf,image/*"
                                    onchange="previewUploadedFile(this, 'medicalReportPreview-{{ $HumanResource->id }}')" />
                                <div class="mt-2">
                                    <a id="medicalReportPreview-{{ $HumanResource->id }}" href="{{ $medical_report }}" target="_blank"
                                        class="btn btn-info {{ $medical_report ? '' : 'd-none' }}">
                                        View Uploaded Report
                                    </a>
                                </div>
                            </div>
                            {{-- Original Report Received --}}
                            <div class="col-md-6 mt-4">
                                <label for="recieved" class="mt-4">Original Report Received?</label> &nbsp; &nbsp;
                                <input type="checkbox" id="recieved" name="original_report_received" class="mt-4"
                                    {{ $original_report_received == 'yes' ? 'checked' : '' }} />
                            </div>
                        </div>

                       
                        {{-- Visa Form --}}
                        <h5 class="mt-5">Visa Form</h5>
                        @php
                            $visaStep = optional($HumanResource->hrSteps->where('step_number', 6)->first());
                            $visa_type = $visaStep->visa_type ?? '';
                            $visa_issue_date = $visaStep->visa_issue_date ?? '';
                            $visa_expiry_date = $visaStep->visa_expiry_date ?? '';
                            $visa_receive_date = $visaStep->visa_receive_date ?? '';
                            $visa_status = $visaStep->visa_status ?? '';
                            $visa_issue_number = $visaStep->visa_issue_number ?? '';
                            $visa_endorsement_date = $visaStep->visa_endorsement_date ?? '';
                            $endorsement_checked = $visaStep->endorsement_checked ?? false;
                            $scanned_visa = $visaStep->scanned_visa ? asset($visaStep->scanned_visa) : null;
                        @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <label for="visa_type">Visa Type</label>
                                <select name="visa_type" class="form-control" required>
                                    <option value="" disabled {{ !$visa_type ? 'selected' : '' }}>Select an Option</option>
                                    <option value="Work Permit" {{ $visa_type == 'Work Permit' ? 'selected' : '' }}>Work Permit</option>
                                    <option value="Visit Visa" {{ $visa_type == 'Visit Visa' ? 'selected' : '' }}>Visit Visa</option>
                                    {{-- ...other options... --}}
                                </select>
                            </div>
                             <div class="col-md-6">
                                <label for="issue_date">Number</label>
                                <input type="number" class="form-control" name="visa_issue_number" value="{{ $visa_issue_number }}" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="issue_date">Issue Date</label>
                                <input type="date" class="form-control" name="visa_issue_date" value="{{ $visa_issue_date }}" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="expiry_date">Expiry Date</label>
                                <input type="date" class="form-control" name="visa_expiry_date" value="{{ $visa_expiry_date }}" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="receive_date">Visa Receive Date</label>
                                <input type="date" class="form-control" name="visa_receive_date" value="{{ $visa_receive_date }}" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="visa_status">Visa Status</label>
                                <input type="text" class="form-control" name="visa_status" value="{{ $visa_status }}" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="scanned_visa">Scanned Visa</label>
                                <input type="file" class="form-control" name="scanned_visa" accept=".pdf,image/*"
                                onchange="previewUploadedFile(this, 'visaPreview-{{ $HumanResource->id }}')" />
                                <div class="mt-2">
                                    <a id="visaPreview-{{ $HumanResource->id }}" href="{{ $scanned_visa }}" target="_blank"
                                        class="btn btn-info {{ $scanned_visa ? '' : 'd-none' }}">
                                        View Uploaded Visa
                                    </a>
                                </div>
                            </div>
                                {{-- Endorsement --}}
                               <div class="col-md-6 mt-4">
                                {{-- <input type="text" value="{{$endorsement_checked}}"> --}}
                                   <label for="Endorsement" class="mt-4">Endorsement?</label> &nbsp; &nbsp;
                                   <input type="checkbox" id="Endorsement" name="endorsement_checked" class="mt-4"
                                       {{ $endorsement_checked == 'yes' ? 'checked' : '' }} />
                               </div>
                                <div class="col-md-6 mt-3">
                                    <label for="endorsement_date">Endorsement Date</label>
                                    <input type="date" class="form-control" name="visa_endorsement_date" value="{{ $visa_endorsement_date }}" />
                                </div>
                        </div>

                        {{-- Air Booking --}}
                        <h5 class="mt-5">Air Booking</h5>
                        @php
                            $airBookingStep = optional($HumanResource->hrSteps->where('step_number', 6)->first());
                            $ticket_number = $airBookingStep->ticket_number ?? '';
                            $flight_number = $airBookingStep->flight_number ?? '';
                            $flight_route = $airBookingStep->flight_route ?? '';
                            $flight_date = $airBookingStep->flight_date ?? '';
                            $flight_etd = $airBookingStep->flight_etd ?? '';
                            $flight_eta = $airBookingStep->flight_eta ?? '';
                            $upload_ticket = $airBookingStep->upload_ticket ? asset($airBookingStep->upload_ticket) : null;
                        @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <label for="ticket_number">Ticket Number</label>
                                <input type="text" class="form-control" name="ticket_number" value="{{ $ticket_number }}" />
                            </div>
                            <div class="col-md-6">
                                <label for="flight_number">Flight Number</label>
                                <input type="text" class="form-control" name="flight_number" value="{{ $flight_number }}" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="flight_route">Flight Route</label>
                                <input type="text" class="form-control" name="flight_route" value="{{ $flight_route }}" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="flight_date">Flight Date</label>
                                <input type="date" class="form-control" name="flight_date" value="{{ $flight_date }}" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="etd">Expected Time of Departure (ETD)</label>
                                <input type="time" class="form-control" name="flight_etd"
                                    value="{{ $flight_etd ? date('H:i', strtotime($flight_etd)) : '' }}" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="eta">Expected Time of Arrival (ETA)</label>
                                <input type="time" class="form-control" name="flight_eta"
                                    value="{{ $flight_eta ? date('H:i', strtotime($flight_eta)) : '' }}" />
                            </div>
                            <div class="col-md-6 mt-3">
                                <label for="upload_ticket">Upload Ticket</label>
                                <input type="file" class="form-control" name="upload_ticket" accept=".pdf,image/*"
                                    onchange="previewUploadedFile(this, 'ticketPreview-{{ $HumanResource->id }}')" />
                                <div class="mt-2">
                                    <a id="ticketPreview-{{ $HumanResource->id }}" href="{{ $upload_ticket }}" target="_blank"
                                        class="btn btn-info {{ $upload_ticket ? '' : 'd-none' }}">
                                        View Uploaded Ticket
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Step 3: Amount Details (Previously Step 7) --}}
                <div class="form-section" data-step="3">
                    <form id="form-step-3" action="{{ route('submit.step', ['step' => 3]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @php
                            $step = optional($HumanResource->hrSteps->where('step_number', 7)->first());
                            $amountInDigits = $step->amount_digits ?? '15000';
                            $amountInWords = $step->amount_words ?? 'Fifteen Thousand Rupees Only';
                            $fileExists = $step->file_name ? asset($step->file_name) : null;
                        @endphp
                        <div class="row mb-3">
                            <div class="col-md-5 pr-0">
                                <label for="amountInDigits">Amount in digits</label>
                                <input type="hidden" name="human_resource_id" class="human_resource_id"
                                    value="{{ $HumanResource->id }}" />
                                <input type="text" class="form-control amountInDigits" id="amountInDigits"
                                    value="{{ $amountInDigits }}" name="amount_digits" />
                            </div>
                            <div class="col-md-6 pl-2 d-flex align-items-end">
                                <div style="flex: 1" class="mr-2">
                                    <label for="amountInWords">Amount in words</label>
                                    <input type="text" class="form-control amountInWords" id="amountInWords"
                                        value="{{ $amountInWords }}" readonly name="amount_words" />
                                </div>
                                <button id="" class="btn btn-primary generatePdfBtn"
                                    style="margin-bottom: 2px">Generate PDF</button>
                            </div>
                        </div>
                        <input type="text" id="stepThreeFile" class="stepThreeFile d-none" name="step_three_file"
                            value="{{ $fileExists ? $fileExists : '' }}">
                        <iframe class="pdfFrame" src="{{ $fileExists ? $fileExists : '' }}" width="100%"
                            height="{{ $fileExists ? '600px' : '0px' }}"></iframe>
                    </form>
                </div>

                {{-- Step 4: NBP Form (Previously Step 8) --}}
                <div class="form-section" data-step="4">
                    <form id="form-step-4" action="{{ route('submit.step', ['step' => 4]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @php
                            $step = optional($HumanResource->hrSteps->where('step_number', 8)->first());
                            $opfValue = $step->amount_digits ?? '4000';
                            $stateLifeValue = $step->amount_digits1 ?? '2500';
                            $fileExists = $step->file_name ? asset($step->file_name) : null;
                        @endphp
                        <div>
                            <div class="row mb-3">
                                <div class="col-md-5 pr-0">
                                    <label for="opf">OPF Welfare Fund</label>
                                    <input type="text" class="form-control" id="opf" name="opf"
                                        value="{{ $opfValue }}" />
                                </div>
                                <div class="col-md-5 pr-0">
                                    <label for="stateLife">State Life Insurance Premium</label>
                                    <input type="text" class="form-control" id="stateLife"
                                        value="{{ $stateLifeValue }}" name="state_life_insurance" />
                                </div>
                                <input type="hidden" class="human_resource_id" name="human_resource_id"
                                    value="{{ $HumanResource->id }}" />
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" id="generatePdfBtn4" class="btn btn-primary"
                                        style="margin-bottom: 2px">Generate PDF</button>
                                </div>
                            </div>
                        </div>
                        <input type="text" id="stepFourFile" class="stepFourFile d-none" name="step_four_file"
                            value="{{ $fileExists ? $fileExists : '' }}">
                        <iframe class="pdfFrame" src="{{ $fileExists ? $fileExists : '' }}" width="100%"
                            height="{{ $fileExists ? '600px' : '0px' }}"></iframe>
                    </form>
                </div>

                {{-- Step 5: Challan Form (Previously Step 9) --}}
                <div class="form-section" data-step="5">
                    <form id="form-step-5" action="{{ route('submit.step', ['step' => 5]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @php
                            $step = optional($HumanResource->hrSteps->where('step_number', 9)->first());
                            $fileExists = $step->file_name ? asset($step->file_name) : null;
                        @endphp
                        <div>
                            <input type="hidden" class="human_resource_id" name="human_resource_id"
                                value="{{ $HumanResource->id }}" />
                            <button id="generatePdfBtn5" class="btn btn-primary" style="margin-bottom: 2px">Generate
                                PDF</button>
                        </div>
                        <input type="text" id="stepFiveFile" class="stepFiveFile d-none" name="step_five_file"
                            value="{{ $fileExists ? $fileExists : '' }}">
                        <iframe class="pdfFrame" src="{{ $fileExists ? $fileExists : '' }}" width="100%"
                            height="{{ $fileExists ? '600px' : '0px' }}"></iframe>
                    </form>
                </div>

                {{-- Step 6: Life Insurance Form (Previously Step 10) --}}
                <div class="form-section" data-step="6">
                    <form id="form-step-6" action="{{ route('submit.step', ['step' => 6]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @php
                            $step = optional($HumanResource->hrSteps->where('step_number', 10)->first());
                            $fileExists = $step->file_name ? asset($step->file_name) : null;
                        @endphp
                        <input type="hidden" class="human_resource_id" name="human_resource_id"
                            value="{{ $HumanResource->id }}" />
                        <button id="generatePdfBtn6" class="btn btn-primary">Generate PDF</button>
                        <br /><br />
                        <input type="text" id="stepSixFile" class="stepSixFile d-none" name="step_six_file"
                            value="{{ $fileExists ? $fileExists : '' }}">
                        <iframe class="pdfFrame" src="{{ $fileExists ? $fileExists : '' }}" width="100%"
                            height="{{ $fileExists ? '600px' : '0px' }}"></iframe>
                    </form>
                </div>

                {{-- Step 7: FSA Form (Previously Step 11) --}}
                <div class="form-section" data-step="7">
                    <form id="form-step-7" action="{{ route('submit.step', ['step' => 7]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @php
                            $step = optional($HumanResource->hrSteps->where('step_number', 11)->first());
                            $fileExists = $step->file_name ? asset($step->file_name) : null;
                        @endphp
                        <input type="hidden" class="human_resource_id" name="human_resource_id"
                            value="{{ $HumanResource->id }}" />
                        <button id="generatePdfBtn7" class="btn btn-primary">Generate PDF</button>
                        <br /><br />
                        <input type="text" id="stepSevenFile" class="stepSevenFile d-none" name="step_seven_file"
                            value="{{ $fileExists ? $fileExists : '' }}">
                        <iframe class="pdfFrame" src="{{ $fileExists ? $fileExists : '' }}" width="100%"
                            height="{{ $fileExists ? '600px' : '0px' }}"></iframe>
                    </form>
                </div>

                {{-- Step 8: Final Step (Previously Step 10) --}}
                {{-- <div class="form-section" data-step="8">
                    <form id="form-step-8" action="{{ route('submit.step', ['step' => 8]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @php
                            $step = optional($HumanResource->hrSteps->where('step_number', 10)->first());
                            $fileExists = $step->file_name ? asset($step->file_name) : null;
                        @endphp
                        <input type="hidden" class="human_resource_id" name="human_resource_id"
                            value="{{ $HumanResource->id }}" />
                        <button id="generatePdfBtn8" class="btn btn-primary">Generate PDF</button>
                        <br /><br />
                        <input type="text" id="stepEightFile" class="stepEightFile d-none" name="step_eight_file"
                            value="{{ $fileExists ? $fileExists : '' }}">
                        <iframe class="pdfFrame" src="{{ $fileExists ? $fileExists : '' }}" width="100%"
                            height="{{ $fileExists ? '600px' : '0px' }}"></iframe>
                    </form>
                </div> --}}

                <div class="buttons d-flex justify-content-end">
                    <button id="prev" class="btn btn-success d-none">
                        Previous
                    </button>

                    <button id="nextStep" class="btn btn-success">Next</button>
                    <button id="next" class="btn btn-primary">Save & Next</button>

                    <button id="submit" class="btn btn-primary d-none">
                        Submit
                    </button>
                </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function numberToWords(num) {
        const a = [
            "",
            "One",
            "Two",
            "Three",
            "Four",
            "Five",
            "Six",
            "Seven",
            "Eight",
            "Nine",
            "Ten",
            "Eleven",
            "Twelve",
            "Thirteen",
            "Fourteen",
            "Fifteen",
            "Sixteen",
            "Seventeen",
            "Eighteen",
            "Nineteen",
        ];
        const b = [
            "",
            "",
            "Twenty",
            "Thirty",
            "Forty",
            "Fifty",
            "Sixty",
            "Seventy",
            "Eighty",
            "Ninety",
        ];
        const c = ["", "Thousand", "Million", "Billion"];

        if (num === 0) return "Zero";

        let words = "";

        function convertToWords(n, index) {
            if (n === 0) return "";
            let str = "";
            if (n > 99) {
                str += a[Math.floor(n / 100)] + " Hundred ";
                n %= 100;
            }
            if (n > 19) {
                str += b[Math.floor(n / 10)] + " ";
                n %= 10;
            }
            if (n > 0) {
                str += a[n] + " ";
            }
            return str + (index > 0 ? c[index] + " " : "");
        }

        let i = 0;
        while (num > 0) {
            const chunk = num % 1000;
            if (chunk > 0) {
                words = convertToWords(chunk, i) + words;
            }
            num = Math.floor(num / 1000);
            i++;
        }

        return words.trim() + " Only";
    }

    $(document).ready(function() {
        $(".amountInDigits").on("input", function() {
            const amount = parseInt($(this).val().replace(/,/g, ""), 10);
            const words = isNaN(amount) ? "" : numberToWords(amount);
            $(".amountInWords").val(words);
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(".modal").each(function() {
            let modal = $(this);
            let currentStep = 1;
            let maxSteps = 7;

            function updateSteps() {
                modal.find(".step, .line, .step-text").removeClass("active");

                modal.find(".step").each(function() {
                    let stepNum = $(this).data("step");

                    if (stepNum <= currentStep) {
                        $(this).addClass("active");
                        $(this).next(".step-text").addClass("active");
                    }
                });

                modal.find(".line").each(function(index) {
                    if (index < currentStep - 1) {
                        $(this).addClass("active");
                    }
                });

                modal.find(".form-section").removeClass("active");
                modal.find(`.form-section[data-step="${currentStep}"]`).addClass("active");

                modal.find("#prev").toggleClass("d-none", currentStep === 1);
                modal.find("#next").toggleClass("d-none", currentStep === maxSteps);
                if (currentStep === maxSteps) {
                    $("#nextStep").hide();
                } else {
                    $("#nextStep").show();
                }
                modal.find("#submit").toggleClass("d-none", currentStep !== maxSteps);
            }

            modal.on("show.bs.modal", function() {
                updateSteps();
            });

            modal.find("#nextStep").click(function(event) {
                event.preventDefault();
                if (currentStep < maxSteps) {
                    currentStep++;
                    updateSteps();
                }
            });

            modal.find("#prev").click(function() {
                if (currentStep > 1) {
                    currentStep--;
                    updateSteps();
                }
            });

            modal.find("#next,#submit").click(function(event) {
                event.preventDefault();

                let form = modal.find(`#form-step-${currentStep}`);
                let button = $(this); // Get the button
                let originalText = button.html(); // Store original button text

                // Show loading spinner and disable button
                button.prop("disabled", true).html(
                    '<i class="fa fa-spinner fa-spin"></i> Processing...');

                let formData = new FormData(form[0]);
                $.ajax({
                    url: form.attr("action"),
                    method: form.attr("method"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        toastr.success(`Step ${currentStep} saved successfully`);

                        if (currentStep < maxSteps) {
                            currentStep++;
                            updateSteps();
                        } else {
                            // Close the modal on the last step
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                            // modal.modal("hide");
                            // toastr.success("All steps completed successfully");
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error(`Error saving step ${currentStep}: ${error}`);
                    },
                    complete: function() {
                        // Restore button state after success/error
                        button.prop("disabled", false).html(originalText);
                        updateSteps();
                    }
                });
            });

            modal.find(".step-container").click(function() {
                let stepNum = $(this).find(".step").data("step");

                if (stepNum <= maxSteps) {
                    currentStep = stepNum;
                    updateSteps();
                }
            });

            updateSteps();
        });

        // Generate PDF and display in iframe
        $(".generatePdfBtn").click(function(e) {
            e.preventDefault()
            // Get the closest form section
            let formSection = $(this).closest('.form-section');

            // Get the required values
            let hr_id = formSection.find('.human_resource_id').val();
            let amount_digits = formSection.find('.amountInDigits').val();
            let amount_words = formSection.find('.amountInWords').val();

            console.log('amount_digits:', amount_digits, 'amount_words:', amount_words);

            // Make the AJAX request
            $.ajax({
                url: "{{ url('/generate-form-7') }}", // Update this URL if necessary
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "Content-Type": "application/json" // Ensure JSON format
                },
                data: JSON.stringify({
                    human_resource_id: hr_id,
                    amount_digits: amount_digits,
                    amount_words: amount_words,
                }),
                success: function(response) {
                    console.log('PDF URL:', response.pdf_url);

                    // Set the PDF URL in the input field
                    formSection.find('.stepSevenFile').val(response.url).trigger('change');

                    // Update the iframe to display the generated PDF
                    formSection.find('.pdfFrame').attr("src", response.pdf_url + "?t=" +
                        new Date().getTime());
                    formSection.find('.pdfFrame').attr("height", "600px");
                },
                error: function(xhr, status, error) {
                    console.error("Error generating PDF:", error);
                }
            });
        });

        // For step 4 PDF generation
        $(document).on('click', '#generatePdfBtn4', function(e) {
            e.preventDefault();
            // Get the closest form section
            let formSection = $(this).closest('.form-section');

            // Get the required values
            let hr_id = formSection.find('.human_resource_id').val(); // Human Resource ID
            let opfValue = parseInt(formSection.find('#opf').val()) || 0; // Default to 0 if empty
            let stateLifeValue = parseInt(formSection.find('#stateLife').val()) ||
                0; // Default to 0 if empty
            let totalAmount = opfValue + stateLifeValue + 200; // Add 200 to the total

            // Convert the total amount to words
            let totalAmountInWords = numberToWords(totalAmount);

            console.log('Human Resource ID:', hr_id);
            console.log('Total Amount:', totalAmount, 'In Words:', totalAmountInWords);

            $.ajax({
                url: "{{ url('/generate-nbp-form') }}", // Update this URL if necessary
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "Content-Type": "application/json" // Ensure JSON format
                },
                data: JSON.stringify({
                    human_resource_id: hr_id,
                    opf: opfValue,
                    state_life: stateLifeValue,
                    total_amount: totalAmount,
                    total_amount_words: totalAmountInWords,
                }),
                success: function(response) {
                    console.log('PDF URL:', response.pdf_url);

                    // Set the PDF URL in the input field
                    formSection.find('.stepFourFile').val(response.url).trigger('change');

                    // Update the iframe to display the generated PDF
                    formSection.find('.pdfFrame').attr("src", response.pdf_url + "?t=" +
                        new Date().getTime());
                    formSection.find('.pdfFrame').attr("height", "600px");
                },
                error: function(xhr, status, error) {
                    console.error("Error generating PDF:", error);
                }
            });
        });

        // For step 5 pdf
        $(document).on('click', '#generatePdfBtn5', function(e) {

            e.preventDefault(); // Prevent the default form submission behavior
            // Get the closest form section
            let formSection = $(this).closest('.form-section');
            // Get the required values
            let hr_id = formSection.find('.human_resource_id').val();
            console.log('Human Resource ID:', hr_id);
            // return;
            $.ajax({
                url: "{{ url('/generate-challan-92') }}",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "Content-Type": "application/json" // Ensure JSON format
                },
                data: JSON.stringify({
                    human_resource_id: hr_id,
                }),
                success: function(response) {
                    console.log('PDF URL:', response.pdf_url);

                    // Set the PDF URL in the input field
                    formSection.find('.stepFiveFile').val(response.url).trigger('change');

                    // Update the iframe to display the generated PDF
                    formSection.find('.pdfFrame').attr("src", response.pdf_url + "?t=" +
                        new Date().getTime());
                    formSection.find('.pdfFrame').attr("height", "600px");
                },
                error: function(xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        });

        // For step 6 pdf
        $(document).on('click', '#generatePdfBtn6', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior
            // Get the closest form section
            let formSection = $(this).closest('.form-section');
            // Get the required values
            let hr_id = formSection.find('.human_resource_id').val();
            console.log('Human Resource ID:', hr_id);
            $.ajax({
                url: "{{ url('/generate-life-insurance') }}",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "Content-Type": "application/json" // Ensure JSON format
                },
                data: JSON.stringify({
                    human_resource_id: hr_id,
                }),
                success: function(response) {
                    console.log('PDF URL:', response.pdf_url);
                    // Set the PDF URL in the input field
                    formSection.find('.stepSixFile').val(response.url).trigger('change');
                    // Update the iframe to display the generated PDF
                    formSection.find('.pdfFrame').attr("src", response.pdf_url + "?t=" +
                        new Date().getTime());
                    formSection.find('.pdfFrame').attr("height", "600px");
                },
                error: function(xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        });

        // For step 7 pdf
        $(document).on('click', '#generatePdfBtn7', function(e) {
            e.preventDefault(); // Prevent the default form submission behavior
            // Get the closest form section
            let formSection = $(this).closest('.form-section');
            // Get the required values
            let hr_id = formSection.find('.human_resource_id').val();
            console.log('Human Resource ID:', hr_id);
            $.ajax({
                url: "{{ url('/generate-fsa-form') }}",
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "Content-Type": "application/json" // Ensure JSON format
                },
                data: JSON.stringify({
                    human_resource_id: hr_id,
                }),
                success: function(response) {
                    console.log('PDF URL:', response.pdf_url);
                    // Set the PDF URL in the input field
                    formSection.find('.stepSevenFile').val(response.url).trigger('change');
                    // Update the iframe to display the generated PDF
                    formSection.find('.pdfFrame').attr("src", response.pdf_url + "?t=" +
                        new Date().getTime());
                    formSection.find('.pdfFrame').attr("height", "600px");
                },
                error: function(xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        });

        // For step 8 pdf
        // $(document).on('click', '#generatePdfBtn8', function(e) {
        //     e.preventDefault(); // Prevent default form submission behavior

        //     // Get the closest form section
        //     let formSection = $(this).closest('.form-section');

        //     // Get the required values
        //     let hr_id = formSection.find('.human_resource_id').val();

        //     console.log('Human Resource ID:', hr_id);

        //     // Make the AJAX request
        //     $.ajax({
        //         url: "{{ url('/generate-life-insurance') }}", // Update this URL if necessary
        //         method: "POST",
        //         headers: {
        //             "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        //             "Content-Type": "application/json" // Ensure JSON format
        //         },
        //         data: JSON.stringify({
        //             human_resource_id: hr_id,
        //         }),
        //         success: function(response) {
        //             if (response.success && response.pdf_url) {
        //                 console.log('PDF URL:', response.pdf_url);

        //                 // Set the PDF URL in the input field
        //                 formSection.find('.stepEightFile').val(response.pdf_url).trigger(
        //                     'change');

        //                 // Update the iframe to display the generated PDF
        //                 formSection.find('.pdfFrame').attr("src", response.pdf_url + "?t=" +
        //                     new Date().getTime());
        //                 formSection.find('.pdfFrame').attr("height", "600px");

        //                 toastr.success(response.message || "PDF generated successfully!");
        //             } else {
        //                 toastr.error(response.message || "Failed to generate PDF.");
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Error generating PDF:", error);
        //             toastr.error("An error occurred while generating the PDF.");
        //         }
        //     });
        // });
    });
</script>

<script>
    $(document).ready(function() {
        $(".modal").on("show.bs.modal", function() {
            let humanResourceId = $(this).attr("id").split('-')[1];
            let url = new URL(window.location.href);
            url.searchParams.set('human_resource_id', humanResourceId);
            window.history.pushState({}, '', url);
        });

        $(".modal").on("hidden.bs.modal", function() {
            let url = new URL(window.location.href);
            url.searchParams.delete('human_resource_id');
            window.history.pushState({}, '', url);
        });

        // ...existing code...
    });
</script>

<script>
function previewPDF(input, previewId) {
    const file = input.files[0];
    if (file && file.type === "application/pdf") {
        const reader = new FileReader();
        reader.onload = function (e) {
            const frame = document.getElementById(previewId);
            if (frame) {
                frame.src = e.target.result;
                frame.classList.remove('d-none'); // Make sure it becomes visible
                frame.style.height = "300px";
            }
        };
        reader.readAsDataURL(file);
    } else {
        alert("Please upload a valid PDF file.");
    }
}


    function previewFile(input) {
        const file = input.files[0];
        const modal = $(input).closest(".modal"); // Find the closest modal
        const pdfPreview = modal.find("iframe[id^='pdfPreview']");
        const imagePreview = modal.find("img[id^='imagePreview']");

        if (file) {
            const fileType = file.type;

            // Reset previews
            pdfPreview.addClass("d-none");
            imagePreview.addClass("d-none");

            if (fileType === "application/pdf") {
                // Preview PDF
                const fileURL = URL.createObjectURL(file);
                pdfPreview.attr("src", fileURL).removeClass("d-none");
            } else if (fileType.startsWith("image/")) {
                // Preview Image
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.attr("src", e.target.result).removeClass("d-none");
                };
                reader.readAsDataURL(file);
            } else {
                alert("Please upload a valid PDF or image file.");
            }
        }
    }

    function previewTicket(input) {
        const file = input.files[0];
        const pdfPreview = document.getElementById("ticketPdfPreview");
        const imagePreview = document.getElementById("ticketImagePreview");

        if (file) {
            const fileType = file.type;

            // Reset previews
            pdfPreview.classList.add("d-none");
            imagePreview.classList.add("d-none");

            if (fileType === "application/pdf") {
                // Preview PDF
                const fileURL = URL.createObjectURL(file);
                pdfPreview.src = fileURL;
                pdfPreview.classList.remove("d-none");
            } else if (fileType.startsWith("image/")) {
                // Preview Image
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.classList.remove("d-none");
                };
                reader.readAsDataURL(file);
            } else {
                alert("Please upload a valid PDF or image file.");
            }
        }
    }

    document
        .getElementById("step-8-print-btn")
        .addEventListener("click", function() {
            // Get slip content and styles

            const printContents =
                document.getElementById("step-8-slip").outerHTML;

            const styles = Array.from(
                    document.querySelectorAll('style, link[rel="stylesheet"]')
                )

                .map((el) => el.outerHTML)

                .join("\n");

            // Create a new print window

            const printWindow = window.open("", "_blank");

            // Write content into the new window

            printWindow.document.write(`

        <html>

            <head>

                <title>Print Slip</title>

                ${styles}

                <style>

                    body { margin: 20px; }

                    table { width: 100%; border-collapse: collapse; }

                    th, td { border: 1px solid black; padding: 8px; text-align: left; }

                    .no-print { display: none; } /* Hide buttons or unnecessary elements */

                </style>

            </head>

            <body>

                ${printContents}

            </body>

        </html>

    `);

            printWindow.document.close();

            printWindow.focus();

            // Delay print to ensure content loads properly

            setTimeout(() => {
                printWindow.print();

                printWindow.close();
            }, 500);
        });
</script>

<script>
    function downloadImage(button) {
        const imgElement = button.closest('.position-relative').querySelector('img');
        if (imgElement && imgElement.src) {
            const link = document.createElement('a');
            link.href = imgElement.src;
            link.download = 'downloaded-image.jpg'; // Default filename
            link.click();
        } else {
            alert('No image available to download.');
        }
    }

    // Attach the function to all download buttons
    document.querySelectorAll('.download-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            downloadImage(this);
        });
    });
</script>

<script>
    function previewImage(input, previewId) {
        const file = input.files[0];
        if (file && file.type.startsWith("image/")) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewElement = document.getElementById(previewId);
                if (previewElement) {
                    previewElement.src = e.target.result;
                    previewElement.classList.remove("d-none");
                }
            };
            reader.readAsDataURL(file);
        } else {
            alert("Please upload a valid image file.");
        }
    }

    function previewUploadedFile(input, previewId) {
        const file = input.files[0];
        const previewElement = document.getElementById(previewId);

        if (file) {
            const fileURL = URL.createObjectURL(file);
            previewElement.href = fileURL;
            previewElement.classList.remove("d-none");
        } else {
            previewElement.classList.add("d-none");
        }
    }

    function previewPDF1(input, iframeId) {
        const file = input.files[0];
        const iframe = document.getElementById(iframeId);

        if (file && file.type === "application/pdf") {
            const fileURL = URL.createObjectURL(file);
            iframe.src = fileURL;
            iframe.classList.remove("d-none");
        } else {
            iframe.src = "";
            iframe.classList.add("d-none");
            alert("Please upload a valid PDF file.");
        }
    }
</script>


