@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start">
    <div>
        <h1>Data Siswa</h1>
        <p>Kelola data siswa sekolah.</p>
    </div>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-sm flex-shrink-0">
        <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.students.index') }}" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari nama atau NIS...">
            </div>
            <div class="col-md-4">
                <select name="class_id" class="form-select form-select-sm">
                    <option value="">Semua Kelas</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-outline-secondary">Cari</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-link">Atur ulang</a>
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
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Orang Tua</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration + $students->firstItem() - 1 }}</td>
                            <td>{{ $student->nis }}</td>
                            <td class="fw-medium">{{ $student->name }}</td>
                            <td>{{ $student->schoolClass->name ?? '-' }}</td>
                            <td>{{ $student->guardian->name ?? '-' }}</td>
                            <td>
                                @if ($student->isActive())
                                    <span class="badge text-bg-success"><i class="bi bi-check-lg me-1"></i>Aktif</span>
                                @else
                                    <span class="badge text-bg-secondary"><i class="bi bi-dash-lg me-1"></i>Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-qr-code me-1"></i>QR</a>
                                <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Ubah</a>
                                @if ($student->isActive())
                                    <form method="POST" action="{{ route('admin.students.destroy', $student) }}" class="d-inline"
                                        onsubmit="return confirm('Nonaktifkan siswa {{ $student->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-person-x me-1"></i>Nonaktifkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data siswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($students->hasPages())
        <div class="card-footer">{{ $students->links() }}</div>
    @endif
</div>
@endsection
