@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="hero-band mb-4">
    <div class="row align-items-center g-3">
        <div class="col-md-7">
            <div class="hero-label">{{ $today }}</div>
            <div class="hero-number"><em id="hero-checked">{{ $checkedIn }}</em><span class="fs-4"> / {{ $totalStudents }}</span></div>
            <div class="hero-label">siswa sudah melakukan absensi hari ini</div>
        </div>
        <div class="col-md-5">
            <div class="d-flex justify-content-between small mb-1">
                <span>Tingkat kehadiran</span>
                <span id="hero-percent">{{ $totalStudents > 0 ? round($checkedIn / $totalStudents * 100) : 0 }}%</span>
            </div>
            <div class="progress" role="progressbar" aria-label="Tingkat kehadiran">
                <div class="progress-bar" id="hero-bar" style="width: {{ $totalStudents > 0 ? round($checkedIn / $totalStudents * 100) : 0 }}%"></div>
            </div>
            <div class="small mt-2" style="color: #bcd2c4;">Diperbarui otomatis setiap 30 detik</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="stat-icon stat-icon--blue"><i class="bi bi-people"></i></span>
                <div>
                    <div class="stat-value" id="stat-total">{{ $totalStudents }}</div>
                    <div class="stat-label">Total Siswa</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="stat-icon stat-icon--green"><i class="bi bi-check-circle"></i></span>
                <div>
                    <div class="stat-value" id="stat-present">{{ $present }}</div>
                    <div class="stat-label">Sudah Hadir</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card stat-card h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <span class="stat-icon stat-icon--amber"><i class="bi bi-alarm"></i></span>
                <div>
                    <div class="stat-value" id="stat-late">{{ $late }}</div>
                    <div class="stat-label">Terlambat</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <a href="{{ route('admin.attendances.missing') }}" class="text-decoration-none">
            <div class="card stat-card h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <span class="stat-icon stat-icon--red"><i class="bi bi-person-exclamation"></i></span>
                    <div>
                        <div class="stat-value text-dark" id="stat-missing">{{ $notYet }}</div>
                        <div class="stat-label">Belum Absen</div>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h2 class="h6 fw-semibold mb-3">Absensi Terbaru</h2>
        <div id="recent-wrap">
            @if ($recent->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-calendar-x"></i>
                    <p>Belum ada data absensi hari ini.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-0">Jam</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="recent-body">
                            @foreach ($recent as $attendance)
                                <tr>
                                    <td class="ps-0">{{ $attendance['time'] }}</td>
                                    <td>{{ $attendance['name'] }}</td>
                                    <td>{{ $attendance['class'] }}</td>
                                    <td><span class="stamp stamp--{{ $attendance['status'] }}">{{ $attendance['status_label'] }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
(function () {
    var stampClass = {
        present: 'stamp--present',
        late: 'stamp--late',
        permission: 'stamp--permission',
        sick: 'stamp--sick',
        absent: 'stamp--absent'
    };

    function esc(text) {
        var div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function refresh() {
        fetch('{{ route('admin.dashboard') }}?live=1', { headers: { 'Accept': 'application/json' } })
            .then(function (response) { return response.json(); })
            .then(function (data) {
                document.getElementById('hero-checked').textContent = data.checkedIn;
                var percent = data.totalStudents > 0 ? Math.round(data.checkedIn / data.totalStudents * 100) : 0;
                document.getElementById('hero-percent').textContent = percent + '%';
                document.getElementById('hero-bar').style.width = percent + '%';
                document.getElementById('stat-total').textContent = data.totalStudents;
                document.getElementById('stat-present').textContent = data.present;
                document.getElementById('stat-late').textContent = data.late;
                document.getElementById('stat-missing').textContent = data.notYet;

                var wrap = document.getElementById('recent-wrap');
                if (!data.recent.length) {
                    wrap.innerHTML = '<div class="empty-state"><i class="bi bi-calendar-x"></i><p>Belum ada data absensi hari ini.</p></div>';
                    return;
                }
                var rows = data.recent.map(function (row) {
                    var cls = stampClass[row.status] || 'stamp--neutral';
                    return '<tr><td class="ps-0">' + esc(row.time) + '</td><td>' + esc(row.name) + '</td><td>' + esc(row.class) + '</td><td><span class="stamp ' + cls + '">' + esc(row.status_label) + '</span></td></tr>';
                }).join('');
                if (!document.getElementById('recent-body')) {
                    wrap.innerHTML = '<div class="table-responsive"><table class="table table-hover mb-0"><thead><tr><th class="ps-0">Jam</th><th>Nama</th><th>Kelas</th><th>Status</th></tr></thead><tbody id="recent-body">' + rows + '</tbody></table></div>';
                } else {
                    document.getElementById('recent-body').innerHTML = rows;
                }
            })
            .catch(function () {});
    }

    setInterval(refresh, 30000);
})();
</script>
@endsection
