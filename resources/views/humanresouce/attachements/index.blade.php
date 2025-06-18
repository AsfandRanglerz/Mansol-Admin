@extends('humanresouce.layout.app')
@section('title', 'Human Resource')
@section('content')
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
<div class="main-content" style="min-height: 562px;">
    <section class="section">
        <div class="section-body">
            {{-- Step 1: Combined Form --}}
               <div class="container">

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
                                onchange="previewPDF(this, 'cvPreview')" />
                            <iframe id="cvPreview" class="border-0 mt-2 {{ $cv ? '' : 'd-none' }}"
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
                                    onchange="previewImage(this, 'passportFrontPreview')" />
                                <div class="position-relative">
                                    <img id="passportFrontPreview"
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
                                    onchange="previewImage(this, 'passportBackPreview')" />
                                <div class="position-relative"><img id="passportBackPreview"
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
                                    onchange="previewImage(this, 'passportPreviewThree')" />
                                <div class="position-relative"><img id="passportPreviewThree"
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
                                    onchange="previewImage(this, 'cnicFrontPreview')" />
                                <div class="position-relative">
                                    <img id="cnicFrontPreview"
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
                                    onchange="previewImage(this, 'cnicBackPreview')" />
                                <div class="position-relative">
                                    <img id="cnicBackPreview"
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
                                    onchange="previewImage(this, 'photoPreview')" />
                                <div class="position-relative">
                                    <img id="photoPreview"
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
                                    onchange="previewImage(this, 'policeCertificate')" />
                                <div class="position-relative">
                                    <img id="policeCertificate"
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
                                    onchange="previewImage(this, 'accountDetail')" />
                                <div class="position-relative">
                                    <img id="accountDetail"
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
                                    onchange="previewImage(this, 'updatedAppraisal')" />
                                <div class="position-relative">
                                    <img id="updatedAppraisal"
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
                                    onchange="previewImage(this, 'nokCnicFrontPreview')" />
                                <div class="position-relative">
                                    <img id="nokCnicFrontPreview"
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
                                    onchange="previewImage(this, 'nokCnicBackPreview')" />
                                <div class="position-relative">
                                    <button class="btn btn-primary position-absolute download-btn">
                                        <span class="fa-solid fa-download"></span>
                                    </button>
                                    <img id="nokCnicBackPreview"
                                        class="img-fluid mt-2 border rounded {{ $nokCnicBack ? '' : 'd-none' }}"
                                        src="{{ $nokCnicBack ? asset($nokCnicBack) : '' }}"
                                        style="width: 100%; height: 5.5cm; object-fit: contain;" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                @php
                                    $step = optional($HumanResource->hrSteps->where('step_number', 6)->first());
                                    // {{$step}}
                                    $medical_report = $step->file_name ? asset($step->file_name) : null;
                                @endphp
                                <div class="col-md-6 mt-3">
                                    <label>Medical Report</label>
                                    <div class="mt-2">
                                        <a id="medicalReportPreview" href="{{ $medical_report }}" target="_blank"
                                            class="btn btn-info {{ $medical_report ? '' : 'd-none' }}">
                                            View Uploaded Report
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                   @php
                            $visaStep = optional($HumanResource->hrSteps->where('step_number', 6)->first());
                            $scanned_visa = $visaStep->scanned_visa ? asset($visaStep->scanned_visa) : null;
                        @endphp
                                <label for="scanned_visa">Scanned Visa</label>
                                <div class="mt-2">
                                    @if ($scanned_visa)
                                        <a id="visaPreview" href="{{ $scanned_visa }}" target="_blank"
                                            class="btn btn-info {{ $scanned_visa ? '' : 'd-none' }}">
                                            View Uploaded Visa
                                        </a>
                                    @else
                                        <span class="text-danger">No Data Exist</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
               </div>

        </div>
    </section>
</div>
<script>
     document.querySelectorAll('.download-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            downloadImage(this);
        });
    });
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
</script>

@endsection

@section('js')