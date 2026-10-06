@extends('layouts.guest')

@section('title', 'Cek Kehadiran Siswa')

@section('content')
<div class="container-fluid p-0">
    <div class="hero-band rounded-0 text-center py-5 px-3">
        <i class="bi bi-mortarboard-fill fs-1" style="color: var(--kunyit);"></i>
        <h1 class="h3 fw-bold mt-3 mb-2">Cek Kehadiran Siswa</h1>
        <p class="mb-0" style="color: #bcd2c4;">Pastikan putra-putri Anda sudah melakukan absensi di sekolah hari ini.</p>
    </div>

    <div class="row justify-content-center mt-4 px-3">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="card-body p-4">
                    @if (session('lookup_error'))
                        <div class="alert alert-warning py-2 small">
                            <i class="bi bi-exclamation-triangle me-1"></i>{{ session('lookup_error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('lookup.check') }}">
                        @csrf

                        <label for="identifier" class="form-label">NIS / NISN Siswa</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                            <input type="text" name="identifier" id="identifier" value="{{ old('identifier') }}"
                                class="form-control @error('identifier') is-invalid @enderror"
                                placeholder="Contoh: 2627001" required autofocus autocomplete="off">
                            @error('identifier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <p class="text-muted small mb-3">NIS/NISN dapat dilihat pada kartu pelajar atau rapor siswa.</p>

                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search me-1"></i>Cek Kehadiran</button>
                    </form>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon stat-icon--blue"><i class="bi bi-building"></i></span>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">Sekolah belum terdaftar?</div>
                        <div class="text-muted small">Daftarkan sekolah Anda untuk memakai sistem ini.</div>
                    </div>
                    <a href="{{ route('schools.register') }}" class="btn btn-sm btn-outline-primary flex-shrink-0">Daftar</a>
                </div>
            </div>

            <p class="text-center text-muted small mt-4 mb-0">Halaman ini hanya menampilkan status kehadiran. Data pribadi siswa dilindungi.</p>
        </div>
    </div>
</div>
@endsection
