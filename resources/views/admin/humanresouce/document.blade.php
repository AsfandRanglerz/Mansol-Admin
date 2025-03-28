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
</style>

<link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
/>

{{-- Create Human Resource Model --}}

@foreach ($HumanResources as $HumanResource)

<div
    class="modal fade"
    id="createHRModal-{{ $HumanResource->id }}"
    tabindex="-1"
    role="dialog"
    aria-labelledby="createModalLabel-{{ $HumanResource->id }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content p-4">
            <div class="steps mb-5">
                @for ($i = 1; $i <= 11; $i++)
                <div
                    class="d-flex flex-column align-items-center position-relative step-container"
                >
                    <div
                        class="step {{ $i == 1 ? 'active' : '' }}"
                        data-step="{{ $i }}"
                    >
                        {{ $i }}
                    </div>

                    <p class="m-0 step-text {{ $i == 1 ? 'active' : '' }}">
                        Step {{ $i }}
                    </p>

                    <span
                        class="fa-solid fa-circle-check position-absolute top-0 tick-mark d-none"
                    ></span>
                </div>

                @if ($i < 11)
                <div class="line"></div>

                @endif @endfor
            </div>

            {{-- Step 1: Latest Resume --}}

            <div class="form-section active" data-step="1">
                <div style="gap: 10px" class="d-flex align-items-center">
                    <form
                        style="width: 40%"
                        id="form-step-1"
                        action="{{ route('submit.step', ['step' => 1]) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        target="uploadFrame"
                    >
                        @csrf

                        <input
                            type="hidden"
                            name="human_resource_id"
                            value="{{ $HumanResource->id }}"
                        />

                        <h5>Latest Resume</h5>

                        <div class="form-group">
                            <label>Upload CV (PDF only)</label>
                            @php
                                $step = optional($HumanResource->hrSteps->where('step_number', 1)->first());
                                $fileExists = $step->file_name ? asset($step->file_name) : null;
                            @endphp
                        
                          
                            <input
                                type="file"
                                class="form-control"
                                name="cv"
                                id="cvInput"
                                accept=".pdf"
                                @if($fileExists) value={{$step->file_name}} @endif
                                @if(!$fileExists) required @endif
                                onchange="previewPDF(this)"
                            />
                        </div>
                    </form>
                    <div style="width: 60%">
                          {{-- PDF Preview Iframe --}}
                            <iframe
                                class="border-0"
                                id="pdfFrame1"
                                src="{{ $fileExists ? $fileExists : '' }}"
                                width="100%"
                                height="{{ $fileExists ? '300px' : '0px' }}" {{-- Hide if no file --}}
                            ></iframe>
                    </div>
                </div>
            </div>

            {{-- Step 2: Passport Images --}}
            <div class="form-section" data-step="2">
                <form
                    id="form-step-2"
                    action="{{ route('submit.step', ['step' => 2]) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <h5>Valid Passport</h5>

                    <div class="row">
                        @php
                        $steps = $HumanResource->hrSteps->where('step_number', 2);
                        $passport_front = null;
                        $passport_back = null;
                    
                        foreach ($steps as $step) {
                            if (!empty($step->file_type) && strtolower($step->file_type) === 'passport front') {
                                $passport_front = asset($step->file_name);
                            } elseif (!empty($step->file_type) && strtolower($step->file_type) === 'passport back') {
                                $passport_back = asset($step->file_name);
                            }
                        }
                    @endphp
                    

                        {{-- Passport Image 1 --}}
                        <div class="col-md-6">
                            <label>Passport Image 1</label>
                            <input
                                type="file"
                                class="form-control"
                                name="passport_image_1"
                                accept="image/*"
                                onchange="previewImage(this, 'preview-passport-1')"
                                required
                            />

                            <img
                                id="preview-passport-1"
                                src="{{ $passport_front ?? 'default-placeholder.png' }}"
                                class="img-fluid mt-2 border rounded {{ $passport_front ? '' : 'd-none' }}"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;"
                            />
                        </div>

                        {{-- Passport Image 2 --}}
                        <div class="col-md-6">
                            <label>Passport Image 2</label>
                            <input
                                type="file"
                                class="form-control"
                                name="passport_image_2"
                                accept="image/*"
                                onchange="previewImage(this, 'preview-passport-2')"
                                required
                            />

                            <img
                                id="preview-passport-2"
                                src="{{ $passport_back ?? 'default-placeholder.png' }}"
                                class="img-fluid mt-2 border rounded {{ $passport_back ? '' : 'd-none' }}"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;"
                            />
                        </div>

                        <input type="hidden" name="human_resource_id" value="{{ $HumanResource->id }}" />
                    </div>
                </form>
            </div>


             {{-- Step 3: CNIC --}}
            <div class="form-section" data-step="3">
                <form
                    id="form-step-3"
                    action="{{ route('submit.step', ['step' => 3]) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <h5>CNIC</h5>

                    <div class="row">
                        @php
                            $steps = $HumanResource->hrSteps->where('step_number', 3);
                            $cnic_front = null;
                            $cnic_back = null;

                            foreach ($steps as $step) {
                                if (!empty($step->file_type) && strtolower($step->file_type) === 'cnic front') {
                                    $cnic_front = asset($step->file_name);
                                } elseif (!empty($step->file_type) && strtolower($step->file_type) === 'cnic back') {
                                    $cnic_back = asset($step->file_name);
                                }
                            }
                        @endphp

                        {{-- CNIC Front --}}
                        <div class="col-md-6">
                            <label>CNIC Front</label>
                            <input
                                type="file"
                                class="form-control"
                                name="cnic_front"
                                accept="image/*"
                                onchange="previewImage(this, 'preview-cnic-front')"
                                required
                            />

                            <img
                                id="preview-cnic-front"
                                src="{{ $cnic_front ?? 'default-placeholder.png' }}"
                                class="img-fluid mt-2 border rounded {{ $cnic_front ? '' : 'd-none' }}"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;"
                            />
                        </div>

                        {{-- CNIC Back --}}
                        <div class="col-md-6">
                            <label>CNIC Back</label>
                            <input
                                type="file"
                                class="form-control"
                                name="cnic_back"
                                accept="image/*"
                                onchange="previewImage(this, 'preview-cnic-back')"
                                required
                            />

                            <img
                                id="preview-cnic-back"
                                src="{{ $cnic_back ?? 'default-placeholder.png' }}"
                                class="img-fluid mt-2 border rounded {{ $cnic_back ? '' : 'd-none' }}"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;"
                            />
                        </div>

                        <input type="hidden" name="human_resource_id" value="{{ $HumanResource->id }}" />
                    </div>
                </form>
            </div>


{{-- Step 4: Passport-size Photo --}}
<div class="form-section" data-step="4">
    <form
        id="form-step-4"
        action="{{ route('submit.step', ['step' => 4]) }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @php
            $step = optional($HumanResource->hrSteps->where('step_number', 4)->first());
            $fileExists = $step->file_name ? asset($step->file_name) : null;
        @endphp

        <h5>Passport-size Photograph</h5>

        <div class="form-group">
            <label>Upload Photo</label>

            <input
                type="file"
                class="form-control"
                name="photo"
                accept="image/*"
                onchange="previewImage(this, 'preview-photo')"
                required
            />

            <img
                id="preview-photo"
                class="img-fluid mt-2 border rounded"
                src="{{ $fileExists ?: asset('default-placeholder.png') }}"
                style="width: 3.5cm; height: 4.5cm; object-fit: cover;"
            />
            
            <input
                type="hidden"
                name="human_resource_id"
                value="{{ $HumanResource->id }}"
            />
        </div>
    </form>
</div>


            {{-- Step 5: NOK CNIC --}}
            <div class="form-section" data-step="5">
                <form
                    id="form-step-5"
                    action="{{ route('submit.step', ['step' => 5]) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    <h5>Next of Kin (NOK) CNIC</h5>

                    <div class="row">
                        @php
                            $steps = $HumanResource->hrSteps->where('step_number', 5);
                            $nok_cnic_front = null;
                            $nok_cnic_back = null;

                            foreach ($steps as $step) {
                                if (!empty($step->file_type) && strtolower($step->file_type) === 'nok cnic front') {
                                    $nok_cnic_front = asset($step->file_name);
                                } elseif (!empty($step->file_type) && strtolower($step->file_type) === 'nok cnic back') {
                                    $nok_cnic_back = asset($step->file_name);
                                }
                            }
                        @endphp

                        {{-- NOK CNIC Front --}}
                        <div class="col-md-6">
                            <label>NOK CNIC Front</label>

                            <input
                                type="file"
                                class="form-control"
                                name="nok_cnic_front"
                                accept="image/*"
                                onchange="previewImage(this, 'preview-nok-front')"
                                required
                            />

                            <img
                                id="preview-nok-front"
                                src="{{ $nok_cnic_front ?? 'default-placeholder.png' }}"
                                class="img-fluid mt-2 border rounded {{ $nok_cnic_front ? '' : 'd-none' }}"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;"
                            />
                        </div>

                        {{-- NOK CNIC Back --}}
                        <div class="col-md-6">
                            <label>NOK CNIC Back</label>

                            <input
                                type="file"
                                class="form-control"
                                name="nok_cnic_back"
                                accept="image/*"
                                onchange="previewImage(this, 'preview-nok-back')"
                                required
                            />

                            <img
                                id="preview-nok-back"
                                src="{{ $nok_cnic_back ?? 'default-placeholder.png' }}"
                                class="img-fluid mt-2 border rounded {{ $nok_cnic_back ? '' : 'd-none' }}"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;"
                            />
                        </div>

                        <input type="hidden" name="human_resource_id" value="{{ $HumanResource->id }}" />
                    </div>
                </form>
            </div>


            {{-- Step 6: Medical Report --}}
            <div class="form-section" data-step="6">
                <form
                    id="form-step-6"
                    action="{{ route('submit.step', ['step' => 6]) }}"
                    method="POST"
                    enctype="multipart/form-data"
                    >
                    @csrf

                    @php
                        $step = optional($HumanResource->hrSteps->where('step_number', 6)->first());
                        $medical_report = $step->file_name ? asset($step->file_name) : null;
                        $process_status = $step->process_status ?? '';
                        $medically_fit = $step->medically_fit ?? '';
                        $report_date = $step->report_date ?? '';
                        $valid_until = $step->valid_until ?? '';
                        $lab = $step->lab ?? '';
                        $any_comments = $step->any_comments ?? '';
                        $original_report_received = $step->original_report_received ?? false;
                    @endphp

                    <h5>Medical Report</h5>

                    <div class="row">
                        {{-- Process Status --}}
                        <div class="col-md-6">
                            <label>Process Status</label>
                            <select name="process_status" class="form-control" required>
                                <option value="" disabled {{ !$process_status ? 'selected' : '' }}>Select an Option</option>
                                <option value="Yet to appear" {{ $process_status == 'Yet to appear' ? 'selected' : '' }}>Yet to appear</option>
                                <option value="Appeared" {{ $process_status == 'Appeared' ? 'selected' : '' }}>Appeared</option>
                                <option value="Waiting" {{ $process_status == 'Waiting' ? 'selected' : '' }}>Waiting</option>
                                <option value="Result Available" {{ $process_status == 'Result Available' ? 'selected' : '' }}>Result Available</option>
                            </select>
                        </div>

                        {{-- Medically Fit --}}
                        <div class="col-md-6">
                            <label>Medically Fit</label>
                            <select name="medically_fit" class="form-control" required>
                                <option value="" disabled {{ !$medically_fit ? 'selected' : '' }}>Select an Option</option>
                                <option value="Repeat" {{ $medically_fit == 'Repeat' ? 'selected' : '' }}>Repeat</option>
                                <option value="Fit" {{ $medically_fit == 'Fit' ? 'selected' : '' }}>Fit</option>
                                <option value="Unfit" {{ $medically_fit == 'Unfit' ? 'selected' : '' }}>Unfit</option>
                            </select>
                        </div>

                        {{-- Report Date --}}
                        <div class="col-md-6 mt-3">
                            <label>Report Date</label>
                            <input type="date" class="form-control" name="report_date" value="{{ $report_date }}" />
                        </div>

                        {{-- Valid Until --}}
                        <div class="col-md-6 mt-3">
                            <label>Valid Until</label>
                            <input type="date" class="form-control" name="valid_until" value="{{ $valid_until }}" />
                        </div>

                        {{-- Lab Selection --}}
                        <div class="col-md-6 mt-3">
                            <label>Lab</label>
                            <select name="lab" class="form-control" required>
                                <option value="" disabled {{ !$lab ? 'selected' : '' }}>Select an Option</option>
                                <option value="Lab 1" {{ $lab == 'Lab 1' ? 'selected' : '' }}>Lab 1</option>
                                <option value="Lab 2" {{ $lab == 'Lab 2' ? 'selected' : '' }}>Lab 2</option>
                                <option value="Lab 3" {{ $lab == 'Lab 3' ? 'selected' : '' }}>Lab 3</option>
                            </select>
                        </div>

                        {{-- Comments --}}
                        <div class="col-md-6 mt-3">
                            <label>Any Comments on Medical Report</label>
                            <input type="text" class="form-control" name="any_comments" value="{{ $any_comments }}" />
                            {{-- Original Report Received --}}
                            <div class="d-flex align-items-center">
                                <label class="mb-0" for="recieved">Original Report Received?</label> &nbsp; &nbsp;
                                <input type="checkbox" id="recieved" name="original_report_received" {{ $original_report_received == 'yes' ? 'checked' : '' }} />
                            </div>
                        </div>

                        {{-- Upload Medical Report --}}
                        <div class="col-md-6">
                            <label>Upload Medical Report</label>
                            <input type="file" class="form-control" name="medical_report" accept=".pdf,image/*" />
                        </div>

                        <div class="col-md-6 mt-3 d-flex align-items-center">
                             @if ($medical_report)
                                <a href="{{ $medical_report }}" target="_blank" class="btn btn-info mt-2">View Recent Uploaded Report</a>
                            @endif
                        </div>

                        {{-- Hidden Input for Human Resource ID --}}
                        <input type="hidden" name="human_resource_id" value="{{ $HumanResource->id }}" />
                    </div>
                </form>
            </div>


            {{-- Step 7: Medical Report --}}

            <div class="form-section" data-step="7">
                <form
                id="form-step-7"
                action="{{ route('submit.step', ['step' => 7]) }}"
                method="POST"
                enctype="multipart/form-data"
                >
                @csrf
                <div>
                    @php
                                $step = optional($HumanResource->hrSteps->where('step_number', 7)->first());
                                $fileExists = $step->file_name ? asset($step->file_name) : null;
                                $fileExist = $step->file_name ? $step->file_name : null;
                            @endphp
                    <div class="row mb-3">
                        <div class="col-md-5 pr-0">
                            <label for="amountInDigits"
                                >Amount in digits</label
                            >
                            <input
                            type="hidden"
                            name="human_resource_id"
                            class="human_resource_id"
                            value="{{ $HumanResource->id }}"
                            />

                            <input
                                type="text"
                                class="form-control amountInDigits"
                                id="amountInDigits"
                                value="15000"
                                name="amount_digits"
                            />
                        </div>

                        <div class="col-md-6 pl-2 d-flex align-items-end">
                            <div style="flex: 1" class="mr-2">
                                <label for="amountInWords"
                                    >Amount in words</label
                                >
                                <input
                                    type="text"
                                    class="form-control amountInWords"
                                    id="amountInWords"
                                    value="Fifteen Thousand Rupees Only"
                                    readonly
                                    name="amount_words"

                                />
                            </div>
                            <button
                                id=""
                                class="btn btn-primary generatePdfBtn"
                                style="margin-bottom: 2px"
                            >
                                Generate PDF
                            </button>
                        </div>
                    </div>
                </div>
                <input type="text" id="stepSevenFile" class="stepSevenFile d-none" name="step_seven_file" value="{{ $fileExist ? $fileExist : '' }}">

                <iframe class="pdfFrame"   src="{{ $fileExists ? $fileExists : '' }}" width="100%" height="{{ $fileExists ? '600px' : '0px' }}"></iframe>

          

                </form>
            </div>

            {{-- Step 8: NBP form --}}

            <div class="form-section" data-step="8">
                <div>
                    <div class="row mb-3">
                        <div class="col-md-5 pr-0">
                            <label for="opf">OPF Welfare Fund</label>

                            <input
                                type="text"
                                class="form-control"
                                id="opf"
                                value="4000"
                            />
                        </div>

                        <div class="col-md-6 pl-2 d-flex align-items-end">
                            <div style="flex: 1" class="mr-2">
                                <label for="stateLife"
                                    >State Life Insurance Premium</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="stateLife"
                                    value="2500"
                                />
                            </div>
                            <button
                                id="generatePdfBtn8"
                                class="btn btn-primary"
                                style="margin-bottom: 2px"
                            >
                                Generate PDF
                            </button>
                        </div>
                    </div>
                </div>

                <iframe id="pdfFrame8" src="" width="100%" height="0"></iframe>
            </div>

            {{-- Step 9 --}}

            <div class="form-section" data-step="9">
                <div>
                    <button
                        id="generatePdfBtn9"
                        class="btn btn-primary"
                        style="margin-bottom: 2px"
                    >
                        Generate PDF
                    </button>
                </div>

                <iframe id="pdfFrame9" src="" width="100%" height="0"></iframe>
            </div>

            {{-- Step 10 --}}

            <div class="form-section" data-step="10">
                <button id="generatePdfBtn10" class="btn btn-primary">
                    Generate PDF
                </button>

                <br /><br />

                <iframe id="pdfFrame10" src="" width="100%" height="0"></iframe>
            </div>

            {{-- Step 11 --}}

            <div class="form-section" data-step="11">
                <button id="generatePdfBtn11" class="btn btn-primary">
                    Generate PDF
                </button>

                <br /><br />

                <iframe id="pdfFrame11" src="" width="100%" height="0"></iframe>
            </div>

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
        </div>
    </div>
</div>

@endforeach

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

    $(document).ready(function () {
      $(".amountInDigits").on("input", function () {
        const amount = parseInt($(this).val().replace(/,/g, ""), 10);
        const words = isNaN(amount) ? "" : numberToWords(amount);
        $(".amountInWords").val(words);
      });
    });
  </script>
<script>
    $(document).ready(function () {
        $(".modal").each(function () {
            let modal = $(this);
            let currentStep = 1;
            let maxSteps = 11;
            let isChanged = false; // Flag to track changes

            // Track changes in form fields
            modal.find("input, select, textarea").on("change input", function () {
                isChanged = true; // Set the flag to true when a field changes
            });

            function updateSteps() {
                modal.find(".step, .line, .step-text").removeClass("active");

                modal.find(".step").each(function () {
                    let stepNum = $(this).data("step");

                    if (stepNum <= currentStep) {
                        $(this).addClass("active");
                        $(this).next(".step-text").addClass("active");
                    }
                });

                modal.find(".line").each(function (index) {
                    if (index < currentStep - 1) {
                        $(this).addClass("active");
                    }
                });

                modal.find(".form-section").removeClass("active");
                modal.find(`.form-section[data-step="${currentStep}"]`).addClass("active");

                modal.find("#prev").toggleClass("d-none", currentStep === 1);
                modal.find("#next").toggleClass("d-none", currentStep === maxSteps);
                modal.find("#submit").toggleClass("d-none", currentStep !== maxSteps);

                checkStepCompletion();
            }

            function checkStepCompletion() {
                let currentSection = modal.find(`.form-section[data-step="${currentStep}"]`);
                let allFieldsFilled = true;

                // Check all inputs except file and hidden inputs
                currentSection.find("input:not([type='file']):not([type='hidden']), select, textarea").each(function () {
                    if (!$(this).val()) {
                        allFieldsFilled = false;
                        return false; // Break loop
                    }
                });

                // Check iframes or images for file-related fields
                currentSection.find("iframe, img").each(function () {
                    if ($(this).is("iframe") && (!$(this).attr("src") || $(this).attr("src") === "")) {
                        allFieldsFilled = false;
                        return false; // Break loop
                    }
                    if ($(this).is("img") && $(this).hasClass("d-none")) {
                        allFieldsFilled = false;
                        return false; // Break loop
                    }
                });

                // Update the text of the #next button based on allFieldsFilled
                modal.find("#next").text(allFieldsFilled ? "Update & Next" : "Save & Next");

                // Show or hide the "Next Step" button
                modal.find("#nextStep").toggleClass("d-none", !allFieldsFilled);
            }

            function findFirstIncompleteStep() {
                for (let step = 1; step <= maxSteps; step++) {
                    currentStep = step;
                    let currentSection = modal.find(`.form-section[data-step="${step}"]`);
                    let allFieldsFilled = true;

                    // Check all inputs except file and hidden inputs
                    currentSection.find("input:not([type='file']):not([type='hidden']), select, textarea").each(function () {
                        if (!$(this).val()) {
                            allFieldsFilled = false;
                            return false; // Break loop
                        }
                    });

                    // Check iframes or images for file-related fields
                    currentSection.find("iframe, img").each(function () {
                        if ($(this).is("iframe") && (!$(this).attr("src") || $(this).attr("src") === "")) {
                            allFieldsFilled = false;
                            return false; // Break loop
                        }
                        if ($(this).is("img") && $(this).hasClass("d-none")) {
                            allFieldsFilled = false;
                            return false; // Break loop
                        }
                    });

                    if (!allFieldsFilled) {
                        return step; // Return the first incomplete step
                    }
                }
                return maxSteps; // If all steps are complete, return the last step
            }

            modal.on("show.bs.modal", function () {
                currentStep = findFirstIncompleteStep();
                updateSteps();
            });

            modal.find("#nextStep").click(function (event) {
                event.preventDefault();
                if (currentStep < maxSteps) {
                    currentStep++;
                    updateSteps();
                }
            });

            modal.find("#prev").click(function () {
                if (currentStep > 1) {
                    currentStep--;
                    updateSteps();
                }
            });

            modal.find("#next").click(function (event) {
                event.preventDefault();
                let currentSection = modal.find(`.form-section[data-step="${currentStep}"]`);

                // Check if any changes were made
                if (!isChanged) {
                    toastr.warning("Nothing has changed.");
                    return; // Prevent submission if no changes
                }

                let allFieldsFilled = true;

                // Check all inputs except file and hidden inputs
                currentSection.find("input:not([type='file']):not([type='hidden']), select, textarea").each(function () {
                    if (!$(this).val()) {
                        allFieldsFilled = false;
                        return false; // Break loop
                    }
                });

                // Check iframes or images for file-related fields
                currentSection.find("iframe, img").each(function () {
                    if ($(this).is("iframe") && (!$(this).attr("src") || $(this).attr("src") === "")) {
                        allFieldsFilled = false;
                        return false; // Break loop
                    }
                    if ($(this).is("img") && $(this).hasClass("d-none")) {
                        allFieldsFilled = false;
                        return false; // Break loop
                    }
                });

                if (!allFieldsFilled) {
                    toastr.error("Please complete all required fields before proceeding.");
                    return;
                }

                let form = modal.find(`#form-step-${currentStep}`);
                let button = $(this); // Get the button
                let originalText = button.html(); // Store original button text

                // Show loading spinner and disable button
                button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Processing...');

                let formData = new FormData(form[0]);

                $.ajax({
                    url: form.attr("action"),
                    method: form.attr("method"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        toastr.success(`Step ${currentStep} saved successfully.`);
                        if (currentStep < maxSteps) {
                            currentStep++;
                            updateSteps();
                        }
                        isChanged = false; // Reset the flag after successful submission
                    },
                    error: function (xhr, status, error) {
                        toastr.error(`Error saving step ${currentStep}: ${error}`);
                    },
                    complete: function () {
                        // Restore button state after success/error
                        button.prop("disabled", false).html(originalText);

                        updateSteps();
                    }
                });
            });

            modal.find("input[type='file']").change(function (event) {
                let fileInput = $(this);
                let file = event.target.files[0];

                if (file) {
                    let reader = new FileReader();

                    reader.onload = function (e) {
                        fileInput.siblings("img").attr("src", e.target.result).removeClass("d-none");
                    };

                    reader.readAsDataURL(file);
                }
            });

            modal.find(".step-container").click(function () {
                let stepNum = $(this).find(".step").data("step");

                if (stepNum <= currentStep) {
                    currentStep = stepNum;
                    updateSteps();
                }
            });

            updateSteps();
        });

        // Generate PDF and display in iframe
        $(".generatePdfBtn").click(function (e) {
            e.preventDefault();

            // Get the closest form section
            let formSection = $(this).closest('.form-section');

            // Get the required values
            let hr_id = formSection.find('.human_resource_id').val();
            let amount_digits = formSection.find('.amountInDigits').val();
            let amount_words = formSection.find('.amountInWords').val();

            console.log('amount_digits:', amount_digits, 'amount_words:', amount_words);

            // Add a loader to the button
            let button = $(this);
            let originalText = button.html(); // Store the original button text
            button.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Generating...');

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
                success: function (response) {
                    console.log('PDF URL:', response.pdf_url);

                    // Set the PDF URL in the input field
                    formSection.find('.stepSevenFile').val(response.pdf_url).trigger('change');

                    // Update the iframe to display the generated PDF
                    formSection.find('.pdfFrame').attr("src", response.pdf_url + "?t=" + new Date().getTime());
                    formSection.find('.pdfFrame').attr("height", "600px");
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                    toastr.error("Failed to generate PDF. Please try again.");
                },
                complete: function () {
                    // Restore the button state
                    button.prop("disabled", false).html(originalText);
                }
            });
        });

        // For step 8 pdf
        $("#generatePdfBtn8").click(function () {
            $.ajax({
                url: "{{ asset('/generate-nbp-form') }}",
                method: "GET",
                success: function (response) {
                    $("#pdfFrame8").attr("src", "{{ asset('public/admin/assets/nbp-form.pdf') }}");
                    $("#pdfFrame8").attr("height", "600px");
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        });

        // For step 9 pdf
        $("#generatePdfBtn9").click(function () {
            $.ajax({
                url: "{{ asset('/generate-challan-92') }}",
                method: "GET",
                success: function (response) {
                    $("#pdfFrame9").attr("src", "{{ asset('public/admin/assets/Challan-92.pdf') }}");
                    $("#pdfFrame9").attr("height", "600px");
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        });

        // For step 10 pdf
        $("#generatePdfBtn10").click(function () {
            $.ajax({
                url: "{{ asset('/generate-life-insurance') }}",
                method: "GET",
                success: function (response) {
                    $("#pdfFrame10").attr("src", "{{ asset('public/admin/assets/life-insurance.pdf') }}");
                    $("#pdfFrame10").attr("height", "600px");
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        });

        // For step 11 pdf
        $("#generatePdfBtn11").click(function () {
            $.ajax({
                url: "{{ asset('/generate-fsa-form') }}",
                method: "GET",
                success: function (response) {
                    $("#pdfFrame11").attr("src", "{{ asset('public/admin/assets/fsa-form.pdf') }}");
                    $("#pdfFrame11").attr("height", "600px");
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
        $(".modal").on("show.bs.modal", function () {
            let humanResourceId = $(this).attr("id").split('-')[1];
            let url = new URL(window.location.href);
            url.searchParams.set('human_resource_id', humanResourceId);
            window.history.pushState({}, '', url);
        });

        $(".modal").on("hidden.bs.modal", function () {
            let url = new URL(window.location.href);
            url.searchParams.delete('human_resource_id');
            window.history.pushState({}, '', url);
        });

        // ...existing code...
    });
</script>

<script>
    function previewPDF(input) {
        const file = input.files[0];
        if (file && file.type === "application/pdf") {
            const reader = new FileReader();
            reader.onload = function (e) {
                // Find the closest modal container
                const modal = input.closest(".modal-content");
                if (modal) {
                    // Find the associated iframe inside the same modal
                    const frame = modal.querySelector("iframe");
                    if (frame) {
                        frame.src = e.target.result;
                        frame.style.height = "300px"; // Make it visible
                    }
                }
            };
            reader.readAsDataURL(file);
        } else {
            alert("Please upload a valid PDF file.");
        }
    }


    document
        .getElementById("step-8-print-btn")
        .addEventListener("click", function () {
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
