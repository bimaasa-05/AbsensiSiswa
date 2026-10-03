<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Anak Saya') - {{ config('app.name', 'Absensi Siswa') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1f4e79;
            --secondary: #5b7083;
            --success: #2e7d32;
            --warning: #b7791f;
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
        .topbar {
            background-color: var(--surface);
            border-bottom: 1px solid var(--border);
        }
        .card {
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: none;
        }
        .status-banner {
            border: 1px solid var(--border);
            border-radius: 8px;
            background-color: var(--surface);
        }
    </style>
</head>
<body>
    <header class="topbar sticky-top">
        <div class="container d-flex align-items-center justify-content-between py-2" style="max-width: 720px;">
            <span class="fw-bold">Absensi Siswa</span>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-box-arrow-right me-1"></i>Keluar</button>
            </form>
        </div>
    </header>

    <main class="container py-3" style="max-width: 720px;">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
