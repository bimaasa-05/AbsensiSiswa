<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Absensi Siswa') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1f4e79;
            --secondary: #5b7083;
            --success: #2e7d32;
            --warning: #b7791f;
            --danger: #c62828;
            --background: #f5f7fa;
            --surface: #ffffff;
            --text: #263238;
            --border: #dde3e8;
        }
        body {
            font-family: 'Inter', -apple-system, 'Segoe UI', sans-serif;
            background-color: var(--background);
            color: var(--text);
        }
        .sidebar {
            width: 230px;
            min-height: 100vh;
            background-color: var(--surface);
            border-right: 1px solid var(--border);
        }
        .sidebar .nav-link {
            color: var(--text);
            border-radius: 6px;
            padding: 0.55rem 0.9rem;
            font-size: 0.925rem;
        }
        .sidebar .nav-link:hover {
            background-color: var(--background);
        }
        .sidebar .nav-link.active {
            background-color: var(--primary);
            color: #fff;
        }
        .topbar {
            background-color: var(--surface);
            border-bottom: 1px solid var(--border);
        }
        .card {
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: none;
        }
        .btn-primary {
            --bs-btn-bg: var(--primary);
            --bs-btn-border-color: var(--primary);
            --bs-btn-hover-bg: #183d5f;
            --bs-btn-hover-border-color: #183d5f;
        }
        .table thead th {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            color: var(--secondary);
            border-bottom: 1px solid var(--border);
        }
        a { color: var(--primary); }
    </style>
    @stack('styles')
</head>
<body>
<div class="d-flex">
    <aside class="sidebar d-none d-md-flex flex-column flex-shrink-0 p-3 position-sticky top-0">
        <span class="fw-bold mb-4 px-2">Absensi Siswa</span>
        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="bi bi-people me-2"></i>Data Siswa</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.guardians.index') }}" class="nav-link {{ request()->routeIs('admin.guardians.*') ? 'active' : '' }}"><i class="bi bi-person-vcard me-2"></i>Data Orang Tua</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.classes.index') }}" class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}"><i class="bi bi-building me-2"></i>Data Kelas</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="bi bi-clipboard-check me-2"></i>Absensi</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="bi bi-table me-2"></i>Rekap</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link"><i class="bi bi-gear me-2"></i>Pengaturan</a>
            </li>
        </ul>
    </aside>

    <div class="flex-grow-1 min-vw-0">
        <header class="topbar d-flex align-items-center justify-content-between px-4 py-2 sticky-top">
            <span class="fw-semibold">@yield('title', 'Dashboard')</span>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ auth()->user()->name ?? 'Pengguna' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <main class="p-4">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
