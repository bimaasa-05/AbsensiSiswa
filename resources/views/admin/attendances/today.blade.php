@extends('layouts.admin')

@section('title', 'Absensi Hari Ini')

@section('content')
<div class="page-header">
    <h1>Absensi Hari Ini</h1>
    <p>{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.attendances.today') }}" class="row g-2">
            <div class="col-md-3">
                <select name="class_id" class="form-select form-select-sm">
                    <option value="">Semua Kelas</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="method" class="form-select form-select-sm">
                    <option value="">Semua Metode</option>
                    <option value="qr" @selected(request('method') === 'qr')>QR Code</option>
                    <option value="fingerprint" @selected(request('method') === 'fingerprint')>Fingerprint</option>
                    <option value="manual" @selected(request('method') === 'manual')>Manual</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-funnel me-1"></i>Terapkan</button>
                <a href="{{ route('admin.attendances.today') }}" class="btn btn-sm btn-link">Atur ulang</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Jam</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>WA Ortu</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr>
                            <td class="ps-3">{{ substr((string) $attendance->check_in, 0, 5) }}</td>
                            <td class="fw-medium">{{ $attendance->student->name }}</td>
                            <td>{{ $attendance->student->schoolClass->name ?? '-' }}</td>
                            <td>{{ $attendance->method === 'qr' ? 'QR Code' : ucfirst((string) $attendance->method) }}</td>
                            <td>
                                <span class="badge {{ $attendance->status === 'present' ? 'text-bg-success' : ($attendance->status === 'late' ? 'text-bg-warning' : 'text-bg-secondary') }}">
                                    <i class="bi {{ $attendance->status === 'present' ? 'bi-check-circle-fill' : ($attendance->status === 'late' ? 'bi-alarm-fill' : 'bi-dash-circle-fill') }} me-1"></i>{{ \App\Models\Attendance::statusLabel($attendance->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge text-bg-secondary">
                                    <i class="bi {{ $attendance->check_in_notification_status === 'sent' ? 'bi-check-lg' : ($attendance->check_in_notification_status === 'failed' ? 'bi-x-lg' : 'bi-clock') }} me-1"></i>{{ $attendance->check_in_notification_status }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.corrections.edit', $attendance) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil-square me-1"></i>Koreksi</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data absensi hari ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($attendances->hasPages())
        <div class="card-footer">{{ $attendances->links() }}</div>
    @endif
</div>
@endsection
