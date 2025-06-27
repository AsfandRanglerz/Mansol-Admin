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
                                    <h6 class="badge bg-primary text-white">Total Count: {{ $count }}</h6>
                                    <h6 class="text-muted text-danger" style="font-style: italic;">
                                            Note: The default password for all human resources is <strong>12345678</strong>. This password is automatically generated when a new human resource created.
                                    </h6>
                                </div>
                            </div>
                                <div class="card-body table-striped table-bordered table-responsive">
                                     {{-- Filter Form --}}
                                        <form action="" method="GET" class="row g-3 mt-3">
                                            {{-- Company --}}
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                <label class="text-danger" for="company_id">Company</label>
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
                                                <label class="text-danger" for="project_id">Project</label>
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
                                                <label class="text-danger" for="demand_id">Demand</label>
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

                                            {{-- CNCC Expiry Date --}}
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
                                                <label for="passport_expiry" class="form-label">Passport Expiry Date</label>
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
                                                <label for="visa_expiry" class="form-label">Visa Expiry Date</label>
                                                <select name="visa_expiry" id="visa_expiry" class="form-control">
                                                        <option value="">Select Status</option>
                                                        <option value="Valid" {{ request('visa_expiry') == 'Valid' ? 'selected' : '' }}>Valid</option>
                                                        <option value="Expired" {{ request('visa_expiry') == 'Expired' ? 'selected' : '' }}>Expire</option>
                                                    </select>
                                            </div>
                                            </div>

                                            {{-- Filter Button --}}
                                            <div class="col-md-3 d-flex align-items-center">
                                                <div class="row w-100">
                                                    <div class="col-6 pr-1">
                                                        <button type="submit" class="btn btn-primary" style="width:max-content">Apply Filter</button>
                                                    </div>
                                                    <div class="col-6 pl-1">
                                                        <a href="{{ route('humanresource.index') }}" class="btn btn-secondary w-100">Clear Filter</a>
                                                    </div>
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
                                        <form action="{{ url('admin/human-resource/import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center gap-2">
                                            @csrf
                                            <input type="file" name="file" required class="form-control">
                                            <button type="submit" class="btn btn-success ml-3">Import</button>
                                        </form>
                                    </div>

                                <table class="table responsive" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th class="noExport">Sr.</th>
                                            <th>Id No.</th>
                                            <th class="noExport">Photo</th>
                                            <th class="noExport">Documents</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>CNIC</th>
                                            <th>Application Date</th>
                                            <th>Appication for Post Craft</th>
                                            <th>Sub-Craft</th>
                                            <th>Approvals #</th>
                                            <th class="noExport">Approvals Document</th>
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
                                            <th>Phone</th>
                                            <th>Mobile</th>
                                            <th>Permanent Address</th>
                                            <th>Present Address City</th>
                                            <th>Permanent Address</th>
                                            <th>Phone</th>
                                            <th>Mobile</th>
                                            <th>Gender</th>
                                            <th>Permanent Address City</th>
                                            <th>Permanent Address Province</th>
                                            <th>Citizenship</th>
                                            <th>Refference</th>
                                            <th>Performance-Appraisal Awarded %</th>
                                            <th>Min Acceptable Salary</th>
                                            <th>Comment</th>
                                            <th>Status</th>
                                            <th scope="col" class="noExport">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($HumanResources as $HumanResource)
                                        <tr>
                                            <td class="noExport">{{ $loop->iteration }}</td>
                                            <td>{{ $HumanResource->registration ?? 'null' }}</td>
                                              @php
                                                    $step4 = $HumanResource->hrSteps->firstWhere('step_number', 4);
                                                @endphp

                                                <td class="noExport">
                                                    <img src="{{ $step4 ? asset($step4->file_name) : asset('public/admin/assets/images/avator.png') }}" 
                                                        alt="Step 4 Image" width="50" height="50">
                                                </td>
                                            <td class="noExport">
                                                <button data-toggle="modal"    data-target="#createHRModal-{{ $HumanResource->id }}"
                                                    class="btn btn-primary text-white d-flex align-items-center"
                                                    href="{{ route('humanresource.index') }}">
                                                    <span class="fa-solid fa-plus mr-2"></span>
                                                    <p class="m-0 text-white">Attachments</p>
                                                </button>
                                            </td>
                                            <td>{{ $HumanResource->name ?? 'null' }}</td>
                                            <td>
                                            @if(!empty($HumanResource->email))
                                                <a href="mailto:{{ $HumanResource->email }}">{{ $HumanResource->email }}</a>
                                            @else
                                                null
                                            @endif
                                        </td>

                                            <td>{{ $HumanResource->cnic ?? 'null' }}</td>
                                            <td>{{ $HumanResource->application_date ?? 'null' }}</td>
                                            <td>
                                                {{ $HumanResource->Crafts->name ?? 'null' }}
                                            </td>
                                            <td>
                                                {{ $HumanResource->SubCrafts->name ?? 'null' }}
                                            </td>
                                            <td>{{ $HumanResource->approvals ?? 'null' }}</td>
                                            <td class="noExport">
                                                @if ($HumanResource->medical_doc)
                                                    <a href="{{ asset($HumanResource->medical_doc) }}" download>Download File</a>
                                                @endif
                                            </td>
                                            <td>{{ $HumanResource->son_of ?? 'null' }}</td>
                                            <td>{{ $HumanResource->mother_name ?? 'null' }}</td>
                                            <td>{{ $HumanResource->date_of_birth ?? 'null' }}</td>
                                            <td>{{ $HumanResource->cnic_expiry_date ?? 'null' }}</td>
                                            <td>{{ $HumanResource->doi ?? 'null' }}</td>
                                            <td>{{ $HumanResource->doe ?? 'null' }}</td>
                                            <td>{{ $HumanResource->passport ?? 'null' }}</td>
                                            <td>{{ $HumanResource->next_of_kin ?? 'null' }}</td>
                                            <td>{{ $HumanResource->relation ?? 'null' }}</td>
                                            <td>{{ $HumanResource->kin_cnic ?? 'null' }}</td>
                                            <td>{{ $HumanResource->shoe_size ?? 'null' }}</td>
                                            <td>{{ $HumanResource->cover_size ?? 'null' }}</td>
                                            <td>{{ $HumanResource->acdemic_qualification ?? 'null' }}</td>
                                            <td>{{ $HumanResource->technical_qualification ?? 'null' }}</td>
                                            <td>{{ $HumanResource->experience_local ?? 0 }} Years</td>
                                            <td>{{ $HumanResource->experience_gulf ?? 0 }} Years</td>
                                            <td>{{ $HumanResource->district_of_domicile ?? 'null' }}</td>
                                            <td>{{ $HumanResource->present_address ?? 'null' }}</td>
                                            <td>{{ $HumanResource->present_address_phone ?? 'null' }}</td>
                                            <td>{{ $HumanResource->present_address_mobile ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address ?? 'null' }}</td>
                                            <td>{{ $HumanResource->present_address_city ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address_phone ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address_mobile ?? 'null' }}</td>
                                            <td>{{ $HumanResource->gender ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address_city ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address_province ?? 'null' }}</td>
                                            <td>{{ $HumanResource->citizenship ?? 'null' }}</td>
                                            <td>{{ $HumanResource->refference ?? 'null' }}</td>
                                            <td>{{ $HumanResource->performance_appraisal ?? 'null' }}</td>
                                            <td>{{ $HumanResource->min_salary ?? 'null' }}</td>
                                            <td>{{ $HumanResource->comment ?? 'null' }}</td>

                                            <td>
                                                @if ($HumanResource->status == 1)
                                                    <div class="badge badge-success badge-shadow">Pending</div>
                                                @elseif ($HumanResource->status == 2)
                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                @elseif ($HumanResource->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Rejected</div>
                                                @elseif ($HumanResource->status == 3)
                                                    <div class="badge badge-info badge-shadow">Assigned</div>
                                                @endif
                                            </td>
                                            <td class="noExport">
                                                <div class="d-flex gap-4">
                                                    @if ($canEdit)
                                                        <a href="{{ route('humanresource.edit', $HumanResource->id) }}"
                                                            class="btn btn-primary">Edit</a>
                                                    @endif
                                                    @if ($canDelete)
                                                        <form action="{{ route('humanresource.destroy', $HumanResource->id) }}"
                                                            method="POST" style="display:inline-block; margin-left: 10px">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-flat show_confirm"
                                                                data-toggle="tooltip">Delete</button>
                                                        </form>
                                                    @endif
                                                    @if(!($canEdit || $canDelete))
                                                            <div class="alert alert-danger text-center py-2" role="alert">
                                                                <strong>Access Denied</strong>
                                                            </div>
                                                     @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
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
            event.preventDefault(); // prevent default button action first
            var form = $(this).closest("form");
            var name = $(this).data("name");

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
    });
    </script>
    <script>
        $(document).ready(function() {
            var table = $('#table_id_events').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':not(.noExport)' // Exclude columns with 'noExport' class
                        }
                    },
                   {
                extend: 'print',
                exportOptions: {
                    columns: ':not(.noExport)'
                },
                className: 'custom-red-btn',
                text: 'PDF' // Renamed button label
                }
                ],
                scrollX: true,
                responsive: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#table_id_events').DataTable();
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
                $('#sub_craft').empty().append(
                    '<option value="" selected disabled>Select Sub-Craft</option>');

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
        })
    </script>
    
    <script src="https://kit.fontawesome.com/78f80335ec.js" crossorigin="anonymous"></script>
@endsection
