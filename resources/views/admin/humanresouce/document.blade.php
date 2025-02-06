<style>
    .steps {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .step {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: lightgray;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
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
        width: 50px;
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
        color: rgb(84 202 104);
        top: 0;
        right: 10px;
        font-size: 1.2rem;
    }
</style>

{{-- Create Company Model --}}
<div class="modal fade" id="createCompanyModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content p-4">
            <div class="steps mb-5">
                <div class="d-flex flex-column align-items-center position-relative">
                    <div class="step active" data-step="1">1</div>
                    <p class="m-0 step-text active">Account</p>
                    <span class="fa-solid fa-check position-absolute top-0 tick-mark d-none"></span>
                </div>
                <div class="line"></div>
                <div class="d-flex flex-column align-items-center position-relative">
                    <div class="step" data-step="2">2</div>
                    <p class="m-0 step-text">Profile</p>
                    <span class="fa-solid fa-check position-absolute top-0 tick-mark d-none"></span>
                </div>
                <div class="line"></div>
                <div class="d-flex flex-column align-items-center position-relative">
                    <div class="step" data-step="3">3</div>
                    <p class="m-0 step-text">Warning</p>
                    <span class="fa-solid fa-check position-absolute top-0 tick-mark d-none"></span>
                </div>
                <div class="line"></div>
                <div class="d-flex flex-column align-items-center position-relative">
                    <div class="step" data-step="4">4</div>
                    <p class="m-0 step-text">Finish</p>
                    <span class="fa-solid fa-check position-absolute top-0 tick-mark d-none"></span>
                </div>
            </div>
            <div class="form-section active" data-step="1">
                <form>
                    <h3>Account</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="file1">Upload PDF or JPG</label>
                                <input type="file" class="form-control" id="file1" accept=".pdf, .jpg, .jpeg, .png">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="preview-box">
                                <img id="preview1"
                                    src="https://solaralberta.ca/wp-content/uploads/legacylogos/default-placeholder.png"
                                    alt="Preview" class="w-100">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="form-section" data-step="2">
                <form>
                    <h3>Profile</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="file2">Upload PDF or JPG</label>
                                <input type="file" class="form-control" id="file2" accept=".pdf, .jpg, .jpeg, .png">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="preview-box">
                                <img id="preview2"
                                    src="https://solaralberta.ca/wp-content/uploads/legacylogos/default-placeholder.png"
                                    alt="Preview" class="w-100">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="form-section" data-step="3">
                <form>
                    <h3>Warning</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="file3">Upload PDF or JPG</label>
                                <input type="file" class="form-control" id="file3" accept=".pdf, .jpg, .jpeg, .png">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="preview-box">
                                <img id="preview3"
                                    src="https://solaralberta.ca/wp-content/uploads/legacylogos/default-placeholder.png"
                                    alt="Preview" class="w-100">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="form-section" data-step="4">
                <form>
                    <h3>Finish</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="file4">Upload PDF or JPG</label>
                                <input type="file" class="form-control" id="file4" accept=".pdf, .jpg, .jpeg, .png">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="preview-box">
                                <img id="preview4"
                                    src="https://solaralberta.ca/wp-content/uploads/legacylogos/default-placeholder.png"
                                    alt="Preview" class="w-100">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="buttons d-flex justify-content-end">
                <button id="prev" class="btn btn-success d-none">Previous</button>
                <button id="next" class="btn btn-primary">Save & Next</button>
                <button id="submit" class="btn btn-primary d-none" data-dismiss="modal">Submit</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        let currentStep = 1;

        function updateSteps() {
            $(".step, .line, .step-text").removeClass("active");
            $(".step").each(function () {
                let stepNum = $(this).data("step");
                if (stepNum <= currentStep) {
                    $(this).addClass("active");
                    $(this).next("p").addClass("active");
                }
            });
            $(".line").each(function (index) {
                if (index < currentStep - 1) {
                    $(this).addClass("active");
                }
            });
            $(".step-text").each(function () {
                let stepNum = $(this).prev(".step").data("step");
                if (stepNum <= currentStep) {
                    $(this).addClass("active");
                }
            });
            $(".form-section").removeClass("active");
            $(`.form-section[data-step="${currentStep}"]`).addClass("active");

            if (currentStep === 1) {
                $("#prev").addClass("d-none");
            } else {
                $("#prev").removeClass("d-none");
            }

            if (currentStep === 4) {
                $("#next").addClass("d-none");
                $("#submit").removeClass("d-none");
            } else {
                $("#next").removeClass("d-none");
                $("#submit").addClass("d-none");
            }
        }

        function updateTickMarks() {
            $(".form-section").each(function () {
                const stepNum = $(this).data("step");
                const fileInput = $(this).find("input[type='file']");
                if (fileInput.val() !== "") {
                    $(`.step[data-step="${stepNum}"]`).closest(".d-flex").find(".tick-mark").removeClass("d-none");
                } else {
                    $(`.step[data-step="${stepNum}"]`).closest(".d-flex").find(".tick-mark").addClass("d-none");
                }
            });
        }

        $("#next").click(function () {
            const currentFileInput = $(`#file${currentStep}`);
            if (currentFileInput.val() === "") {
                alert("Please upload a file before proceeding.");
                return;
            }
            if (currentStep < 4) {
                currentStep++;
                updateSteps();
            }
            updateTickMarks();
        });

        $("#prev").click(function () {
            if (currentStep > 1) {
                currentStep--;
                updateSteps();
            }
        });

        $("input[type='file']").change(function (event) {
            const inputId = $(this).attr("id");
            const previewId = `#preview${inputId.replace("file", "")}`;
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $(previewId).attr("src", e.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        $(".preview-box img").click(function () {
            const src = $(this).attr("src");
            const modal = `<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <img src="${src}" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>`;
            $("body").append(modal);
            $("#imageModal").modal("show");
            $("#imageModal").on("hidden.bs.modal", function () {
                $(this).remove();
            });
        });

        updateTickMarks();
    });
</script>