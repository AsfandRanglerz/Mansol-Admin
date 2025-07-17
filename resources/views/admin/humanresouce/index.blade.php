@extends('admin.layout.app')
@section('title', 'Human Resources')
@section('content')
{{-- <head>
    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
</head> --}}
<style>
@media print {
    .noExport {
        display: none !important;
    }
}
.custom-red-btn {
    background-color: #d5363c !important;
    color: white !important;
    border: none;
}
.btn-export-excel {
    width: max-content;
}

</style>
    <div class="modal fade" id="createSubadminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Human Resource</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <form action="{{ url('admin/human-resource/import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="file" required>
                                            <button type="submit" class="btn btn-success">Import</button>
                                        </form>
                </div>
                <div class="modal-body">
                    <form id="createSubadminForm" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" id="draft_id" name="draft_id">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" onclick="submitSubadminForm()">Create</button>
                </div>
            </div>
        </div>
    </div>


    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Human Resources</h4>
                                    <h6 class="badge bg-primary text-white" id="total-count-badge">Total Count: {{ $count }}</h6>
                                    <h6 class="text-muted text-danger" style="font-style: italic;">
                                            Note: The default password for all human resources is <strong>12345678</strong>. This password is automatically generated when a new human resource created.
                                    </h6>
                                </div>
                            </div>
                                <div class="card-body table-striped table-bordered table-responsive">
                                     {{-- Filter Form --}}
                                        <form action="" method="POST" class="row g-3 mt-3" id="filter-form">
                                            {{-- Company --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label class="" for="company_id">Company</label>
                                                <select name="company_id" id="company_id" class="form-control">
                                                    <option value="">Select Company</option>
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            </div>

                                            {{-- Project --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label class="" for="project_id">Project</label>
                                                <select name="project_id" id="project_id" class="form-control">
                                                    <option value="" selected disabled>Select Project</option>
                                                    @foreach ($projects as $project)
                                                        @if(request('company_id') && $project->company_id == request('company_id'))
                                                            <option value="{{ $project->id }}" {{ request('project_id') == $project->id ? 'selected' : '' }}>{{ $project->project_name }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                @error('project_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            </div>

                                            {{-- Demand --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label class="" for="demand_id">Demand</label>
                                                <select name="demand_id" id="demand_id" class="form-control">
                                                    <option value="" selected disabled>Select Demand</option>
                                                    
                                                    {{-- @if($projectId) --}}
                                                        @foreach ($demands as $demand)
                                                            @if(request('project_id') && $demand->project_id == request('project_id'))
                                                                <option value="{{ $demand->id }}" {{ request('demand_id') == $demand->id ? 'selected' : '' }}>{{ $demand->full_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    {{-- @endif --}}
                                                </select>
                                                
                                                @error('demand_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            </div>

                                            {{-- Crafts --}}
                                           <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="craft" class="form-label">Craft</label>
                                                    <select name="craft" id="craft" class="form-control">
                                                    <option value="">Select Craft</option>
                                                        @foreach ($crafts as $data)
                                                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Reference --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="refference" class="form-label">Refference</label>
                                                    <select name="refference" id="refference" class="form-control">
                                                        <option value="" disabled selected>Select Refference</option>
                                                        @foreach($references as $item)
                                                                <option value="{{ $item }}">
                                                                    {{ $item }}
                                                                </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Medically Fit --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="medically_fit" class="form-label">Medically Fit</label>
                                                    <select name="medically_fit" id="medically_fit" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="Repeat" {{ request('medically_fit') == 'Repeat' ? 'selected' : '' }}>Repeat</option>
                                                        <option value="Fit" {{ request('medically_fit') == 'Fit' ? 'selected' : '' }}>Fit</option>
                                                         <option value="Unfit" {{ request('medically_fit') == 'Unfit' ? 'selected' : '' }}>Unfit</option>
                                                    </select>
                                                </div>
                                            </div>
                                            {{-- Application Date From --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="date_from" class="form-label">Application Date From</label>
                                                    <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') }}">
                                                </div>
                                            </div>
                                            {{-- Application Date To --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="date_to" class="form-label">Application Date To</label>
                                                    <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') }}">
                                                </div>
                                            </div>
                                            {{-- CNIC Expiry Status --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="cnic_expiry" class="form-label">CNIC Expiry Status</label>
                                                    <select name="cnic_expiry" id="cnic_expiry" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="Valid" {{ request('cnic_expiry') == 'Valid' ? 'selected' : '' }}>Valid</option>
                                                        <option value="Expired" {{ request('cnic_expiry') == 'Expired' ? 'selected' : '' }}>Expire</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Passport Expiry Date --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label for="passport_expiry" class="form-label">Passport Expiry Status</label>
                                               <select name="passport_expiry" id="passport_expiry" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="Valid" {{ request('passport_expiry') == 'Valid' ? 'selected' : '' }}>Valid</option>
                                                        <option value="Expired" {{ request('passport_expiry') == 'Expired' ? 'selected' : '' }}>Expire</option>
                                                    </select>
                                            </div>
                                            </div>

                                            {{-- Visa Expiry Date --}}
                                            <div class="col-md-3">
                                                <div class="form-group"> 
                                                <label for="visa_expiry" class="form-label">Visa Expiry Status</label>
                                                <select name="visa_expiry" id="visa_expiry" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="Valid" {{ request('visa_expiry') == 'Valid' ? 'selected' : '' }}>Valid</option>
                                                        <option value="Expired" {{ request('visa_expiry') == 'Expired' ? 'selected' : '' }}>Expire</option>
                                                    </select>
                                            </div>
                                            </div>

                                            {{-- Visa Expiry Date --}}
                                            <div class="col-md-3">
                                                <div class="form-group"> 
                                                <label for="visa_type">Visa Type</label>
                                                    <select name="visa_type" class="form-control" id="visa_type">
                                                        <option value="" disabled selected>Select Visa Type</option>
                                                        <option value="Work Permit">Work Permit</option>
                                                        <option value="Visit Visa">Visit Visa</option>
                                                        <option value="B-1">B-1</option>
                                                        <option value="DEB">DEB</option>
                                                        <option value="Single Entry">Single Entry</option>
                                                        <option value="EV">EV</option>
                                                        <option value="Work Visa">Work Visa</option>
                                                        <option value="WORK VISIT VISA">WORK VISIT VISA</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Flight Date --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="flight_date" class="form-label">Flight Date</label>
                                                    <input type="date" name="flight_date" id="flight_date" class="form-control" value="{{ request('flight_date') }}">
                                                </div>
                                            </div>

                                            {{-- Mobilized FIlter --}}
                                            <div class="col-md-3">
                                                <div class="form-group"> 
                                                <label for="mobilized">Mobilized</label>
                                                    <select name="mobilized" class="form-control" id="mobilized">
                                                        <option value="" disabled selected>Select Option</option>
                                                        <option value="Mobilized">Mobilized</option>
                                                        <option value="Not Yet Mobilized">Not Yet Mobilized</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- CNIC Taken Filter --}}
                                            <div class="col-md-3">
                                                <div class="form-group"> 
                                                <label for="cnic_taken">CNIC</label>
                                                    <select name="cnic_taken" class="form-control" id="cnic_taken">
                                                        <option value="" disabled selected>Select Option</option>
                                                        <option value="Taken">Taken</option>
                                                        <option value="Not Taken">Not Taken</option>
                                                    </select>
                                                </div>
                                            </div>


                                            {{-- Passport Taken Filter --}}
                                            <div class="col-md-3">
                                                <div class="form-group"> 
                                                <label for="passport_taken">Passport</label>
                                                    <select name="passport_taken" class="form-control" id="passport_taken">
                                                        <option value="" disabled selected>Select Option</option>
                                                        <option value="Taken">Taken</option>
                                                        <option value="Not Taken">Not Taken</option>
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Blood Group --}}
                                            <div class="col-md-3">
                                                <div class="form-group"> 
                                                <label for="blood_group">Blood Group</label>
                                                        <select name="blood_group" class="form-control" id="blood_group">
                                                            <option value="" disabled selected>Select Blood Group</option>
                                                    @foreach (['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $blood)
                                                        <option value="{{ strtolower($blood) }}">
                                                            {{ $blood }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                    
                                                </div>
                                            </div>


                                            {{-- Religion --}}
                                            <div class="col-md-3">
                                                <div class="form-group"> 
                                                <label for="religion">Religion</label>
                                                    <select name="religion" class="form-control" id="religion">
                                                    <option value="" disabled selected>
                                                        Select Religion
                                                    </option>
                                                    @foreach (['Muslim', 'Hindu', 'Christian', 'Buddhist', 'Jewish', 'Sikh'] as $religion)
                                                        <option value="{{ strtolower($religion) }}">
                                                            {{ $religion }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>

                                            {{-- Approval --}}
                                            <div class="col-md-3">
                                                <div class="form-group"> 
                                                <label for="approvals">Approvals</label>
                                                    <select name="approvals" id="approvals" class="form-control">
                                                    <option value="" disabled selected>
                                                        Select Company</option>
                                                    @foreach (['ARAMCO', 'SABIC', 'PDO', 'ADNOC', 'Shell', 'Dolphin', 'Q Con', 'Qatar Gas', 'Oryx', 'Oxchem'] as $company)
                                                        <option value="{{ strtolower($company) }}">
                                                            {{ $company }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>

                                            {{-- Interview Location --}}
                                            <div class="col-md-3">
                                                <div class="form-group"> 
                                                <label for="interview_location">Interview Location</label>
                                                    <select name="interview_location" class="form-control" id="interview_location">
                                                        <option value="" disabled selected>Select Option</option>
                                                        @foreach ($cities as $city)
                                                        <option value="{{ strtolower($city->name) }}">
                                                            {{ $city->name }}
                                                        </option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            {{-- Filter Button --}}
                                            <div class="col-md-12 d-flex justify-content-end align-items-end mb-3">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-primary mr-2">Apply Filter</button>
                                                    <button type="button" id="clear-filter-btn" class="btn btn-secondary">Clear</button>
                                                </div>
                                            </div>
                                        </form>

                                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-1">
                                        @php
                                        $canCreate = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Human Resources', 'create'));
                                        $canEdit = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Human Resources', 'edit'));
                                        $canDelete = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Human Resources', 'delete'));
                                        @endphp
                                        @if ($canCreate)
                                        <a class="btn btn-primary text-white" href="{{ route('humanresource.create') }}">
                                            Add Human Resource
                                        </a>
                                        @endif
                                       <form id="importForm" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                                @csrf
                                                <input type="file" name="file" id="importFile" required class="form-control">
                                                <button type="submit" id="importBtn" class="btn btn-success ml-3">
                                                    <span class="default-text">Import</span>
                                                    <span class="loading-text d-none"> 
                                                    <span class="spinner-border spinner-border-sm"></span></span>
                                                </button>
                                            </form>

                                            {{-- <!-- Success/Error Message -->
                                            <div id="importMsg" class="mt-2"></div> --}}

                                    </div>
                                    {{-- Export/Print Buttons --}}
                                  

                                <table class="table responsive" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th class="noExport">Sr.</th>
                                            <th>Id No.</th>
                                            <th class="noExport">Passport Photo</th>
                                            <th class="noExport">Documents</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>CNIC</th>
                                            <th>Application Date</th>
                                            <th>Appication for Post Craft</th>
                                            <th>Sub-Craft</th>
                                            <th>Approvals #</th>
                                            <th class="noExport">Approvals Document</th>
                                            <th>City Of Interview</th>
                                            <th>S/O</th>
                                            <th>Mother Name</th>
                                            <th>Date Of Birth</th>
                                            <th>CNIC Expiry Date</th>
                                            <th>Data Of Issue/Passport</th>
                                            <th>Data Of Expiry/Passport</th>
                                            <th>Passport #</th>
                                            <th>Next Of Kin</th>
                                            <th>Relation</th>
                                            <th>Kin CNIC</th>
                                            <th>Shoe Size</th>
                                            <th>Cover Size</th>
                                            <th>Academic Qualification</th>
                                            <th>Technical Qualification</th>
                                            <th>Experience (Local)</th>
                                            <th>Experience (Gulf)</th>
                                            <th>District Of Domicile</th>
                                            <th>Present Address</th>
                                            <th>Present Address Phone</th>
                                            <th>Present Address Mobile</th>
                                            <th>Permanent Address</th>
                                            <th>Present Address City</th>
                                            <th>Permanent Address Phone</th>
                                            <th>Permanent Address Mobile</th>
                                            <th>Gender</th>
                                            <th>Blood Group</th>
                                            <th>Religion</th>
                                            <th>Permanent Address City</th>
                                            <th>Permanent Address Province</th>
                                            <th>Citizenship</th>
                                            <th>Refference</th>
                                            <th>Performance-Appraisal Awarded %</th>
                                            <th>Min Acceptable Salary</th>
                                            <th>Visa Type</th>
                                            <th>Visa Status</th>
                                            <th>Visa Issue Date</th>
                                            <th>Visa Expiry Date</th>
                                            <th>Flight Date</th>
                                            <th>Flight Route</th>
                                            <th>CNIC Taken Status</th>
                                            <th>Passport Taken Status</th>
                                            <th>Comment</th>
                                            <th>Status</th>
                                            <th scope="col" class="noExport">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- DataTables will fill this --}}
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


@include('admin.humanresouce.document')

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.show_confirm', function(event){
            event.preventDefault();
            var form = $(this).closest("form");
            swal({
                title: "Are you sure you want to delete this record?",
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

        var table = $('#table_id_events').DataTable({
            processing: true,
            serverSide: true,
            deferRender: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, 250, 500, 1000, -1], [10, 25, 50, 100, 250, 500, 1000, "All"]],
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: { columns: ':not(.noExport)' },
                    title: 'Human Resources',
                    className: 'btn-export-excel',
                    text: 'Genrate Excel Report', 
                    action: function(e, dt, button, config) {
                        var self = this;
                        var oldStart = dt.settings()[0]._iDisplayStart;
                        dt.one('preXhr', function(e, s, data) {
                            data.start = 0;
                            data.length = -1;
                            dt.one('preDraw', function(e, settings) {
                                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
                                dt.one('preXhr', function(e, s, data) {
                                    settings._iDisplayStart = oldStart;
                                    data.start = oldStart;
                                });
                                setTimeout(dt.ajax.reload, 0);
                                return false;
                            });
                        });
                        dt.ajax.reload();
                    }
                }
            ],
            ajax: {
                url: "{{ route('humanresource.ajax') }}",
                type: "POST",
                data: function (d) {
                    d._token = "{{ csrf_token() }}";
                    d.company_id = $('#company_id').val();
                    d.project_id = $('#project_id').val();
                    d.demand_id = $('#demand_id').val();
                    d.craft_id = $('#craft').val();
                    d.medically_fit = $('#medically_fit').val();
                    d.cnic_expiry = $('#cnic_expiry').val();
                    d.passport_expiry = $('#passport_expiry').val();
                    d.visa_expiry = $('#visa_expiry').val();
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
                    d.visa_type = $('#visa_type').val();
                    d.refference = $('#refference').val();
                    d.flight_date = $('#flight_date').val();
                    d.mobilized = $('#mobilized').val();
                    d.cnic_taken = $('#cnic_taken').val();
                    d.passport_taken = $('#passport_taken').val();
                    d.blood_group = $('#blood_group').val();
                    d.religion = $('#religion').val();
                    d.approvals = $('#approvals').val();
                    d.interview_location = $('#interview_location').val();
                }
            },
            columns: [
                { render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; } },
                { data: "registration" },
                { data: "passport_photo", render: function (data) {
                    if (!data) return '<img src="{{ asset('public/admin/assets/images/avator.png') }}" width="50" height="50">';
                    return '<img src="{{ asset('') }}' + data + '" width="50" height="50">';
                }}, 
                { 
                data: "id",
                render: function (data) {
                    return `
                    <button class="btn btn-primary text-white d-flex align-items-center open-modal-btn"
                            data-id="${data}"
                            data-toggle="modal"
                            data-target="#dynamicHRModal">
                        <span class="fa-solid fa-plus mr-2"></span>
                        <span class="m-0">Attachments</span>
                    </button>`;
                }
                },
                { data: "name" },
                { data: "email", render: function (data) {
                    return data ? '<a href="mailto:' + data + '">' + data + '</a>' : '';
                }},
                { data: "cnic" },
                { data: "application_date" },
                { data: "craft" },
                { data: "sub_craft" },
                { data: "approvals" },
                { data: "approvals_document", render: function (data) {
                    return data ? '<a href="{{ asset('') }}' + data + '" download>Download File</a>' : '';
                }},
                { data: "interview_location" },
                { data: "son_of" },
                { data: "mother_name" },
                { data: "date_of_birth" },
                { data: "cnic_expiry_date" },
                { data: "doi" },
                { data: "doe" },
                { data: "passport" },
                { data: "next_of_kin" },
                { data: "relation" },
                { data: "kin_cnic" },
                { data: "shoe_size" },
                { data: "cover_size" },
                { data: "acdemic_qualification" },
                { data: "technical_qualification" },
                { data: "experience_local", render: function (data) { return (data || 0) + ' Years'; }},
                { data: "experience_gulf", render: function (data) { return (data || 0) + ' Years'; }},
                { data: "district_of_domicile" },
                { data: "present_address" },
                { data: "present_address_phone" },
                { data: "present_address_mobile" },
                { data: "permanent_address" },
                { data: "present_address_city" },
                { data: "permanent_address_phone" },
                { data: "permanent_address_mobile" },
                { data: "gender" },
                { data: "blood_group" },
                { data: "religion" },
                { data: "permanent_address_city" },
                { data: "permanent_address_province" },
                { data: "citizenship" },
                { data: "refference" },
                { data: "performance_appraisal" },
                { data: "min_salary" },
                { data: "visa_type" },
                { data: "visa_status" },
                { data: "visa_issue_date" },
                { data: "visa_expiry_date" },
                { data: "flight_date" },
                { data: "flight_route" },
                { data: "cnic_taken_status" },
                { data: "passport_taken_status" },
                { data: "comment" },
                { data: "status", render: function (data) {
                    if (data == 1) return '<span class="badge badge-success">Pending</span>';
                    if (data == 2) return '<span class="badge badge-success">Approved</span>';
                    if (data == 0) return '<span class="badge badge-danger">Rejected</span>';
                    if (data == 3) return '<span class="badge badge-info">Assigned</span>';
                    return '';
                }},
                { data: "id", render: function (data, type, row) {
                    var buttons = '<div class="d-flex gap-4">';
                    @if ($canEdit)
                        buttons += '<a href="{{ url('admin/human-resource-edit') }}/' + data + '" class="btn btn-primary">Edit</a>';
                    @endif 
                    @if ($canDelete)
                        buttons += '<form action="{{ url('admin/human-resource') }}/' + data + '" method="POST" style="display:inline-block; margin-left: 10px">@csrf @method("DELETE")<button type="submit" class="btn btn-danger btn-flat show_confirm" data-toggle="tooltip">Delete</button></form>';
                    @endif
                    @if (!($canEdit || $canDelete))
                        buttons += '<div class="alert alert-danger text-center py-2" role="alert"><strong>Access Denied</strong></div>';
                    @endif
                    buttons += '</div>';
                    return buttons;
                }}
            ],
            drawCallback: function(settings) {
                var api = this.api();
                var total = settings.json ? settings.json.recordsFiltered : api.data().count();
                $('#total-count-badge').text('Total Count: ' + total);
            }
        });

        // Filter form submit
        $('#filter-form').on('submit', function(e) {
            e.preventDefault();
            const filters = [
                '#company_id',
                '#project_id',
                '#demand_id',
                '#medically_fit',
                '#cnic_expiry',
                '#passport_expiry',
                '#visa_expiry',
                '#date_from',
                '#date_to',
                '#visa_type',
                '#refference',
                '#flight_date',
                '#mobilized',
                '#cnic_taken',
                '#passport_taken',
                '#blood_group',
                '#religion',
                '#approvals',
                '#interview_location',
                '#craft',
            ];
            const hasAnyFilter = filters.some(sel => {
                const val = $(sel).val();
                return val !== null && val !== '' && val !== undefined;
            });
            if (!hasAnyFilter) {
                toastr.error('Please select at least one filter first');
                return;                            
            }
            toastr.success('Filter Applied Successfully');
            table.ajax.reload();
        });

        // Clear filter button
        $('#clear-filter-btn').on('click', function() {
            $('#company_id').val('');
            $('#project_id').val('');
            $('#demand_id').val('');
            $('#craft').val('');
            $('#medically_fit').val('');
            $('#cnic_expiry').val('');
            $('#passport_expiry').val('');
            $('#visa_expiry').val('');
            $('#date_from').val('');
            $('#date_to').val('');
            $('#visa_type').val('');
            $('#refference').val('');
            $('#flight_date').val('');
            $('#mobilized').val('');
            $('#cnic_taken').val('');
            $('#passport_taken').val('');
            $('#blood_group').val('');
            $('#religion').val('');
            $('#approvals').val('');
            $('#interview_location').val('');
            toastr.success('Filter Removed Successfully');
            table.ajax.reload();
        });

        
    });
</script>
<script>
    $(document).ready(function() {
        $('#company_id').on('change', function() {
            var companyId = $(this).val();

            if (companyId) {
                $('#project-group').removeClass('d-none');
                $('#demand-group').removeClass('d-none');
            } else {
                $('#project-group').addClass('d-none');
                $('#demand-group').addClass('d-none');
                $('#craft').closest('.col-md-4').removeClass('d-none');
                $('#sub_craft').closest('.col-md-4').removeClass('d-none');
            }

            // Reset dependent fields
            $('#project_id').empty().append(
                '<option value="" selected disabled>Select Project</option>');
            $('#demand_id').empty().append('<option value="" selected disabled>Select Demand</option>');
            $('#craft').empty().append('<option value="" selected disabled>Select Craft</option>');
            // $('#sub_craft').empty().append(
            //     '<option value="" selected disabled>Select Sub-Craft</option>');

            if (companyId) {
                $.ajax({
                    url: "{{ route('get-projects') }}",
                    type: "GET",
                    data: {
                        company_id: companyId
                    },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#project_id').append('<option value="' + value.id +
                                '">' + value.project_name + '</option>');
                        });
                    }
                });
            }
        });

        // When project is selected
        $('#project_id').on('change', function() {
            var projectId = $(this).val();

            $('#demand_id').empty().append('<option value="" selected disabled>Select Demand</option>');
            $('#craft').empty().append('<option value="" selected disabled>Select Craft</option>');
            $('#sub_craft').empty().append(
                '<option value="" selected disabled>Select Sub-Craft</option>');

            if (projectId) {
                $.ajax({
                    url: "{{ route('get-demand') }}",
                    type: "GET",
                    data: {
                        project_id: projectId
                    },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            $('#demand_id').append('<option value="' + value.id +
                                '">Man Power - ' + value.full_name + '</option>'
                            );
                        });
                    }
                });
            }
        });

        // When demand is selected
            $('#demand_id').on('change', function() {
                var demandId = $(this).val();

                $('#craft').empty().append('<option value="" selected disabled>Select Craft</option>');

                if (demandId) {
                    $.ajax({
                        url: "{{ route('get-crafts-by-demand') }}",
                        type: "GET",
                        data: {
                            demand_id: demandId
                        },
                        success: function(data) {
                            if (data.length > 0) {
                                $.each(data, function(key, value) {
                                    $('#craft').append('<option value="' + value.id +
                                        '">' + value.name + '</option>');
                                });
                                // Automatically select the first craft
                                $('#craft').val(data[0].id).trigger('change');
                            }
                        }
                    });
                }
            });

         $('#importForm').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        // Disable button and show loader
        $('#importBtn').prop('disabled', true);
        $('#importBtn .default-text').addClass('d-none');
        $('#importBtn .loading-text').removeClass('d-none');

        $.ajax({
            url: "{{ url('admin/human-resource/import') }}",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (res) {
                toastr.success('Excel file imported successfully. The data is now being processed.');
            },
            error: function (xhr) {
                let message = 'Something went wrong.';
                if (xhr.responseJSON?.message) {
                    message = xhr.responseJSON.message;
                }
                toastr.error(message);
            },
            complete: function () {
                // Reset button
                $('#importBtn').prop('disabled', false);
                $('#importBtn .default-text').removeClass('d-none');
                $('#importBtn .loading-text').addClass('d-none');
                $('#importForm')[0].reset();
            }
        });
    });
    })
    $(document).on('click', '.open-modal-btn', function () {
        var hrId = $(this).data('id');
            $('#dynamic-modal-content').html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');

            $.ajax({
                url: "{{ route('hr.modal.content') }}", // Define this route
                type: 'GET',
                data: { id: hrId },
                success: function (response) {
                    $('#dynamic-modal-content').html(response);
                },
                error: function (xhr, status, error) {
                console.error('AJAX Error:', {
                    status: status,
                    error: error,
                    response: xhr.responseText
                });

                $('#dynamic-modal-content').html('<p class="text-danger text-center">Failed to load content.</p>');
                }
            });
        });

</script>
<script src="https://kit.fontawesome.com/78f80335ec.js" crossorigin="anonymous"></script>
@endsection