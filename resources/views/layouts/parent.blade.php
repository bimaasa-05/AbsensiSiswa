<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Anak Saya') - {{ config('app.name', 'Absensi Siswa') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .topbar {
            background-color: var(--primary-dark);
            border-bottom: 3px solid var(--accent);
        }
        .topbar .fw-bold {
            color: #ffffff;
        }
        .topbar .fw-bold i {
            color: var(--accent);
        }
        .topbar .btn-outline-secondary {
            --bs-btn-color: #ffffff;
            --bs-btn-border-color: rgba(255, 255, 255, 0.5);
            --bs-btn-hover-bg: rgba(255, 255, 255, 0.15);
            --bs-btn-hover-border-color: #ffffff;
        }
    </style>
</head>
<body>
    <header class="topbar sticky-top">
        <div class="container d-flex align-items-center justify-content-between py-2" style="max-width: 720px;">
            <span class="fw-bold"><i class="bi bi-mortarboard-fill me-2"></i>Absensi Siswa</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-box-arrow-right me-1"></i>Keluar</button>
            </form>
        </div>
    </header>

    <main class="container py-3" style="max-width: 720px;">
        @include('components.toast')

        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
