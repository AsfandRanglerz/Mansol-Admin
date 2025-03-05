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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

{{-- Create Human Resource Model --}}
@foreach ($HumanResources as $HumanResource)
<div class="modal fade" id="createHRModal-{{ $HumanResource->id }}" tabindex="-1" role="dialog"
    aria-labelledby="createModalLabel-{{ $HumanResource->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content p-4">
            <div class="steps mb-5">
                @for ($i = 1; $i <= 15; $i++) 
                <div class="d-flex flex-column align-items-center position-relative">
                    <div class="step {{ $i == 1 ? 'active' : '' }}" data-step="{{ $i }}">{{ $i }}</div>
                    <p class="m-0 step-text {{ $i == 1 ? 'active' : '' }}">Step {{ $i }}</p>
                    <span class="fa-solid fa-circle-check position-absolute top-0 tick-mark d-none"></span>
                </div>
                @if ($i < 15) 
                <div class="line"></div>
                @endif
                @endfor
            </div>

            {{-- Step 1: Latest Resume --}}
            <div class="form-section active" data-step="1">
                <form id="form-step-1" action="{{ route('submit.step', ['step' => 1]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="human_resource_id" value="{{ $HumanResource->id }}">

                    <h5>Latest Resume</h5>
                    <div class="form-group">
                        <label>Upload CV (PDF only)</label>
                        <input type="file" class="form-control" name="cv" accept=".pdf" required>
                    </div>
                </form>
            </div>

            {{-- Step 2: Passport Images --}}
            <div class="form-section" data-step="2">
                <form id="form-step-2" action="{{ route('submit.step', ['step' => 2]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <h5>Valid Passport</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Passport Image 1</label>
                            <input type="file" class="form-control" name="passport_image_1" accept="image/*"
                                onchange="previewImage(this, 'preview-passport-1')" required>
                            <img id="preview-passport-1" src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <label>Passport Image 2</label>
                            <input type="file" class="form-control" name="passport_image_2" accept="image/*"
                                onchange="previewImage(this, 'preview-passport-2')" required>
                            <img id="preview-passport-2" src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                    </div>
                </form>
            </div>

            {{-- Step 3: CNIC --}}
            <div class="form-section" data-step="3">
                <form id="form-step-3" action="{{ route('submit.step', ['step' => 3]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <h5>CNIC</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>CNIC Front</label>
                            <input type="file" class="form-control" name="cnic_front" accept="image/*"
                                onchange="previewImage(this, 'preview-cnic-front')" required>
                            <img id="preview-cnic-front" src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <label>CNIC Back</label>
                            <input type="file" class="form-control" name="cnic_back" accept="image/*"
                                onchange="previewImage(this, 'preview-cnic-back')" required>
                            <img id="preview-cnic-back" src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                    </div>
                </form>
            </div>

            {{-- Step 4: Passport-size Photo --}}
            <div class="form-section" data-step="4">
                <form id="form-step-4" action="{{ route('submit.step', ['step' => 4]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <h5>Passport-size Photograph</h5>
                    <div class="form-group">
                        <label>Upload Photo</label>
                        <input type="file" class="form-control" name="photo" accept="image/*"
                            onchange="previewImage(this, 'preview-photo')" required>
                        <img id="preview-photo" src="default-placeholder.png" class="img-fluid mt-2 d-none border rounded"
                            style="width: 3.5cm; height: 4.5cm; object-fit: cover;">

                    </div>
                </form>
            </div>

            {{-- Step 5: NOK CNIC --}}
            <div class="form-section" data-step="5">
                <form id="form-step-5" action="{{ route('submit.step', ['step' => 5]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <h5>Next of Kin (NOK) CNIC</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>NOK CNIC Front</label>
                            <input type="file" class="form-control" name="nok_cnic_front" accept="image/*"
                                onchange="previewImage(this, 'preview-nok-front')" required>
                            <img id="preview-nok-front" src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <label>NOK CNIC Back</label>
                            <input type="file" class="form-control" name="nok_cnic_back" accept="image/*"
                                onchange="previewImage(this, 'preview-nok-back')" required>
                            <img id="preview-nok-back" src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                    </div>
                </form>
            </div>

            {{-- Step 6: Medical Report --}}
            <div class="form-section" data-step="6">
                <form id="form-step-6" action="{{ route('submit.step', ['step' => 6]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <h5>Medical Report</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Process Status</label>
                            <select name="" id="" class="form-control" required>
                                <option value="" selected disabled>Select an Option</option>
                                <option value="">Yet to appear
                                </option>
                                <option value="">Appeared</option>
                                <option value="">Waiting</option>
                                <option value="">Result Available</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Medically Fit</label>
                            <select name="" id="" class="form-control" required>
                                <option value="" selected disabled>Select an Option</option>
                                <option value="">Repeat</option>
                                <option value="">Fit</option>
                                <option value="">Unfit</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Report Date</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Valid Until</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Lab</label>
                            <select name="" id="" class="form-control" required>
                                <option value="" selected disabled>Select an Option</option>
                                <option value="">Lab 1</option>
                                <option value="">Lab 2</option>
                                <option value="">Lab 3</option>
                            </select>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Any Comments on Medical Report</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="col-md-6 mt-3">
                            <label>Upload Medical Report</label>
                            <input type="file" class="form-control" name="medical_report" accept=".pdf,image/*" required>
                        </div>
                        <div class="col-md-6 mt-3">
                            <label for="recieved">Orignal Report Recieved?</label> &nbsp; &nbsp;
                            <input type="checkbox" id="recieved">
                        </div>
                    </div>
                </form>
            </div>

            {{-- Step 7: Medical Report --}}
            <div class="form-section" data-step="7">
                <div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ammountInDigits">Amount in digits</label>
                            <input type="text" class="form-control" id="ammountInDigits">
                        </div>
                        <div class="col-md-6">
                            <label for="ammountInWords">Amount in words</label>
                            <input type="text" class="form-control" id="ammountInWords">
                        </div>
                    </div>
                </div>
                <button id="generatePdfBtn" class="btn btn-primary">Generate PDF</button>
                <br><br>
                <iframe id="pdfFrame" src="" width="100%" height="0"></iframe>
            </div>

            {{-- Step 8: NBP form --}}
            <div class="form-section step-8" data-step="8">
                <div id="step-8-slip">
                    <!-- First Copy -->
                    <div class="row">
                        <div class="col-2">
                            <img src="{{ asset('public/admin/assets/images/NBP_Logo.png') }}" alt="" class="bank-logo">
                        </div>
                        <div class="col-7">
                            <h3 class="text-center">SPECIALIZED DEPOSIT SLIP</h3>
                            <p class="text-center fw-bold">On Behalf of Bureau of Engports & Overseas Employment</p>
                        </div>


                        <div class="col-3 data-copy-section">
                            <p class="bold text-center border-bottom-black">Bank Copy</p>

                            <p class="text-center">Deposit Slip, No.</p>
                            <p class="text-center fw-medium border-bottom-black">29787</p>
                        </div>
                    </div>

                    <div class="bold text-center" style="margin-bottom: 15px;">EMIGRANT THROUGH OVERSEAS EMPLOYMENT PROMOTOR
                        (OEP)</div>

                    <table>
                        <tr>
                            <td style="width: 35%">Collection Branch Name</td>
                            <td style="width: 25%">Branch Code</td>
                            <td style="width: 40%">Date
                                <div class="number-grid">
                                    <span class="number-cell">2</span>
                                    <span class="number-cell">5</span>
                                    <span>-</span>
                                    <span class="number-cell">0</span>
                                    <span class="number-cell">2</span>
                                    <span>-</span>
                                    <span class="number-cell">2</span>
                                    <span class="number-cell">0</span>
                                    <span class="number-cell">2</span>
                                    <span class="number-cell">5</span>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td colspan="3">Employant Information</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Employee Names</td>
                            <td style="width: 35%">AMAR 2022</td>
                            <td style="width: 40%">CNIC
                                <div class="number-grid">
                                    <span class="number-cell">3</span>
                                    <span class="number-cell">8</span>
                                    <span class="number-cell">0</span>
                                    <span class="number-cell">2</span>
                                    <span>-</span>
                                    <span class="number-cell">2</span>
                                    <span class="number-cell">9</span>
                                    <span class="number-cell">7</span>
                                    <span class="number-cell">4</span>
                                    <span class="number-cell">6</span>
                                    <span class="number-cell">8</span>
                                    <span class="number-cell">9</span>
                                    <span>-</span>
                                    <span class="number-cell">1</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Telephone (mobile)</td>
                            <td colspan="2">03244557417</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between">
                        <div class="bold">Particular of Payments _ CREDIT TO MADE THROUGH TRANSACTION CODE "ZBOGGP"</div>
                        <div class="border border-black px-1">Amount in Rs.</div>
                    </div>

                    <table>
                        <tr>
                            <td rowspan="3" style="width: 50%" class="text-center">
                                <p>Payment made on behalf of</p>
                                <p class="fw-bold">Director General</p>
                                <p class="fw-bold">Bureau of Employees & Overseas Employment</p>
                            </td>
                            <td style="width: 30%" class="text-center">OPE Welfare Fund</td>
                            <td style="width: 20%" class="text-end">Rs. 4000/-</td>
                        </tr>
                        <tr>
                            <td class="text-center">State Life Insurance Premium</td>
                            <td class="text-end">Rs. 2000/-</td>
                        </tr>
                        <tr>
                            <td class="text-center">OCE: Emigrant Promotion FEE</td>
                            <td class="text-end">Rs. 1200/-</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between">
                        <p class="mb-0">Amount in Words: SIX THOUSAND SEVEN HUNDRED ONLY</p>
                        <div class="d-flex">
                            <div class="border border-black px-1 fw-bold">Total</div>
                            <div class="border border-black px-1 fw-bold ml-2 pl-5">Rs 6700/-</div>
                        </div>
                    </div>

                    <div>
                        <div class="row mt-3">
                            <div class="col-4">
                                <div class="border border-black text-center">Received By</div>
                                <div class="border border-black d-flex justify-content-center align-items-center mt-1 h-100">
                                    <p class="mb-0">Cashier's Stamp & Signature</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border border-black text-center">Authorized By</div>
                                <div class="border border-black d-flex justify-content-center align-items-center mt-1 h-100">
                                    <p class="mb-0">Authorized Officer's Signature</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border border-black text-center">Depository's Signature</div>
                                <div
                                    class="border border-black d-flex flex-column justify-content-center align-items-center mt-1 h-100">
                                    <p class="text-center">Name: Muhammad Ad El-Sahatad</p>
                                    <p class="text-center">Contact Member: 03244557417</p>
                                    <p class="text-center">Signature: _________________</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-4">
                            <p class="text-center fw-bold">Note: for branch only</p>
                        </div>
                        <div class="col-4">
                            <p class="text-center fw-bold">- Only cash is acceptable</p>
                        </div>
                        <div class="col-4">
                            <p class="text-center fw-bold">- Separate slip for every individual</p>
                        </div>
                    </div>

                    <div style="border: 1px solid black;" class="mb-4 mt-1"></div>

                    <!-- Second Copy -->
                    <div class="row">
                        <div class="col-2">
                            <img src="{{ asset('public/admin/assets/images/NBP_Logo.png') }}" alt="" class="bank-logo">
                        </div>
                        <div class="col-8">
                            <h3 class="text-center">SPECIALIZED DEPOSIT SLIP</h3>
                            <p class="text-center fw-bold">On Behalf of Bureau of Engports & Overseas Employment</p>
                        </div>


                        <div class="col-2 data-copy-section">
                            <p class="bold text-center border-bottom-black">Bank Copy</p>

                            <p class="text-center">Deposit Slip, No.</p>
                            <p class="text-center fw-medium border-bottom-black">29787</p>
                        </div>
                    </div>

                    <div class="bold text-center" style="margin-bottom: 15px;">EMIGRANT THROUGH OVERSEAS EMPLOYMENT PROMOTOR
                        (OEP)</div>

                    <table>
                        <tr>
                            <td style="width: 35%">Collection Branch Name</td>
                            <td style="width: 25%">Branch Code</td>
                            <td style="width: 40%">Date
                                <div class="number-grid">
                                    <span class="number-cell">2</span>
                                    <span class="number-cell">5</span>
                                    <span>-</span>
                                    <span class="number-cell">0</span>
                                    <span class="number-cell">2</span>
                                    <span>-</span>
                                    <span class="number-cell">2</span>
                                    <span class="number-cell">0</span>
                                    <span class="number-cell">2</span>
                                    <span class="number-cell">5</span>
                                </div>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td colspan="3">Employant Information</td>
                        </tr>
                        <tr>
                            <td style="width: 25%">Employee Names</td>
                            <td style="width: 35%">AMAR 2022</td>
                            <td style="width: 40%">CNIC
                                <div class="number-grid">
                                    <span class="number-cell">3</span>
                                    <span class="number-cell">8</span>
                                    <span class="number-cell">0</span>
                                    <span class="number-cell">2</span>
                                    <span>-</span>
                                    <span class="number-cell">2</span>
                                    <span class="number-cell">9</span>
                                    <span class="number-cell">7</span>
                                    <span class="number-cell">4</span>
                                    <span class="number-cell">6</span>
                                    <span class="number-cell">8</span>
                                    <span class="number-cell">9</span>
                                    <span>-</span>
                                    <span class="number-cell">1</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Telephone (mobile)</td>
                            <td colspan="2">03244557417</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between">
                        <div class="bold">Particular of Payments _ CREDIT TO MADE THROUGH TRANSACTION CODE "ZBOGGP"</div>
                        <div class="border border-black px-1">Amount in Rs.</div>
                    </div>

                    <table>
                        <tr>
                            <td rowspan="3" style="width: 50%" class="text-center">
                                <p>Payment made on behalf of</p>
                                <p class="fw-bold">Director General</p>
                                <p class="fw-bold">Bureau of Employees & Overseas Employment</p>
                            </td>
                            <td style="width: 30%" class="text-center">OPE Welfare Fund</td>
                            <td style="width: 20%" class="text-end">Rs. 4000/-</td>
                        </tr>
                        <tr>
                            <td class="text-center">State Life Insurance Premium</td>
                            <td class="text-end">Rs. 2000/-</td>
                        </tr>
                        <tr>
                            <td class="text-center">OCE: Emigrant Promotion FEE</td>
                            <td class="text-end">Rs. 1200/-</td>
                        </tr>
                    </table>

                    <div class="d-flex justify-content-between">
                        <p class="mb-0">Amount in Words: SIX THOUSAND SEVEN HUNDRED ONLY</p>
                        <div class="d-flex">
                            <div class="border border-black px-1 fw-bold">Total</div>
                            <div class="border border-black px-1 fw-bold ml-2 pl-5">Rs 6700/-</div>
                        </div>
                    </div>

                    <div>
                        <div class="row mt-3">
                            <div class="col-4">
                                <div class="border border-black text-center">Received By</div>
                                <div class="border border-black d-flex justify-content-center align-items-center mt-1 h-100">
                                    <p class="mb-0">Cashier's Stamp & Signature</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border border-black text-center">Authorized By</div>
                                <div class="border border-black d-flex justify-content-center align-items-center mt-1 h-100">
                                    <p class="mb-0">Authorized Officer's Signature</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border border-black text-center">Depository's Signature</div>
                                <div
                                    class="border border-black d-flex flex-column justify-content-center align-items-center mt-1 h-100">
                                    <p class="text-center">Name: Muhammad Ad El-Sahatad</p>
                                    <p class="text-center">Contact Member: 03244557417</p>
                                    <p class="text-center">Signature: _________________</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-4">
                            <p class="text-center fw-bold">Note: for branch only</p>
                        </div>
                        <div class="col-4">
                            <p class="text-center fw-bold">- Only cash is acceptable</p>
                        </div>
                        <div class="col-4">
                            <p class="text-center fw-bold">- Separate slip for every individual</p>
                        </div>
                    </div>

                    <div style="border: 1px solid black;" class="mb-4 mt-1"></div>
                </div>
                <div class="d-flex justify-content-end my-3">
                    <button id="step-8-print-btn" class=" d-flex align-items-center btn btn-primary">
                        <span class="fa-solid fa-print"></span>
                        <p class="mb-0 ml-2">Print</p>
                    </button>
                </div>
            </div>

            <div class="buttons d-flex justify-content-end">
                <button id="prev" class="btn btn-success d-none">Previous</button>
                <button id="next" class="btn btn-primary">Save & Next</button>
                <button id="submit" class="btn btn-primary d-none">Submit</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $(".modal").each(function () {
            let modal = $(this);
            let currentStep = 1;
            let maxSteps = 15;

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
            }

            modal.find("#next").click(function (event) {
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

            // Reset progress when modal opens
            modal.on("show.bs.modal", function () {
                currentStep = 7;
                updateSteps();
            });

            updateSteps();
        });

        // Add print functionality for step-7-print-btn
        $("#step-7-print-btn").click(function () {
            var printContents = document.getElementById("step-7-slip").innerHTML;
            var originalContents = document.body.innerHTML;

            var printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('<style>');
            printWindow.document.write(document.querySelector('style').innerHTML); // Copy styles from the main document
            printWindow.document.write('</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
            document.body.innerHTML = originalContents;
            location.reload();
        });

        // Generate PDF and display in iframe
        $("#generatePdfBtn").click(function () {
            $.ajax({
                url: 'http://localhost/Mansol-Admin/generate-form-7',
                method: 'GET',
                success: function (response) {
                    $("#pdfFrame").attr("src", "{{ asset('public/admin/assets/form-7.pdf') }}");
                    $("#pdfFrame").attr("height", "600px");
                },
                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                }
            });
        });
    });
</script>

<script>
    document.getElementById("step-8-print-btn").addEventListener("click", function () {
        // Get slip content and styles
        const printContents = document.getElementById("step-8-slip").outerHTML;
        const styles = Array.from(document.querySelectorAll('style, link[rel="stylesheet"]'))
            .map(el => el.outerHTML)
            .join('\n');

        // Create a new print window
        const printWindow = window.open('', '_blank');

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