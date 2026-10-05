@if (session('success') || session('error'))
    <div class="toast-container position-fixed top-0 end-0 p-3">
        @if (session('success'))
            <div class="toast toast-success align-items-center bg-white" role="alert" aria-live="polite">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>{{ session('success') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div class="toast toast-error align-items-center bg-white" role="alert" aria-live="assertive">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>{{ session('error') }}
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
                </div>
            </div>
        @endif
    </div>
    <script>
    (function () {
        if (typeof bootstrap === 'undefined') return;
        document.querySelectorAll('.toast-container .toast').forEach(function (el) {
            new bootstrap.Toast(el, { delay: 4000 }).show();
        });
    })();
    </script>
@endif
