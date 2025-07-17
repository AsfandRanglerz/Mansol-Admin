@extends('admin.layout.app')
@section('title', 'Flight Reports')
@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Flight Reports</h4>
                            </div>
                            <div class="card-body table-responsive">
                                <form method="GET" id="filter-form" class="row g-3">
                                    {{-- Flight Date --}}
                                    <div class="col-md-3">
                                        <label for="flight_date">Flight Date</label>
                                        <input type="date" name="flight_date" id="flight_date" class="form-control"
                                            value="{{ request('flight_date') }}">
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
    $(document).ready(function () {
        const table = $('#table_id_events').DataTable({
            processing: true,
            serverSide: false,
            ajax: {
                url: "{{ route('flight-reports.ajax') }}",
                dataSrc: 'data',
                data: function (d) {
                    d.flight_date = $('#flight_date').val();
                }
            },
            columns: [
                { data: 'sr' },
                { data: 'name' },
                { data: 'approved_for_craft' },
                { data: 'passport' },
                { data: 'flight_route' },
                { data: 'flight_date' }
            ]
        });

        $('#filter-form').on('submit', function (e) {
            e.preventDefault();
            table.ajax.reload();
        });

        $('#clear-filter-btn').on('click', function () {
            $('#flight_date').val('');
            table.ajax.reload();
        });

        $('#export-excel-btn').on('click', function () {
            table.button('.buttons-excel').trigger();
        });
    });
</script>
@endsection

