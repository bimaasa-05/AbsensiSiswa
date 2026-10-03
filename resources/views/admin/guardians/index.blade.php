@extends('layouts.admin')

@section('title', 'Data Orang Tua')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start">
    <div>
        <h1>Data Orang Tua</h1>
        <p>Kelola data orang tua/wali siswa.</p>
    </div>
    <a href="{{ route('admin.guardians.create') }}" class="btn btn-primary btn-sm flex-shrink-0">
        <i class="bi bi-plus-lg me-1"></i>Tambah Orang Tua
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Nama</th>
                        <th>Nomor WhatsApp</th>
                        <th>Email</th>
                        <th>Jumlah Anak</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($guardians as $guardian)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration + $guardians->firstItem() - 1 }}</td>
                            <td class="fw-medium">{{ $guardian->name }}</td>
                            <td>{{ $guardian->phone }}</td>
                            <td>{{ $guardian->email ?? '-' }}</td>
                            <td>{{ $guardian->students_count }}</td>
                            <td>
                                @if ($guardian->isActive())
                                    <span class="badge text-bg-success"><i class="bi bi-check-lg me-1"></i>Aktif</span>
                                @else
                                    <span class="badge text-bg-secondary"><i class="bi bi-dash-lg me-1"></i>Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.guardians.edit', $guardian) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Ubah</a>
                                <form method="POST" action="{{ route('admin.guardians.destroy', $guardian) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus data {{ $guardian->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data orang tua/wali.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($guardians->hasPages())
        <div class="card-footer">{{ $guardians->links() }}</div>
    @endif
</div>
@endsection
