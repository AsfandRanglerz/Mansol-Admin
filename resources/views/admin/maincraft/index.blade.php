@extends('admin.layout.app')
@section('title', 'Main Crafts')
@section('content')
    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Main Crafts</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                 @php
                                    $canCreate = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Main Crafts', 'create'));
                                        $canEdit = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Main Crafts', 'edit'));
                                        $canDelete = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Main Crafts', 'delete'));
                                        $canViewSub = Auth::guard('admin')->check() || 
                                        (Auth::guard('subadmin')->check() && \App\Models\SubAdmin::hasSpecificPermission(Auth::guard('subadmin')->id(), 'Sub Crafts', 'view'));
                                @endphp
                                @if ($canCreate)
                                <a class="btn btn-primary mb-3 text-white" href="{{ route('maincraft.create') }}">Add Craft</a>
                                @endif
                                <table class="table responsive" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Main Craft Name</th>
                                            <th>Sub Craft</th>
                                            <th>Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mainCrafts as $mainCraft)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $mainCraft->name }}</td>
                                            <td>
                                                @if ($canViewSub)
                                                    <a href="{{ route('subcraft.index', $mainCraft->id) }}"
                                                    class="btn btn-primary" style="margin-left: 10px">View</a>
                                                @else
                                                    <div class="alert alert-danger text-center py-2" role="alert">
                                                        <strong>Access Denied</strong>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($mainCraft->status == 1)
                                                    <div class="badge badge-success badge-shadow">Activated</div>
                                                @else
                                                    <div class="badge badge-danger badge-shadow">Deactivated</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-4">
                                                    @if ($canEdit)
                                                        <a href="{{ route('maincraft.edit', $mainCraft->id) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    @endif
                                                    @if ($canDelete)
                                                        <form action="{{ route('maincraft.destroy', $mainCraft->id) }}"
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
