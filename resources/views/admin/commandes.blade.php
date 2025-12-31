@extends('admin.layout')

@section('title','Gestion des commandes')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-0"><i class="fas fa-shopping-cart me-2 text-success"></i>Gestion des commandes</h1>
                    <p class="text-muted mb-0">Suivi et traitement des commandes clients</p>
                </div>
                <div class="d-flex gap-2 align-items-center flex-wrap">
                    <span class="badge bg-light text-dark border">
                        <i class="fas fa-calendar me-1"></i>{{ now()->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">En préparation</p>
                            <h3 class="mb-0 fw-bold">{{ $users->sum(fn($u) => $u->commandes_active->where('statut', 'pending')->count()) }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0dcaf0 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">En livraison</p>
                            <h3 class="mb-0 fw-bold">{{ $users->sum(fn($u) => $u->commandes_active->where('statut', 'en_livraison')->count()) }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-truck fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Livré ce mois</p>
                            <h3 class="mb-0 fw-bold">{{ $users->sum(fn($u) => $u->commandes_archives->count()) }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Barre de filtres -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">
                        <i class="fas fa-filter me-1"></i>Filtrer par statut
                    </label>
                    <select name="statut" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="pending" {{ request('statut') === 'pending' ? 'selected' : '' }}>En préparation</option>
                        <option value="en_livraison" {{ request('statut') === 'en_livraison' ? 'selected' : '' }}>En livraison</option>
                        <option value="livre" {{ request('statut') === 'livre' ? 'selected' : '' }}>Livré</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label small text-muted mb-1">
                        <i class="fas fa-sort me-1"></i>Trier par
                    </label>
                    <select name="sort" class="form-select">
                        <option value="date" {{ request('sort') === 'date' ? 'selected' : '' }}>Date (récent → ancien)</option>
                        <option value="amount" {{ request('sort') === 'amount' ? 'selected' : '' }}>Montant (élevé → bas)</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i>Appliquer les filtres
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($users->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune commande trouvée</h5>
                <p class="text-muted mb-0">Les commandes des clients apparaîtront ici.</p>
            </div>
        </div>
    @endif

    <!-- Liste des commandes par utilisateur -->
    @foreach($users as $user)
        @php
            // Générer une couleur de bordure unique par utilisateur basée sur l'ID
            $colors = ['#0d6efd', '#198754', '#dc3545', '#fd7e14', '#6f42c1', '#d63384', '#20c997', '#0dcaf0'];
            $userColor = $colors[$user->id % count($colors)];
        @endphp
        <div class="card border-0 shadow-sm mb-4 user-card" style="border-left: 4px solid {{ $userColor }} !important;">
            <!-- En-tête utilisateur -->
            <div class="card-header bg-white border-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <!-- Photo de profil ou fallback -->
                            @if($user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                <div class="position-relative">
                                    <img
                                        src="{{ asset('storage/' . $user->avatar) }}"
                                        alt="{{ $user->name }}"
                                        class="rounded-circle border border-3 user-avatar"
                                        style="width: 60px; height: 60px; object-fit: cover; border-color: {{ $userColor }} !important;"
                                    >
                                    <span class="position-absolute bottom-0 end-0 badge rounded-pill" style="background-color: {{ $userColor }};">
                                        <i class="fas fa-user-circle"></i>
                                    </span>
                                </div>
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center border border-3 user-avatar-placeholder"
                                     style="width: 60px; height: 60px; background: linear-gradient(135deg, {{ $userColor }}22, {{ $userColor }}44); border-color: {{ $userColor }} !important;">
                                    <span class="fw-bold fs-4" style="color: {{ $userColor }};">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <h5 class="mb-0">{{ $user->name ?? 'Utilisateur' }}</h5>
                                    <span class="badge rounded-pill" style="background-color: {{ $userColor }};">
                                        ID: {{ $user->id }}
                                    </span>
                                </div>
                                <div class="small text-muted">
                                    <i class="fas fa-envelope me-1"></i>{{ $user->email }}
                                    @if($user->phone)
                                        <span class="ms-2"><i class="fas fa-phone me-1"></i>{{ $user->phone }}</span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span class="badge bg-light text-dark border">
                                        <i class="fas fa-shopping-bag me-1"></i>{{ $user->commandes_active->count() }} active(s)
                                    </span>
                                    @if($user->commandes_archives && $user->commandes_archives->isNotEmpty())
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-archive me-1"></i>{{ $user->commandes_archives->count() }} archivée(s)
                                        </span>
                                    @endif
                                    @php
                                        $totalAmount = $user->commandes_active->sum('total');
                                    @endphp
                                    @if($totalAmount > 0)
                                        <span class="badge bg-success">
                                            <i class="fas fa-coins me-1"></i>{{ number_format($totalAmount, 0, ',', ' ') }} FCFA
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <button
                            class="btn btn-outline-primary btn-sm toggle-user-orders"
                            data-target="#collapse-user-{{ $user->id }}"
                            data-show-text="Voir les commandes"
                            data-hide-text="Masquer"
                        >
                            <i class="fas fa-chevron-down me-1"></i>
                            <span>Voir les commandes</span>
                        </button>

                        <!-- Actions massives -->
                        <div class="btn-group ms-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="fas fa-tasks me-1"></i>Actions
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <h6 class="dropdown-header">Actions massives</h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.commandes.bulkStatus', $user->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="pending">
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-clock text-warning me-2"></i>Mettre en préparation
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('admin.commandes.bulkStatus', $user->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="en_livraison">
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-truck text-info me-2"></i>Mettre en livraison
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('admin.commandes.bulkStatus', $user->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="livre">
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-check-circle text-success me-2"></i>Marquer comme livré
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Corps: Commandes actives -->
            <div class="card-body collapse" id="collapse-user-{{ $user->id }}">
                @if($user->commandes_active->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-box-open fa-2x mb-2"></i>
                        <p class="mb-0">Aucune commande active pour cet utilisateur.</p>
                    </div>
                @else
                    <div class="row g-3">
                        @foreach($user->commandes_active as $c)
                            @php
                                $badge = 'secondary';
                                $icon = 'fa-info-circle';
                                $raw = $c->statut;
                                $label = $c->statut_label;
                                if ($raw === 'pending') {
                                    $badge = 'warning';
                                    $icon = 'fa-clock';
                                }
                                elseif ($raw === 'en_livraison') {
                                    $badge = 'info';
                                    $icon = 'fa-truck';
                                }
                                elseif ($raw === 'livre' || $raw === 'livree') {
                                    $badge = 'success';
                                    $icon = 'fa-check-circle';
                                }
                            @endphp

                            <div class="col-lg-6">
                                <div class="card border h-100 shadow-sm hover-shadow">
                                    <div class="card-body">
                                        <!-- En-tête de la commande -->
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <h6 class="mb-1">
                                                    <i class="fas fa-receipt text-success me-1"></i>
                                                    Commande #{{ $c->id }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>{{ $c->created_at->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                            <span class="badge bg-{{ $badge }}">
                                                <i class="fas {{ $icon }} me-1"></i>{{ $label }}
                                            </span>
                                        </div>

                                        <!-- Informations -->
                                        <div class="mb-3">
                                            <div class="small mb-2">
                                                <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                <strong>Adresse:</strong> {{ $c->adresse ?? '—' }}
                                            </div>

                                            <!-- Items -->
                                            <div class="border-top pt-2 mt-2">
                                                <div class="small text-muted mb-1">
                                                    <i class="fas fa-box me-1"></i>Articles commandés:
                                                </div>
                                                @foreach($c->items as $it)
                                                    <div class="small ms-3">
                                                        <i class="fas fa-book text-primary me-1"></i>
                                                        {{ Str::limit($it->titre, 40) }}
                                                        <span class="badge bg-light text-dark">x{{ $it->quantite }}</span>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Total -->
                                            <div class="border-top pt-2 mt-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <strong class="text-success">
                                                        <i class="fas fa-money-bill-wave me-1"></i>Total:
                                                    </strong>
                                                    <strong class="fs-5 text-success">{{ number_format($c->total,0,',',' ') }} FCFA</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="border-top pt-3">
                                            @php
                                                $tel = $c->telephone ?? $c->tel ?? $user->phone ?? '';
                                                $email = $c->email ?? $user->email ?? '';
                                                $wa = $tel ? 'https://wa.me/'.preg_replace('/[^0-9+]/','',$tel) : '#';
                                            @endphp

                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ route('admin.commandes.show', $c->id) }}" class="btn btn-primary btn-sm flex-fill">
                                                    <i class="fas fa-eye me-1"></i>Détails
                                                </a>

                                                @if(!empty($tel))
                                                    <a href="{{ $wa }}" target="_blank" class="btn btn-success btn-sm">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </a>
                                                    <a href="tel:{{ $tel }}" class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-phone"></i>
                                                    </a>
                                                @endif

                                                @if(!empty($email))
                                                    <a href="mailto:{{ $email }}?subject={{ urlencode('Commande #' . $c->id) }}" class="btn btn-outline-secondary btn-sm">
                                                        <i class="fas fa-envelope"></i>
                                                    </a>
                                                @endif
                                            </div>

                                            @if(!empty($tel) || !empty($email))
                                                <div class="small text-muted mt-2">
                                                    @if(!empty($tel))
                                                        <div><i class="fas fa-phone me-1"></i>{{ $tel }}</div>
                                                    @endif
                                                    @if(!empty($email))
                                                        <div><i class="fas fa-envelope me-1"></i>{{ $email }}</div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Section Archives -->
                @if($user->commandes_archives && $user->commandes_archives->isNotEmpty())
                    <div class="border-top mt-4 pt-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">
                                <i class="fas fa-archive text-muted me-2"></i>
                                Commandes archivées ({{ $user->commandes_archives->count() }})
                            </h6>
                            <button class="btn btn-sm btn-outline-secondary toggle-user-archives" data-target="#collapse-archives-{{ $user->id }}">
                                <i class="fas fa-chevron-down me-1"></i>Afficher
                            </button>
                        </div>

                        <div class="collapse" id="collapse-archives-{{ $user->id }}">
                            <div class="row g-2">
                                @foreach($user->commandes_archives as $ac)
                                    <div class="col-md-6">
                                        <div class="card bg-light border-0">
                                            <div class="card-body p-3">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div class="small">
                                                        <strong>Commande #{{ $ac->id }}</strong><br>
                                                        <span class="text-muted">{{ $ac->created_at->format('d/m/Y') }}</span>
                                                    </div>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check"></i> Livré
                                                    </span>
                                                </div>
                                                <div class="small text-muted">
                                                    {{ $ac->items->count() }} article(s) — {{ number_format($ac->total,0,',',' ') }} FCFA
                                                </div>
                                                <a href="{{ route('admin.commandes.show', $ac->id) }}" class="btn btn-sm btn-outline-secondary mt-2 w-100">
                                                    <i class="fas fa-eye me-1"></i>Voir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endforeach

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection

@push('styles')
<style>
    .hover-shadow {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .toggle-user-orders i,
    .toggle-user-archives i {
        transition: transform 0.3s ease;
    }

    .toggle-user-orders.active i,
    .toggle-user-archives.active i {
        transform: rotate(180deg);
    }

    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }

    .collapsing {
        transition: height 0.3s ease;
    }

    /* Styles pour les avatars utilisateurs */
    .user-avatar {
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .user-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .user-avatar-placeholder {
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .user-avatar-placeholder:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    /* Animation pour les cards utilisateur */
    .user-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .user-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        transition: width 0.3s ease;
    }

    .user-card:hover {
        transform: translateX(2px);
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.12) !important;
    }

    /* Badge ID utilisateur */
    .badge.rounded-pill {
        font-size: 0.7rem;
        padding: 0.25em 0.6em;
    }

    /* Amélioration visuelle des badges */
    .badge i {
        font-size: 0.85em;
    }

    /* Responsive pour les avatars */
    @media (max-width: 768px) {
        .user-avatar,
        .user-avatar-placeholder {
            width: 50px !important;
            height: 50px !important;
        }

        .user-avatar-placeholder span {
            font-size: 1.2rem !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle pour les commandes
    document.querySelectorAll('.toggle-user-orders').forEach(function(btn) {
        var target = document.querySelector(btn.dataset.target);
        var span = btn.querySelector('span');
        var showText = btn.dataset.showText || 'Voir les commandes';
        var hideText = btn.dataset.hideText || 'Masquer';

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var bs = bootstrap.Collapse.getOrCreateInstance(target);
            bs.toggle();

            setTimeout(function() {
                if (target.classList.contains('show')) {
                    if (span) span.textContent = hideText;
                    btn.classList.add('active');
                } else {
                    if (span) span.textContent = showText;
                    btn.classList.remove('active');
                }
            }, 150);
        });
    });

    // Toggle pour les archives
    document.querySelectorAll('.toggle-user-archives').forEach(function(btn) {
        var target = document.querySelector(btn.dataset.target);

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var bs = bootstrap.Collapse.getOrCreateInstance(target);
            bs.toggle();

            setTimeout(function() {
                if (target.classList.contains('show')) {
                    btn.innerHTML = '<i class="fas fa-chevron-up me-1"></i>Masquer';
                    btn.classList.add('active');
                } else {
                    btn.innerHTML = '<i class="fas fa-chevron-down me-1"></i>Afficher';
                    btn.classList.remove('active');
                }
            }, 150);
        });
    });
});
</script>
@endpush
