@extends('home.template')

@section('title', 'Rangi')

@section('center-column')
    <div class="col">
        <div class="row">
            <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
                <h1 class="display-5 fw-normal text-body-emphasis">Rangi</h1>
                <p class="fs-5 text-body-secondary">OnlyPets oferuje system rang, który nagradza stałych użytkowników za ich
                    aktywność i zaangażowanie w społeczność.</p>
            </div>

            <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                <div class="col mb-3">
                    <div class="card mb-4 rounded-3 shadow-sm d-flex align-items-stretch h-100">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-bold"><i class="bi bi-star"></i> Początkujący</h4>
                        </div>
                        <div class="card-body pb-0">
                            <p>Nowy użytkownik.</p>
                            <p class="mb-0">Maksymalna liczba załączników: <strong>1</strong>.</p>
                        </div>
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="card mb-4 rounded-3 shadow-sm d-flex align-items-stretch h-100">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-bold text-warning"><i class="bi bi-star-half"></i> Weteran</h4>
                        </div>
                        <div class="card-body pb-0">
                            <p>Opublikuj co najmniej <strong>25 postów</strong> i bądź członkiem społeczności przynajmniej
                                przez <strong>2 tygodnie</strong>.</p>
                            <p>Maksymalna liczba załączników: <strong>3</strong>.</p>
                            <p>Zniżka na subskrypcję: <strong>30%</strong></p>
                            <p class="mb-0">Możliwość autoodnawiania subskrypcji: <strong>Tak</strong></p>
                        </div>
                    </div>
                </div>
                <div class="col mb-3">
                    <div class="card mb-4 rounded-3 shadow-sm d-flex align-items-stretch h-100">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-bold text-info"><i class="bi bi-star-fill"></i> Mistrz</h4>
                        </div>
                        <div class="card-body pb-0">
                            <p>Opublikuj co najmniej <strong>50 postów</strong> i bądź członkiem społeczności przynajmniej
                                przez <strong>2 miesiące</strong>.</p>
                            <p>Maksymalna liczba załączników: <strong>6</strong>.</p>
                            <p class="mb-0">Zniżka na subskrypcję: <strong>50%</strong></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
