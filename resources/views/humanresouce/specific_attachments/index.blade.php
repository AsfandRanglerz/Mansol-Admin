@extends('humanresouce.layout.app')
@section('title', 'Attachments')

@section('content')
<div class="main-content">
    <section class="section">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">

                <div class="card">
                    <div class="card-header">
                        <h4>Attachments</h4>
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
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
