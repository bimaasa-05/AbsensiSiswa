@extends('layouts.admin')

@section('title', isset($guardian) ? 'Ubah Orang Tua' : 'Tambah Orang Tua')

@section('content')
<div class="page-header">
    <h1>{{ isset($guardian) ? 'Ubah Orang Tua' : 'Tambah Orang Tua' }}</h1>
    <p>{{ isset($guardian) ? 'Perbarui data orang tua/wali.' : 'Daftarkan orang tua/wali beserta nomor WhatsApp notifikasi.' }}</p>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($guardian) ? route('admin.guardians.update', $guardian) : route('admin.guardians.store') }}">
            @csrf
            @if (isset($guardian))
                @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $guardian->name ?? '') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Nama orang tua/wali" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="phone" class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $guardian->phone ?? '') }}"
                        class="form-control @error('phone') is-invalid @enderror"
                        placeholder="Contoh: 081234567890" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email <span class="text-muted">(opsional)</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $guardian->email ?? '') }}"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="nama@email.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" @selected(old('status', $guardian->status ?? 'active') === 'active')>Aktif</option>
                        <option value="inactive" @selected(old('status', $guardian->status ?? '') === 'inactive')>Nonaktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Simpan Data</button>
                <a href="{{ route('admin.guardians.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg me-1"></i>Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
