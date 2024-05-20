@extends('home.template')

@section('title', 'Ustawienia')

@push('body-scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const activeTab = @json(session('activeTab', 'name'));
            const triggerElement = document.getElementById(`v-pills-${activeTab}-tab`);

            const tab = new bootstrap.Tab(triggerElement);
            if (tab) {
                tab.show();
            }
        });
    </script>
@endpush

@section('center-column')
    <div class="row mt-3">
        <div class="col">
            <div class="d-flex align-items-start w-100">
                <div class="nav flex-column nav-pills me-3 border rounded p-3 w-50" id="v-pills-tab" role="tablist"
                    aria-orientation="vertical">
                    <button class="nav-link text-start link-body-emphasis" id="v-pills-name-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-name" type="button" role="tab" aria-controls="v-pills-name"
                        aria-selected="true">
                        <i class="bi bi-person-vcard me-2"></i>
                        Nazwa
                    </button>
                    <button class="nav-link text-start link-body-emphasis" id="v-pills-display-name-tab"
                        data-bs-toggle="pill" data-bs-target="#v-pills-display-name" type="button" role="tab"
                        aria-controls="v-pills-display-name" aria-selected="false">
                        <i class="bi bi-person-bounding-box me-2"></i>
                        Nazwa wyświetlana
                    </button>
                    <button class="nav-link text-start link-body-emphasis" id="v-pills-password-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password"
                        aria-selected="false">
                        <i class="bi bi-key-fill me-2"></i>
                        Hasło
                    </button>
                    <button class="nav-link text-start link-body-emphasis" id="v-pills-avatar-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-avatar" type="button" role="tab" aria-controls="v-pills-avatar"
                        aria-selected="false">
                        <i class="bi bi-person-circle me-2"></i>
                        Awatar
                    </button>
                    <button class="nav-link text-start link-body-emphasis" id="v-pills-background-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-background" type="button" role="tab"
                        aria-controls="v-pills-background" aria-selected="false">
                        <i class="bi bi-image-fill me-2"></i>
                        Zdjęcie w tle
                    </button>
                    <button class="nav-link text-start link-body-emphasis" id="v-pills-other-tab" data-bs-toggle="pill"
                        data-bs-target="#v-pills-other" type="button" role="tab" aria-controls="v-pills-other"
                        aria-selected="false">
                        <i class="bi bi-info-square-fill me-2"></i>
                        Inne informacje
                    </button>
                </div>
                <div class="tab-content w-100" id="v-pills-tabContent">
                    <div class="tab-pane fade ms-2" id="v-pills-name" role="tabpanel" aria-labelledby="v-pills-name-tab"
                        tabindex="0">
                        @include('settings.name')
                    </div>
                    <div class="tab-pane fade ms-2" id="v-pills-display-name" role="tabpanel"
                        aria-labelledby="v-pills-display-name-tab" tabindex="0">
                        @include('settings.display-name')
                    </div>
                    <div class="tab-pane fade ms-2" id="v-pills-password" role="tabpanel"
                        aria-labelledby="v-pills-password-tab" tabindex="0">
                        @include('settings.password')
                    </div>
                    <div class="tab-pane fade ms-2" id="v-pills-avatar" role="tabpanel" aria-labelledby="v-pills-avatar-tab"
                        tabindex="0">
                        @include('settings.avatar')
                    </div>
                    <div class="tab-pane fade ms-2" id="v-pills-background" role="tabpanel"
                        aria-labelledby="v-pills-background-tab" tabindex="0">
                        @include('settings.background')
                    </div>
                    <div class="tab-pane fade ms-2" id="v-pills-other" role="tabpanel" aria-labelledby="v-pills-other-tab"
                        tabindex="0">
                        @include('settings.other')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
