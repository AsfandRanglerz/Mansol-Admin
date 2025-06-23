@extends('companypanel.layout.app')
@section('title', 'Projects')
@section('content')

    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Projects</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">

                                <table class="table responsive" id="table_id_events">
                                    <thead>
                                        <tr> 
                                            <th>Sr.</th>
                                            <th>Project Code</th>
                                            <th>Project Name</th>
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
                                            <th>Demands</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($projects as $project)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $project->project_code }}</td>
                                            <td>{{ $project->project_name }}</td>
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
                                                    <a href="
                                                    {{ route('companydemands.index', $project->id) }}
                                                     " class="btn btn-primary">View</a>
                                                </td>
                                                <td> @if ($project->is_active == 1)
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
