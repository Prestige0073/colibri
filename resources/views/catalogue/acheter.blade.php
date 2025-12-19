@extends('layouts.app')

@section('title', 'Acheter / Prêter un livre')
@section('meta_description', "Procédez à l'achat ou au prêt d'un livre africain via le catalogue Colibri Littéraire.")

@section('content')
    @php
        $user = Auth::user();
        // prefer controller-provided $emprunts, fallback to fetching from user
        // Trier du plus récent au plus ancien
        $emprunts = isset($emprunts) ? $emprunts : ($user ? $user->emprunts()->with('livre')->orderByDesc('created_at')->get() : collect());
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

    <!-- Mes emprunts (utilisateur connecté) -->
    @if($user)
        <div class="container mt-4">
            <div class="card border-0 rounded-4 shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h5 class="mb-0 text-secondary"><i class="fa fa-book-reader me-2"></i>Mes emprunts</h5>
                </div>
                <div class="table-responsive">
                    @if($emprunts && $emprunts->count())
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>Livre</th>
                                    <th>Date d'emprunt</th>
                                    <th>Date de retour</th>
                                    <th>Statut</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emprunts as $emprunt)
                                    <tr>
                                        <td><strong>{{ $emprunt->livre ? $emprunt->livre->titre : 'Livre inconnu' }}</strong></td>
                                        <td>{{ $emprunt->date_emprunt ? \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') : 'date inconnue' }}</td>
                                        <td>{{ $emprunt->date_retour ? \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') : 'Non rendu' }}</td>
                                        <td>
                                            @php
                                                $statusLabel = $emprunt->date_retour ? 'Rendu' : 'En cours';
                                            @endphp
                                            <span class="badge {{ $emprunt->date_retour ? 'bg-success' : 'bg-warning text-dark' }}">{{ $statusLabel }}</span>
                                        </td>
                                        <td class="text-end">
                                            <form method="POST" action="{{ route('emprunts.destroy', $emprunt->id) }}" onsubmit="return confirm('Confirmer la suppression de cet emprunt ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-muted">Vous n'avez aucun emprunt en cours.</div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <!-- Catalogue Vente Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">Catalogue</p>
                <h1 class="display-6 mb-4">Achetez nos livres africains</h1>
            </div>
            <div class="row g-4">
                @foreach ($livres as $livre)
                    <div class="col-md-6 col-lg-4 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="catalogue-item card h-100 border-0 shadow-lg"
                            style="background: transparent; backdrop-filter: blur(6px); border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                            <img class="card-img-top" src="{{ asset('img/' . $livre->image) }}" alt="{{ $livre->titre }}"
                                style="border-top-left-radius: 12px; border-top-right-radius: 12px; height: 300px; object-fit: cover;">
                            <div class="card-body d-flex flex-column justify-content-between"
                                style="padding: 1.2rem;">
                                <h5 class="card-title mb-2 d-flex align-items-center"
                                    style="color: #212529; font-weight: 700; font-size: 1.15rem;">
                                    <i class="fa fa-book"
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
                                        style="background: #1976d2; color: #fff; font-size: 1rem; padding: 0.4em 0.8em; border-radius: 8px; font-weight: 600;">
                                        Prix: {{ number_format($livre->prix, 0, ',', ' ') }} FCFA
                                    </span>
                                    <span class="badge ms-2"
                                        style="background: #198754; color: #fff; font-size: 0.8rem; padding: 0.25em 0.5em; border-radius: 8px;">
                                        Stock: {{ $livre->quantite }}
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('panier.ajouter') }}">
                                    @csrf
                                    <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                    <div class="mb-2 d-flex align-items-center">
                                        <label for="qty_{{ $livre->id }}"
                                            class="form-label me-2 mb-0">Quantité :</label>
                                        <div class="input-group" style="width: 90px;">
                                            <button type="button" class="btn btn-outline-secondary p-1"
                                                style="width:28px; height:28px;"
                                                onclick="changeQty({{ $livre->id }}, -1)">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="number" min="1" max="{{ $livre->quantite }}"
                                                name="quantite" id="qty_{{ $livre->id }}"
                                                class="form-control text-center" value="1"
                                                style="width: 34px; height:28px; padding:0; font-size:1rem;">
                                            <button type="button" class="btn btn-outline-secondary p-1"
                                                style="width:28px; height:28px;"
                                                onclick="changeQty({{ $livre->id }}, 1)">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn w-100 catalogue-buy-btn"
                                        style="background: #1976d2; color: #ffffffff; border-radius: 0; font-weight: 600; font-size: 1.05rem; border: none; transition: background 0.2s;">
                                        <i class="fa fa-shopping-cart me-2"></i>Acheter
                                    </button>
                                </form>
                                <style>
                                    .catalogue-buy-btn:hover {
                                        background: #1565c0 !important;
                                        color: #fff !important;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($livres->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $livres->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- Catalogue Vente End -->

    <script>
        function changeQty(id, delta) {
            var input = document.getElementById('qty_' + id);
            if (!input) return;

            var min = parseInt(input.min);
            var max = parseInt(input.max);
            var val = parseInt(input.value);
            var newVal = val + delta;

            if (newVal >= min && newVal <= max) {
                input.value = newVal;
            }
        }
    </script>
@endsection
