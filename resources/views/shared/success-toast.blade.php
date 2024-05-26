@if (Session::has('successToast'))
    <div id="success-toast" class="toast position-absolute top-3 start-50 translate-middle-x mt-3" style="z-index: 2000;"
        role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <span class="badge text-bg-primary me-2 fs-6">❤️</span>
            <strong class="me-auto">Sukces</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Zamknij"></button>
        </div>
        <div class="toast-body">
            {{ Session::get('successToast') }}
        </div>
    </div>

    @push('body-scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const successToast = document.getElementById('success-toast');
                const bootstrapToast = new bootstrap.Toast(successToast);
                bootstrapToast.show();
            });
        </script>
    @endpush
@endif
