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
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                <form id="form-step-1" action="{{ route('submit.step', ['step' => 1]) }}" method="POST" enctype="multipart/form-data">
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
                <form id="form-step-2" action="{{ route('submit.step', ['step' => 2]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5>Valid Passport</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Passport Image 1</label>
                            <input type="file" class="form-control" name="passport_image_1" accept="image/*" onchange="previewImage(this, 'preview-passport-1')" required>
                            <img id="preview-passport-1" src="default-placeholder.png" class="img-fluid mt-2 d-none border rounded" 
                            style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <label>Passport Image 2</label>
                            <input type="file" class="form-control" name="passport_image_2" accept="image/*" onchange="previewImage(this, 'preview-passport-2')" required>
                            <img id="preview-passport-2" src="default-placeholder.png" class="img-fluid mt-2 d-none border rounded" 
                            style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                    </div>
                </form>
            </div>

            {{-- Step 3: CNIC --}}
            <div class="form-section" data-step="3">
                <form id="form-step-3" action="{{ route('submit.step', ['step' => 3]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5>CNIC</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>CNIC Front</label>
                            <input type="file" class="form-control" name="cnic_front" accept="image/*" onchange="previewImage(this, 'preview-cnic-front')" required>
                            <img id="preview-cnic-front" src="default-placeholder.png" class="img-fluid mt-2 d-none border rounded" 
                            style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <label>CNIC Back</label>
                            <input type="file" class="form-control" name="cnic_back" accept="image/*" onchange="previewImage(this, 'preview-cnic-back')" required>
                            <img id="preview-cnic-back" src="default-placeholder.png" class="img-fluid mt-2 d-none border rounded" 
                            style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                    </div>
                </form>
            </div>

            {{-- Step 4: Passport-size Photo --}}
            <div class="form-section" data-step="4">
                <form id="form-step-4" action="{{ route('submit.step', ['step' => 4]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5>Passport-size Photograph</h5>
                    <div class="form-group">
                        <label>Upload Photo</label>
                        <input type="file" class="form-control" name="photo" accept="image/*" onchange="previewImage(this, 'preview-photo')" required>
                        <img id="preview-photo" src="default-placeholder.png" 
     class="img-fluid mt-2 d-none border rounded" 
     style="width: 3.5cm; height: 4.5cm; object-fit: cover;">

                    </div>
                </form>
            </div>

            {{-- Step 5: NOK CNIC --}}
            <div class="form-section" data-step="5">
                <form id="form-step-5" action="{{ route('submit.step', ['step' => 5]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5>Next of Kin (NOK) CNIC</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label>NOK CNIC Front</label>
                            <input type="file" class="form-control" name="nok_cnic_front" accept="image/*" onchange="previewImage(this, 'preview-nok-front')" required>
                            <img id="preview-nok-front" src="default-placeholder.png" class="img-fluid mt-2 d-none border rounded" 
                            style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                        <div class="col-md-6">
                            <label>NOK CNIC Back</label>
                            <input type="file" class="form-control" name="nok_cnic_back" accept="image/*" onchange="previewImage(this, 'preview-nok-back')" required>
                            <img id="preview-nok-back" src="default-placeholder.png" class="img-fluid mt-2 d-none border rounded" 
                            style="width: 9.5cm; height: 5.5cm; object-fit: cover;">
                        </div>
                    </div>
                </form>
            </div>

            {{-- Step 6: Medical Report --}}
            <div class="form-section" data-step="6">
                <form id="form-step-6" action="{{ route('submit.step', ['step' => 6]) }}" method="POST" enctype="multipart/form-data">
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

        // $("#next").click(function () {
        //     let form = $(`.form-section[data-step="${currentStep}"] form`);
        //     let formData = new FormData(form[0]);
            

        //     $.ajax({
        //         url: form.attr('action'),
        //         type: 'POST',
        //         data: formData,
        //         contentType: false,
        //         processData: false,
        //         success: function (response) {
        //             currentStep++;
        //             updateSteps();
        //         },
        //         error: function (xhr) {
        //             alert("Error: " + xhr.responseText);
        //         }
        //     });
        // });

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
            currentStep = 1;
            updateSteps();
        });

        updateSteps();
    });

    });
</script>
