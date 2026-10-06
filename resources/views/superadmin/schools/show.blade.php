@extends('layouts.admin')

@section('title', 'Detail Sekolah')

@section('content')
<div class="page-header">
    <h1>{{ $school->name }}</h1>
    <p>Diajukan {{ $school->created_at->locale('id')->isoFormat('D MMMM YYYY HH:mm') }} • Status: {{ \App\Models\School::statusLabel($school->status) }}</p>
</div>

@if (session('new_admin_email'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill me-1"></i>Akun admin berhasil dibuat. Serahkan kredensial ini ke pihak sekolah (hanya tampil sekali):
        <br>Email: <strong>{{ session('new_admin_email') }}</strong>
        <br>Kata sandi: <strong>{{ session('new_admin_password') }}</strong>
    </div>
@endif

<div class="row g-3">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h2 class="h6 fw-semibold mb-3">Data Pengajuan</h2>
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nama Sekolah</dt>
                    <dd class="col-sm-8">{{ $school->name }}</dd>
                    <dt class="col-sm-4">Alamat</dt>
                    <dd class="col-sm-8">{{ $school->address ?? '-' }}</dd>
                    <dt class="col-sm-4">Telepon</dt>
                    <dd class="col-sm-8">{{ $school->phone ?? '-' }}</dd>
                    <dt class="col-sm-4">Email</dt>
                    <dd class="col-sm-8">{{ $school->email ?? '-' }}</dd>
                    <dt class="col-sm-4">Penanggung Jawab</dt>
                    <dd class="col-sm-8">{{ $school->contact_person ?? '-' }}</dd>
                    <dt class="col-sm-4">Jumlah Siswa</dt>
                    <dd class="col-sm-8">{{ $school->students_count }}</dd>
                    <dt class="col-sm-4">Jumlah Pengguna</dt>
                    <dd class="col-sm-8">{{ $school->users_count }}</dd>
                    @if ($school->status === 'rejected')
                        <dt class="col-sm-4">Alasan Ditolak</dt>
                        <dd class="col-sm-8">{{ $school->rejection_reason }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        @if ($school->isPending())
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="h6 fw-semibold mb-3">Setujui Sekolah</h2>
                    <p class="text-muted small">Menyetujui akan membuatkan akun admin otomatis untuk sekolah ini.</p>
                    <form method="POST" action="{{ route('superadmin.schools.approve', $school) }}"
                        onsubmit="return confirm('Setujui {{ $school->name }}?')">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-lg me-1"></i>Setujui</button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h2 class="h6 fw-semibold mb-3">Tolak Pengajuan</h2>
                    <form method="POST" action="{{ route('superadmin.schools.reject', $school) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">Alasan Penolakan</label>
                            <textarea name="rejection_reason" id="rejection_reason" rows="3" class="form-control @error('rejection_reason') is-invalid @enderror" required>{{ old('rejection_reason') }}</textarea>
                            @error('rejection_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-lg me-1"></i>Tolak</button>
                    </form>
                </div>
            </div>
        @endif

        <a href="{{ route('superadmin.schools.index') }}" class="btn btn-sm btn-link mt-3"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
    </div>
</div>
@endsection
