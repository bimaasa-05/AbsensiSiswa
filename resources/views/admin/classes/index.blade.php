@extends('layouts.admin')

@section('title', 'Data Kelas')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start">
    <div>
        <h1>Data Kelas</h1>
        <p>Kelola data kelas sekolah.</p>
    </div>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary btn-sm flex-shrink-0">
        <i class="bi bi-plus-lg me-1"></i>Tambah Kelas
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <input type="text" id="live-search" class="form-control form-control-sm" placeholder="Cari nama kelas..." autocomplete="off">
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Nama Kelas</th>
                        <th>Tingkat</th>
                        <th>Jurusan</th>
                        <th>Tahun Ajaran</th>
                        <th>Jumlah Siswa</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="classes-body">
                    @forelse ($classes as $class)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration + $classes->firstItem() - 1 }}</td>
                            <td class="fw-medium">{{ $class->name }}</td>
                            <td>{{ $class->level ?? '-' }}</td>
                            <td>{{ $class->major ?? '-' }}</td>
                            <td>{{ $class->academic_year ?? '-' }}</td>
                            <td>{{ $class->students_count }}</td>
                            <td>
                                @if ($class->isActive())
                                    <span class="badge text-bg-success"><i class="bi bi-check-lg me-1"></i>Aktif</span>
                                @else
                                    <span class="badge text-bg-secondary"><i class="bi bi-dash-lg me-1"></i>Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.classes.edit', $class) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Ubah</a>
                                <form method="POST" action="{{ route('admin.classes.destroy', $class) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus kelas {{ $class->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash me-1"></i>Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-building"></i>
                                    <p>Belum ada data kelas.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($classes->hasPages())
        <div class="card-footer">{{ $classes->links() }}</div>
    @endif
</div>

<script>
(function () {
    var input = document.getElementById('live-search');
    var tbody = document.getElementById('classes-body');
    var timer = null;
    if (!input || !tbody) return;

    function esc(text) {
        var div = document.createElement('div');
        div.textContent = text == null ? '' : String(text);
        return div.innerHTML;
    }

    function render(rows) {
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="8"><div class="empty-state"><i class="bi bi-building"></i><p>Tidak ada kelas yang cocok.</p></div></td></tr>';
            return;
        }
        tbody.innerHTML = rows.map(function (row, i) {
            var badge = row.active
                ? '<span class="badge text-bg-success"><i class="bi bi-check-lg me-1"></i>Aktif</span>'
                : '<span class="badge text-bg-secondary"><i class="bi bi-dash-lg me-1"></i>Nonaktif</span>';
            return '<tr><td class="ps-3">' + (i + 1) + '</td><td class="fw-medium">' + esc(row.name) + '</td><td>' + esc(row.level) + '</td><td>' + esc(row.major) + '</td><td>' + esc(row.academic_year) + '</td><td>' + row.students + '</td><td>' + badge + '</td><td class="text-end pe-3"><a href="' + row.edit_url + '" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Ubah</a> <button type="button" class="btn btn-sm btn-outline-danger" data-delete-url="' + row.delete_url + '" data-name="' + esc(row.name) + '"><i class="bi bi-trash me-1"></i>Hapus</button></td></tr>';
        }).join('');
    }

    tbody.addEventListener('click', function (event) {
        var button = event.target.closest('[data-delete-url]');
        if (!button) return;
        if (!confirm('Hapus kelas ' + button.getAttribute('data-name') + '?')) return;
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var form = document.createElement('form');
        form.method = 'POST';
        form.action = button.getAttribute('data-delete-url');
        form.innerHTML = '<input type="hidden" name="_token" value="' + token + '"><input type="hidden" name="_method" value="DELETE">';
        document.body.appendChild(form);
        form.submit();
    });

    input.addEventListener('input', function () {
        clearTimeout(timer);
        timer = setTimeout(function () {
            var url = '{{ route('admin.classes.index') }}?search=' + encodeURIComponent(input.value);
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
                .then(function (response) { return response.json(); })
                .then(function (body) { render(body.data || []); })
                .catch(function () {});
        }, 300);
    });
})();
</script>
@endsection
