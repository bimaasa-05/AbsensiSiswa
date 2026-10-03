@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<p class="text-muted mb-4">{{ $today }}</p>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Total Siswa</div>
                <div class="h4 mb-0">-</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Sudah Hadir</div>
                <div class="h4 mb-0">-</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Terlambat</div>
                <div class="h4 mb-0">-</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="text-muted small">Belum Absen</div>
                <div class="h4 mb-0">-</div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h2 class="h6 fw-semibold mb-3">Absensi Terbaru</h2>
        <p class="text-muted mb-0">Belum ada data absensi hari ini.</p>
    </div>
</div>
@endsection
