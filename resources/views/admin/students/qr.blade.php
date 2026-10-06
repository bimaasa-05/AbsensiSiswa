@extends('layouts.admin')

@section('title', 'QR Code Siswa')

@section('content')
<div class="page-header">
    <h1>QR Code Siswa</h1>
    <p>Cetak atau buat ulang QR Code absensi.</p>
</div>
<div class="row g-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body text-center">
                <h2 class="h6 fw-semibold mb-3">QR Code Absensi</h2>
                <div class="d-inline-block border p-3 rounded">
                    {!! QrCode::size(220)->generate($student->qr_token) !!}
                </div>
                <div class="mt-3 d-flex gap-2 justify-content-center">
                    <button type="button" class="btn btn-sm btn-outline-dark" onclick="window.print()"><i class="bi bi-printer me-1"></i>Cetak</button>
                    <form method="POST" action="{{ route('admin.students.qr.regenerate', $student) }}" class="d-inline"
                        onsubmit="return confirm('Buat ulang QR Code? QR lama tidak akan berlaku lagi.')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-dark"><i class="bi bi-arrow-clockwise me-1"></i>Buat Ulang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h2 class="h6 fw-semibold mb-3">Data Siswa</h2>
                <dl class="row mb-0">
                    <dt class="col-sm-4">NIS</dt>
                    <dd class="col-sm-8">{{ $student->nis }}</dd>
                    <dt class="col-sm-4">NISN</dt>
                    <dd class="col-sm-8">{{ $student->nisn ?? '-' }}</dd>
                    <dt class="col-sm-4">Nama</dt>
                    <dd class="col-sm-8">{{ $student->name }}</dd>
                    <dt class="col-sm-4">Kelas</dt>
                    <dd class="col-sm-8">{{ $student->schoolClass->name ?? '-' }}</dd>
                    <dt class="col-sm-4">Orang Tua/Wali</dt>
                    <dd class="col-sm-8">{{ $student->guardian->name ?? '-' }}</dd>
                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">{{ $student->isActive() ? 'Aktif' : 'Nonaktif' }}</dd>
                </dl>
                <div class="mt-3">
                    <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-accent"><i class="bi bi-pencil me-1"></i>Ubah Data</a>
                    <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-link"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
