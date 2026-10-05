@extends('layouts.admin')

@section('title', 'Rekap Absensi')

@section('content')
<div class="page-header">
    <h1>Rekap Absensi</h1>
    <p>Rekapitulasi kehadiran per siswa pada periode terpilih.</p>
</div>
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.attendances.recap') }}" class="row g-2">
            <div class="col-md-3">
                <input type="date" name="start_date" value="{{ $start }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" value="{{ $end }}" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
                <select name="class_id" class="form-select form-select-sm">
                    <option value="">Semua Kelas</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-funnel me-1"></i>Terapkan</button>
                <a href="{{ route('admin.attendances.recap.export', request()->only(['start_date', 'end_date', 'class_id'])) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-download me-1"></i>CSV</a>
                <a href="{{ route('admin.attendances.recap.excel', request()->only(['start_date', 'end_date', 'class_id'])) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-file-earmark-spreadsheet me-1"></i>Excel</a>
                <button type="button" class="btn btn-sm btn-outline-secondary" id="btn-print-pdf"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</button>
            </div>
        </form>
        <script>
        (function () {
            var button = document.getElementById('btn-print-pdf');
            if (!button) return;
            button.addEventListener('click', function () {
                var params = new URLSearchParams(window.location.search);
                window.open('{{ route('admin.attendances.recap.print') }}?' + params.toString(), '_blank');
            });
        })();
        </script>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Nama</th>
                        <th>Kelas</th>
                        <th class="text-center">Hadir</th>
                        <th class="text-center">Terlambat</th>
                        <th class="text-center">Izin</th>
                        <th class="text-center">Sakit</th>
                        <th class="text-center pe-3">Alpha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recap as $row)
                        <tr>
                            <td class="ps-3 fw-medium">{{ $row['student']->name }}</td>
                            <td>{{ $row['student']->schoolClass->name ?? '-' }}</td>
                            <td class="text-center">{{ $row['present'] }}</td>
                            <td class="text-center">{{ $row['late'] }}</td>
                            <td class="text-center">{{ $row['permission'] }}</td>
                            <td class="text-center">{{ $row['sick'] }}</td>
                            <td class="text-center pe-3">{{ $row['absent'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="bi bi-table"></i>
                                    <p>Belum ada data siswa.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
