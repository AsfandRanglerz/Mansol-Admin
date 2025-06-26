@extends('admin.layout.app')
@section('title', 'Notifications')
@section('content')

    <div class="modal fade" id="createSubadminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createSubadminForm" enctype="multipart/form-data">
                        <input type="hidden" name="target_ids_by_type" id="target_ids_by_type">

                        <div class="row">
                            <input type="hidden" id="draft_id" name="draft_id">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user_type">User Type</label>
                                    <select id="user_type" name="user_type" class="form-control">
                                        <option value="">Select Type</option>
                                        <option value="company">Company</option>
                                        <option value="human_resource">Human Resource</option>
                                    </select>

                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-md-12" id="target_container" style="display:none;">
                                <div class="form-group">
                                    <label for="target_ids">Select Recipients</label>

                                    <div class="form-check mb-2">
                                        <input type="checkbox" class="form-check-input" id="select_all_recipients"
                                            onchange="toggleSelectAllRecipients(this)">
                                        <label class="form-check-label" for="select_all_recipients">Select All
                                            Recipients</label>
                                    </div>

                                    <select name="target_ids[]" id="target_ids" class="form-control" multiple>
                                        {{-- Options will be loaded dynamically --}}
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email">Message</label>
                                    <textarea type="text" class="form-control" name="message"></textarea>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Create</button>
                </div>
            </div>
        </div>
    </div>

    @foreach ($notifications as $notification)
        <div class="modal fade" id="editCompanyModal-{{ $notification->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Notification</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="editForm-{{ $notification->id }}" enctype="multipart/form-data">
                            <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>User Type</label>
                                        <select name="user_type" class="form-control user_type_edit" required>
                                            <option value="">Select Type</option>
                                            <option value="company"
                                                {{ $notification->type === 'company' ? 'selected' : '' }}>Company</option>
                                            <option value="human_resource"
                                                {{ $notification->type === 'human_resource' ? 'selected' : '' }}>Human
                                                Resource</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Recipients</label>

                                        <div class="form-check mb-2">
                                            <input type="checkbox" class="form-check-input select-all-edit"
                                                data-target="#target_ids_edit_{{ $notification->id }}"
                                                id="select_all_recipients_edit_{{ $notification->id }}">
                                            <label class="form-check-label"
                                                for="select_all_recipients_edit_{{ $notification->id }}">Select All
                                                Recipients</label>
                                        </div>

                                        <select name="target_ids[]" id="target_ids_edit_{{ $notification->id }}"
                                            class="form-control target_ids_edit" multiple required>
                                            @if (str_contains($notification->type, 'company') || $notification->type === 'both')
                                                <optgroup label="Companies">
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company->id }}"
                                                            @if ($notification->targets->where('targetable_type', \App\Models\Company::class)->pluck('targetable_id')->contains($company->id)) selected @endif>
                                                            {{ $company->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endif

                                            @if (str_contains($notification->type, 'human_resource') || $notification->type === 'both')
                                                <optgroup label="Human Resources">
                                                    @foreach ($humanResources as $hr)
                                                        <option value="{{ $hr->id }}"
                                                            @if ($notification->targets->where('targetable_type', \App\Models\HumanResource::class)->pluck('targetable_id')->contains($hr->id)) selected @endif>
                                                            {{ $hr->name }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea name="message" class="form-control" required>{{ $notification->message }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-primary"
                            onclick="submitEditForm({{ $notification->id }})">Update</button>
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
                                <h4>Notifications</h4>
                            </div>
                        </div>

                        <div class="card-body">
                            <!-- Tabs -->
                            <ul class="nav nav-tabs mb-3" id="notificationTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="my-notifications-tab" data-toggle="tab"
                                       href="#my-notifications" role="tab">My Notifications</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="expiry-notifications-tab" data-toggle="tab"
                                       href="#expiry-notifications" role="tab">Document Expiry Notifications</a>
                                </li>
                            </ul>
                        

                            <!-- Tab Panes -->
                            <div class="tab-content" id="notificationTabContent">
                                <!-- My Notifications Tab -->
                                <div class="tab-pane fade show active" id="my-notifications" role="tabpanel"> 
                                @php
                                    $canCreate = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Notifications', 'create'));
                                        $canEdit = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Notifications', 'edit'));
                                        $canDelete = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Notifications', 'delete'));
                                @endphp
                                @if ($canCreate)
                                    <a class="btn btn-primary mb-3 text-white" data-toggle="modal"
                                       data-target="#createSubadminModal">
                                        Create
                                    </a>
                                @endif
                                    <div class="card-body table-striped table-bordered table-responsive">
                                        <table class="table responsive" id="table_id_events">
                                            <thead>
                                                <tr>
                                                    <th>Sr.</th>
                                                    <th>User Type</th>
                                                    <th>Name</th>
                                                    <th>Message</th>
                                                    <th scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($notifications as $index => $notification)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>
                                                            @if ($notification->type === 'both')
                                                                Company, Human Resource
                                                            @elseif ($notification->type === 'company')
                                                                Company
                                                            @elseif ($notification->type === 'human_resource')
                                                                Human Resource
                                                            @endif
                                                        </td>
                                                       <td
                                                            @php
                                                                $targets = $notification->targets;
                                                                $displayTargets = $targets->take(2);
                                                                $remainingCount = $targets->count() - $displayTargets->count();
                                                                $allTargetNames = $targets->pluck('targetable.name')->filter()->implode(', ');
                                                            @endphp
                                                            title="{{ $allTargetNames }}"
                                                        >
                                                            <ul class="list-unstyled mb-0">
                                                                @foreach ($displayTargets as $target)
                                                                    <li>{{ $target->targetable->name ?? 'N/A' }}</li>
                                                                @endforeach
                                                                @if ($remainingCount > 0)
                                                                    <li><span class="text-muted">+{{ $remainingCount }} more</span></li>
                                                                @endif
                                                            </ul>
                                                        </td>

                                                        <td>
                                                            @php
                                                                $words = explode(' ', $notification->message);
                                                                $shortMessage = implode(' ', array_slice($words, 0, 5));
                                                            @endphp
                                                            {{ $shortMessage }}@if (count($words) > 5)...@endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-center align-items-center" style="gap: 10px;">
                                                                {{-- <a class="btn btn-primary" data-toggle="modal"
                                                                   data-target="#editCompanyModal-{{ $notification->id }}">
                                                                    Edit
                                                                </a> --}}
                                                                @if ($canDelete)
                                                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-danger btn-flat show_confirm"
                                                                                data-toggle="tooltip">Delete</button>
                                                                    </form>
                                                                @else
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

                                <!-- Document Expiry Notifications Tab -->
                                <div class="tab-pane fade" id="expiry-notifications" role="tabpanel">
                                        <div class="d-flex">
                                            <a href="{{route('notifications.read.all')}}" class="btn btn-primary mb-3 text-white">Mark All As Read</a>
                                        </div>
                                    <div class="card-body table-striped table-bordered table-responsive mt-3">
                                        <table class="table responsive" id="table_id_expiry">
                                            <thead>
                                                <tr>
                                                    <th>Sr.</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Document Type</th>
                                                    <th>Expiry Date</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($expiryNotifications as $index => $item)
                                                    @foreach ($item->targets as $target)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $target->targetable->name ?? 'N/A' }}</td>
                                                            <td>
                                                                 <a href="mailto:{{ $target->targetable->email }}">{{ $target->targetable->email }}</a>
                                                            </td>
                                                            <td>{{ $item->document_type }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d M Y') }}</td>
                                                            <td>
                                                              @if($item->seen == 0)
                                                                    <a href="{{ route('notifications.read', $item->id) }}" class="btn btn-primary text-white">
                                                                        read</a>
                                                                @else
                                                                    <span class="badge bg-success text-white">Seen</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- /tab-content -->

                        </div> <!-- /card-body -->

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
            $('#table_id_expiry').DataTable();
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
    <script>
        $(document).ready(function() {
            $('#target_ids').select2({
                placeholder: "Select",
                width: '100%'
            });
        });
        $(document).ready(function() {
            $('#user_type').select2({
                placeholder: "Select Type",
                width: '100%'
            });
        });
    </script>
    <script>
        $('#user_type').on('change', function() {
            const selectedType = $(this).val();
            const $targetContainer = $('#target_container');
            const $targetSelect = $('#target_ids');

            if (!selectedType) {
                $targetContainer.hide();
                $targetSelect.empty();
                return;
            }

            // Show the target container
            $targetContainer.show();

            // Clear existing options
            $targetSelect.empty();

            // Load recipients via AJAX
            $.ajax({
                url: "{{ url('admin/fetch-recipients') }}",
                type: 'GET',
                data: {
                    type: selectedType // now just a single value
                },
                success: function(data) {
                    data.forEach(function(item) {
                        $targetSelect.append(
                            $('<option>', {
                                value: item.id,
                                text: item.name,
                                'data-type': item.type
                            })
                        );
                    });
                },
                error: function() {
                    alert('Failed to load recipients.');
                }
            });
        });

        function submitForm() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const selectedType = $('#user_type').val();
            const selectedIds = $('#target_ids').val() || [];

            const targetsByType = {
                [selectedType]: selectedIds
            };

            $('#target_ids_by_type').val(JSON.stringify(targetsByType));

            const formData = new FormData(document.getElementById('createSubadminForm'));

            $.ajax({
                url: "{{ route('notifications.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $('.btn-primary').attr('disabled', true).text('Submitting...');
                },
                success: function() {
                    toastr.success('Notification Sent Successfully');
                    location.reload();
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    if (response && response.errors) {
                        for (const [key, messages] of Object.entries(response.errors)) {
                            $(`[name="${key}"]`).addClass('is-invalid')
                                .siblings('.invalid-feedback').text(messages[0]).show();
                        }
                    } else {
                        alert('Failed to send notification.');
                    }
                    console.log(xhr.responseText);
                },
                complete: function() {
                    $('.btn-primary').attr('disabled', false).text('Create');
                }
            });
        }

        function toggleSelectAllRecipients(checkbox) {
            const isChecked = checkbox.checked;
            $('#target_ids option').prop('selected', isChecked);
            $('#target_ids').trigger('change');
        }
    </script>


    <script>
        function submitEditForm(id) {
            let form = document.getElementById(`editForm-${id}`);
            let formData = new FormData();

            let message = form.querySelector('textarea[name="message"]').value;
            formData.append('_method', 'PUT');
            formData.append('message', message);

            let userType = form.querySelector('select[name="user_type"]').value;
            formData.append('user_type', userType);


            let targetSelect = form.querySelector('select[name="target_ids[]"]');
            if (targetSelect) {
                Array.from(targetSelect.selectedOptions).forEach(option => {
                    formData.append('target_ids[]', option.value);
                });
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $.ajax({
                url: "{{ route('notifications.update', ':id') }}".replace(':id', id),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $(`#editCompanyModal-${id} .btn-primary`).prop('disabled', true).text('Updating...');
                },
                success: function(res) {
                    // alert(res.message);
                    location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = Object.values(errors).map(arr => arr.join(', ')).join('\n');
                        alert('Validation error:\n' + errorMessages);
                    } else {
                        alert('Update failed: ' + xhr.status);
                    }
                    console.error(xhr.responseText);
                },
                complete: function() {
                    $(`#editCompanyModal-${id} .btn-primary`).prop('disabled', false).text('Update');
                }
            });
        }

        // Initialize select2 in all modals
        $(document).ready(function() {
            $('.target_ids_edit').select2({
                placeholder: 'Select Recipients',
                width: '100%'
            });
            $('.user_type_edit').select2({
                placeholder: 'Select Type',
                width: '100%',
                minimumResultsForSearch: Infinity // disables search for only 2 options
            });

        });

        $(document).on('change', '.select-all-edit', function() {
            const targetSelect = $($(this).data('target'));
            const isChecked = $(this).is(':checked');
            targetSelect.find('option').prop('selected', isChecked);
            targetSelect.trigger('change');
        });

        $(document).on('change', '.target_ids_edit', function() {
            const select = $(this);
            const allOptions = select.find('option');
            const selectedOptions = select.find('option:selected');
            const relatedCheckbox = select.closest('.form-group').find('.select-all-edit');

            if (allOptions.length === selectedOptions.length) {
                relatedCheckbox.prop('checked', true);
            } else {
                relatedCheckbox.prop('checked', false);
            }
        });
    </script>


@endsection
