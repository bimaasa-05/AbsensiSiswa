@extends('layouts.admin')

@section('title', 'Belum Absen')

@section('content')
<div class="page-header">
    <h1>Belum Absen</h1>
    <p>{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }} — siswa aktif yang belum tercatat melakukan absensi hari ini.</p>
</div>
<div class="alert alert-info py-2 small"><i class="bi bi-info-circle me-1"></i>Daftar ini bukan vonis alpha, melainkan bahan monitoring sesuai kebijakan sekolah.</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.attendances.missing') }}" class="row g-2">
            <div class="col-md-4">
                <select name="class_id" class="form-select form-select-sm">
                    <option value="">Semua Kelas</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-funnel me-1"></i>Terapkan</button>
                <a href="{{ route('admin.attendances.missing') }}" class="btn btn-sm btn-link">Atur ulang</a>
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
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Orang Tua/Wali</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration + $students->firstItem() - 1 }}</td>
                            <td>{{ $student->nis }}</td>
                            <td class="fw-medium">{{ $student->name }}</td>
                            <td>{{ $student->schoolClass->name ?? '-' }}</td>
                            <td>{{ $student->guardian->name ?? '-' }}{{ $student->guardian ? ' ('.$student->guardian->phone.')' : '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-check-circle text-success"></i>
                                    <p>Semua siswa sudah melakukan absensi hari ini.</p>
                                </div>
                            </td>
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
