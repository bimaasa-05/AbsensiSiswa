@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<p class="text-muted mb-4">{{ $today }}</p>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Total Siswa</div>
                <div class="h4 mb-0">{{ $totalStudents }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Sudah Hadir</div>
                <div class="h4 mb-0">{{ $present }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Terlambat</div>
                <div class="h4 mb-0">{{ $late }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Belum Absen</div>
                <div class="h4 mb-0">{{ $notYet }}</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h2 class="h6 fw-semibold mb-3">Absensi Terbaru</h2>
        @if ($recent->isEmpty())
            <p class="text-muted mb-0">Belum ada data absensi hari ini.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-0">Jam</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recent as $attendance)
                            <tr>
                                <td class="ps-0">{{ substr((string) $attendance->check_in, 0, 5) }}</td>
                                <td>{{ $attendance->student->name }}</td>
                                <td>{{ $attendance->student->schoolClass->name ?? '-' }}</td>
                                <td>
                                    <span class="badge {{ $attendance->status === 'present' ? 'text-bg-success' : ($attendance->status === 'late' ? 'text-bg-warning' : 'text-bg-secondary') }}">
                                        {{ \App\Models\Attendance::statusLabel($attendance->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
