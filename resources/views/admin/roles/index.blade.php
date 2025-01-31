@extends('admin.layout.app')
@section('title', 'Roles')
@section('content')
    {{-- <div class="modal fade" id="createSubadminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    <form id="createSubadminForm" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" id="draft_id" name="draft_id">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Active Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Permissions</label>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft">Roles</label>
                                        </div>
                                        <div class="d-flex w-100 mb-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="add"
                                                    name="permissions[]" value="Add">
                                                <label class="form-check-label" for="add">Add</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="update"
                                                    name="permissions[]" value="Update">
                                                <label class="form-check-label" for="update">Update</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="delete"
                                                    name="permissions[]" value="Delete">
                                                <label class="form-check-label" for="delete">Delete</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="view"
                                                    name="permissions[]" value="View">
                                                <label class="form-check-label" for="view">View</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft">Sub Admins</label>
                                        </div>
                                        <div class="d-flex w-100 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="add"
                                                name="permissions[]" value="Add">
                                            <label class="form-check-label" for="add">Add</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update"
                                                name="permissions[]" value="Update">
                                            <label class="form-check-label" for="update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete"
                                                name="permissions[]" value="Delete">
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="view"
                                                name="permissions[]" value="View">
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft">Main Craft</label>
                                        </div>
                                        <div class="d-flex w-100 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="add"
                                                name="permissions[]" value="Add">
                                            <label class="form-check-label" for="add">Add</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update"
                                                name="permissions[]" value="Update">
                                            <label class="form-check-label" for="update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete"
                                                name="permissions[]" value="Delete">
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="view"
                                                name="permissions[]" value="View">
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft">Sub Craft</label>
                                        </div>
                                        <div class="d-flex w-100 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="add"
                                                name="permissions[]" value="Add">
                                            <label class="form-check-label" for="add">Add</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update"
                                                name="permissions[]" value="Update">
                                            <label class="form-check-label" for="update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete"
                                                name="permissions[]" value="Delete">
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="view"
                                                name="permissions[]" value="View">
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft"> Human Resources</label>
                                        </div>
                                        <div class="d-flex w-100 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="add"
                                                name="permissions[]" value="Add">
                                            <label class="form-check-label" for="add">Add</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update"
                                                name="permissions[]" value="Update">
                                            <label class="form-check-label" for="update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete"
                                                name="permissions[]" value="Delete">
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="view"
                                                name="permissions[]" value="View">
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft">Companies</label>
                                        </div>
                                        <div class="d-flex w-100 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="add"
                                                name="permissions[]" value="Add">
                                            <label class="form-check-label" for="add">Add</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update"
                                                name="permissions[]" value="Update">
                                            <label class="form-check-label" for="update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete"
                                                name="permissions[]" value="Delete">
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="view"
                                                name="permissions[]" value="View">
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft">Projects</label>
                                        </div>
                                        <div class="d-flex w-100 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="add"
                                                name="permissions[]" value="Add">
                                            <label class="form-check-label" for="add">Add</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update"
                                                name="permissions[]" value="Update">
                                            <label class="form-check-label" for="update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete"
                                                name="permissions[]" value="Delete">
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="view"
                                                name="permissions[]" value="View">
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft">Demands</label>
                                        </div>
                                        <div class="d-flex w-100 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="add"
                                                name="permissions[]" value="Add">
                                            <label class="form-check-label" for="add">Add</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update"
                                                name="permissions[]" value="Update">
                                            <label class="form-check-label" for="update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete"
                                                name="permissions[]" value="Delete">
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="view"
                                                name="permissions[]" value="View">
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft">Nominations</label>
                                        </div>
                                        <div class="d-flex w-100 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="add"
                                                name="permissions[]" value="Add">
                                            <label class="form-check-label" for="add">Add</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update"
                                                name="permissions[]" value="Update">
                                            <label class="form-check-label" for="update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete"
                                                name="permissions[]" value="Delete">
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="view"
                                                name="permissions[]" value="View">
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft">Reports</label>
                                        </div>
                                        <div class="d-flex w-100 mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="add"
                                                name="permissions[]" value="Add">
                                            <label class="form-check-label" for="add">Add</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update"
                                                name="permissions[]" value="Update">
                                            <label class="form-check-label" for="update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete"
                                                name="permissions[]" value="Delete">
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="view"
                                                name="permissions[]" value="View">
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="mt-2 d-flex flex-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="main_craft"
                                                name="permissions[]" value="Main Craft">
                                            <label class="form-check-label font-weight-bold" for="main_craft">Notification</label>
                                        </div>
                                        <div class="d-flex w-100">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="add"
                                                name="permissions[]" value="Add">
                                            <label class="form-check-label" for="add">Add</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="update"
                                                name="permissions[]" value="Update">
                                            <label class="form-check-label" for="update">Update</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="delete"
                                                name="permissions[]" value="Delete">
                                            <label class="form-check-label" for="delete">Delete</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="view"
                                                name="permissions[]" value="View">
                                            <label class="form-check-label" for="view">View</label>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="pt-0 modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" onclick="submitSubadminForm()">Create</button>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Roles</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                <a class="btn btn-primary mb-3 text-white" href="{{ route('roles.create') }}">Add Role</a>
                                <table class="table responsive" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Name</th>
                                            <th>Permissions</th>
                                            <th>Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->title }}</td>
                                            <td><a href="{{ route('roles.edit', $role->id) }}"
                                                class="btn btn-primary">View</a></td>

                                            <td>
                                                @if ($role->status == 1)
                                                    <div class="badge badge-success badge-shadow">Activated</div>
                                                @else
                                                    <div class="badge badge-danger badge-shadow">Deactivated</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-4">
                                                    {{-- <a href="{{ route('roles.edit', $role->id) }}"
                                                        class="btn btn-primary" style="margin-left: 10px">Edit</a> --}}
                                                    <form action="{{ route('roles.destroy', $role->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
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
