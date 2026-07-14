@extends('layouts.dashboard')

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="order-last col-12 col-md-6 order-md-1">
                    <h3>Leave Requests</h3>
                    <p class="text-subtitle text-muted">Manage Leave Requests data</p>
                </div>
                <div class="order-first col-12 col-md-6 order-md-2">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Leave Requests</li>
                            <li class="breadcrumb-item active" aria-current="page">Index</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Data.
                    </h5>
                </div>
                <div class="card-body">

                    <div class="d-flex">
                        <a href="{{ route('leave-requests.create') }}" class="mb-3 btn btn-primary ms-auto">New Leave
                            Request</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leaveRequests as $leaveRequest)
                                <tr>
                                    <td>{{ $leaveRequest->employee->fullname }}</td>
                                    <td>{{ $leaveRequest->leave_type }}</td>
                                    <td>{{ $leaveRequest->start_date }}</td>
                                    <td>{{ $leaveRequest->end_date }}</td>
                                    <td>
                                        @if ($leaveRequest->status == 'confirm')
                                            <span class="badge bg-success">{{ ucfirst($leaveRequest->status) }}</span>
                                        @elseif ($leaveRequest->status == 'reject')
                                            <span class="badge bg-danger">{{ ucfirst($leaveRequest->status) }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ ucfirst($leaveRequest->status) }}</span>
                                        @endif

                                    </td>

                                    <td>
                                        @if ($leaveRequest->status == 'confirm')
                                            <a href="{{ route('leave-requests.reject', $leaveRequest) }}"
                                                class="btn btn-secondary btn-sm">Reject</a>
                                        @elseif ($leaveRequest->status == 'reject')
                                            <a href="{{ route('leave-requests.confirm', $leaveRequest) }}"
                                                class="btn btn-success btn-sm">Confirm</a>
                                        @else
                                            <a href="{{ route('leave-requests.confirm', $leaveRequest) }}"
                                                class="btn btn-success btn-sm">Confirm</a>
                                            <a href="{{ route('leave-requests.reject', $leaveRequest) }}"
                                                class="btn btn-secondary btn-sm">Reject</a>
                                        @endif

                                        <a href="{{ route('leave-requests.edit', $leaveRequest) }}"
                                            class="btn btn-warning btn-sm">Edit</a>

                                        <form action="{{ route('leave-requests.destroy', $leaveRequest) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this leave request?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
@endsection
