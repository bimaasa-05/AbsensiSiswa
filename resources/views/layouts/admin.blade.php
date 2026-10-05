<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Absensi Siswa') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<div class="d-flex">
    <aside class="sidebar d-none d-md-flex flex-column flex-shrink-0 p-3 position-sticky top-0">
        <div class="sidebar-brand fw-bold mb-2 px-2">
            <i class="bi bi-mortarboard-fill me-2"></i>Absensi Siswa
        </div>
        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                </a>
            </li>
            <li class="sidebar-section">Master Data</li>
            <li class="nav-item">
                <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}"><i class="bi bi-people me-2"></i>Data Siswa</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.guardians.index') }}" class="nav-link {{ request()->routeIs('admin.guardians.*') ? 'active' : '' }}"><i class="bi bi-person-vcard me-2"></i>Data Orang Tua</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.classes.index') }}" class="nav-link {{ request()->routeIs('admin.classes.*') ? 'active' : '' }}"><i class="bi bi-building me-2"></i>Data Kelas</a>
            </li>
            <li class="sidebar-section">Absensi</li>
            <li class="nav-item">
                <a href="{{ route('attendance.scanner') }}" class="nav-link" target="_blank"><i class="bi bi-qr-code-scan me-2"></i>Scanner</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.fingerprint.mock') }}" class="nav-link {{ request()->routeIs('admin.fingerprint.*') ? 'active' : '' }}"><i class="bi bi-fingerprint me-2"></i>Fingerprint</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.attendances.today') }}" class="nav-link {{ request()->routeIs('admin.attendances.today') ? 'active' : '' }}"><i class="bi bi-clipboard-check me-2"></i>Absensi</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.attendances.missing') }}" class="nav-link {{ request()->routeIs('admin.attendances.missing') ? 'active' : '' }}"><i class="bi bi-person-exclamation me-2"></i>Belum Absen</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.attendances.history') }}" class="nav-link {{ request()->routeIs('admin.attendances.history') ? 'active' : '' }}"><i class="bi bi-clock-history me-2"></i>Riwayat</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.attendances.recap') }}" class="nav-link {{ request()->routeIs('admin.attendances.recap*') ? 'active' : '' }}"><i class="bi bi-table me-2"></i>Rekap</a>
            </li>
            <li class="sidebar-section">Sistem</li>
            <li class="nav-item">
                <a href="{{ route('admin.attendances.notifications') }}" class="nav-link {{ request()->routeIs('admin.attendances.notifications') ? 'active' : '' }}"><i class="bi bi-bell me-2"></i>Notifikasi</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.settings.edit') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"><i class="bi bi-gear me-2"></i>Pengaturan</a>
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
                            <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>

        <nav class="mobile-nav d-md-none sticky-top">
            <div class="d-flex px-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.attendances.today') }}" class="nav-link {{ request()->routeIs('admin.attendances.today') ? 'active' : '' }}">Absensi</a>
                <a href="{{ route('admin.attendances.missing') }}" class="nav-link {{ request()->routeIs('admin.attendances.missing') ? 'active' : '' }}">Belum Absen</a>
                <a href="{{ route('admin.attendances.history') }}" class="nav-link {{ request()->routeIs('admin.attendances.history') ? 'active' : '' }}">Riwayat</a>
                <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">Siswa</a>
            </div>
        </nav>

        <main class="p-4">
            @include('components.toast')

            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
