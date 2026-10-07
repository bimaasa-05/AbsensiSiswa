<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rekap Absensi — {{ $settings->school_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; color: #1c2b26; }
        .kop { border-bottom: 3px solid #1e4d3b; padding-bottom: 1rem; margin-bottom: 1.5rem; }
        .kop h1 { font-size: 1.4rem; font-weight: 700; margin-bottom: 0.1rem; }
        .kop p { margin-bottom: 0; font-size: 0.85rem; color: #5f7269; }
        .table thead th { background-color: #1e4d3b !important; color: #fff !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .ttd { margin-top: 2.5rem; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body class="p-4">
    <div class="no-print mb-3 d-flex gap-2">
        <button type="button" class="btn btn-primary btn-sm" onclick="window.print()"><i class="bi bi-printer me-1"></i>Cetak</button>
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.close()"><i class="bi bi-arrow-left me-1"></i>Kembali</button>
    </div>

    <div class="kop text-center">
        <h1>{{ $settings->school_name }}</h1>
        <p>{{ $settings->school_address ?? '' }}{{ $settings->school_phone ? ' • Telp. '.$settings->school_phone : '' }}</p>
    </div>

    <h2 class="h5 fw-bold text-center mb-1">Rekap Absensi Siswa</h2>
    <p class="text-center text-muted small mb-4">
        Periode {{ \Carbon\Carbon::parse($start)->locale('id')->isoFormat('D MMMM YYYY') }}
        sampai {{ \Carbon\Carbon::parse($end)->locale('id')->isoFormat('D MMMM YYYY') }}
        • Kelas: {{ $className }}
    </p>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th class="text-center">Hadir</th>
                <th class="text-center">Terlambat</th>
                <th class="text-center">Izin</th>
                <th class="text-center">Sakit</th>
                <th class="text-center">Alpha</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recap as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row['student']->name }}</td>
                    <td>{{ $row['student']->nis }}</td>
                    <td>{{ $row['student']->schoolClass->name ?? '-' }}</td>
                    <td class="text-center">{{ $row['present'] }}</td>
                    <td class="text-center">{{ $row['late'] }}</td>
                    <td class="text-center">{{ $row['permission'] }}</td>
                    <td class="text-center">{{ $row['sick'] }}</td>
                    <td class="text-center">{{ $row['absent'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">Belum ada data siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="ttd row">
        <div class="col-6 text-center">
            <p class="mb-5">Wali Kelas,</p>
            <p class="fw-bold mb-0">( ........................................ )</p>
        </div>
        <div class="col-6 text-center">
            <p class="mb-5">{{ \Carbon\Carbon::parse($end)->locale('id')->isoFormat('D MMMM YYYY') }},<br>Kepala Sekolah,</p>
            <p class="fw-bold mb-0">( ........................................ )</p>
        </div>
    </div>

    <script>
        window.onafterprint = function () { window.close(); };
    </script>
</body>
</html>
