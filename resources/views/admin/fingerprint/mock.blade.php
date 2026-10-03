@extends('layouts.admin')

@section('title', 'Simulasi Fingerprint')

@section('content')
<div class="page-header">
    <h1>Simulasi Fingerprint</h1>
    <p>Simulasi perangkat fingerprint untuk pengembangan. Pada perangkat nyata, alat akan mengirim identifier secara otomatis ke sistem.</p>
</div>

<div class="card">
    <div class="card-body">
        @if ($students->isEmpty())
            <p class="text-muted mb-0">Belum ada siswa dengan ID fingerprint. Daftarkan ID fingerprint pada Data Siswa terlebih dahulu.</p>
        @else
            <form method="POST" action="{{ route('admin.fingerprint.store') }}" class="row g-2">
                @csrf
                <div class="col-md-5">
                    <label for="fingerprint_identifier" class="form-label">Siswa (simulasi tempel jari)</label>
                    <select name="fingerprint_identifier" id="fingerprint_identifier" class="form-select" required>
                        <option value="">Pilih siswa</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->fingerprint_identifier }}">
                                {{ $student->name }} &mdash; {{ $student->schoolClass->name ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="type" class="form-label">Jenis</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="masuk">Masuk</option>
                        <option value="pulang">Pulang</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-fingerprint me-1"></i>Proses Absensi</button>
                </div>
            </form>
        @endif
    </div>
</div>
@endsection
