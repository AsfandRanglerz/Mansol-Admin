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

                            <input
                                type="file"
                                class="form-control"
                                name="cv"
                                id="cvInput"
                                accept=".pdf"
                                required
                                onchange="previewPDF(this)"
                            />
                        </div>
                    </form>
                    <!-- <div style="width: 60%">
                        <iframe
                            class="border-0"
                            id="pdfFrame1"
                            src=""
                            width="100%"
                            height="0px"
                        ></iframe>
                    </div> -->
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
                                src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="
                                    width: 9.5cm;
                                    height: 5.5cm;
                                    object-fit: cover;
                                "
                            />
                        </div>

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
                                src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="
                                    width: 9.5cm;
                                    height: 5.5cm;
                                    object-fit: cover;
                                "
                            />
                        </div>
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
                                src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="
                                    width: 9.5cm;
                                    height: 5.5cm;
                                    object-fit: cover;
                                "
                            />
                        </div>

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
                                src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="
                                    width: 9.5cm;
                                    height: 5.5cm;
                                    object-fit: cover;
                                "
                            />
                        </div>
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
                            src="default-placeholder.png"
                            class="img-fluid mt-2 d-none border rounded"
                            style="
                                width: 3.5cm;
                                height: 4.5cm;
                                object-fit: cover;
                            "
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
                                src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="
                                    width: 9.5cm;
                                    height: 5.5cm;
                                    object-fit: cover;
                                "
                            />
                        </div>

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
                                src="default-placeholder.png"
                                class="img-fluid mt-2 d-none border rounded"
                                style="
                                    width: 9.5cm;
                                    height: 5.5cm;
                                    object-fit: cover;
                                "
                            />
                        </div>
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

                    <h5>Medical Report</h5>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Process Status</label>

                            <select name="" id="" class="form-control" required>
                                <option value="" selected disabled>
                                    Select an Option
                                </option>

                                <option value="">Yet to appear</option>

                                <option value="">Appeared</option>

                                <option value="">Waiting</option>

                                <option value="">Result Available</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Medically Fit</label>

                            <select name="" id="" class="form-control" required>
                                <option value="" selected disabled>
                                    Select an Option
                                </option>

                                <option value="">Repeat</option>

                                <option value="">Fit</option>

                                <option value="">Unfit</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Report Date</label>

                            <input type="date" class="form-control" />
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Valid Until</label>

                            <input type="date" class="form-control" />
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Lab</label>

                            <select name="" id="" class="form-control" required>
                                <option value="" selected disabled>
                                    Select an Option
                                </option>

                                <option value="">Lab 1</option>

                                <option value="">Lab 2</option>

                                <option value="">Lab 3</option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Any Comments on Medical Report</label>

                            <input type="text" class="form-control" />
                        </div>

                        <div class="col-md-6 mt-3">
                            <label>Upload Medical Report</label>

                            <input
                                type="file"
                                class="form-control"
                                name="medical_report"
                                accept=".pdf,image/*"
                                required
                            />
                        </div>

                        <div class="col-md-6 mt-3">
                            <label for="recieved"
                                >Orignal Report Recieved?</label
                            >
                            &nbsp; &nbsp;

                            <input type="checkbox" id="recieved" />
                        </div>
                    </div>
                </form>
            </div>

            {{-- Step 7: Medical Report --}}

            <div class="form-section" data-step="7">
                <div>
                    <div class="row mb-3">
                        <div class="col-md-5 pr-0">
                            <label for="ammountInDigits"
                                >Amount in digits</label
                            >

                            <input
                                type="text"
                                class="form-control"
                                id="ammountInDigits"
                                value="15000"
                            />
                        </div>

                        <div class="col-md-6 pl-2 d-flex align-items-end">
                            <div style="flex: 1" class="mr-2">
                                <label for="ammountInWords"
                                    >Amount in words</label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="ammountInWords"
                                    value="Fifteen Thousand Rupees Only"
                                    readonly
                                />
                            </div>
                            <button
                                id="generatePdfBtn"
                                class="btn btn-primary"
                                style="margin-bottom: 2px"
                            >
                                Generate PDF
                            </button>
                        </div>
                    </div>
                </div>

                <iframe id="pdfFrame" src="" width="100%" height="0"></iframe>
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
    $(document).ready(function () {
        $(".modal").each(function () {
            let modal = $(this);

            let currentStep = 1;

            let maxSteps = 11;

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

                modal
                    .find(`.form-section[data-step="${currentStep}"]`)
                    .addClass("active");

                modal.find("#prev").toggleClass("d-none", currentStep === 1);

                modal
                    .find("#next")
                    .toggleClass("d-none", currentStep === maxSteps);

                modal
                    .find("#submit")
                    .toggleClass("d-none", currentStep !== maxSteps);
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
                        fileInput
                            .siblings("img")
                            .attr("src", e.target.result)
                            .removeClass("d-none");
                    };

                    reader.readAsDataURL(file);
                }
            });

            // Reset progress when modal opens

            modal.on("show.bs.modal", function () {
                currentStep = 1;

                updateSteps();
            });

            // Make active steps clickable
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

        $("#generatePdfBtn").click(function () {
            $.ajax({
                url: "{{ asset('/generate-form-7') }}",

                method: "GET",

                success: function (response) {
                    $("#pdfFrame").attr(
                        "src",
                        "{{ asset('public/admin/assets/form-7.pdf') }}"
                    );

                    $("#pdfFrame").attr("height", "600px");
                },

                error: function (xhr, status, error) {
                    console.error("Error generating PDF:", error);
                },
            });
        });

        // For step 8 pdf

        $("#generatePdfBtn8").click(function () {
            $.ajax({
                url: "{{ asset('/generate-nbp-form') }}",
                // url: "http://localhost/Mansol-Admin/generate-nbp-form",

                method: "GET",

                success: function (response) {
                    $("#pdfFrame8").attr(
                        "src",
                        "{{ asset('public/admin/assets/nbp-form.pdf') }}"
                    );

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
                // url: "http://localhost/Mansol-Admin/generate-nbp-form",

                method: "GET",

                success: function (response) {
                    $("#pdfFrame9").attr(
                        "src",
                        "{{ asset('public/admin/assets/Challan-92.pdf') }}"
                    );

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
                // url: "http://localhost/Mansol-Admin/generate-life-insurance",

                method: "GET",

                success: function (response) {
                    $("#pdfFrame10").attr(
                        "src",
                        "{{ asset('public/admin/assets/life-insurance.pdf') }}"
                    );

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

                // url: "http://localhost/Mansol-Admin/generate-fsa-form",

                method: "GET",

                success: function (response) {
                    $("#pdfFrame11").attr(
                        "src",
                        "{{ asset('public/admin/assets/fsa-form.pdf') }}"
                    );

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
    function previewPDF(input) {
        const file = input.files[0];
        if (file && file.type === "application/pdf") {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById("pdfFrame1").src = e.target.result;
                document.getElementById("pdfFrame1").style.height = "300px";
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
