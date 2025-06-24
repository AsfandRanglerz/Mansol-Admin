@extends('admin.layout.app')
@section('title', 'Create Role')
@section('content')

    <style>
        .permissions-container {
            display: flex;
            flex-direction: column;
        }

        .sub-permissions {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-left: 30px;
        }

        .form-check-label.main-permission {
            font-weight: bold;
        }

        .form-check {
            margin-bottom: 10px;
        }

        .d-none {
            display: none;
        }
    </style>

    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <a class="btn btn-primary mb-3" href="{{ url()->previous() }}">Back</a>
                <form id="add_department" action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <h4 class="text-center my-4">Add Role</h4>
                                <div class="row mx-0 px-4">
                                    <!-- Role Name -->
                                    <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                        <div class="form-group mb-2">
                                            <label for="title">Role Name <span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                placeholder="Enter Role Name" value="{{ old('title') }}" required>
                                        </div>
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                        <div class="form-group mb-2">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="" disabled selected>Select an Option</option>
                                                <option value="1" {{ old('status') == 1 ?: '' }}>Active</option>
                                                <option value="0" {{ old('status') == 0 ?: '' }}>DeActive</option>
                                            </select>
                                        </div>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Permissions -->
                                    <div class="col-sm-6 pl-sm-0 pr-sm-3">
                                        <div class="form-group mb-2">
                                            <label>Permissions <span class="text-danger">*</span></label>
                                            <div class="mt-2 permissions-container">
                                                @foreach ($permissions as $permission)
                                                    <div class="form-check">
                                                        <input class="permission-checkbox" type="checkbox"
                                                            id="permission_{{ $permission->id }}" name="permissions[]"
                                                            value="{{ $permission->id }}"
                                                            data-permission-id="{{ $permission->id }}"
                                                            {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label main-permission"
                                                            for="permission_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                    <!-- Sub-permissions -->
                                                    <div id="sub_permissions_{{ $permission->id }}"
                                                        class="sub-permissions d-none">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                id="sub_permission_{{ $permission->id }}_view"
                                                                name="sub_permissions[{{ $permission->id }}][]"
                                                                value="view"
                                                                {{ in_array('view', old('sub_permissions.' . $permission->id, [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="sub_permission_{{ $permission->id }}_view">View</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                id="sub_permission_{{ $permission->id }}_create"
                                                                name="sub_permissions[{{ $permission->id }}][]"
                                                                value="create"
                                                                {{ in_array('create', old('sub_permissions.' . $permission->id, [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="sub_permission_{{ $permission->id }}_create">Create</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                id="sub_permission_{{ $permission->id }}_edit"
                                                                name="sub_permissions[{{ $permission->id }}][]"
                                                                value="edit"
                                                                {{ in_array('edit', old('sub_permissions.' . $permission->id, [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="sub_permission_{{ $permission->id }}_edit">Edit</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                id="sub_permission_{{ $permission->id }}_delete"
                                                                name="sub_permissions[{{ $permission->id }}][]"
                                                                value="delete"
                                                                {{ in_array('delete', old('sub_permissions.' . $permission->id, [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="sub_permission_{{ $permission->id }}_delete">Delete</label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('permissions')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-1 btn-bg"
                                            id="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </section>
    </div>

@endsection

@section('js')
    @if (\Illuminate\Support\Facades\Session::has('message'))
        <script>
            toastr.success('{{ \Illuminate\Support\Facades\Session::get('message') }}');
        </script>
    @endif

    <script>
        $(document).ready(function() {
            // Toggle sub-permissions
            $('.permission-checkbox').on('change', function() {
                const permissionId = $(this).data('permission-id');
                const $subPermissions = $('#sub_permissions_' + permissionId);

                if ($(this).is(':checked')) {
                    $subPermissions.removeClass('d-none').find('input[type="checkbox"]').prop('disabled',
                        false);
                } else {
                    $subPermissions.addClass('d-none')
                        .find('input[type="checkbox"]')
                        .prop('checked', false)
                        .prop('disabled', true);
                }
            });

            // Initialize state for pre-checked permissions
            $('.permission-checkbox').each(function() {
                const permissionId = $(this).data('permission-id');
                const $subPermissions = $('#sub_permissions_' + permissionId);

                if ($(this).is(':checked')) {
                    $subPermissions.removeClass('d-none').find('input[type="checkbox"]').prop('disabled',
                        false);
                } else {
                    $subPermissions.addClass('d-none').find('input[type="checkbox"]').prop('disabled',
                    true);
                }
            });
        });
    </script>
@endsection
