@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
<div class="row justify-content-center" style="margin-top: 10vh;">
    <div class="col-md-5 col-lg-4">
        <div class="text-center mb-4">
            <h1 class="h4 fw-bold mb-1">Sistem Absensi Siswa</h1>
            <p class="text-muted small mb-0">Masuk untuk mengelola kehadiran siswa</p>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="nama@sekolah.sch.id" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Masukkan kata sandi" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input" value="1">
                        <label for="remember" class="form-check-label">Ingat saya</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
