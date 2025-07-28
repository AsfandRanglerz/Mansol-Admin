@extends('admin.layout.app')
@section('title', 'Project Reports')
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
        .spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

    </style>
    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Project Reports</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                {{-- Filter Form --}}
                                <form action="{{ route('project-reports.index') }}" method="GET" class="row g-3 mt-3"
                                    id="filter-form">
                                    {{-- Company --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="" for="company_id">Company</label>
                                            <select name="company_id" id="company_id" class="form-control">
                                                <option value="" disabled selected>Select Company</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}"
                                                        {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                                        {{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Project --}}
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="" for="project_id">Project</label>
                                            <select name="project_id" id="project_id" class="form-control">
                                                <option value="" selected disabled>Select Project</option>
                                                @foreach ($projects as $project)
                                                    @if (request('company_id') && $project->company_id == request('company_id'))
                                                        <option value="{{ $project->id }}"
                                                            {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                                            {{ $project->project_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('project_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 d-flex align-items-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary mr-2 mb-0">Apply Filters</button>
                                            <button type="button" id="clear-filter-btn"
                                                class="btn btn-secondary mr-2 mb-0">Clear</button>
                                        </div>
                                    </div>


                                    {{-- Demand --}}
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="" for="demand_id">Demand</label>
                                            <select name="demand_id" id="demand_id" class="form-control">
                                                <option value="" selected disabled>Select Demand</option>

                                                @foreach ($demands as $demand)
                                                    @if (request('project_id') && $demand->project_id == request('project_id'))
                                                        <option value="{{ $demand->id }}"
                                                            {{ request('demand_id') == $demand->id ? 'selected' : '' }}>
                                                            {{ $demand->full_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>

                                            @error('demand_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div> --}}

                                    {{-- Crafts --}}
                                    {{-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="craft" class="form-label">Craft</label>
                                            <select name="craft" id="craft" class="form-control">
                                                <option value="">Select Craft</option>
                                                @foreach ($crafts as $data)
                                                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> --}}

                                    {{-- Filter Button --}}
                                    {{-- <div class="col-md-12 d-flex justify-content-end align-items-end mb-3">
                                        
                                    </div> --}}

                                </form>
                                <div class="table-responsive">
                                    <table class="table responsive table-bordered w-100" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Project</th>
                                            <th>Craft</th>
                                            <th>Demand</th>
                                            <th>Assigned</th>
                                            <th>Medical Fit</th>
                                            <th>Medical Repeat</th>
                                            <th>Medical Unfit</th>
                                            <th>Visa Received</th>
                                            <th>Mobilized</th>
                                            {{-- <th scope="col">Actions</th> --}}
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
            // Initialize DataTable once globally
            let table = $('#table_id_events').DataTable({
                processing: true,
                serverSide: false,
                searching: true,
                paging: true,
                scrollX: true,
                responsive: false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'excelHtml5',
                    title: 'MANSOLSOFT - PROJECTS REPORT',
                    text: 'Generate Excel Report',
                    className: 'btn-export-excel', // hide built-in button
                    exportOptions: {
                        columns: ':not(.noExport)'
                    }
                },
                {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':not(.noExport)' // Exclude columns with this class
                        },
                        pageSize: 'A4', // Portrait by default
                        className: 'btn-export-pdf',
                        title: 'MANSOLSOFT - PROJECTS REPORT',
                        text: 'Generate PDF Report',

                        // Export all rows (not just visible)
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

                                        // Delay reset for button state after generation
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
                            // Add logo + title (left-aligned)
                            // 1. Add Logo at Top
                                    doc.content.splice(0, 0, {
                                        image: logoBase64,
                                        width: 150,
                                        alignment: 'center',
                                        margin: [0, 0, 0, 10]
                                    });


                            // Make table fit width nicely
                            doc.styles.tableHeader.fontSize = 9;
                            doc.styles.tableHeader.alignment = 'center';
                            doc.defaultStyle.fontSize = 8;
                            doc.pageMargins = [20, 40, 20, 30];

                            // Stretch table to full width
                            const table = doc.content.find(el => el.table);
                            if (table) {
                                table.layout = {
                                    hLineWidth: () => 0.5,
                                    vLineWidth: () => 0.5,
                                    hLineColor: () => '#aaa',
                                    vLineColor: () => '#aaa',
                                    paddingLeft: () => 4,
                                    paddingRight: () => 4,
                                    paddingTop: () => 2,
                                    paddingBottom: () => 2
                                };
                                table.widths = '*'.repeat(table.table.body[0].length).split('').map(() => '*');
                            }
                        }
                }

                ],
                ajax: {
                    url: "{{ route('project-reports.ajax') }}",
                    data: function(d) {
                        d.company_id = $('#company_id').val();
                        d.project_id = $('#project_id').val();
                    }, 
                    dataSrc: function(json) {
                        if (!$('#company_id').val() && !$('#project_id').val()) {
                            return [];
                        }
                        return json.data;
                    },
                    error: function(xhr, error, thrown) {
                        console.error('AJAX Error:', xhr.responseText);
                        alert("AJAX load failed. Check console or Laravel logs.");
                    }
                },
               columns: [
                { data: 'sr', name: 'sr', orderable: false, searchable: false },
                { data: 'project', name: 'project' },
                { data: 'craft', name: 'craft' },
                { data: 'requirements', name: 'requirements' },
                { data: 'selected', name: 'selected' },
                { data: 'fit', name: 'fit' },
                { data: 'repeat', name: 'repeat' },
                { data: 'unfit', name: 'unfit' },
                { data: 'visa_received', name: 'visa_received' },
                { data: 'mobilized', name: 'mobilized' }
            ]
            });

            // Export to Excel button click
            $('#export-excel-btn').click(function() {
                table.button('.buttons-excel').trigger();
            });


            // Apply filter
            $('#filter-form').on('submit', function(e) {
                e.preventDefault();
                if (!$('#company_id').val() && !$('#project_id').val()) {
                    toastr.error("Please select at least one filter");
                    return;
                }
                toastr.success('Filters Applied Sucessfully');
                table.ajax.reload();
            });

            // Load project on company change
            $('#company_id').on('change', function() {
                let companyId = $(this).val();
                $('#project_id').html('<option value="" selected disabled>Select Project</option>');
                if (companyId) {
                    $.get("{{ route('projects-get') }}", {
                        company_id: companyId
                    }, function(data) {
                        data.forEach(project => {
                            $('#project_id').append(
                                `<option value="${project.id}">${project.project_name}</option>`
                            );
                        });
                    });
                } 
            });

            // Clear filters
            $('#clear-filter-btn').click(function() {
                $('#company_id').val('');
                $('#project_id').html('<option value="" selected disabled>Select Project</option>');
                table.clear().draw();
                toastr.success('Filters Cleared Successfully');
                table.ajax.reload();
            });
        });
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
