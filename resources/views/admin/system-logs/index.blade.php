@extends('admin.layouts.master')

@section('title', 'System Logs')

@section('css')
    <link href="{{ asset('/assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border border-primary">
                <div class="card-header bg-transparent border-primary">
                    <h5 class="my-0 text-primary">
                        <i class="uil uil-bug"></i> System Logs
                    </h5>
                </div>

                <div class="card-body">
                    <x-alert />

                    <table id="datatable-logs" class="table table-striped table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>User</th>
                                <th>Level</th>
                                <th>Action</th>
                                <th>Message</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($logs as $log)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $log->created_at->format('Y-m-d H:i') }}</td>
                                                    <td>{{ $log->user->name ?? 'System' }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ 
                                                                                                                                                                                        match ($log->level) {
                                    'critical' => 'danger',
                                    'error' => 'danger',
                                    'warning' => 'warning',
                                    default => 'secondary'
                                }
                                                                                                                                                                                    }}">
                                                            {{ strtoupper($log->level) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $log->action ?? '-' }}</td>
                                                    <td style="max-width:300px; white-space: normal;">
                                                        {{ $log->message }}
                                                    </td>
                                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('/assets/libs/datatables/datatables.min.js') }}"></script>
    <script>
        $(function () {
            $('#datatable-logs').DataTable({
                order: [[1, 'desc']],
                pageLength: 25,
                lengthMenu: [[25, 50, 100, -1], [25, 50, 100, "All"]],
                dom: 'Bfrtip',
                buttons: ['excel', 'print']
            });
        });
    </script>
@endsection