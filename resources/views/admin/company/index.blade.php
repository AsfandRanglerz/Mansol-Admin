@extends('admin.layout.app')

@section('title', 'Companies')

@section('content')



    {{-- Create Company Model --}}

    <div class="modal fade" id="createCompanyModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"

        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="createModalLabel">Add Company</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                        <span aria-hidden="true">&times;</span>

                    </button>

                </div>

                <div class="modal-body">

                    <form enctype="multipart/form-data" action="{{ route('companies.store') }}" method="POST">

                        @csrf

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="name">Name <span class="text-danger">*</span></label>

                                    <input type="text" class="form-control" id="name" name="name" required>

                                    <div class="invalid-feedback"></div>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="phone">Phone Number</label>

                                    <input type="tel" class="form-control" id="phone" name="phone">

                                    <div class="invalid-feedback"></div>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="email">Email <span class="text-danger">*</span></label>

                                    <input type="email" class="form-control" id="email" name="email" required>

                                    <div class="invalid-feedback"></div>

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="status">Active Status <span class="text-danger">*</span></label>

                                    <select name="status" class="form-control">

                                        <option value="" disabled selected>Select Status</option>

                                        <option value="1">Active</option>

                                        <option value="0">Deactive</option>

                                    </select>

                                    <div class="invalid-feedback"></div>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                    <label for="image">Profile Image</label>

                                    <!-- <input type="file" class="form-control" id="image" name="image"> -->
                                    <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png">

                                    <div class="invalid-feedback"></div>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer justify-content-center">

                            <button type="submit" class="btn btn-primary">Create</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>





    {{-- Edit Company Model --}}

    @foreach ($companies as $company)

        <div class="modal fade" id="editCompanyModal-{{ $company->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"

            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title" id="editModalLabel">Edit Company</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                            <span aria-hidden="true">&times;</span>

                        </button>

                    </div>

                    <div class="modal-body">

                        <form enctype="multipart/form-data" action="{{ route('company.update', $company->id) }}" method="POST">

                            @csrf

                            @method('POST')

                            <div class="row">

                                <input type="hidden" name="id" value="{{ $company->id ?? '' }}">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="name">Name <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" id="name" name="name" value="{{ $company->name }}">

                                        <div class="invalid-feedback"></div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="phone">Phone Number</label>

                                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ $company->phone }}">

                                        <div class="invalid-feedback"></div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="email">Email <span class="text-danger">*</span></label>

                                        <input type="email" class="form-control" value="{{ $company->email }}" readonly>

                                        <div class="invalid-feedback"></div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="status">Active Status <span class="text-danger">*</span></label>

                                        <select name="status" class="form-control">

                                            @if ($company->is_active == 1)

                                                <option value="1">Active</option>

                                                <option value="0">Deactive</option>

                                            @else

                                                <option value="0">Deactive</option>

                                                <option value="1">Active</option>

                                            @endif

                                        </select>

                                        <div class="invalid-feedback"></div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="image">Profile Image</label>

                                        <input type="file" class="form-control" id="image" name="image">

                                        <div class="invalid-feedback"></div>

                                    </div>

                                </div>

                            </div>

                            <div class="modal-footer justify-content-center">

                                <button type="submit" class="btn btn-primary">Update</button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    @endforeach





    <div class="main-content" style="min-height: 562px;">

        <section class="section">

            <div class="section-body">

                <div class="row">

                    <div class="col-12 col-md-12 col-lg-12">

                        <div class="card">

                            <div class="card-header">

                                <div class="col-12">
{{-- {{ session('message') }} --}}
                                    <h4>Companies</h4>
                                          <h6 class="text-muted text-danger" style="font-style: italic;">
                                            Note: The default password for all companies is <strong>12345678</strong>. This password is automatically generated when a new company created.
                                          </h6>
                                </div>

                            </div>

                            <div class="card-body table-striped table-bordered table-responsive">

                                 @php
                                    $canCreate = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Companies', 'create'));
                                        $canEdit = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Companies', 'edit'));
                                        $canDelete = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Companies', 'delete'));
                                        $canViewProject = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Projects', 'view'));
                                @endphp
                                @if ($canCreate)
                                <a class="btn btn-primary mb-3 text-white" data-toggle="modal"

                                    data-target="#createCompanyModal">

                                    Add Company
                                </a>
                                @endif
                                <table class="table responsive" id="table_id_events">
                                    {{-- @if ($errors->any())
                                        <div class="">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li class="text-danger">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif --}}

                                    <thead>

                                        <tr>

                                            <th>Sr.</th>

                                            <th>Name</th>

                                            <th>Profile Image</th>

                                            <th>Email</th>

                                            <th>Projects</th>

                                            <th>Status</th>

                                            <th scope="col">Actions</th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach ($companies as $company)   

                                        <tr>

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $company->name }}</td>
                                            <td>
                                            <img src="{{ asset($company->image ?? 'public/admin/assets/images/avator.png') }}"
                                                onerror="this.onerror=null;this.src='{{ asset('public/admin/assets/images/avator.png') }}';"
                                                alt="Company Image"
                                                width="50"
                                                height="50">
                                        </td>


                                           

                                           <td>
                                            @if(!empty($company->email))
                                                <a href="mailto:{{ $company->email }}">{{ $company->email }}</a>
                                            @else
                                                null
                                            @endif
                                        </td>

                                                    

                                            <td>
                                                @if ($canViewProject)
                                                    <a href="{{ route('project.index', $company->id) }}" class="btn btn-primary">
                                                        View</a>
                                                @else
                                                    <div class="alert alert-danger text-center py-2" role="alert">
                                                        <strong>Access Denied</strong>
                                                    </div>
                                                @endif
                                                
                                                </td>

                                                    <td>

                                                        @if ($company->is_active == 1)

                                                            <div class="badge badge-success badge-shadow">Activated</div>

                                                        @else

                                                            <div class="badge badge-danger badge-shadow">Deactivated</div>

                                                        @endif

                                                    </td>
                                                    
                                                    <td>
                                                        @if ($canEdit)
                                                        <a href="#" class="btn btn-primary" data-toggle="modal"
                                                        data-target="#editCompanyModal-{{ $company->id }}">Edit</a>
                                                        @endif
                                                        @if ($canDelete)
                                                        <form action="{{ route('company.destroy', $company->id) }}" method="POST" style="display: inline-block;">

                                                            @csrf

                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-danger show_confirm">Delete</button>

                                                        </form>                   
                                                        @endif
                                                      
                                                        @if(!($canEdit || $canDelete))
                                                            <div class="alert alert-danger text-center py-2" role="alert">
                                                                <strong>Access Denied</strong>
                                                            </div>
                                                        @endif
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



@endsection



@section('js')

    

    <script>

        $(document).ready(function() {

            $('#table_id_events').DataTable();



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

