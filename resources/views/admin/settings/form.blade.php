@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            <h2 class="h6 fw-semibold mb-3">Identitas Sekolah</h2>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label for="school_name" class="form-label">Nama Sekolah</label>
                    <input type="text" name="school_name" id="school_name" value="{{ old('school_name', $settings->school_name) }}"
                        class="form-control @error('school_name') is-invalid @enderror" required>
                    @error('school_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="school_phone" class="form-label">Nomor Telepon</label>
                    <input type="text" name="school_phone" id="school_phone" value="{{ old('school_phone', $settings->school_phone) }}"
                        class="form-control">
                </div>
                <div class="col-12">
                    <label for="school_address" class="form-label">Alamat</label>
                    <textarea name="school_address" id="school_address" rows="2" class="form-control">{{ old('school_address', $settings->school_address) }}</textarea>
                </div>
            </div>

            <h2 class="h6 fw-semibold mb-3">Jam Sekolah</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="check_in_time" class="form-label">Jam Masuk</label>
                    <input type="time" name="check_in_time" id="check_in_time" value="{{ old('check_in_time', substr((string) $settings->check_in_time, 0, 5)) }}"
                        class="form-control @error('check_in_time') is-invalid @enderror" required>
                    @error('check_in_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="late_tolerance_minutes" class="form-label">Toleransi Terlambat (menit)</label>
                    <input type="number" name="late_tolerance_minutes" id="late_tolerance_minutes" value="{{ old('late_tolerance_minutes', $settings->late_tolerance_minutes) }}"
                        class="form-control @error('late_tolerance_minutes') is-invalid @enderror" min="0" max="120" required>
                    @error('late_tolerance_minutes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="check_out_time" class="form-label">Jam Pulang <span class="text-muted">(opsional)</span></label>
                    <input type="time" name="check_out_time" id="check_out_time" value="{{ old('check_out_time', $settings->check_out_time ? substr((string) $settings->check_out_time, 0, 5) : '') }}"
                        class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="timezone" class="form-label">Zona Waktu</label>
                    <select name="timezone" id="timezone" class="form-select" required>
                        @foreach (['Asia/Jakarta' => 'WIB (Asia/Jakarta)', 'Asia/Makassar' => 'WITA (Asia/Makassar)', 'Asia/Jayapura' => 'WIT (Asia/Jayapura)'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('timezone', $settings->timezone) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection
