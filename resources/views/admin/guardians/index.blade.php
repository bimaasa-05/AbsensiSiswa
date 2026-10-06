@extends('layouts.admin')

@section('title', 'Data Orang Tua')

@section('content')
<div class="page-header d-flex justify-content-between align-items-start">
    <div>
        <h1>Data Orang Tua</h1>
        <p>Kelola data orang tua/wali siswa.</p>
    </div>
    <a href="{{ route('admin.guardians.create') }}" class="btn btn-primary btn-sm flex-shrink-0">
        <i class="bi bi-plus-lg me-1"></i>Tambah Orang Tua
    </a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <input type="text" id="live-search" class="form-control form-control-sm" placeholder="Cari nama atau nomor WhatsApp..." autocomplete="off">
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">No</th>
                        <th>Nama</th>
                        <th>Nomor WhatsApp</th>
                        <th>Email</th>
                        <th>Jumlah Anak</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Aksi</th>
                    </tr>
                </thead>
                <tbody id="guardians-body">
                    @forelse ($guardians as $guardian)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration + $guardians->firstItem() - 1 }}</td>
                            <td class="fw-medium">{{ $guardian->name }}</td>
                            <td>{{ $guardian->phone }}</td>
                            <td>{{ $guardian->email ?? '-' }}</td>
                            <td>{{ $guardian->students_count }}</td>
                            <td>
                                @if ($guardian->isActive())
                                    <span class="badge text-bg-success"><i class="bi bi-check-lg me-1"></i>Aktif</span>
                                @else
                                    <span class="badge text-bg-secondary"><i class="bi bi-dash-lg me-1"></i>Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <a href="{{ route('admin.guardians.edit', $guardian) }}" class="btn btn-sm btn-accent"><i class="bi bi-pencil me-1"></i>Ubah</a>
                                <form method="POST" action="{{ route('admin.guardians.destroy', $guardian) }}" class="d-inline"
                                    onsubmit="return confirm('Hapus data {{ $guardian->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash me-1"></i>Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="bi bi-person-vcard"></i>
                                    <p>Belum ada data orang tua/wali.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($guardians->hasPages())
        <div class="card-footer">{{ $guardians->links() }}</div>
    @endif
</div>

<script>
(function () {
    var input = document.getElementById('live-search');
    var tbody = document.getElementById('guardians-body');
    var timer = null;
    if (!input || !tbody) return;

    function esc(text) {
        var div = document.createElement('div');
        div.textContent = text == null ? '' : String(text);
        return div.innerHTML;
    }

    function render(rows) {
        if (!rows.length) {
            tbody.innerHTML = '<tr><td colspan="7"><div class="empty-state"><i class="bi bi-person-vcard"></i><p>Tidak ada orang tua yang cocok.</p></div></td></tr>';
            return;
        }
        tbody.innerHTML = rows.map(function (row, i) {
            var badge = row.active
                ? '<span class="badge text-bg-success"><i class="bi bi-check-lg me-1"></i>Aktif</span>'
                : '<span class="badge text-bg-secondary"><i class="bi bi-dash-lg me-1"></i>Nonaktif</span>';
            return '<tr><td class="ps-3">' + (i + 1) + '</td><td class="fw-medium">' + esc(row.name) + '</td><td>' + esc(row.phone) + '</td><td>' + esc(row.email) + '</td><td>' + row.children + '</td><td>' + badge + '</td><td class="text-end pe-3"><a href="' + row.edit_url + '" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil me-1"></i>Ubah</a> <button type="button" class="btn btn-sm btn-outline-danger" data-delete-url="' + row.delete_url + '" data-name="' + esc(row.name) + '"><i class="bi bi-trash me-1"></i>Hapus</button></td></tr>';
        }).join('');
    }

    tbody.addEventListener('click', function (event) {
        var button = event.target.closest('[data-delete-url]');
        if (!button) return;
        if (!confirm('Hapus data ' + button.getAttribute('data-name') + '?')) return;
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
            var url = '{{ route('admin.guardians.index') }}?search=' + encodeURIComponent(input.value);
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
                .then(function (response) { return response.json(); })
                .then(function (body) { render(body.data || []); })
                .catch(function () {});
        }, 300);
    });
})();
</script>
@endsection
