@extends('layouts.admin')

@section('title', 'Data Sekolah')

@section('content')
<div class="page-header">
    <h1>Data Sekolah</h1>
    <p>Kelola pendaftaran dan status sekolah.</p>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('superadmin.schools.index') }}" class="row g-2">
            <div class="col-md-4">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="pending" @selected(request('status') === 'pending')>Menunggu</option>
                    <option value="approved" @selected(request('status') === 'approved')>Disetujui</option>
                    <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
                </select>
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
                        <th class="ps-3">No</th>
                        <th>Nama Sekolah</th>
                        <th>Kontak</th>
                        <th>Siswa</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schools as $school)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration + $schools->firstItem() - 1 }}</td>
                            <td class="fw-medium">{{ $school->name }}</td>
                            <td>{{ $school->contact_person ?? '-' }}<br><span class="text-muted small">{{ $school->phone ?? '-' }}</span></td>
                            <td>{{ $school->students_count }}</td>
                            <td>
                                <span class="stamp {{ $school->status === 'approved' ? 'stamp--present' : ($school->status === 'rejected' ? 'stamp--absent' : 'stamp--neutral') }}">
                                    {{ \App\Models\School::statusLabel($school->status) }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('superadmin.schools.show', $school) }}" class="btn btn-sm btn-outline-dark"><i class="bi bi-eye me-1"></i>Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="bi bi-building"></i>
                                    <p>Belum ada data sekolah.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($schools->hasPages())
        <div class="card-footer">{{ $schools->links() }}</div>
    @endif
</div>
@endsection
