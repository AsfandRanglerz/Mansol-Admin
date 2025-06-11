@extends('admin.layout.app')
@section('title', 'Notification')
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
                        <div class="row">
                            <input type="hidden" id="draft_id" name="draft_id">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="user_type">User Type</label>
                                    <select name="user_type[]" id="user_type" class="form-control" multiple required>
                                        <option value="company">Company</option>
                                        <option value="human_resource">Human Resource</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>

                            <div class="col-md-12" id="target_container" style="display:none;">
                                <div class="form-group">
                                    <label for="target_ids">Select Recipients</label>
                                    <select name="target_ids[]" id="target_ids" class="form-control" multiple>
                                        {{-- Options will be loaded dynamically --}}
                                    </select>
                                    <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</small>
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
                                        <select name="user_type[]" class="form-control user_type_edit" multiple required>
                                            <option value="company"
                                                {{ str_contains($notification->type, 'company') ? 'selected' : '' }}>Company
                                            </option>
                                            <option value="human_resource"
                                                {{ str_contains($notification->type, 'human_resource') ? 'selected' : '' }}>
                                                Human Resource</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Recipients</label>
                                        <select name="target_ids[]" class="form-control target_ids_edit" multiple required>
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
                                    <h4>Notifcation</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                <a class="btn btn-primary mb-3 text-white" data-toggle="modal"
                                    data-target="#createSubadminModal">
                                    Create
                                </a>
                                <table class="table text-center" id="table_id_events">
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
                                                <td>
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach ($notification->targets as $target)
                                                            <li>{{ $target->targetable->name ?? 'N/A' }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{{ $notification->message }}</td>
                                                <td>
                                                    <div class="d-flex gap-4">
                                                        <a class="btn btn-primary" data-toggle="modal"
                                                            data-target="#editCompanyModal-{{ $notification->id }}">
                                                            Edit
                                                        </a>
                                                        <form
                                                            action="{{ route('notifications.destroy', $notification->id) }}"
                                                            method="POST">
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

            if (!selectedType) return;

            // Show the container
            $targetContainer.show();

            // Clear existing options
            $targetSelect.empty();

            // Load data from route
            $.ajax({
                url: "{{ url('admin/fetch-recipients') }}",
                type: 'GET',
                data: {
                    types: selectedType
                },
                success: function(data) {
                    data.forEach(function(item) {
                        $targetSelect.append(new Option(item.name, item.id));
                    });
                },
                error: function() {
                    alert('Failed to load recipients.');
                }
            });
        });

        function submitForm() {
            // Add CSRF token to header
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            let formData = new FormData(document.getElementById('createSubadminForm'));

            $.ajax({
                url: "{{ route('notifications.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    // Optional: Disable button to prevent multiple clicks
                    $('.btn-primary').attr('disabled', true).text('Submitting...');
                },
                success: function(res) {
                    alert(res.message);
                    location.reload();
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;

                    if (response && response.errors) {
                        // Show validation errors
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
                    // Re-enable button
                    $('.btn-primary').attr('disabled', false).text('Create');
                }
            });
        }
    </script>

    <script>
        function submitEditForm(id) {
            let form = document.getElementById(`editForm-${id}`);
            let formData = new FormData();

            let message = form.querySelector('textarea[name="message"]').value;
            formData.append('_method', 'PUT');
            formData.append('message', message);

            let userTypeSelect = form.querySelector('select[name="user_type[]"]');
            if (userTypeSelect) {
                Array.from(userTypeSelect.selectedOptions).forEach(option => {
                    formData.append('user_type[]', option.value);
                });
            }

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
                    alert(res.message);
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
                width: '100%'
            });
        });
    </script>


@endsection
