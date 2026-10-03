@extends('layouts.guest')

@section('title', 'Absensi Siswa')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6 col-lg-5">
        <div class="text-center mb-3">
            <h1 class="h5 fw-bold mb-1">Absensi Siswa</h1>
            <p class="text-muted small mb-0" id="clock">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY HH:mm') }} WIB</p>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="btn-group w-100 mb-3" role="group">
                    <input type="radio" class="btn-check" name="scan-type" id="type-masuk" value="masuk" checked>
                    <label class="btn btn-outline-primary" for="type-masuk">Masuk</label>
                    <input type="radio" class="btn-check" name="scan-type" id="type-pulang" value="pulang">
                    <label class="btn btn-outline-primary" for="type-pulang">Pulang</label>
                </div>

                <div id="reader" class="border rounded"></div>
                <p class="text-muted small text-center mt-2 mb-0">Arahkan QR Code siswa ke kamera</p>
            </div>
        </div>

        <div id="result" class="alert d-none" role="alert"></div>

        <div class="text-center">
            <a href="{{ route('login') }}" class="btn btn-sm btn-link">Masuk sebagai Admin</a>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
(function () {
    const resultBox = document.getElementById('result');
    let processing = false;
    let cooldown = false;

    function showResult(success, message, data) {
        resultBox.classList.remove('d-none', 'alert-success', 'alert-danger');
        resultBox.classList.add(success ? 'alert-success' : 'alert-danger');
        if (success && data) {
            resultBox.innerHTML = '<strong>Absensi Berhasil</strong><br>' +
                data.name + ' &mdash; ' + data.class + '<br>' +
                data.time + ' WIB &mdash; ' + data.status + ' &mdash; ' + data.method;
        } else {
            resultBox.textContent = message;
        }
    }

    function onScan(qrToken) {
        if (processing || cooldown) return;
        processing = true;

        const type = document.querySelector('input[name="scan-type"]:checked').value;

        fetch('{{ route('attendance.scan') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ qr_token: qrToken, type: type }),
        })
            .then(async (response) => {
                const body = await response.json();
                showResult(body.success, body.message, body.data);
                if (body.success) {
                    cooldown = true;
                    setTimeout(() => { cooldown = false; }, 3000);
                }
            })
            .catch(() => showResult(false, 'Absensi belum dapat diproses. Silakan coba kembali.'))
            .finally(() => { processing = false; });
    }

    const scanner = new Html5Qrcode('reader');
    scanner.start(
        { facingMode: 'environment' },
        { fps: 10, qrbox: { width: 220, height: 220 } },
        onScan,
        () => {}
    ).catch(() => {
        showResult(false, 'Kamera tidak tersedia atau izin kamera ditolak.');
    });
})();
</script>
@endsection
