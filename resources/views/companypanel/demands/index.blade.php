@extends('companypanel.layout.app')
@section('title', 'Demands')
@section('content')

    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>{{ $project->project_name }} - (Demands)</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">

                                <table class="table responsive" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Craft</th>
                                            <th>Man Power</th>
                                            <th>Salary</th>
                                            <th>Mobilization</th>
                                            <th>Demobilization</th>
                                            <th>Nominees</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($demands as $demand)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $demand->craft->name }} </td>
                                                <td>{{ $demand->manpower }} </td>
                                                <td>{{ $demand->salary }} {{ strtoupper($demand->project->project_currency) }} </td>
                                                <td>{{ $demand->mobilization }} </td>
                                                <td>{{ $demand->demobilization }} </td>
                                                <td>
                                                    <a href="
                                                    {{ route('companynominees.index', $demand->id) }}
                                                     " class="btn btn-primary">View</a>
                                                </td>
                                                <td> 
                                                    @if ($demand->is_active == 1)
                                                    <div class="badge badge-success badge-shadow">Activated</div>
                                                    @else
                                                        <div class="badge badge-danger badge-shadow">Deactivated</div>
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
