@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
<div class="container-fluid login-wrap p-0">
    <div class="row g-0" style="min-height: 100vh;">
        <div class="col-md-6 d-none d-md-flex flex-column justify-content-center login-panel p-5">
            <div style="max-width: 420px; margin: 0 auto;">
                <i class="bi bi-mortarboard-fill brand-icon"></i>
                <h1 class="h3 fw-bold mt-3 mb-2">Sistem Absensi Siswa</h1>
                <p class="mb-4" style="color: #b9c7d4;">Pencatatan kehadiran digital dengan QR Code dan fingerprint, terhubung langsung ke orang tua/wali.</p>
                <hr>
                <div class="login-info d-flex flex-column gap-2 mt-4">
                    <span><i class="bi bi-qr-code-scan me-2"></i>Absensi QR Code &amp; fingerprint</span>
                    <span><i class="bi bi-whatsapp me-2"></i>Notifikasi otomatis ke orang tua</span>
                    <span><i class="bi bi-clipboard-data me-2"></i>Rekap kehadiran per kelas</span>
                </div>
            </div>
        </div>

        <div class="col-md-6 d-flex align-items-center justify-content-center login-form-col p-4">
            <div class="w-100" style="max-width: 380px;">
                <div class="d-md-none text-center mb-4">
                    <i class="bi bi-mortarboard-fill fs-1" style="color: #1b3a5c;"></i>
                    <h1 class="h5 fw-bold mt-2 mb-0">Sistem Absensi Siswa</h1>
                </div>

                <h2 class="h5 fw-bold mb-1">Masuk</h2>
                <p class="text-muted small mb-4">Kelola kehadiran siswa sekolah</p>

                <div class="card">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="nama@sekolah.sch.id" required autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Masukkan kata sandi" required>
                                    <button type="button" class="btn btn-outline-secondary" id="toggle-password" aria-label="Tampilkan kata sandi">
                                        <i class="bi bi-eye" id="toggle-password-icon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input" value="1">
                                <label for="remember" class="form-check-label">Ingat saya</label>
                            </div>

                            <button type="submit" class="btn btn-primary w-100"><i class="bi bi-box-arrow-in-right me-1"></i>Masuk</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var toggle = document.getElementById('toggle-password');
    var input = document.getElementById('password');
    var icon = document.getElementById('toggle-password-icon');
    if (!toggle || !input || !icon) return;
    toggle.addEventListener('click', function () {
        var show = input.type === 'password';
        input.type = show ? 'text' : 'password';
        icon.classList.toggle('bi-eye', !show);
        icon.classList.toggle('bi-eye-slash', show);
        toggle.setAttribute('aria-label', show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    });
})();
</script>
@endsection
