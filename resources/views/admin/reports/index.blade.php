@extends('admin.layout.app')
@section('title', 'Reports')
@section('content')

    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Reports</h4>
                                </div>
                            </div>
                            <div class="row col-12 mt-3 d-flex justify-content-center">
                                <div class="form-group col-sm-12 mb-2 d-flex align-items-start">
                                    <button class="btn btn-danger" id="filterButton" onclick="clearFilters()">Clear
                                        Filters</button>
                                        <form action="{{ url('admin/human-resource/import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="file" name="file" required>
                                            <button type="submit" class="btn btn-success">Import</button>
                                        </form>
                                </div>
                                <div class="form-group col-sm-3 mb-2">
                                    <label for="periodSelect">Select Companies</label>
                                    <select id="periodSelect" class="form-control" onchange="loadData()">
                                  <option value="" selected disabled>Select Companies</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 mb-2">
                                    <label for="periodSelect">Select Projects</label>
                                    <select id="periodSelect" class="form-control" onchange="loadData()">
                                  <option value="" selected disabled>Select Projects</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 mb-2">
                                    <label for="periodSelect">Select Demands</label>
                                    <select id="periodSelect" class="form-control" onchange="loadData()">
                                  <option value="" selected disabled>Select Demands</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 mb-2">
                                    <label for="periodSelect">Select Nominations</label>
                                    <select id="periodSelect" class="form-control" onchange="loadData()">
                                  <option value="" selected disabled>Select Nominations</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                <table class="table text-center" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Companies</th>
                                            <th>Projects</th>
                                            <th>Demands</th>
                                            <th>Nominations</th>
                                            <th>Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
