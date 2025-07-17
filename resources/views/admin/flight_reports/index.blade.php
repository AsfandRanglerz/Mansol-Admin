@extends('admin.layout.app')
@section('title', 'Flight Reports')
@section('content')
    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Flight Reports</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                <form method="GET" id="filter-form" class="row g-3 mt-3">
                                    {{-- Flight Date --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="flight_date">Flight Date</label>
                                            <input type="date" name="flight_date" id="flight_date" class="form-control"
                                                value="{{ request('flight_date') }}">
                                        </div>
                                    </div>

                                    {{-- Buttons --}}
                                    <div class="col-md-3 d-flex align-items-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                                            <button type="button" id="clear-filter-btn"
                                                class="btn btn-secondary">Clear</button>
                                            <button type="button" id="export-excel-btn" class="btn btn-success">Export to
                                                Excel</button>
                                        </div>
                                    </div>
                                </form>

                                <table class="table" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Name</th>
                                            <th>Approved For Craft</th>
                                            <th>Passport</th>
                                            <th>Flight Route</th>
                                            <th>Flight Date</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
            const table = $('#table_id_events').DataTable({
                processing: true,
                serverSide: false,
                dom: 'Bfrtip', // Important to show buttons
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'Flight Reports',
                    text: 'Export to Excel',
                    className: 'd-none', // Hide default button
                }],
                ajax: {
                    url: "{{ route('flight-reports.ajax') }}",
                    dataSrc: 'data',
                    data: function(d) {
                        d.flight_date = $('#flight_date').val();
                    }
                },
                columns: [{
                        data: 'sr'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'approved_for_craft'
                    },
                    {
                        data: 'passport'
                    },
                    {
                        data: 'flight_route'
                    },
                    {
                        data: 'flight_date'
                    }
                ]
            });

            // Trigger hidden button on your custom click
            $('#export-excel-btn').on('click', function() {
                table.button('.buttons-excel').trigger();
            });


            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            $('#clear-filter-btn').on('click', function() {
                $('#flight_date').val('');
                table.ajax.reload();
            });
        });
    </script>
@endsection
