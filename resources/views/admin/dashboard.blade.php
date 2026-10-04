@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>{{ $today }}</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="stat-icon stat-icon--blue"><i class="bi bi-people"></i></span>
                <div>
                    <div class="stat-value">{{ $totalStudents }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="stat-icon stat-icon--green"><i class="bi bi-check-circle"></i></span>
                <div>
                    <div class="stat-value">{{ $present }}</div>
                    <div class="stat-label">Sudah Hadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="stat-icon stat-icon--amber"><i class="bi bi-alarm"></i></span>
                <div>
                    <div class="stat-value">{{ $late }}</div>
                    <div class="stat-label">Terlambat</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.attendances.missing') }}" class="text-decoration-none">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon stat-icon--red"><i class="bi bi-person-exclamation"></i></span>
                    <div>
                        <div class="stat-value text-dark">{{ $notYet }}</div>
                        <div class="stat-label">Belum Absen</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h2 class="h6 fw-semibold mb-3">Absensi Terbaru</h2>
        @if ($recent->isEmpty())
            <div class="empty-state">
                <i class="bi bi-calendar-x"></i>
                <p>Belum ada data absensi hari ini.</p>
            </div>
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
                                        <i class="bi {{ $attendance->status === 'present' ? 'bi-check-circle-fill' : ($attendance->status === 'late' ? 'bi-alarm-fill' : 'bi-dash-circle-fill') }} me-1"></i>{{ \App\Models\Attendance::statusLabel($attendance->status) }}
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
