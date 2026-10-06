@extends('layouts.admin')

@section('title', 'Hari Libur')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start">
    <div>
        <h1>Hari Libur</h1>
        <p>Kelola kalender libur sekolah. Absensi tetap dapat dicatat pada hari libur untuk kegiatan khusus.</p>
    </div>
    <a href="{{ route('admin.holidays.create') }}" class="btn btn-primary btn-sm flex-shrink-0">
        <i class="bi bi-plus-lg me-1"></i>Tambah Libur
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Tanggal</th>
                        <th>Nama Libur</th>
                        <th>Jenis</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($holidays as $holiday)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration + $holidays->firstItem() - 1 }}</td>
                            <td class="fw-medium">{{ $holiday->holiday_date->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</td>
                            <td>{{ $holiday->name }}</td>
                            <td><span class="stamp stamp--neutral">{{ \App\Models\Holiday::typeLabel($holiday->type) }}</span></td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.holidays.edit', $holiday) }}" class="btn btn-sm btn-accent"><i class="bi bi-pencil me-1"></i>Ubah</a>
                                <form method="POST" action="{{ route('admin.holidays.destroy', $holiday) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus libur {{ $holiday->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash me-1"></i>Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-calendar-x"></i>
                                    <p>Belum ada hari libur terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($holidays->hasPages())
        <div class="card-footer">{{ $holidays->links() }}</div>
    @endif
</div>
@endsection
