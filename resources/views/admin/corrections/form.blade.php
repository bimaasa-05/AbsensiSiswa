@extends('layouts.admin')

@section('title', 'Koreksi Absensi')

@section('content')
<div class="page-header">
    <h1>Koreksi Absensi</h1>
    <p>Ubah status kehadiran beserta alasan yang tercatat.</p>
</div>
<div class="row g-3">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h2 class="h6 fw-semibold mb-3">Data Absensi</h2>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Tanggal</dt>
                    <dd class="col-sm-8">{{ $attendance->attendance_date->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</dd>
                    <dt class="col-sm-4">Siswa</dt>
                    <dd class="col-sm-8">{{ $attendance->student->name }}</dd>
                    <dt class="col-sm-4">Kelas</dt>
                    <dd class="col-sm-8">{{ $attendance->student->schoolClass->name ?? '-' }}</dd>
                    <dt class="col-sm-4">Masuk</dt>
                    <dd class="col-sm-8">{{ $attendance->check_in ? substr((string) $attendance->check_in, 0, 5) : '-' }}</dd>
                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">{{ \App\Models\Attendance::statusLabel($attendance->status) }}</dd>
                </dl>
            </div>
        </div>

        @if ($attendance->corrections->isNotEmpty())
            <div class="card mt-3">
                <div class="card-body">
                    <h2 class="h6 fw-semibold mb-3">Riwayat Koreksi</h2>
                    <ul class="list-unstyled mb-0">
                        @foreach ($attendance->corrections as $correction)
                            <li class="mb-2 small">
                                {{ \App\Models\Attendance::statusLabel($correction->old_status) }}
                                &rarr; {{ \App\Models\Attendance::statusLabel($correction->new_status) }}
                                <span class="text-muted">oleh {{ $correction->user->name }}</span><br>
                                <span class="text-muted">{{ $correction->reason }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h2 class="h6 fw-semibold mb-3">Ubah Status</h2>
                <form method="POST" action="{{ route('admin.corrections.update', $attendance) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Baru</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach ($statuses as $value => $label)
                                <option value="{{ $value }}" @selected(old('status') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan Koreksi</label>
                        <textarea name="reason" id="reason" rows="3" class="form-control @error('reason') is-invalid @enderror"
                            placeholder="Contoh: Surat izin dari orang tua" required>{{ old('reason') }}</textarea>
                        @error('reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i>Simpan Koreksi</button>
                        <a href="{{ route('admin.attendances.today') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg me-1"></i>Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
