@extends('layouts.guest')

@section('title', 'Daftarkan Sekolah')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6">
            <div class="text-center mb-4">
                <i class="bi bi-mortarboard-fill fs-1" style="color: #1e4d3b;"></i>
                <h1 class="h4 fw-bold mt-2 mb-1">Daftarkan Sekolah Anda</h1>
                <p class="text-muted small mb-0">Isi data sekolah. Pengajuan akan ditinjau oleh superadmin sebelum dapat digunakan.</p>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('schools.register.store') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Nama Sekolah</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Contoh: SMK Negeri 1 Contoh" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea name="address" id="address" rows="2" class="form-control" placeholder="Jalan, nomor, kota">{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="Contoh: 0211234567" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-muted">(opsional)</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="info@sekolah.sch.id">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="contact_person" class="form-label">Nama Penanggung Jawab</label>
                                <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}"
                                    class="form-control @error('contact_person') is-invalid @enderror"
                                    placeholder="Nama kepala sekolah / operator" required>
                                @error('contact_person')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mt-4"><i class="bi bi-send me-1"></i>Kirim Pengajuan</button>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('landing') }}" class="btn btn-sm btn-link"><i class="bi bi-arrow-left me-1"></i>Kembali ke beranda</a>
            </div>
        </div>
    </div>
</div>
@endsection
