@extends('layouts.guest')

@section('title', 'Hasil Pengecekan')

@section('content')
<div class="container py-4" style="max-width: 720px;">
    <div class="page-header">
        <h1>Hasil Pengecekan</h1>
        <p>Data kehadiran siswa berikut tercatat pada sistem.</p>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="fw-semibold fs-5">{{ $student->name }}</div>
            <div class="text-muted small mb-3">{{ $student->schoolClass->name ?? '-' }} • {{ $student->school->name ?? '-' }}</div>

            <div class="status-banner p-3 text-center">
                <div class="text-muted small">Status Hari Ini ({{ today()->locale('id')->isoFormat('D MMMM YYYY') }})</div>
                @if ($todayAttendance)
                    <div class="mb-1 mt-1">
                        <span class="stamp stamp--{{ $todayAttendance->status }}">{{ \App\Models\Attendance::statusLabel($todayAttendance->status) }}</span>
                    </div>
                    <div class="small text-muted">
                        Masuk: {{ $todayAttendance->check_in ? substr((string) $todayAttendance->check_in, 0, 5) : '-' }}
                        &middot;
                        Pulang: {{ $todayAttendance->check_out ? substr((string) $todayAttendance->check_out, 0, 5) : '-' }}
                    </div>
                @else
                    <div class="mb-1 mt-1">
                        <span class="stamp stamp--neutral">Belum Absen</span>
                    </div>
                    <div class="small text-muted">Ananda belum tercatat melakukan absensi hari ini.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="h6 fw-semibold mb-3">7 Hari Terakhir</h2>
            @if ($history->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <p>Belum ada riwayat kehadiran.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $row)
                                <tr>
                                    <td>{{ $row->attendance_date->locale('id')->isoFormat('D MMM YYYY') }}</td>
                                    <td><span class="stamp stamp--{{ $row->status }}">{{ \App\Models\Attendance::statusLabel($row->status) }}</span></td>
                                    <td>{{ $row->check_in ? substr((string) $row->check_in, 0, 5) : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('landing') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Cek NIS Lain</a>
    </div>
</div>
@endsection
