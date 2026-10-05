@extends('layouts.admin')

@section('title', isset($holiday) ? 'Ubah Libur' : 'Tambah Libur')

@section('content')
<div class="page-header">
    <h1>{{ isset($holiday) ? 'Ubah Libur' : 'Tambah Libur' }}</h1>
    <p>{{ isset($holiday) ? 'Perbarui hari libur.' : 'Daftarkan hari libur baru ke kalender sekolah.' }}</p>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ isset($holiday) ? route('admin.holidays.update', $holiday) : route('admin.holidays.store') }}">
            @csrf
            @if (isset($holiday))
                @method('PUT')
            @endif

            <div class="row g-3">
                <div class="col-md-4">
                    <label for="holiday_date" class="form-label">Tanggal</label>
                    <input type="date" name="holiday_date" id="holiday_date" value="{{ old('holiday_date', isset($holiday) ? $holiday->holiday_date->format('Y-m-d') : '') }}"
                        class="form-control @error('holiday_date') is-invalid @enderror" required>
                    @error('holiday_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="name" class="form-label">Nama Libur</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $holiday->name ?? '') }}"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Contoh: Libur Semester" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="type" class="form-label">Jenis</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="school" @selected(old('type', $holiday->type ?? 'school') === 'school')>Sekolah</option>
                        <option value="national" @selected(old('type', $holiday->type ?? '') === 'national')>Nasional</option>
                        <option value="weekend" @selected(old('type', $holiday->type ?? '') === 'weekend')>Akhir Pekan</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Simpan Data</button>
                <a href="{{ route('admin.holidays.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg me-1"></i>Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
