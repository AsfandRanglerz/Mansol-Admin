@extends('admin.layout.app')
@section('title', 'Human Resource')
@section('content')

    <div class="modal fade" id="createSubadminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Human Resource</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createSubadminForm" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" id="draft_id" name="draft_id">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">In Active</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" onclick="submitSubadminForm()">Create</button>
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
                                    <h4>Human Resource</h4>
                                </div>
                            </div>
                            <div class="card-body table-striped table-bordered table-responsive">
                                <a class="btn btn-primary mb-3 text-white" href="{{route('humanresource.create')}}">
                                    Add Human Recource
                                </a>
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
                                            <th>Approvals Document</th>
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
                                            <th scope="col">Actions</th>
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
                                            <td>
                                                @if ($HumanResource->medical_doc)
                                                    <a href="{{ asset($HumanResource->medical_doc) }}" download>Download File</a>
                                                @endif
                                            </td>
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
                                                @if ($HumanResource->status == 1)
                                                    <div class="badge badge-success badge-shadow">Pending</div>
                                                @else
                                                    <div class="badge badge-danger badge-shadow">Rejected</div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-4">
                                                    <a href="{{ route('humanresource.edit', $HumanResource->id) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    <form action="{{ route('humanresource.destroy', $HumanResource->id) }}"
                                                        method="POST" style="display:inline-block; margin-left: 10px">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-flat show_confirm"
                                                            data-toggle="tooltip">Delete</button>
                                                    </form>
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
