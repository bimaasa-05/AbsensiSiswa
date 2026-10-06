@extends('layouts.guest')

@section('title', 'Pengajuan Terkirim')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 text-center">
            <div class="empty-state">
                <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                <p class="fs-5 fw-bold text-dark mt-3 mb-1">Pengajuan Terkirim</p>
                <p>Terima kasih. Data sekolah Anda sedang ditinjau oleh superadmin. Kredensial admin akan diserahkan setelah pengajuan disetujui.</p>
            </div>
            <a href="{{ route('landing') }}" class="btn btn-primary btn-sm mt-3"><i class="bi bi-house me-1"></i>Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
