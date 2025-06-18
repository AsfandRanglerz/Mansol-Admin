@extends('humanresouce.layout.app')
@section('title', 'Human Resource')
@section('content')

<div class="main-content" style="min-height: 562px;">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-12">
                                <h4>Profile Status <span class="text-danger ml-2">
                                    @if ($user->status == 0)
                                        ( Rejected )
                                    @elseif ($user->status == 1)
                                        ( Pending )
                                    @elseif ($user->status == 2)
                                        ( Approved )
                                    @elseif ($user->status == 3)
                                        ( Nominated )
                                    @endif
                                </span></h4>
                            </div>
                        </div>
                        <div class="card-body table-striped table-bordered table-responsive">
                            <form id="createSubadminForm" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger" for="registration">Id No.</label>
                                            <input type="text" class="form-control" value="{{ $user->registration }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Name</label>
                                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Application for Post</label>
                                            <input type="text" class="form-control" value="{{ $MainCraft->name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Sub-Craft</label>
                                            <input type="text" class="form-control" value="{{ $SubCraft->name ?? '' }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Application Date</label>
                                            <input type="date" class="form-control" value="{{ $user->application_date }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Approval</label>
                                            <input type="text" class="form-control" value="{{ strtoupper($user->approvals) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Approval Document</label>
                                             {{-- Eye Button if file exists --}}
                                                    @if (!empty($user->medical_doc))
                                                        <div class="input-group-append">
                                                            <a href="{{ asset('/' . $user->medical_doc) }}"
                                                                target="_blank" class="btn btn-danger"
                                                                title="View Document">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    @else
                                                       <div class="input-group">
                                                        <div class="input-group-append">
                                                            <span class="btn btn-danger disabled">
                                                                <i class="fa fa-eye-slash"></i>
                                                            </span>
                                                        </div>
                                                        <div class="ml-2 align-self-center text-danger">
                                                            No document uploaded
                                                        </div>
                                                    </div>
                                                    @endif
                                        </div>  
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">S/O</label>
                                            <input type="text" class="form-control" value="{{ $user->son_of }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Mother Name</label>
                                            <input type="text" class="form-control" value="{{ $user->mother_name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Blood Group</label>
                                            <input type="text" class="form-control" value="{{ $user->blood_group }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Date Of Birth</label>
                                            <input type="date" class="form-control" value="{{ $user->date_of_birth }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">City Of Birth</label>
                                            <input type="text" class="form-control" value="{{ $user->city_of_birth }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">CNIC</label>
                                            <input type="text" class="form-control" value="{{ $user->cnic }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">CNIC Expiry Date</label>
                                            <input type="date" class="form-control" value="{{ $user->cnic_expiry_date }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Passport #</label>
                                            <input type="text" class="form-control" value="{{ $user->passport }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Passport Place Of Issue</label>
                                            <input type="text" class="form-control" value="{{ $user->passport_issue_place }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">DOI</label>
                                            <input type="date" class="form-control" value="{{ $user->doi }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">DOE</label>
                                            <input type="date" class="form-control" value="{{ $user->doe }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Religion</label>
                                            <input type="text" class="form-control" value="{{ $user->religion }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Martial Status</label>
                                            <input type="text" class="form-control" value="{{ $user->martial_status }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Next Of Kin</label>
                                            <input type="text" class="form-control" value="{{ $user->next_of_kin }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Relation</label>
                                            <input type="text" class="form-control" value="{{ $user->relation }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Kin CNIC</label>
                                            <input type="text" class="form-control" value="{{ $user->cnic }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Shoe Size</label>
                                            <input type="text" class="form-control" value="{{ $user->shoe_size }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Cover Size</label>
                                            <input type="text" class="form-control" value="{{ $user->cover_size }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Academic Qualification</label>
                                            <input type="text" class="form-control" value="{{ $user->acdemic_qualification }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Technical Qualification</label>
                                            <input type="text" class="form-control" value="{{ $user->technical_qualification }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Profession</label>
                                            <input type="text" class="form-control" value="{{ $user->profession }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Years of Experience</label>
                                            <input type="text" class="form-control" value="{{ $user->experience }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">District Of Domicile</label>
                                            <input type="text" class="form-control" value="{{ $user->district_of_domicile }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Present Address</label>
                                            <textarea class="form-control" readonly>{{ $user->present_address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row col-md-8">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger">Phone</label>
                                                <input type="text" class="form-control" value="{{ $user->present_address_phone }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger">Mobile</label>
                                                <input type="text" class="form-control" value="{{ $user->present_address_mobile }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger">Email</label>
                                                <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger">Present Address City</label>
                                                <input type="text" class="form-control" value="{{ $user->present_address_city }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Permanent Address</label>
                                            <textarea class="form-control" readonly>{{ $user->permanent_address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row col-md-8">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger">Phone</label>
                                                <input type="text" class="form-control" value="{{ $user->permanent_address_phone }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger">Mobile</label>
                                                <input type="text" class="form-control" value="{{ $user->permanent_address_mobile }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger">Permanent Address City</label>
                                                <input type="text" class="form-control" value="{{ $user->permanent_address_city }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="text-danger">Permanent Address Province</label>
                                                <input type="text" class="form-control" value="{{ $user->permanent_address_province }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Citizenship</label>
                                            <input type="text" class="form-control" value="{{ $user->citizenship }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Gender</label>
                                            <input type="text" class="form-control" value="{{ $user->gender }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Reference</label>
                                            <input type="text" class="form-control" value="{{ $user->refference }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Performance-Appraisal Awarded %</label>
                                            <input type="text" class="form-control" value="{{ $user->performance_appraisal }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Min Acceptable Salary %</label>
                                            <input type="text" class="form-control" value="{{ $user->min_salary }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="text-danger">Comment</label>
                                            <input type="text" class="form-control" value="{{ $user->comment }}" readonly>
                                        </div>
                                    </div>
                                    
                                </div>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
             <div class="card">
                    <div class="card-header text-center d-flex justify-content-between align-items-center">
                        {{-- @if ($nominat)
                            <a class="btn btn-primary" disabled title="Please Demob" onclick="showToaster()">Nominate</a>
                        @else
                            <a class="btn btn-primary"
                                onclick="showUserModel('createDriverModel', {{ $HumanResource->id }})">Nominate</a>
                        @endif --}}
                        <h4 class="flex-grow-1 text-center m-0">Job History</h4>
                        <div style="width: 75px;"></div> <!-- Empty space to balance the button width -->
                    </div>


                    <div class="card-body table-striped table-bordered table-responsive">
                        <table class="table responsive" id="table_id_events">
                            <thead>
                                <tr>
                                    <th>Sr.</th>
                                    <th>Company</th>
                                    <th>Interview Location</th>
                                    <th>Project</th>
                                    <th>Craft</th>
                                    <th>Sub-Craft</th>
                                    <th>Application Date</th>
                                    <th>Mob-Date</th>
                                    <th>Demob-Date</th>
                                    {{-- <th scope="col-2">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($histories as $data)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $data->company->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->city_of_interview ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->project->project_name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->craft->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->subCraft->name ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->application_date ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->mob_date ?? 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $data->demobe_date ?? 'N/A' }}
                                        </td>
                                      
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </section>
</div>

@endsection

@section('js')

    <script>
        $(document).ready(function() {
            $('#table_id_events').DataTable()

        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <script type="text/javascript">
        $('.show_confirm').click(function(event) {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            swal({
                    title: `Are you sure you want to delete this record?`,
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
        });
    </script>
@endsection
