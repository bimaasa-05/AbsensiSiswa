@extends('layouts.parent')

@section('title', 'Anak Saya')

@section('content')
<h1 class="h5 fw-bold mb-3">Anak Saya</h1>

@if ($children->isEmpty())
    <div class="card">
        <div class="card-body">
            <p class="text-muted mb-0">Belum ada data anak yang terhubung dengan akun ini. Silakan hubungi admin sekolah.</p>
        </div>
    </div>
@else
    @if ($children->count() > 1)
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('parent.dashboard') }}">
                    <label for="anak" class="form-label small text-muted">Pilih anak</label>
                    <select name="anak" id="anak" class="form-select" onchange="this.form.submit()">
                        @foreach ($children as $child)
                            <option value="{{ $child->id }}" @selected($selected->id === $child->id)>
                                {{ $child->name }} &mdash; {{ $child->schoolClass->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <div class="fw-semibold">{{ $selected->name }}</div>
            <div class="text-muted small mb-3">{{ $selected->schoolClass->name ?? '-' }}</div>

            <div class="status-banner p-3 text-center">
                <div class="text-muted small">Status Hari Ini</div>
                @if ($todayAttendance)
                    <div class="h5 mb-1">
                        <i class="bi {{ $todayAttendance->status === 'present' ? 'bi-check-circle-fill text-success' : ($todayAttendance->status === 'late' ? 'bi-alarm-fill text-warning' : 'bi-dash-circle-fill text-secondary') }}"></i>
                        {{ \App\Models\Attendance::statusLabel($todayAttendance->status) }}
                    </div>
                    <div class="small text-muted">
                        Masuk: {{ $todayAttendance->check_in ? substr((string) $todayAttendance->check_in, 0, 5) : '-' }}
                        &middot;
                        Pulang: {{ $todayAttendance->check_out ? substr((string) $todayAttendance->check_out, 0, 5) : '-' }}
                    </div>
                @else
                    <div class="h5 mb-1">Belum Absen</div>
                    <div class="small text-muted">Ananda belum tercatat melakukan absensi hari ini.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h2 class="h6 fw-semibold mb-3">Riwayat Kehadiran</h2>
            @if ($history->isEmpty())
                <p class="text-muted mb-0">Belum ada riwayat kehadiran.</p>
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
                                    <td>
                                        <i class="bi {{ $row->status === 'present' ? 'bi-check-circle-fill text-success' : ($row->status === 'late' ? 'bi-alarm-fill text-warning' : 'bi-dash-circle-fill text-secondary') }} me-1"></i>{{ \App\Models\Attendance::statusLabel($row->status) }}
                                    </td>
                                    <td>{{ $row->check_in ? substr((string) $row->check_in, 0, 5) : '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endif
@endsection
