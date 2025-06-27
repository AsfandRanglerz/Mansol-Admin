@extends('humanresouce.layout.app')
@section('title', 'Human Resource')
@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="row mb-3">
                <div class="col-xl-3 mb-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Profile</h5>
                                            <h2 class="mb-3 font-18"><span class="{{ $user->status == 0 ? 'text-danger' : 'col-green' }}">
                                                    @if ($user->status == 0)
                                                        Rejected
                                                    @elseif ($user->status == 1)
                                                        Pending
                                                    @elseif ($user->status == 2)
                                                        Approved
                                                    @elseif ($user->status == 3)
                                                        Assigned
                                                    @endif
                                                </span>
                                                </h2> 
                                            {{-- <p class="mb-0"><span class="col-green">10%</span> Increase</p> --}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
    </div>
@endsection
