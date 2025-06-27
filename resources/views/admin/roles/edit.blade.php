@extends('admin.layout.app')
@section('title', 'Edit Role')
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
                <form id="edit_role" action="{{ route('roles.update', $role->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <h4 class="text-center my-4">Edit Role</h4>
                                <div class="row mx-0 px-4">
                                    <!-- Role Name -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="title">Role Name <span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control"
                                                placeholder="Enter Role Name" value="{{ old('title', $role->title) }}"
                                                disabled>
                                            @error('title')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div class="col-sm-6">
                                        <div class="form-group mb-2">
                                            <label for="status">Status <span class="text-danger">*</span></label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="" disabled>Select an Option</option>
                                                <option value="1"
                                                    {{ old('status', $role->status) == 1 ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="0"
                                                    {{ old('status', $role->status) == 0 ? 'selected' : '' }}>DeActive
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Permissions -->
                                    <div class="col-12">
                                        <div class="form-group mb-2">
                                            <label>Permissions</label>
                                            <div class="permissions-container">
                                                @foreach ($permissions as $permission)
                                                    <div class="form-check">
                                                        <input type="checkbox" name="permissions[]"
                                                            value="{{ $permission->id }}"
                                                            id="permission_{{ $permission->id }}"
                                                            class="permission-checkbox"
                                                            data-permission-id="{{ $permission->id }}"
                                                            {{ in_array($permission->id, array_column($assignedPermissions, 'id')) ? 'checked' : '' }}>
                                                        <label class="form-check-label main-permission"
                                                            for="permission_{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>

                                                    <!-- Sub-permissions -->
                                                    <div id="sub_permissions_{{ $permission->id }}"
                                                        class="sub-permissions {{ in_array($permission->id, array_column($assignedPermissions, 'id')) ? '' : 'd-none' }}">
                                                        @foreach (['view', 'create', 'edit', 'delete'] as $action)
                                                            <div class="form-check">
                                                                <input type="checkbox"
                                                                    id="sub_permission_{{ $permission->id }}_{{ $action }}"
                                                                    name="sub_permissions[{{ $permission->id }}][]"
                                                                    value="{{ $action }}"
                                                                    @if (in_array($permission->id, array_column($assignedPermissions, 'id')) &&
                                                                            collect($assignedPermissions)->where('id', $permission->id)->where('subPermissionName', $action)->isNotEmpty()) checked @endif>
                                                                <label class="form-check-label"
                                                                    for="sub_permission_{{ $permission->id }}_{{ $action }}">{{ ucfirst($action) }}</label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('permissions')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary">Update</button>
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
    <script>
        $(document).ready(function() {
            // Toggle sub-permissions on main permission checkbox change
            $('.permission-checkbox').on('change', function() {
                const permissionId = $(this).data('permission-id');
                const $subPermissions = $('#sub_permissions_' + permissionId);

                if ($(this).is(':checked')) {
                    // Enable sub-permissions if main permission is checked
                    $subPermissions
                        .removeClass('d-none')
                        .find('input[type="checkbox"]')
                        .prop('disabled', false);
                } else {
                    // Disable sub-permissions if main permission is unchecked
                    $subPermissions
                        .addClass('d-none')
                        .find('input[type="checkbox"]')
                        .prop('disabled', true);
                }
            });

            // Initialize state for pre-checked permissions
            $('.permission-checkbox').each(function() {
                const permissionId = $(this).data('permission-id');
                const $subPermissions = $('#sub_permissions_' + permissionId);

                if ($(this).is(':checked')) {
                    // Show and enable sub-permissions for pre-checked main permissions
                    $subPermissions
                        .removeClass('d-none')
                        .find('input[type="checkbox"]')
                        .prop('disabled', false);
                } else {
                    // Hide and disable sub-permissions for unchecked main permissions
                    $subPermissions
                        .addClass('d-none')
                        .find('input[type="checkbox"]')
                        .prop('disabled', true);
                }
            });
        });
    </script>
@endsection
