@extends('humanresouce.layout.app')
@section('title', 'Attachments')

@section('content')
<div class="main-content">
    <section class="section">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Step-1 Attachments</h4>
                    </div>

                    <div class="card-body">
                        <div class="container-fluid">

                            {{-- PASSPORT IMAGES --}}
                            <h5 class="mt-4">Valid Passport</h5>
                            <div class="row">

                                {{-- Passport Front --}}
                                <div class="col-md-4 mb-4">
                                    @php
                                        $passportFront = optional(
                                            $HumanResource->hrSteps->where('step_number', 2)->where('file_type', 'passport front')->first()
                                        )->file_name;
                                    @endphp
                                    <label>Passport Image 1</label>
                                    @if($passportFront)
                                        <img src="{{ asset($passportFront) }}" class="img-fluid mt-2 border rounded"
                                             style="width: 100%; height: 5.5cm; object-fit: contain;">
                                        <a href="{{ asset($passportFront) }}" download class="btn btn-primary mt-2">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    @else
                                        <p class="text-muted">Not Uploaded</p>
                                    @endif
                                </div>

                                {{-- Passport Back --}}
                                <div class="col-md-4 mb-4">
                                    @php
                                        $passportBack = optional(
                                            $HumanResource->hrSteps->where('step_number', 2)->where('file_type', 'passport back')->first()
                                        )->file_name;
                                    @endphp
                                    <label>Passport Image 2</label>
                                    @if($passportBack)
                                        <img src="{{ asset($passportBack) }}" class="img-fluid mt-2 border rounded"
                                             style="width: 100%; height: 5.5cm; object-fit: contain;">
                                        <a href="{{ asset($passportBack) }}" download class="btn btn-primary mt-2">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    @else
                                        <p class="text-muted">Not Uploaded</p>
                                    @endif
                                </div>

                                {{-- Passport 3 --}}
                                <div class="col-md-4 mb-4">
                                    @php
                                        $passport3 = optional(
                                            $HumanResource->hrSteps->where('step_number', 2)->where('file_type', 'passport third image')->first()
                                        )->file_name;
                                    @endphp
                                    <label>Passport Image 3</label>
                                    @if($passport3)
                                        <img src="{{ asset($passport3) }}" class="img-fluid mt-2 border rounded"
                                             style="width: 100%; height: 5.5cm; object-fit: contain;">
                                        <a href="{{ asset($passport3) }}" download class="btn btn-primary mt-2">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    @else
                                        <p class="text-muted">Not Uploaded</p>
                                    @endif
                                </div>

                            </div>


                            {{-- CNIC --}}
                            <h5 class="mt-4">CNIC</h5>
                            <div class="row">

                                {{-- CNIC Front --}}
                                <div class="col-md-6 mb-4">
                                    @php
                                        $cnicFront = optional(
                                            $HumanResource->hrSteps->where('step_number', 3)->where('file_type', 'cnic front')->first()
                                        )->file_name;
                                    @endphp
                                    <label>CNIC Front</label>
                                    @if($cnicFront)
                                        <img src="{{ asset($cnicFront) }}" class="img-fluid mt-2 border rounded"
                                             style="width: 100%; height: 5.5cm; object-fit: contain;">
                                        <a href="{{ asset($cnicFront) }}" download class="btn btn-primary mt-2">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    @else
                                        <p class="text-muted">Not Uploaded</p>
                                    @endif
                                </div>

                                {{-- CNIC Back --}}
                                <div class="col-md-6 mb-4">
                                    @php
                                        $cnicBack = optional(
                                            $HumanResource->hrSteps->where('step_number', 3)->where('file_type', 'cnic back')->first()
                                        )->file_name;
                                    @endphp
                                    <label>CNIC Back</label>
                                    @if($cnicBack)
                                        <img src="{{ asset($cnicBack) }}" class="img-fluid mt-2 border rounded"
                                             style="width: 100%; height: 5.5cm; object-fit: contain;">
                                        <a href="{{ asset($cnicBack) }}" download class="btn btn-primary mt-2">
                                            <i class="fa-solid fa-download"></i>
                                        </a>
                                    @else
                                        <p class="text-muted">Not Uploaded</p>
                                    @endif
                                </div>

                            </div>


                            {{-- Police Verification --}}
                            <h5 class="mt-4">Police Verification Certificate</h5>
                            <div class="col-md-6 mb-4">
                                @php
                                    $policePhoto = optional(
                                        $HumanResource->hrSteps->where('step_number', 4)->where('file_type', 'police verification')->first()
                                    )->file_name;
                                @endphp
                                @if($policePhoto)
                                    <img src="{{ asset($policePhoto) }}" class="img-fluid mt-2 border rounded"
                                         style="width: 3.5cm; height: 4.5cm; object-fit: contain;">
                                    <a href="{{ asset($policePhoto) }}" download class="btn btn-primary mt-2">
                                        <i class="fa-solid fa-download"></i>
                                    </a>
                                @else
                                    <p class="text-muted">Not Uploaded</p>
                                @endif
                            </div>

                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
         <h5>Step-2 Medical Report</h5>
        @php
            $step = $HumanResource->hrSteps->where('step_number', 6)->where('file_type', 'medical_report')->first();

            $medical_report = $step?->file_name ? asset($step->file_name) : null;
            $process_status = $step->process_status ?? '';
            $medically_fit = $step->medically_fit ?? '';
            $report_date = $step->report_date ?? '';
            $valid_until = $step->valid_until ?? '';
            $lab = $step->lab ?? '';
            $any_comments = $step->any_comments ?? '';
            $original_report_received = $step->original_report_recieved ?? 'no';
            $received_physically_medical_report = $step->received_physically ?? 'no';
        @endphp

        <div class="row">
            {{-- Process Status --}}
            <div class="col-md-6">
                <label>Process Status</label>
                <input type="text" class="form-control" name="process_status" value="{{ $process_status }}" readonly />
            </div>

            {{-- Medically Fit --}}
            <div class="col-md-6">
                <label>Medically Fit</label>
                <input type="text" class="form-control" name="medically_fit" value="{{ $medically_fit }}" readonly/>
            </div>

            {{-- Report Date --}}
            <div class="col-md-6 mt-3">
                <label>Report Date</label>
                <input type="date" class="form-control" name="report_date" value="{{ $report_date }}" readonly/>
            </div>

            {{-- Valid Until --}}
            <div class="col-md-6 mt-3">
                <label>Valid Until</label>
                <input type="date" class="form-control" name="valid_until" value="{{ $valid_until }}" readonly/>
            </div>

            {{-- Lab --}}
            <div class="col-md-6 mt-3">
                <label>Lab</label>
                <input type="text" class="form-control" name="lab" value="{{ $lab }}" readonly/>
            </div>

            {{-- Comments --}}
            <div class="col-md-6 mt-3">
                <label>Any Comments on Medical Report</label>
                <input type="text" class="form-control" name="any_comments" value="{{ $any_comments }}" readonly/>
            </div>

            {{-- Upload Medical Report --}}
            <div class="col-md-6 mt-3">
                <label>Upload Medical Report</label>
                <div class="mt-2">
                    @if($medical_report)
                    <a id="medicalReportPreview-{{ $HumanResource->id }}" href="{{ $medical_report }}"
                        target="_blank" class="btn btn-info {{ $medical_report ? '' : 'd-none' }}">
                        View Uploaded Report
                    </a>
                    @else
                    <p class="text">No Medical Report Found</p>
                    @endif
                </div>
            </div>

            {{-- Original Report Received --}}
            <div class="col-md-6 mt-4">
                <label for="medical" class="mt-4">Original Report Received?</label> &nbsp; &nbsp;
                <input type="checkbox" id="medical" name="original_report_received" class="mt-4"
                    {{ $original_report_received == 'yes' ? 'checked' : '' }} disabled/>
            </div>

            {{-- In Hand Checkbox --}}
            {{-- <div class="col-md-12 mt-3">
                <div class="form-check">
                    <input type="hidden" name="received_physically_medical_report" value="no">
                    <input type="checkbox" class="form-check-input"
                        id="received_physically_medical_report_{{ $HumanResource->id }}"
                        name="received_physically_medical_report" value="yes"
                        {{ strtolower($received_physically_medical_report) === 'yes' ? 'checked' : '' }}>
                    <label class="form-check-label font-weight-bold "
                        for="received_physically_medical_report_{{ $HumanResource->id }}">
                        In Hand
                    </label>
                </div>
            </div> --}}
        </div>

        {{-- Visa Form --}}
        <h5 class="mt-5">Visa Form</h5>
        @php
            $visaStep = $HumanResource->hrSteps->where('step_number', 6)->where('file_type', 'visa')->first();
            $visa_type = $visaStep->visa_type ?? '';
            $visa_issue_date = $visaStep->visa_issue_date ?? '';
            $visa_expiry_date = $visaStep->visa_expiry_date ?? '';
            $visa_receive_date = $visaStep->visa_receive_date ?? '';
            $visa_status = $visaStep->visa_status ?? '';
            $visa_issue_number = $visaStep->visa_issue_number ?? '';
            $visa_endorsement_date = $visaStep->visa_endorsement_date ?? '';
            $endorsement_checked = $visaStep->endorsement_checked ?? false;
            $scanned_visa = $visaStep && $visaStep->scanned_visa ? asset($visaStep->scanned_visa) : null;
            $received_physically_visa = $visaStep->received_physically ?? 'no';
        @endphp


        <div class="row">
            <div class="col-md-6">
                <label for="visa_type">Visa Type</label>
                <input type="text" class="form-control" name="visa_type" value="{{ $visa_type }}" readonly/>
            </div>

            <div class="col-md-6">
                <label for="issue_date">Number</label>
                <input type="number" class="form-control" name="visa_issue_number"
                    value="{{ $visa_issue_number }}" readonly/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="issue_date">Issue Date</label>
                <input type="date" class="form-control" name="visa_issue_date"
                    value="{{ $visa_issue_date }}" readonly/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" class="form-control" name="visa_expiry_date"
                    value="{{ $visa_expiry_date }}" readonly/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="receive_date">Visa Receive Date</label>
                <input type="date" class="form-control" name="visa_receive_date"
                    value="{{ $visa_receive_date }}" readonly/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="visa_status">Visa Status</label>
                <input type="text" class="form-control" name="visa_status" value="{{ $visa_status }}" readonly/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="scanned_visa">Scanned Visa</label>
                <div class="mt-2">
                    @if($scanned_visa)
                    <a id="visaPreview-{{ $HumanResource->id }}" href="{{ $scanned_visa }}" target="_blank"
                        class="btn btn-info {{ $scanned_visa ? '' : 'd-none' }}">
                        View Uploaded Visa
                    </a>
                    @else
                    <p class="text">No Visa Found</p>
                    @endif
                </div>
            </div>

            {{-- Endorsement --}}
            <div class="col-md-6 mt-4">
                <label for="Endorsement" class="mt-4">Endorsement?</label> &nbsp; &nbsp;
                <input type="checkbox" id="Endorsement" name="endorsement_checked" class="mt-4"
                    {{ $endorsement_checked == 'yes' ? 'checked' : '' }} disabled/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="endorsement_date">Endorsement Date</label>
                <input type="date" class="form-control" name="visa_endorsement_date"
                    value="{{ $visa_endorsement_date }}" readonly/>
            </div>

            {{-- In Hand Checkbox --}}
            {{-- <div class="col-md-12 mt-3">
                <div class="form-check">
                    <input type="hidden" name="received_physically_visa" value="no">
                    <input type="checkbox" class="form-check-input" id="received_physically_visa"
                        name="received_physically_visa" value="yes"
                        {{ strtolower($received_physically_visa) === 'yes' ? 'checked' : '' }}>
                    <label class="form-check-label font-weight-bold " for="received_physically_visa">
                        In Hand
                    </label>
                </div>
            </div> --}}
        </div>

        {{-- Air Booking --}}
        <h5 class="mt-5">Air Booking</h5>
        @php
            $airBookingStep = optional(
                $HumanResource->hrSteps->where('step_number', 7)->where('file_type', 'air_booking')->first(),
            );

            $ticket_number = $airBookingStep->ticket_number ?? '';
            $flight_number = $airBookingStep->flight_number ?? '';
            $flight_route = $airBookingStep->flight_route ?? '';
            $flight_date = $airBookingStep->flight_date ?? '';
            $flight_etd = $airBookingStep->flight_etd ?? '';
            $flight_eta = $airBookingStep->flight_eta ?? '';
            $upload_ticket = $airBookingStep->upload_ticket ? asset($airBookingStep->upload_ticket) : null;
            $received_physically_air_booking = $airBookingStep->received_physically ?? 'no';
        @endphp

        <div class="row">
            <div class="col-md-6">
                <label for="ticket_number">PNP Number</label>
                <input type="text" class="form-control" name="ticket_number" value="{{ $ticket_number }}" readonly/>
            </div>

            <div class="col-md-6">
                <label for="flight_number">Flight Number</label>
                <input type="text" class="form-control" name="flight_number" value="{{ $flight_number }}" readonly/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="flight_route">Flight Route</label>
                <input type="text" class="form-control" name="flight_route" value="{{ $flight_route }}" readonly/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="flight_date">Flight Date</label>
                <input type="date" class="form-control" name="flight_date" value="{{ $flight_date }}" readonly/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="etd">Expected Time of Departure (ETD)</label>
                <input type="time" class="form-control" name="flight_etd"
                    value="{{ $flight_etd ? date('H:i', strtotime($flight_etd)) : '' }}" readonly/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="eta">Expected Time of Arrival (ETA)</label>
                <input type="time" class="form-control" name="flight_eta"
                    value="{{ $flight_eta ? date('H:i', strtotime($flight_eta)) : '' }}" readonly/>
            </div>

            <div class="col-md-6 mt-3">
                <label for="upload_ticket">Upload PNP</label>
                <div class="mt-2">
                    @if($upload_ticket)
                    <a id="ticketPreview-{{ $HumanResource->id }}" href="{{ $upload_ticket }}" target="_blank"
                        class="btn btn-info {{ $upload_ticket ? '' : 'd-none' }}">
                        View Uploaded Ticket
                    </a>
                    @else
                    <p class="text">No PNP Found</p>
                    @endif
                </div>
            </div>

            {{-- In Hand Checkbox --}}
            {{-- <div class="col-md-12 mt-3">
                <div class="form-check">
                    <input type="hidden" name="received_physically_air_booking" value="no">
                    <input type="checkbox" class="form-check-input" id="received_physically_air_booking"
                        name="received_physically_air_booking" value="yes"
                        {{ strtolower($received_physically_air_booking) === 'yes' ? 'checked' : '' }}>
                    <label class="form-check-label font-weight-bold " for="received_physically_air_booking">
                        In Hand
                    </label>
                </div>
            </div> --}}
        </div>
                    </div>   

                </div>
            </div>
        </div>
        
    </section>
</div>
@endsection
