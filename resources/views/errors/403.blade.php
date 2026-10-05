@extends('layouts.guest')

@section('title', 'Akses Ditolak')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5 text-center">
            <div class="empty-state">
                <i class="bi bi-shield-lock" style="font-size: 3rem;"></i>
                <p class="fs-5 fw-bold text-dark mt-3 mb-1">Akses Ditolak (403)</p>
                <p>Anda tidak memiliki akses ke halaman ini. Silakan masuk dengan akun yang sesuai.</p>
            </div>
            <div class="d-flex gap-2 justify-content-center mt-3">
                <a href="{{ route('login') }}" class="btn btn-primary btn-sm"><i class="bi bi-box-arrow-in-right me-1"></i>Masuk</a>
                <a href="/" class="btn btn-outline-secondary btn-sm"><i class="bi bi-house me-1"></i>Beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
