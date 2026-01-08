@extends('layouts.app')

@section('title', 'Mes commandes')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
                    <div>
                        <h2 class="mb-1"><i class="fa fa-truck text-success me-2"></i>Suivi de commandes</h2>
                        <p class="text-muted mb-0">Retrouvez ici l'historique et le statut de vos commandes</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('account.profil') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-user me-1"></i>
                            <span class="d-none d-sm-inline">Retour au profil</span>
                        </a>
                    </div>
                </div>

                @php
                    // Séparer les commandes livrées des commandes actives
                    $delivered = $commandes->filter(function ($c) {
                        $statut = strtolower($c->statut ?? '');
                        return in_array($statut, ['livre', 'livree']);
                    });

                    $active = $commandes->filter(function ($c) {
                        $statut = strtolower($c->statut ?? '');
                        return !in_array($statut, ['livre', 'livree']);
                    });
                @endphp

                @if ($commandes->isEmpty())
                    <div class="card p-4 shadow-sm rounded-4 text-center">
                        <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                        <h5 class="mb-1">Aucune commande enregistrée</h5>
                        <p class="text-muted">Vous n'avez pas encore passé de commande. Commencez par ajouter des livres au
                            panier.</p>
                        <a href="{{ route('catalogue.index') ?? '/' }}" class="btn btn-success">Voir le catalogue</a>
                    </div>
                @else
                    <!-- Bouton pour voir les commandes archivées -->
                    @if ($delivered->isNotEmpty())
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">Commandes en cours</h5>
                            <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#archivedOrdersModal">
                                <i class="fa fa-archive me-1"></i>Commandes livrées
                                <span class="badge bg-secondary ms-1">{{ $delivered->count() }}</span>
                            </button>
                        </div>
                    @endif

                    <!-- Afficher les commandes actives seulement -->
                    @if ($active->isEmpty())
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle me-2"></i>
                            Vous n'avez aucune commande en cours. Toutes vos commandes ont été livrées.
                            @if ($delivered->isNotEmpty())
                                <button type="button" class="btn btn-sm btn-outline-info ms-2" data-bs-toggle="modal"
                                    data-bs-target="#archivedOrdersModal">
                                    Voir les commandes livrées
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="row g-3">
                            @foreach ($active as $c)
                                @php
                                    $badge = 'secondary';
                                    $raw = $c->statut;
                                    $label = $c->statut_label ?? ucfirst($raw);
                                    if ($raw === 'pending') {
                                        $badge = 'warning';
                                        $statusIcon = 'fa-clock';
                                    } elseif ($raw === 'confirmee') {
                                        $badge = 'info';
                                        $statusIcon = 'fa-check';
                                    } elseif ($raw === 'en_livraison') {
                                        $badge = 'info';
                                        $statusIcon = 'fa-truck';
                                    } else {
                                        $statusIcon = 'fa-info-circle';
                                    }

                                    $isEmail = isset($c->adresse) && strpos($c->adresse, '@') !== false;
                                    $addressIcon = $isEmail ? 'fa-envelope' : 'fa-map-marker-alt';
                                @endphp

                                <div class="col-12">
                                    <div class="card shadow-sm rounded-4">
                                        <div
                                            class="card-body d-flex flex-column flex-md-row justify-content-between gap-3 align-items-start">
                                            <div class="d-flex align-items-start gap-3 flex-grow-1">
                                                <div class="icon-circle bg-light border rounded-circle d-flex align-items-center justify-content-center"
                                                    style="width:56px;height:56px;min-width:56px;">
                                                    <i class="fa fa-receipt text-success fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-baseline gap-2 flex-wrap">
                                                        <h5 class="mb-1">Commande #{{ $c->id }}</h5>
                                                        <span class="text-muted small">•
                                                            {{ $c->created_at->format('d/m/Y H:i') }}</span>
                                                    </div>
                                                    <div class="text-muted small mb-2">
                                                        <i
                                                            class="fa {{ $addressIcon }} me-1"></i>{{ $c->adresse ?? 'Adresse non renseignée' }}
                                                    </div>
                                                    <div class="mb-2">
                                                        <strong><i
                                                                class="fa fa-coins text-warning me-1"></i>{{ fcfa($c->total) }}</strong>
                                                        <span class="badge bg-{{ $badge }} ms-2"><i
                                                                class="fa {{ $statusIcon }} me-1"></i>{{ $label }}</span>
                                                    </div>
                                                    <div class="small">
                                                        <strong class="d-block mb-1">Articles:</strong>
                                                        @foreach ($c->items as $it)
                                                            <div class="text-muted"><i
                                                                    class="fa fa-book text-secondary me-1"></i>{{ \Illuminate\Support\Str::limit($it->titre ?? 'Article', 60) }}
                                                                <span class="text-dark">×{{ $it->quantite }}</span></div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                class="text-end d-flex flex-column align-items-end justify-content-between gap-2">
                                                <div>
                                                    <a href="{{ route('commandes.show', $c->id) }}"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="fa fa-eye me-1"></i>Détails
                                                    </a>
                                                </div>
                                                <div class="d-flex gap-2 flex-wrap">
                                                    @php
                                                        $phone = '2290166547808';
                                                        $email = 'colibrilitteraire@gmail.com';
                                                    @endphp
                                                    <a href="https://wa.me/{{ $phone }}?text={{ urlencode('Bonjour, je souhaite des informations sur ma commande #' . $c->id) }}"
                                                        target="_blank" class="btn btn-success btn-sm">
                                                        <i class="fab fa-whatsapp me-1"></i><span
                                                            class="d-none d-md-inline">WhatsApp</span>
                                                    </a>
                                                    <a href="mailto:{{ $email }}?subject={{ urlencode('Commande #' . $c->id) }}"
                                                        class="btn btn-outline-secondary btn-sm">
                                                        <i class="fa fa-envelope me-1"></i><span
                                                            class="d-none d-md-inline">Email</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Modal: Commandes livrées (archivées) -->
    @if ($delivered->isNotEmpty())
        <div class="modal fade" id="archivedOrdersModal" tabindex="-1" aria-labelledby="archivedOrdersLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="archivedOrdersLabel">
                            <i class="fa fa-check-circle text-success me-2"></i>Commandes Livrées
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted mb-3">
                            <i class="fa fa-info-circle me-1"></i>
                            Vous avez <strong>{{ $delivered->count() }}</strong> commande(s) livrée(s)
                        </p>
                        <div class="row g-3">
                            @foreach ($delivered as $d)
                                @php
                                    $isEmail = isset($d->adresse) && strpos($d->adresse, '@') !== false;
                                    $addressIcon = $isEmail ? 'fa-envelope' : 'fa-map-marker-alt';
                                @endphp
                                <div class="col-12">
                                    <div class="card border-success">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <i class="fa fa-receipt text-success me-1"></i>
                                                        Commande #{{ $d->id }}
                                                    </h6>
                                                    <small class="text-muted">
                                                        <i class="fa fa-calendar me-1"></i>
                                                        Commandée le {{ $d->created_at->format('d/m/Y à H:i') }}
                                                    </small>
                                                </div>
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="fa fa-check-circle me-1"></i>Livrée
                                                </span>
                                            </div>

                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="fa {{ $addressIcon }} me-1"></i>
                                                    <strong>Adresse:</strong> {{ $d->adresse ?? 'Non renseignée' }}
                                                </small>
                                            </div>

                                            <div class="mb-2">
                                                <small><strong>Articles livrés:</strong></small>
                                                <div class="ms-3">
                                                    @foreach ($d->items as $it)
                                                        <div class="small text-muted">
                                                            <i class="fa fa-book text-secondary me-1"></i>
                                                            {{ \Illuminate\Support\Str::limit($it->titre ?? 'Article', 60) }}
                                                            <span class="text-dark">× {{ $it->quantite }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                                <strong class="text-success fs-5">
                                                    <i class="fa fa-coins me-1"></i>
                                                    {{ fcfa($d->total) }}
                                                </strong>
                                                <a href="{{ route('commandes.show', $d->id) }}"
                                                    class="btn btn-sm btn-outline-success">
                                                    <i class="fa fa-eye me-1"></i>Voir détails
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@push('styles')
    <style>
        .icon-circle i {
            font-size: 22px;
        }

        .card .small {
            line-height: 1.5;
        }

        .card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .modal-body .card {
            transition: all 0.2s ease;
        }

        .modal-body .card:hover {
            background-color: #f8f9fa;
        }

        @media (max-width: 575px) {
            .card-body {
                padding: 1rem;
            }

            h2 {
                font-size: 1.5rem;
            }

            .btn-sm {
                font-size: 0.8rem;
                padding: 0.25rem 0.5rem;
            }
        }
    </style>
@endpush
