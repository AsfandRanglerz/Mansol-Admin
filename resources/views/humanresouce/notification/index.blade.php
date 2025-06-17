@extends('humanresouce.layout.app')
@section('title', 'Notifications')

@section('content')
    <div class="main-content" style="min-height: 562px;">
        <section class="section">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Notifications</h4>
                        </div>

                        <div class="card-body table-striped table-bordered table-responsive">
                            <table class="table table-hover text-center" id="notifications_table">
                                <thead>
                                    <tr>
                                        <th>Sr.</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($notifications as $index => $target)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $target->notification->message ?? '-' }}</td>
                                            <td>{{ \Carbon\Carbon::parse($target->created_at)->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">No notifications available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
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
            $('#notifications_table').DataTable();
        });
    </script>
@endsection
