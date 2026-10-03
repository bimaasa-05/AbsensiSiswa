@extends('layouts.admin')

@section('title', isset($student) ? 'Ubah Siswa' : 'Tambah Siswa')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($student) ? route('admin.students.update', $student) : route('admin.students.store') }}">
            @csrf
            @if (isset($student))
                @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nis" class="form-label">NIS</label>
                    <input type="text" name="nis" id="nis" value="{{ old('nis', $student->nis ?? '') }}"
                        class="form-control @error('nis') is-invalid @enderror" required>
                    @error('nis')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="nisn" class="form-label">NISN <span class="text-muted">(opsional)</span></label>
                    <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $student->nisn ?? '') }}"
                        class="form-control @error('nisn') is-invalid @enderror">
                    @error('nisn')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $student->name ?? '') }}"
                        class="form-control @error('name') is-invalid @enderror" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="gender" class="form-label">Jenis Kelamin</label>
                    <select name="gender" id="gender" class="form-select">
                        <option value="">Pilih jenis kelamin</option>
                        <option value="L" @selected(old('gender', $student->gender ?? '') === 'L')>Laki-laki</option>
                        <option value="P" @selected(old('gender', $student->gender ?? '') === 'P')>Perempuan</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="class_id" class="form-label">Kelas</label>
                    <select name="class_id" id="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                        <option value="">Pilih kelas</option>
                        @foreach ($classes as $class)
                            <option value="{{ $class->id }}" @selected(old('class_id', $student->class_id ?? '') == $class->id)>{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="parent_id" class="form-label">Orang Tua/Wali</label>
                    <select name="parent_id" id="parent_id" class="form-select @error('parent_id') is-invalid @enderror">
                        <option value="">Pilih orang tua/wali</option>
                        @foreach ($guardians as $guardian)
                            <option value="{{ $guardian->id }}" @selected(old('parent_id', $student->parent_id ?? '') == $guardian->id)>{{ $guardian->name }}</option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="active" @selected(old('status', $student->status ?? 'active') === 'active')>Aktif</option>
                        <option value="inactive" @selected(old('status', $student->status ?? '') === 'inactive')>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
