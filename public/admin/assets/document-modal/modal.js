<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                            modal.modal("hide");
                            toastr.success("All steps completed successfully");
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
