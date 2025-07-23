@extends('admin.layout.app')
@section('title', 'Flight Reports')
@section('content')
<style> 
  .btn-export-excel {
                width: max-content;
        }
    .btn-export-pdf {
                width: max-content;
             background-color: #d5363c !important;
            color: white !important;
            border: none;
        }
</style>
    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12 d-flex justify-content-between align-items-center">
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
                                    <div class="col-md-6 d-flex flex-wrap align-items-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Apply Filter</button>
                                            <button type="button" id="clear-filter-btn"
                                                class="btn btn-secondary">Clear</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table responsive table-bordered w-100" id="table_id_events">
                                        <thead>
                                            <tr>
                                                <th>Sr.</th>
                                                <th>Name</th>
                                                <th>Craft</th>
                                                <th>Passport</th>
                                                <th>Passport Photo</th>
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
            </div>
        </section>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
             function toDataURL(url, callback) {
           var xhr = new XMLHttpRequest();
           xhr.onload = function () {
               var reader = new FileReader();
               reader.onloadend = function () {
                   callback(reader.result);
               }
               reader.readAsDataURL(xhr.response);
           };
           xhr.open('GET', url);
           xhr.responseType = 'blob';
           xhr.send();
           }
           const logoBase64 = "data:image/png;base64,{{ base64_encode(file_get_contents(public_path('admin/assets/images/mansol-01.png'))) }}";

           toDataURL("{{ asset('public/admin/assets/images/mansol-01.png') }}", function (logoBase64) {
               initDataTable(logoBase64);
           });
            const table = $('#table_id_events').DataTable({
                processing: true,
                serverSide: false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'MANSOLSOFT - FLIGHT REPORT',
                    text: 'Export to Excel',
                    className: 'btn-export-excel',
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':not(.noExport)' // Exclude columns with this class
                    },
                    pageSize: 'A4',
                    className: 'btn-export-pdf',
                    title: 'MANSOLSOFT - FLIGHT REPORT',
                    text: 'Generate PDF Report',

                    action: function (e, dt, button, config) {
                        var self = this;
                        var oldStart = dt.settings()[0]._iDisplayStart;

                        // Loader UI: Show spinner and disable button
                        const $btn = $('.btn-export-pdf');
                        $btn.prop('disabled', true).html(`
                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                            Generating...
                        `);

                        dt.one('preXhr', function (e, s, data) {
                            data.start = 0;
                            data.length = -1;

                            dt.one('preDraw', function (e, settings) {
                                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config);

                                dt.one('preXhr', function (e, s, data) {
                                    settings._iDisplayStart = oldStart;
                                    data.start = oldStart;
                                });

                                // Reset button after small delay
                                setTimeout(function () {
                                    dt.ajax.reload();
                                    $btn.prop('disabled', false).html('Generate PDF Report');
                                }, 1000);

                                return false;
                            });
                        });

                        dt.ajax.reload();
                    },

                    customize: function (doc) {
                        // 1. Add Logo at Top
                        doc.content.splice(0, 0, {
                            image: logoBase64,
                            width: 150,
                            alignment: 'center',
                            margin: [0, 0, 0, 10]
                        });

                        // 2. Find Table in PDF Content
                        let tableContent = doc.content.find(c => c.table);
                        if (!tableContent || !tableContent.table || !tableContent.table.body) {
                            console.error("Table not found in PDF content.");
                            return;
                        }

                        let body = tableContent.table.body;

                        // 3. Add Passport Photo Header at index 2
                        body[0].splice(2, 0, {
                            text: 'Passport Photo',
                            style: 'tableHeader',
                            alignment: 'center'
                        });

                        // 4. Insert Passport Photo and center all cells
                        for (let i = 1; i < body.length; i++) {
                            const rowData = table.row(i - 1).data();

                            if (rowData && rowData.passport_photo_base64) {
                                body[i].splice(2, 0, {
                                    image: rowData.passport_photo_base64,
                                    width: 40,
                                    height: 35,
                                    alignment: 'center'
                                });
                            } else {
                                body[i].splice(2, 0, { text: '', alignment: 'center' });
                            }

                            // Center all text values in this row
                            for (let j = 0; j < body[i].length; j++) {
                                if (typeof body[i][j] === 'object') {
                                    if (!body[i][j].alignment) {
                                        body[i][j].alignment = 'center';
                                    }
                                } else {
                                    body[i][j] = { text: body[i][j], alignment: 'center' };
                                }
                            }
                        }

                        // 5. Set table widths
                        const columnCount = body[0].length;
                        tableContent.table.widths = Array(columnCount).fill('*');
                        tableContent.layout = {
                            hLineWidth: () => 0.5,
                            vLineWidth: () => 0.5,
                            hLineColor: () => '#aaa',
                            vLineColor: () => '#aaa',
                            paddingLeft: () => 4,
                            paddingRight: () => 4,
                            paddingTop: () => 2,
                            paddingBottom: () => 2
                        };

                        // 6. Styling
                        doc.defaultStyle.fontSize = 8;
                        doc.styles.tableHeader.fontSize = 9;
                        doc.styles.tableHeader.alignment = 'center';
                        doc.pageMargins = [10, 10, 10, 20];
                    }
                }

                ],
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
                    { data: "passport_photo", render: function (data) {
                        if (!data) return '<img src="{{ asset('public/admin/assets/images/avator.png') }}" width="50" height="50">';
                        return '<img src="{{ asset('') }}' + data + '" width="50" height="50">';
                    }},
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
                toastr.success('Filter Applied Successfully');
                table.ajax.reload();
            });

            $('#clear-filter-btn').on('click', function() {
                $('#flight_date').val('');
                toastr.success('Filter Cleared Successfully');
                table.clear().draw();
                table.ajax.reload();
            });
        });

        function exportWithDate() {
            let date = $('#flight_date').val();
            let url = "{{ route('flight-reports.export') }}";
            if (date) {
                url += '?flight_date=' + date;
            }
            window.location.href = url;
        }
    </script>
@endsection
