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
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Presences</h3>
                    <p class="text-subtitle text-muted">Handle employee presence</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                            <li class="breadcrumb-item" aria-current="page">Presences</li>
                            <li class="breadcrumb-item active" aria-current="page">New</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Create.
                    </h5>
                </div>
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('role') == 'HR')
                        <form action="{{ route('presences.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="" class="form-label">Employee</label>
                                <select name="employee_id" class="form-control @error('employee_id') is-invalid @enderror">
                                    <option value="">Select an Employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->fullname }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Check In</label>
                                <input type="text" class="form-control datetime @error('check_in') is-invalid @enderror"
                                    name="check_in" value="{{ old('check_in') }}" required>
                                @error('check_in')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Check Out</label>
                                <input type="text" class="form-control datetime @error('check_out') is-invalid @enderror"
                                    name="check_out" value="{{ old('check_out') }}" required>
                                @error('check_out')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Date</label>
                                <input type="text" class="form-control date @error('date') is-invalid @enderror"
                                    name="date" value="{{ old('date') }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror">
                                    <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present
                                    </option>
                                    <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent
                                    </option>
                                    <option value="leave" {{ old('status') == 'leave' ? 'selected' : '' }}>Leave</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('presences.index') }}" class="btn btn-secondary">Back to List</a>
                        </form>
                    @else
                        <form action="{{ route('presences.store') }}" method="POST">
                            @csrf

                            <div class="mb-3"><b>Note</b> : Mohon izinkan akses lokasi, supaya presensi diterima</div>

                            <div class="mb-3">
                                <label for="" class="form-label">Latitude</label>
                                <input type="text" class="form-control name="latitude" id="latitude" required>
                            </div>

                            <div class="mb-3">
                                <label for="" class="form-label">Longitude</label>
                                <input type="text" class="form-control name="longitude" id="longitude" required>
                            </div>

                            <div class="mb-3">
                                <iframe witdh="500" height="300" frameborder="0" scroling="no" marginheight="0"
                                    marginwidth="0" src=""></iframe>
                            </div>

                            <button type="submit" class="btn btn-primary" id="btn-present" disable>Present</button>
                        </form>
                    @endif
                </div>
            </div>

        </section>
    </div>

    <script>
        const iframe = document.querySelector('iframe');

        const officeLat = -6.9152366;
        const officeLong = 107.5839853;
        const threshold = 0.01;

        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;

            iframe.src = `https://www.google.com/maps?q=${lat},${lon}&output=embed`;
        }, function(error) {
            console.log(error.code);
            console.log(error.message);
        });

        document.addEventListener('DOMContentLoaded', (event) => {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    document.getElementById('latitude').value = lat;
                    document.getElementById('longitude').value = lon;

                    // Compare lokasi sekarang dengan lokasi kantor
                    const distance = Math.sqrt(Math.pow(lat - officeLat, 2) + Math.pow(lon - officeLong,
                        2));

                    if (distance <= threshold) {
                        // posisi ada di sekitar kantor
                        alert('Kamu berada di kantor, selamat bekerja!');

                        document.getElementById('btn-present').removeAttribute('disabled');
                    } else {
                        // posisi diluat kantor
                        alert(
                            'Kamu tidak berada di kantor, pastikan kamu berada di kantor untuk melakukan presensi'
                        );
                    }
                }, function(error) {
                    console.log(error.code);
                    console.log(error.message);
                });
            }
        });
    </script>
@endsection
