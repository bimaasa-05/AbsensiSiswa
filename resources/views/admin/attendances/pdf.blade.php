<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi — {{ $settings->school_name }}</title>
    <style>
        body { font-family: sans-serif; color: #1c2b26; font-size: 11px; }
        .kop { text-align: center; border-bottom: 3px solid #1e4d3b; padding-bottom: 10px; margin-bottom: 16px; }
        .kop h1 { font-size: 18px; margin: 0 0 2px; }
        .kop p { margin: 0; font-size: 10px; color: #5f7269; }
        .judul { text-align: center; font-size: 14px; font-weight: bold; margin: 0 0 2px; }
        .periode { text-align: center; font-size: 10px; color: #5f7269; margin: 0 0 14px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #1e4d3b; color: #ffffff; font-size: 10px; padding: 6px 4px; border: 1px solid #1e4d3b; }
        td { padding: 4px; border: 1px solid #d8e2dc; font-size: 10px; }
        td.center { text-align: center; }
        .ttd { margin-top: 30px; width: 100%; }
        .ttd td { border: none; text-align: center; font-size: 11px; }
    </style>
</head>
<body>
    <div class="kop">
        <h1>{{ $settings->school_name }}</h1>
        <p>{{ $settings->school_address ?? '' }}{{ $settings->school_phone ? ' • Telp. '.$settings->school_phone : '' }}</p>
    </div>

    <p class="judul">Rekap Absensi Siswa</p>
    <p class="periode">
        Periode {{ \Carbon\Carbon::parse($start)->locale('id')->isoFormat('D MMMM YYYY') }}
        sampai {{ \Carbon\Carbon::parse($end)->locale('id')->isoFormat('D MMMM YYYY') }}
        • Kelas: {{ $className }}
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIS</th>
                <th>Kelas</th>
                <th>Hadir</th>
                <th>Terlambat</th>
                <th>Izin</th>
                <th>Sakit</th>
                <th>Alpha</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($recap as $row)
                <tr>
                    <td class="center">{{ $loop->iteration }}</td>
                    <td>{{ $row['student']->name }}</td>
                    <td>{{ $row['student']->nis }}</td>
                    <td>{{ $row['student']->schoolClass->name ?? '-' }}</td>
                    <td class="center">{{ $row['present'] }}</td>
                    <td class="center">{{ $row['late'] }}</td>
                    <td class="center">{{ $row['permission'] }}</td>
                    <td class="center">{{ $row['sick'] }}</td>
                    <td class="center">{{ $row['absent'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="center">Belum ada data siswa.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="ttd">
        <tr>
            <td>Wali Kelas,<br><br><br><br><br><strong>( ........................................ )</strong></td>
            <td>{{ \Carbon\Carbon::parse($end)->locale('id')->isoFormat('D MMMM YYYY') }},<br>Kepala Sekolah,<br><br><br><br><strong>( ........................................ )</strong></td>
        </tr>
    </table>
</body>
</html>
