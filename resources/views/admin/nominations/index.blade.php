@extends('admin.layout.app')

@section('title', 'Assigned Resources')

@section('content')



    <div class="main-content" style="min-height: 562px;">

        <section class="section">

            <div class="section-body">

                <div class="row">

                    <div class="col-12 col-md-12 col-lg-12">

                        <div class="card">

                            <div class="card-header">

                                <div class="col-12">

                                    <h4>Assigned Resources</h4>

                                </div>

                            </div>

                            <div class="card-body table-striped table-bordered table-responsive">



                                <table class="table responsive" id="table_id_events">

                                    <thead>

                                        <tr>

                                            <th>Sr.</th>

                                            <th>Applicant Id</th>

                                            <th>Project Id</th>

                                            <th>Nominee Name</th>

                                            <th>Project Name</th>

                                            <th>Craft</th>

                                            <th>Approvals</th>

                                            <th>Nominee CNIC</th>

                                            {{-- <th>Demand</th> --}}

                                            {{-- <th scope="col">Actions</th> --}}

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach ($nominates as $HumanResource)

                                        <tr>

                                            <td>{{ $loop->iteration }}</td>

                                            <td>{{ $HumanResource->humanResource->registration }}</td>

                                            <td>{{ $HumanResource->project->project_code }}</td>

                                            <td>{{ $HumanResource->humanResource->name }}</td>

                                            <td>

                                                {{ $HumanResource->project->project_name }}

                                            </td>

                                            <td>

                                                {{ $HumanResource->craft->name }}

                                            </td>

                                            <td>{{ strtoupper($HumanResource->humanResource->approvals) }}</td>

                                            <td>{{ $HumanResource->humanResource->cnic }}</td>

                                            {{-- <td>{{ $HumanResource->application_for_post ?? 'null' }}</td> --}}

                                            

                                            {{-- <td>

                                                <form action="{{ route('nominations.destroy', $HumanResource->id) }}"

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

