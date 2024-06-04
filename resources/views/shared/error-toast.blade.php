@if (Session::has('errorToast'))
    <div id="error-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <span class="badge text-bg-danger me-2 fs-6">😢</span>
            <strong class="me-auto">Błąd</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Zamknij"></button>
        </div>
        <div class="toast-body">
            {{ Session::get('errorToast') }}
        </div>
    </div>

    @push('body-scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const errorToast = document.getElementById('error-toast');
                const bootstrapToast = new bootstrap.Toast(errorToast);
                bootstrapToast.show();
            });
        </script>
    @endpush

    @php
        Session::forget('errorToast');
    @endphp
@endif
