@extends('admin.layout.app')
@section('title', 'Assigned Resources')
@section('content')
    <style>
        .select2-container {
            display: block;
        }
    </style>
    {{-- Demand Create Model --}}
    <div class="modal fade" id="assignNominiModal" tabindex="-1" role="dialog" aria-labelledby="demandModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="demandModalLabel">Assign Human Resource</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="assignNominiForm" action="{{ route('nominate.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <input type="hidden" id="demand_id" name="demand_id" value="{{ $demand_id }}">
                            <input type="hidden" id="craft_id" name="craft_id" value="{{ $craft_id }}">
                            <input type="hidden" id="project_id" name="project_id" value="{{ $project_id }}">

                            <div class="col">
                                <div class="form-group">
                                    <label for="hr_id">Human Resource</label>
                                    <select name="human_resource_id[]" class="form-control select2" multiple>
                                        @foreach ($humanRecources as $humanRecource)
                                            <option value="{{ $humanRecource->id }}">{{ $humanRecource->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn btn-primary" onclick="submitDemandForm()">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>{{ $company->name }} - {{ $project->project_name }} - (Assigned)</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                {{-- <a class="btn btn-primary mb-3 text-white" data-toggle="modal"
                                    data-target="#assignNominiModal">
                                    Assign
                                </a> --}}
                                <table class="table responsive" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Name</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($nominates as $nominate)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $nominate->humanResource->name }}</td>
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
