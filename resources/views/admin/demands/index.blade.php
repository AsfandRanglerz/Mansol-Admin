@extends('admin.layout.app')
@section('title', 'Demands')
@section('content')

    {{-- Demand Create Model --}}
    <div class="modal fade" id="createDemandModal" tabindex="-1" role="dialog" aria-labelledby="demandModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demandModalLabel">Create Demands</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createDemandForm" action="{{ route('demand.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="draft_id" name="draft_id">
                                <input type="hidden" id="project_id" name="project_id" value="{{ $project_id }}">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="craft_id">Select Craft</label>
                                    <select name="craft_id" class="form-control">
                                        <option value="" selected disabled>Select Craft <span class="text-danger">*</span></option>
                                        @foreach ($crafts as $craft)
                                            <option value="{{ $craft->id }}">{{ $craft->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="manpower">Manpower <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="manpower" name="manpower" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="salary">Salary <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="salary" name="salary">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobilization">Mobilization <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="mobilization" name="mobilization" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="demobilization">Demobilization <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="demobilization" name="demobilization" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="confirmpassword">Status <span class="text-danger">*</span></label>
                                    <select name="is_active" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary" onclick="submitDemandForm()">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @foreach ($demands as $demand) 
    {{-- Demand Edit Model --}}
    <div class="modal fade" id="editDemandModal-{{ $demand->id }}" tabindex="-1" role="dialog" aria-labelledby="demandModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demandModalLabel">Create Demands</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editDemandForm" action="{{ route('demand.update', $demand->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <input type="hidden" id="draft_id" name="draft_id">
                            <input type="hidden" id="project_id" name="project_id" value="{{ $demand->project->id }}">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="craft_id">Select Craft</label>
                                    <select name="craft_id" class="form-control">
                                        @foreach ($crafts as $craft)
                                        <option value="{{ $craft->id }}" 
                                            {{ $demand->craft && $demand->craft->id == $craft->id ? 'selected' : '' }}>
                                            {{ $craft->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="manpower">Manpower <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="manpower" name="manpower" value="{{ $demand->manpower }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="salary">Salary <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="salary" name="salary"  value="{{ $demand->salary }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobilization">Mobilization <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="mobilization" name="mobilization"  value="{{ $demand->mobilization }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="demobilization">Demobilization <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="demobilization" name="demobilization"  value="{{ $demand->demobilization }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_active">Status <span class="text-danger">*</span></label>
                                    <select name="is_active" class="form-control">
                                        @if ($demand->is_active == 0)
                                            <option value="1">Deactive</option>
                                            <option value="0">Active</option>
                                        @else
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        @endif
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary" onclick="editDemandForm()">Update</button>
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
                                    <h4>{{ $company->name }} - {{ $project->project_name }} - (Demands)</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">         
                                @php
                                    $canCreate = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Demands', 'create'));
                                        $canEdit = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Demands', 'edit'));
                                        $canDelete = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Demands', 'delete'));
                                @endphp
                                @if ($canCreate)
                                <a class="btn btn-primary mb-3 text-white" data-toggle="modal"
                                    data-target="#createDemandModal">
                                    Add Demand
                                </a>
                                @endif
                                <table class="table responsive" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Craft</th>
                                            <th>Assigned Resources</th>
                                            <th>Man Power</th>
                                            <th>Salary</th>
                                            <th>Mobilization</th>
                                            <th>Demobilization</th>
                                            <th>Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($demands as $demand)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $demand->craft->name }}</td>
                                                <td>
                                                    <a class="btn btn-primary" href="{{ route('nominate.index', ['craft_id' => $demand->craft->id, 'demand_id' => $demand->id, 'project_id' => $project->id]) }}">View</a>
                                                </td>
                                                <td>{{ $demand->manpower }}</td>
                                                <td>{{ $demand->salary }} {{ strtoupper($demand->project->project_currency) }}</td>
                                                <td>{{ $demand->mobilization }}</td>
                                                <td>{{ $demand->demobilization }}</td>
                                                <td>
                                                    @if ($demand->is_active == 1)
                                                        <div class="badge badge-success badge-shadow">Activated</div>
                                                    @else
                                                        <div class="badge badge-danger badge-shadow">Deactivated</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-4">
                                                        @if ($canEdit)
                                                            <a href="#" class="btn btn-primary mr-2" data-toggle="modal"
                                                            data-target="#editDemandModal-{{ $demand->id }}">Edit</a>
                                                        @endif
                                                        @if ($canDelete)
                                                            <form action="{{ route('demand.destroy', $demand->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden"  name="project_id" value="{{ $demand->project->id }}">
                                                                <button type="submit" class="btn btn-danger show_confirm">Delete</button>
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
