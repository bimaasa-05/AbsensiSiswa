@extends('layouts.admin')

@section('title', isset($class) ? 'Ubah Kelas' : 'Tambah Kelas')

@section('content')
<div class="page-header">
    <h1>{{ isset($class) ? 'Ubah Kelas' : 'Tambah Kelas' }}</h1>
    <p>{{ isset($class) ? 'Perbarui data kelas.' : 'Daftarkan kelas baru untuk tahun ajaran berjalan.' }}</p>
</div>
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($class) ? route('admin.classes.update', $class) : route('admin.classes.store') }}">
            @csrf
            @if (isset($class))
                @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama Kelas</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $class->name ?? '') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Contoh: XII RPL 1" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="level" class="form-label">Tingkat</label>
                    <input type="text" name="level" id="level" value="{{ old('level', $class->level ?? '') }}"
                        class="form-control" placeholder="Contoh: XII">
                </div>

                <div class="col-md-6">
                    <label for="major" class="form-label">Jurusan</label>
                    <input type="text" name="major" id="major" value="{{ old('major', $class->major ?? '') }}"
                        class="form-control" placeholder="Contoh: RPL">
                </div>

                <div class="col-md-6">
                    <label for="academic_year" class="form-label">Tahun Ajaran</label>
                    <input type="text" name="academic_year" id="academic_year" value="{{ old('academic_year', $class->academic_year ?? '') }}"
                        class="form-control" placeholder="Contoh: 2026/2027">
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" @selected(old('status', $class->status ?? 'active') === 'active')>Aktif</option>
                        <option value="inactive" @selected(old('status', $class->status ?? '') === 'inactive')>Nonaktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Simpan Data</button>
                <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg me-1"></i>Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
