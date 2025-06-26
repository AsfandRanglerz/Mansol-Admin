@extends('admin.layout.app')
@section('title', 'Approved Applicants')
@section('content')

    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12">
                                    <h4>Approved Applicants</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">

                                <table class="table responsive" id="table_id_events">
                                    <thead>
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Id No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>CNIC/NICOP</th>
                                            <th>Application Date</th>
                                            <th>Appication for Post Craft</th>
                                            <th>Sub-Craft</th>
                                            <th>Approvals #</th>
                                            <th>S/O</th>
                                            <th>Mother Name</th>
                                            <th>Date Of Birth</th>
                                            <th>CNIC/NICOP Expiry Date</th>
                                            <th>DOI</th>
                                            <th>DOE</th>
                                            <th>Passport #</th>
                                            <th>Next Of Kin</th>
                                            <th>Relation</th>
                                            <th>Kin CNIC</th>
                                            <th>Shoe Size</th>
                                            <th>Cover Size</th>
                                            <th>Academic Qualification</th>
                                            <th>Technical Qualification</th>
                                            <th>Profession</th>
                                            <th>District Of Domicile</th>
                                            <th>Present Address</th>
                                            <th>Phone</th>
                                            <th>Mobile</th>
                                            <th>Permanent Address</th>
                                            <th>Present Address City</th>
                                            <th>Permanent Address</th>
                                            <th>Phone</th>
                                            <th>Mobile</th>
                                            <th>Gender</th>
                                            <th>Permanent Address City</th>
                                            <th>Permanent Address Province</th>
                                            <th>Citizenship</th>
                                            <th>Refference</th>
                                            <th>Performance-Appraisal Awarded %</th>
                                            <th>Min Acceptable Salary</th>
                                            <th>Comment</th>
                                            <th>Status</th>
                                            {{-- <th scope="col">Actions</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($HumanResources as $HumanResource)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $HumanResource->registration ?? 'null' }}</td>
                                            <td>{{ $HumanResource->name ?? 'null' }}</td>
                                            <td>{{ $HumanResource->email ?? 'null' }}</td>
                                            <td>{{ $HumanResource->cnic ?? 'null' }}</td>
                                            <td>{{ $HumanResource->application_date ?? 'null' }}</td>
                                            <td>
                                                {{ $HumanResource->Crafts->name ?? 'null' }}
                                            </td>
                                            <td>
                                                {{ $HumanResource->SubCrafts->name ?? 'null' }}
                                            </td>
                                            <td>{{ $HumanResource->approvals ?? 'null' }}</td>
                                            <td>{{ $HumanResource->son_of ?? 'null' }}</td>
                                            <td>{{ $HumanResource->mother_name ?? 'null' }}</td>
                                            <td>{{ $HumanResource->date_of_birth ?? 'null' }}</td>
                                            <td>{{ $HumanResource->cnic_expiry_date ?? 'null' }}</td>
                                            <td>{{ $HumanResource->doi ?? 'null' }}</td>
                                            <td>{{ $HumanResource->doe ?? 'null' }}</td>
                                            <td>{{ $HumanResource->passport ?? 'null' }}</td>
                                            <td>{{ $HumanResource->next_of_kin ?? 'null' }}</td>
                                            <td>{{ $HumanResource->relation ?? 'null' }}</td>
                                            <td>{{ $HumanResource->kin_cnic ?? 'null' }}</td>
                                            <td>{{ $HumanResource->shoe_size ?? 'null' }}</td>
                                            <td>{{ $HumanResource->cover_size ?? 'null' }}</td>
                                            <td>{{ $HumanResource->acdemic_qualification ?? 'null' }}</td>
                                            <td>{{ $HumanResource->technical_qualification ?? 'null' }}</td>
                                            <td>{{ $HumanResource->profession ?? 'null' }}</td>
                                            <td>{{ $HumanResource->district_of_domicile ?? 'null' }}</td>
                                            <td>{{ $HumanResource->present_address ?? 'null' }}</td>
                                            <td>{{ $HumanResource->present_address_phone ?? 'null' }}</td>
                                            <td>{{ $HumanResource->present_address_mobile ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address ?? 'null' }}</td>
                                            <td>{{ $HumanResource->present_address_city ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address_phone ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address_mobile ?? 'null' }}</td>
                                            <td>{{ $HumanResource->gender ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address_city ?? 'null' }}</td>
                                            <td>{{ $HumanResource->permanent_address_province ?? 'null' }}</td>
                                            <td>{{ $HumanResource->citizenship ?? 'null' }}</td>
                                            <td>{{ $HumanResource->refference ?? 'null' }}</td>
                                            <td>{{ $HumanResource->performance_appraisal ?? 'null' }}</td>
                                            <td>{{ $HumanResource->min_salary ?? 'null' }}</td>
                                            <td>{{ $HumanResource->comment ?? 'null' }}</td>

                                            <td>
                                                <div class="badge badge-success badge-shadow">Approved</div>
                                            </td>
                                            {{-- <td>
                                                <form action="{{ route('approved.applicant.destroy', $HumanResource->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger btn-flat show_confirm"
                                                        data-toggle="tooltip">Delete</button>
                                                </form>
                                            </td> --}}
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
