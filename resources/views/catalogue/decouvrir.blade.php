@extends('layouts.app')

@section('title', 'Découvrir les livres')
@section('meta_description',
    'Explorez le catalogue Colibri Littéraire et découvrez les livres africains à lire,
    partager et soutenir.')

@section('content')
    @include('partials.notifications')

    <!-- Catalogue Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-success px-3">Catalogue</p>
                <h1 class="display-6 mb-4">Découvrez notre sélection de livres africains</h1>
            </div>
            <div class="row g-4">
                @foreach ($catalogues ?? [] as $catalogue)
                    @if ($catalogue->type_categorie === 'catalogue')
                        <div class="col-md-6 col-lg-4 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="catalogue-item card h-100 border-0 shadow-lg"
                                style="background: transparent; backdrop-filter: blur(6px); border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                                <img class="card-img-top" src="{{ asset($catalogue->image) }}"
                                    alt="{{ $catalogue->titre }}"
                                    style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                <div class="card-body d-flex flex-column justify-content-between"
                                    style="padding: 1.2rem;">
                                    <h5 class="card-title mb-2 d-flex align-items-start"
                                        style="color: #212529; font-weight: 700; font-size: 1.15rem; line-height: 1.3;">
                                        <i class="fa fa-feather-alt"
                                            style="color: #000000ff; margin-right: 0.5em; margin-top: 0.1em; flex-shrink: 0;"></i>
                                        <span style="word-wrap: break-word; overflow-wrap: break-word;">{{ $catalogue->titre }}</span>
                                    </h5>
                                    <p class="mb-1 d-flex align-items-start" style="color: #607d8b; font-size: 0.95rem; line-height: 1.3;">
                                        <i class="fa fa-user" style="color: #000000ff; margin-right: 0.4em; margin-top: 0.1em; flex-shrink: 0;"></i>
                                        <span style="word-wrap: break-word; overflow-wrap: break-word;">{{ $catalogue->auteur }} &bull; {{ $catalogue->categorie }}</span>
                                    </p>
                                    <hr style="margin: 0.5rem 0; padding: 0;">
                                    <p class="mb-2 d-flex align-items-start"
                                        style="color: #6d838fff; font-size: 0.95rem;">
                                        <i class="fa fa-star" style="color: #FFAC00; margin-right: 0.5em; margin-top: 0.2em; flex-shrink: 0;"></i>
                                        <span class="catalogue-resume" style="text-align: justify; display: block; line-height: 1.4;">
                                            {{ Str::limit(strip_tags($catalogue->resumer), 100) }}
                                        </span>
                                    </p>
                                    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <span class="badge"
                                            style="background: #ffe7e7ff; color: #b30000ff; font-size: 0.95rem; padding: 0.25em 0.5em; border-radius: 8px; word-wrap: break-word;">
                                            <i class="fa fa-tag me-1" aria-hidden="true"></i>Prix&nbsp;: {{ fcfa($catalogue->prix) }}
                                        </span>
                                        @if ($catalogue->quantite > 0)
                                            <span class="badge"
                                                style="background: #198754; color: #fff; font-size: 0.8rem; padding: 0.25em 0.5em; border-radius: 8px;">En
                                                stock</span>
                                        @else
                                            <span class="badge"
                                                style="background: #e53935; color: #fff; font-size: 0.8rem; padding: 0.25em 0.5em; border-radius: 8px;">Pas
                                                en stock</span>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('panier.ajouter') }}"
                                        onsubmit="return checkStock{{ $catalogue->id }}(event)">
                                        @csrf
                                        <input type="hidden" name="catalogue_id" value="{{ $catalogue->id }}">
                                        <div class="mb-2 d-flex align-items-center">
                                            <label for="quantite-{{ $catalogue->id }}"
                                                class="form-label me-2 mb-0">Quantité :</label>
                                            <div class="input-group" style="width: 90px;">
                                                <button type="button" class="btn btn-outline-secondary p-1"
                                                    style="width:28px; height:28px;"
                                                    onclick="decrementQuantite{{ $catalogue->id }}()">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="number" min="1" max="{{ $catalogue->quantite }}"
                                                    name="quantite" id="quantite-{{ $catalogue->id }}"
                                                    class="form-control text-center" value="1"
                                                    style="width: 34px; height:28px; padding:0; font-size:1rem;">
                                                <button type="button" class="btn btn-outline-secondary p-1"
                                                    style="width:28px; height:28px;"
                                                    onclick="incrementQuantite{{ $catalogue->id }}()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <script>
                                            function decrementQuantite{{ $catalogue->id }}() {
                                                var input = document.getElementById('quantite-{{ $catalogue->id }}');
                                                var min = parseInt(input.min);
                                                var val = parseInt(input.value);
                                                if (val > min) input.value = val - 1;
                                            }

                                            function incrementQuantite{{ $catalogue->id }}() {
                                                var input = document.getElementById('quantite-{{ $catalogue->id }}');
                                                var max = parseInt(input.max);
                                                var val = parseInt(input.value);
                                                if (val < max) input.value = val + 1;
                                            }
                                        </script>
                                        <button type="submit" class="btn w-100 catalogue-buy-btn"
                                            style="background: #198754; color: #ffffffff; border-radius: 0; font-weight: 600; font-size: 1.05rem; border: none; transition: background 0.2s;"
                                            @if ($catalogue->quantite == 0) disabled @endif>
                                            <i class="fa fa-shopping-cart me-2"></i>Acheter
                                        </button>
                                    </form>
                                    <script>
                                        function checkStock{{ $catalogue->id }}(e) {
                                            if ({{ $catalogue->quantite }} == 0) {
                                                e.preventDefault();
                                                alert('Ce livre n\'est pas en stock. Veuillez choisir un autre article.');
                                                return false;
                                            }
                                            return true;
                                        }
                                    </script>
                                    <style>
                                        .catalogue-buy-btn:hover {
                                            background: #00a008ff !important;
                                            color: #fff !important;
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>

                        <!-- Modal résumé (affiche le résumé complet) -->
                        <div class="modal fade" id="resumeModal{{ $catalogue->id }}" tabindex="-1"
                            aria-labelledby="resumeModalLabel{{ $catalogue->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="resumeModalLabel{{ $catalogue->id }}">{{ $catalogue->titre }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body" style="white-space:pre-wrap;">
                                        {!! nl2br(e($catalogue->resumer)) !!}
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- Catalogue End -->
@endsection
