@extends('layouts.admin')

@section('title', 'Log Notifikasi')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.attendances.notifications') }}" class="row g-2">
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="sent" @selected(request('status') === 'sent')>Terkirim</option>
                    <option value="failed" @selected(request('status') === 'failed')>Gagal</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select form-select-sm">
                    <option value="">Semua Jenis</option>
                    <option value="check_in" @selected(request('type') === 'check_in')>Masuk</option>
                    <option value="check_out" @selected(request('type') === 'check_out')>Pulang</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-outline-secondary">Terapkan</button>
                <a href="{{ route('admin.attendances.notifications') }}" class="btn btn-sm btn-link">Atur ulang</a>
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
                        <th class="ps-3">Waktu</th>
                        <th>Siswa</th>
                        <th>Penerima</th>
                        <th>Jenis</th>
                        <th>Status</th>
                        <th class="pe-3">Galat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr>
                            <td class="ps-3">{{ $log->created_at->locale('id')->isoFormat('D MMM HH:mm') }}</td>
                            <td class="fw-medium">{{ $log->student->name }}</td>
                            <td>{{ $log->recipient }}</td>
                            <td>{{ $log->type === 'check_in' ? 'Masuk' : 'Pulang' }}</td>
                            <td>
                                <span class="badge {{ $log->status === 'sent' ? 'text-bg-success' : ($log->status === 'failed' ? 'text-bg-danger' : 'text-bg-secondary') }}">
                                    <i class="bi {{ $log->status === 'sent' ? 'bi-check-circle-fill' : ($log->status === 'failed' ? 'bi-x-circle-fill' : 'bi-clock-fill') }} me-1"></i>{{ $log->status === 'sent' ? 'Terkirim' : ($log->status === 'failed' ? 'Gagal' : 'Pending') }}
                                </span>
                            </td>
                            <td class="pe-3 small text-muted">{{ $log->error_message ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada log notifikasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($logs->hasPages())
        <div class="card-footer">{{ $logs->links() }}</div>
    @endif
</div>
@endsection
