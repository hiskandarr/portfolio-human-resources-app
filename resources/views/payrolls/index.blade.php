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
                    <h3>Payrolls</h3>
                    <p class="text-subtitle text-muted">Manage payrolls data</p>
                </div>
                <div class="order-first col-12 col-md-6 order-md-2">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">payrolls</li>
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
                        <a href="{{ route('payrolls.create') }}" class="mb-3 btn btn-primary ms-auto">New Payroll</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Salary</th>
                                <th>Deductions</th>
                                <th>Bonuses</th>
                                <th>Net Salary</th>
                                <th>Pay Date</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payrolls as $payroll)
                                <tr>
                                    <td>{{ $payroll->employee->fullname }}</td>
                                    <td>{{ number_format($payroll->salary) }}</td>
                                    <td>{{ number_format($payroll->deductions) }}</td>
                                    <td>{{ number_format($payroll->bonuses) }}</td>
                                    <td>{{ number_format($payroll->net_salary) }}</td>
                                    <td>{{ $payroll->pay_date }}</td>

                                    <td>
                                        <a href="{{ route('payrolls.show', $payroll) }}" class="btn btn-info btn-sm">Salary
                                            Slip</a>
                                        <a href="{{ route('payrolls.edit', $payroll) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('payrolls.destroy', $payroll) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this payroll?')">Delete</button>
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
