@extends('admin.layout.app')
@section('title', 'Projects')
@section('content')

    {{-- Project Create Modle --}}
    <div class="modal fade" id="createProjectModel" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createSubadminForm" enctype="multipart/form-data" action="{{ route('project.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <div class="col-md-4">
                            <div class="row form-group">
                                <label class="text-danger" for="is_ongoing">Is It On Going Project?</label>
                                <input class="form-check ml-4" type="checkbox" id="is_ongoing" name="is_ongoing" value="unchecked" onchange="this.value = this.checked ? 'checked' : 'unchecked'">
                                @error('is_ongoing')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" id="draft_id" name="draft_id">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_code">Project Code</label>
                                    <input type="number" class="form-control" id="project_code" name="project_code" value="{{ $registration }}" readonly>
                                    @error('project_code')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_name">Project Name</label>
                                    <input type="text" class="form-control" id="project_name" name="project_name">
                                    @error('project_name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>
                        
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="client_id">Select Client</label>
                                    <select name="client_id" class="form-control" id="client_id">
                                        <option value="1">Select Client</option>
                                    </select>
                                    @error('client_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="manpower_location">Man-Power Location City</label>
                                    <select name="manpower_location" id="manpower_location" class="form-control">
                                        <option value="" selected disabled>Select City</option>
                                        <option value="lahore">Lahore</option>
                                        <option value="karachi">Karachi</option>
                                        <option value="islamabad">Islamabad</option>
                                    </select>
                                    @error('manpower_location')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_location">Project Location</label>
                                    <select name="project_location" class="form-control" id="project_location">
                                        <option value="" selected disabled>Select Location City</option>
                                        <option value="lahore">Lahore</option>
                                        <option value="karachi">Karachi</option>
                                        <option value="islamabad">Islamabad</option>
                                    </select>
                                    @error('project_location')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_start_date">Project Start Date</label>
                                    <input type="date" class="form-control" id="project_start_date" name="project_start_date">
                                    @error('project_start_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_end_date">Project End Date</label>
                                    <input type="date" class="form-control" id="project_end_date" name="project_end_date">
                                    @error('project_end_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="permission">Permission #</label>
                                    <input type="text" class="form-control" id="permission" name="permission">
                                    @error('permission')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="permission_date">Permission Date</label>
                                    <input type="date" class="form-control" id="permission_date" name="permission_date">
                                    @error('permission_date')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_currency">Project Currency</label>
                                    <select name="project_currency" class="form-control" id="project_currency">
                                        <option value="" selected disabled>Select Currency</option>
                                        <option value="$">$</option>
                                        <option value="pkr">PKR</option>
                                    </select>
                                    @error('project_currency')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="is_active">Status</label>
                                    <select name="is_active" class="form-control" id="is_active">
                                        <option value="1">Active</option>
                                        <option value="0">Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="additional_notes">Any Additional Project Notes</label>
                                    <textarea class="form-control" id="additional_notes" name="additional_notes"></textarea>
                                </div>
                            </div>
                            <div class="col-md-8 mt-4">
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <label class="text-danger" for="poa_received">Power-of-Attorney received?</label>
                                        <input class="form-check ml-4" type="checkbox" id="poa_received"
                                        name="poa_received" value="unchecked" onchange="this.value = this.checked ? 'checked' : 'unchecked'">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <label class="text-danger" for="demand_letter_received">Demand Letter Received?</label>
                                        <input class="form-check ml-4" type="checkbox" id="demand_letter_received"
                                            name="demand_letter_received" value="unchecked" 
                                            onchange="this.value = this.checked ? 'checked' : 'unchecked'">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <label class="text-danger" for="permission_letter_received">Permission Letter Received</label>
                                        <input class="form-check ml-4" type="checkbox" id="permission_letter_received"
                                            name="permission_letter_received" value="unchecked" 
                                            onchange="this.value = this.checked ? 'checked' : 'unchecked'">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary" onclick="submitSubadminForm()">Create</button>
                        </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Project Edit Modle --}}
    @foreach ($projects as $project)
    <div class="modal fade" id="editProjectModal-{{ $project->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createSubadminForm" enctype="multipart/form-data" action="{{ route('project.update', $project->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                        <div class="col-md-4">
                            <div class="row form-group">
                                <label class="text-danger" for="is_ongoing">Is It On Going Project?</label>
                                <input class="form-check ml-4" type="checkbox" id="is_ongoing" name="is_ongoing" value="{{ $project->is_ongoing }}" 
                                    onchange="this.value = this.checked ? 'checked' : 'unchecked'"
                                    {{ $project->is_ongoing === 'checked' ? 'checked' : '' }}>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" id="draft_id" name="draft_id" value="{{ $project->draft_id }}">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_code">Project Code</label>
                                    <input type="text" class="form-control" id="project_code" name="project_code" value="{{ $project->project_code }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_name">Project Name</label>
                                    <input type="text" class="form-control" id="project_name" name="project_name" value="{{ $project->project_name }}">
                                </div>
                            </div>
                        
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="client_id">Select Client</label>
                                    <select name="client_id" class="form-control" id="client_id">
                                        <option value="1" {{ $project->client_id == 1 ? 'selected' : '' }}>Select Client</option>
                                        <!-- Add other client options here -->
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="manpower_location">Man-Power Location City</label>
                                    <input type="text" class="form-control" id="manpower_location" name="manpower_location" value="{{ $project->manpower_location }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_location">Project Location</label>
                                    <select name="project_location" class="form-control" id="project_location">
                                        <option value="{{ $project->project_location }}" selected>{{ $project->project_location }}</option>
                                        <!-- Add other project location options here -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_start_date">Project Start Date</label>
                                    <input type="date" class="form-control" id="project_start_date" name="project_start_date" value="{{ $project->project_start_date ? $project->project_start_date->format('Y-m-d') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_end_date">Project End Date</label>
                                    <input type="date" class="form-control" id="project_start_date" name="project_start_date" value="{{ $project->project_end_date ? $project->project_end_date->format('Y-m-d') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="permission">Permission #</label>
                                    <input type="text" class="form-control" id="permission" name="permission" value="{{ $project->permission }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="permission_date">Permission Date</label>
                                    <input type="date" class="form-control" id="permission_date" name="permission_date" value="{{ $project->permission_date ? $project->permission_date->format('Y-m-d') : '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="project_currency">Project Currency</label>
                                    <select name="project_currency" class="form-control" id="project_currency">
                                        <option value="$" {{ $project->project_currency == '$' ? 'selected' : '' }}>Select Currency</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="is_active">Status</label>
                                    <select name="is_active" class="form-control" id="is_active">
                                        <option value="1" {{ $project->is_active == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $project->is_active == 0 ? 'selected' : '' }}>Deactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-danger" for="additional_notes">Any Additional Project Notes</label>
                                    <textarea class="form-control" id="additional_notes" name="additional_notes">{{ $project->additional_notes }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-8 mt-4">
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <label class="text-danger" for="poa_received">Power-of-Attorney received?</label>
                                        <input class="form-check ml-4" type="checkbox" id="poa_received" name="poa_received" 
                                            value="{{ $project->poa_received }}" onchange="this.value = this.checked ? 'checked' : 'unchecked'"
                                            {{ $project->poa_received === 'checked' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <label class="text-danger" for="demand_letter_received">Demand Letter Received?</label>
                                        <input class="form-check ml-4" type="checkbox" id="demand_letter_received" name="demand_letter_received" 
                                            value="{{ $project->demand_letter_received }}" onchange="this.value = this.checked ? 'checked' : 'unchecked'"
                                            {{ $project->demand_letter_received === 'checked' ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row form-group">
                                        <label class="text-danger" for="permission_letter_received">Permission Letter Received</label>
                                        <input class="form-check ml-4" type="checkbox" id="permission_letter_received" name="permission_letter_received" 
                                            value="{{ $project->permission_letter_received }}" onchange="this.value = this.checked ? 'checked' : 'unchecked'"
                                            {{ $project->permission_letter_received === 'checked' ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary" onclick="submitSubadminForm()">Update</button>
                        </div>
                            </div>
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
                        <a class="btn btn-primary mb-3 text-white" href="{{ route('companies.index') }}">
                            Back
                        </a>
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>{{ $company_name }} - Projects</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                <a class="btn btn-primary mb-3 text-white" data-toggle="modal"
                                    data-target="#createProjectModel">
                                    Add Project
                                </a>
                                <table class="table responsive" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Project Code</th>
                                            <th>Project Name</th>
                                            <th>Demands</th>
                                            <th>Man-Power Location City</th>
                                            <th>Project Location</th>
                                            <th>Project Start Date</th>
                                            <th>Project End Date</th>
                                            <th>Permission #</th>
                                            <th>Permission Date</th>
                                            <th>Project Currency</th>
                                            <th>On Going?</th>
                                            <th>Power-of-Attorney received?</th>
                                            <th>Demand Letter Received?</th>
                                            <th>Permission Letter Received</th>
                                            <th>Additional Project Notes</th>
                                            <th>Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $project)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $project->project_code }}</td>
                                            <td>{{ $project->project_name }}</td>
                                            <td><a href="{{ route('demands.index', $project->id) }}" class="btn btn-primary">
                                                View</a></td>
                                            <td>{{ $project->manpower_location }}</td>
                                            <td>{{ $project->project_location }}</td>
                                            <td>{{ $project->project_start_date->format('Y-m-d') }}</td>
                                            <td>{{ $project->project_end_date ? $project->project_end_date->format('Y-m-d') : 'N/A' }}</td>
                                            <td>{{ $project->permission }}</td>
                                            <td>{{ $project->permission_date ? $project->permission_date->format('Y-m-d') : 'N/A' }}</td>
                                            <td>{{ strtoupper($project->project_currency) }}</td>
                                            <td>{{ $project->is_ongoing == 'checked' ? 'Yes' : 'No' }}</td>
                                            <td>{{ $project->poa_received == 'checked' ? 'Yes' : 'No' }}</td>
                                            <td>{{ $project->demand_letter_received == 'checked' ? 'Yes' : 'No' }}</td>
                                            <td>{{ $project->permission_letter_received == 'checked' ? 'Yes' : 'No' }}</td>
                                            <td>{{ $project->additional_notes }}</td>
                                            
                                            <td>
                                                @if ($project->is_active == 1)
                                                    <div class="badge badge-success badge-shadow">Activated</div>
                                                @else
                                                    <div class="badge badge-danger badge-shadow">Deactivated</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-4">
                                                    <a href="#" class="btn btn-success" data-toggle="modal"
                                                        data-target="#editProjectModal-{{ $project->id }}">Edit</a>
                                                    <form action="{{ route('project.destroy', $project->id) }}"
                                                        method="POST" style="display:inline-block; margin-left: 10px">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="hidden" name="company_id" value="{{ $company_id }}">
                                                        <button type="submit"
                                                            class="btn btn-danger btn-flat show_confirm"
                                                            data-toggle="tooltip">Delete</button>
                                                    </form>
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
