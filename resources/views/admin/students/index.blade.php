@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start">
    <div>
        <h1>Data Siswa</h1>
        <p>Kelola data siswa sekolah.</p>
    </div>
    <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-sm flex-shrink-0">
        <i class="bi bi-plus-lg me-1"></i>Tambah Siswa
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.students.index') }}" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" id="live-search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Cari nama atau NIS..." autocomplete="off">
            </div>
            <div class="col-md-4">
                <select name="class_id" class="form-select form-select-sm">
                    <option value="">Semua Kelas</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" @selected(request('class_id') == $class->id)>{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-sm btn-outline-secondary">Cari</button>
                <a href="{{ route('admin.students.index') }}" class="btn btn-sm btn-link">Atur ulang</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Orang Tua</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="students-body">
                    @forelse ($students as $student)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration + $students->firstItem() - 1 }}</td>
                            <td>{{ $student->nis }}</td>
                            <td class="fw-medium">{{ $student->name }}</td>
                            <td>{{ $student->schoolClass->name ?? '-' }}</td>
                            <td>{{ $student->guardian->name ?? '-' }}</td>
                            <td>
                                @if ($student->isActive())
                                    <span class="badge text-bg-success"><i class="bi bi-check-lg me-1"></i>Aktif</span>
                                @else
                                    <span class="badge text-bg-secondary"><i class="bi bi-dash-lg me-1"></i>Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.students.show', $student) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-qr-code me-1"></i>QR</a>
                                <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Ubah</a>
                                @if ($student->isActive())
                                    <form method="POST" action="{{ route('admin.students.destroy', $student) }}" class="d-inline"
                                        onsubmit="return confirm('Nonaktifkan siswa {{ $student->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-person-x me-1"></i>Nonaktifkan</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="bi bi-people"></i>
                                    <p>Belum ada data siswa.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($students->hasPages())
        <div class="card-footer">{{ $students->links() }}</div>
    @endif
</div>

<script>
(function () {
    var input = document.getElementById('live-search');
    var tbody = document.getElementById('students-body');
    var timer = null;
    if (!input || !tbody) return;

    function esc(text) {
        var div = document.createElement('div');
        div.textContent = text == null ? '' : String(text);
        return div.innerHTML;
    }

    function render(rows) {
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="7"><div class="empty-state"><i class="bi bi-people"></i><p>Tidak ada siswa yang cocok.</p></div></td></tr>';
            return;
        }
        tbody.innerHTML = rows.map(function (row, i) {
            var badge = row.active
                ? '<span class="badge text-bg-success"><i class="bi bi-check-lg me-1"></i>Aktif</span>'
                : '<span class="badge text-bg-secondary"><i class="bi bi-dash-lg me-1"></i>Nonaktif</span>';
            var deactivate = row.active
                ? ' <button type="button" class="btn btn-sm btn-outline-danger" data-deactivate-url="' + row.delete_url + '" data-name="' + esc(row.name) + '"><i class="bi bi-person-x me-1"></i>Nonaktifkan</button>'
                : '';
            return '<tr><td class="ps-3">' + (i + 1) + '</td><td>' + esc(row.nis) + '</td><td class="fw-medium">' + esc(row.name) + '</td><td>' + esc(row.class) + '</td><td>' + esc(row.guardian) + '</td><td>' + badge + '</td><td class="text-end pe-3"><a href="' + row.qr_url + '" class="btn btn-sm btn-outline-secondary"><i class="bi bi-qr-code me-1"></i>QR</a> <a href="' + row.edit_url + '" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Ubah</a>' + deactivate + '</td></tr>';
        }).join('');
    }

    tbody.addEventListener('click', function (event) {
        var button = event.target.closest('[data-deactivate-url]');
        if (!button) return;
        if (!confirm('Nonaktifkan siswa ' + button.getAttribute('data-name') + '?')) return;
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = button.getAttribute('data-deactivate-url');
        form.innerHTML = '<input type="hidden" name="_token" value="' + token + '"><input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    });

    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            var url = '{{ route('admin.students.index') }}?search=' + encodeURIComponent(input.value);
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
                .then(function (response) { return response.json(); })
                .then(function (body) { render(body.data || []); })
                .catch(function () {});
        }, 300);
    });
})();
</script>
@endsection
