@extends('layouts.admin')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.attendances.history') }}" class="row g-2">
            <div class="col-md-2">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <select name="student_id" class="form-select form-select-sm">
                    <option value="">Semua Siswa</option>
                    @foreach ($students as $student)
                        <option value="{{ $student->id }}" @selected(request('student_id') == $student->id)>{{ $student->name }} ({{ $student->nis }})</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="class_id" class="form-select form-select-sm">
                    <option value="">Semua Kelas</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    @foreach ($statuses as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-sm btn-outline-secondary w-100"><i class="bi bi-search me-1"></i>Cari</button>
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
                        <th class="ps-3">Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Masuk</th>
                        <th>Pulang</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr>
                            <td class="ps-3">{{ $attendance->attendance_date->locale('id')->isoFormat('D MMM YYYY') }}</td>
                            <td class="fw-medium">{{ $attendance->student->name }}</td>
                            <td>{{ $attendance->student->schoolClass->name ?? '-' }}</td>
                            <td>{{ $attendance->check_in ? substr((string) $attendance->check_in, 0, 5) : '-' }}</td>
                            <td>{{ $attendance->check_out ? substr((string) $attendance->check_out, 0, 5) : '-' }}</td>
                            <td>{{ $attendance->method === 'qr' ? 'QR Code' : ucfirst((string) $attendance->method) }}</td>
                            <td>
                                <span class="badge {{ $attendance->status === 'present' ? 'text-bg-success' : ($attendance->status === 'late' ? 'text-bg-warning' : 'text-bg-secondary') }}">
                                    <i class="bi {{ $attendance->status === 'present' ? 'bi-check-circle-fill' : ($attendance->status === 'late' ? 'bi-alarm-fill' : 'bi-dash-circle-fill') }} me-1"></i>{{ \App\Models\Attendance::statusLabel($attendance->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.corrections.edit', $attendance) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil-square me-1"></i>Koreksi</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">Belum ada data absensi pada filter ini.</td>
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
