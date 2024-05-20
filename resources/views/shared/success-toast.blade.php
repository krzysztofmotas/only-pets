@if (Session::has('successToast'))
    <div id="success-toast" style="z-index: 2000;"
        class="toast text-bg-success position-absolute top-0 start-50 translate-middle-x mt-3" role="alert"
        aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">{{ Session::get('successToast') }}</div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Zamknij"></button>
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
