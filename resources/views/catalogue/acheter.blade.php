@extends('layouts.app')

@section('title', 'Acheter / Prêter un livre')
@section('meta_description', 'Procédez à l’achat ou au prêt d’un livre africain via le catalogue Colibri Littéraire.')

@section('content')
    @php
        $user = Auth::user();
        $emprunts = $user ? $user->emprunts()->with('livre')->get() : collect();
    @endphp
    <!-- Toast notification -->
    <div aria-live="polite" aria-atomic="true"
        style="position: fixed; top: 1.5rem; right: 1.5rem; min-width: 320px; z-index: 1080; pointer-events: none;">
        @if (session('success'))
            <div id="toast-success"
                class="toast align-items-center border-0 shadow-lg show animate__animated animate__slideInDown" role="alert"
                aria-live="assertive" aria-atomic="true"
                style="pointer-events:auto; background:#1bc47d; color:#fff; font-weight:500;">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Fermer"></button>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div id="toast-error"
                class="toast align-items-center border-0 shadow-lg show animate__animated animate__slideInDown"
                role="alert" aria-live="assertive" aria-atomic="true"
                style="pointer-events:auto; background:#e53935; color:#fff; font-weight:500;">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Fermer"></button>
                </div>
            </div>
        @endif
    </div>
    <!-- Bibliothèque Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-success px-3">Bibliothèque</p>
                <h1 class="display-6 mb-4">Empruntez nos livres africains pour la lecture</h1>
            </div>
            <div class="row g-4">
                @foreach ($Bibliotheques as $livre)
                    @if ($livre->type_categorie === 'emprunt')
                        <div class="col-md-6 col-lg-4 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="catalogue-item card h-100 border-0 shadow-lg"
                                style="background: transparent; backdrop-filter: blur(6px); border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                                <img class="card-img-top" src="{{ asset($livre->image) }}" alt="{{ $livre->titre }}"
                                    style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                <div class="card-body d-flex flex-column justify-content-between"
                                    style="padding: 1.2rem;">
                                    <h5 class="card-title mb-2 d-flex align-items-center"
                                        style="color: #212529; font-weight: 700; font-size: 1.15rem;">
                                        <i class="fa fa-feather-alt"
                                            style="color: #000000ff; margin-right: 0.5em;"></i>{{ $livre->titre }}
                                    </h5>
                                    <p class="mb-1 d-flex align-items-center" style="color: #607d8b; font-size: 1rem;">
                                        <i class="fa fa-user" style="color: #000000ff; margin-right: 0.4em;"></i>
                                        {{ $livre->auteur }} &bull; {{ $livre->categorie }}
                                    </p>
                                    <hr style="margin: 0.5rem 0; padding: 0;">
                                    <p class="mb-2 d-flex align-items-center"
                                        style="color: #6d838fff; font-size: 1.05rem;">
                                        <i class="fa fa-star" style="color: #FFAC00; margin-right: 0.5em;"></i>
                                        <span style="text-align: justify; display: block;">
                                            {{ Str::limit(strip_tags($livre->resumer), 100) }}
                                        </span>
                                    </p>
                                    <div class="mb-3">
                                        <span class="badge"
                                            style="background: #198754; color: #fff; font-size: 0.8rem; padding: 0.25em 0.5em; border-radius: 8px;">
                                            {{ $livre->statut ?? 'Disponible' }}
                                        </span>
                                    </div>
                                    <form method="POST" action="{{ route('bibliotheque.emprunter') }}">
                                        @csrf
                                        <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                        <div class="mb-2 d-flex align-items-center">
                                            <label for="quantite-emprunt-{{ $livre->id }}"
                                                class="form-label me-2 mb-0">Quantité :</label>
                                            <div class="input-group" style="width: 90px;">
                                                <button type="button" class="btn btn-outline-secondary p-1"
                                                    style="width:28px; height:28px;"
                                                    onclick="decrementQuantiteEmprunt{{ $livre->id }}()">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="number" min="1" max="{{ $livre->quantite }}"
                                                    name="quantite" id="quantite-emprunt-{{ $livre->id }}"
                                                    class="form-control text-center" value="1"
                                                    style="width: 34px; height:28px; padding:0; font-size:1rem;">
                                                <button type="button" class="btn btn-outline-secondary p-1"
                                                    style="width:28px; height:28px;"
                                                    onclick="incrementQuantiteEmprunt{{ $livre->id }}()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <script>
                                            function decrementQuantiteEmprunt{{ $livre->id }}() {
                                                var input = document.getElementById('quantite-emprunt-{{ $livre->id }}');
                                                var min = parseInt(input.min);
                                                var val = parseInt(input.value);
                                                if (val > min) input.value = val - 1;
                                            }

                                            function incrementQuantiteEmprunt{{ $livre->id }}() {
                                                var input = document.getElementById('quantite-emprunt-{{ $livre->id }}');
                                                var max = parseInt(input.max);
                                                var val = parseInt(input.value);
                                                if (val < max) input.value = val + 1;
                                            }
                                        </script>
                                        <button type="submit" class="btn w-100 catalogue-buy-btn"
                                            style="background: #198754; color: #ffffffff; border-radius: 0; font-weight: 600; font-size: 1.05rem; border: none; transition: background 0.2s;">
                                            <i class="fa fa-book-reader me-2"></i>Emprunter
                                        </button>
                                    </form>
                                    <style>
                                        .catalogue-buy-btn:hover {
                                            background: #00a008ff !important;
                                            color: #fff !important;
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- Bibliothèque End -->
@endsection
