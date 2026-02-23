@extends('layouts.app')

@section('title', 'Mes Formations')
@section('meta_description', 'Suivez votre progression et accédez à vos formations sur Colibri Littéraire.')

@push('styles')
<style>
    .formations-hero {
        background: linear-gradient(135deg, #1e7a2f 0%, #0b5e34 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 0.75rem;
        padding: 1rem;
        text-align: center;
    }

    .stat-card .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
    }

    .formation-card {
        border-radius: 0.75rem;
        overflow: hidden;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }

    .formation-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .formation-card .card-img-wrapper {
        height: 140px;
        overflow: hidden;
        position: relative;
    }

    .formation-card .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .formation-card .status-badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        z-index: 10;
        font-size: 0.7rem;
    }

    .progress-ring {
        width: 50px;
        height: 50px;
    }

    .progress-percentage {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: 600;
        font-size: 0.7rem;
    }

    .continue-btn {
        background: #1e7a2f;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-size: 0.85rem;
    }

    .continue-btn:hover {
        background: #0b5e34;
    }

    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
    }

    .filter-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 0.5rem;
    }

    .filter-tab {
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.8rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .filter-tab:hover {
        background: #e9ecef;
    }

    .filter-tab.active {
        background: #1e7a2f;
        color: white;
        border-color: #1e7a2f;
    }

    .achievement-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.2rem 0.5rem;
        border-radius: 0.75rem;
        font-size: 0.65rem;
        font-weight: 600;
    }

    .badge-gold {
        background: linear-gradient(135deg, #f5af19 0%, #f12711 100%);
        color: white;
    }

    /* Mobile responsive */
    @media (max-width: 576px) {
        .formations-hero {
            padding: 1.5rem 0;
        }

        .stat-card {
            padding: 0.75rem;
        }

        .stat-card .stat-number {
            font-size: 1.25rem;
        }

        .stat-card .small {
            font-size: 0.7rem;
        }

        .formation-card .card-img-wrapper {
            height: 120px;
        }

        .formation-card .card-body {
            padding: 0.75rem;
        }

        .formation-card h5 {
            font-size: 0.9rem;
        }

        .filter-tab {
            padding: 0.4rem 0.75rem;
            font-size: 0.75rem;
        }

        .continue-btn {
            padding: 0.4rem 0.75rem;
            font-size: 0.8rem;
        }

        .progress-ring {
            width: 40px;
            height: 40px;
        }

        .progress-percentage {
            font-size: 0.6rem;
        }
    }
</style>
@endpush

@section('content')
@include('partials.notifications')

<!-- Hero Section avec statistiques -->
<div class="formations-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-3 mb-lg-0">
                <h1 class="h4 fw-bold mb-2">
                    <i class="fas fa-graduation-cap me-2"></i>Mes Formations
                </h1>
                <p class="small opacity-90 mb-0">
                    Suivez votre progression et continuez votre apprentissage
                </p>
            </div>
            <div class="col-lg-7">
                <div class="row g-2">
                    @php
                        $totalFormations = $inscriptions->count();
                        $formationsEnCours = $inscriptions->where('paiement_valide', true)->filter(fn($i) => $i->calculated_progression > 0 && $i->calculated_progression < 100)->count();
                        $formationsTerminees = $inscriptions->where('paiement_valide', true)->filter(fn($i) => $i->calculated_progression >= 100)->count();
                        $totalProgression = $totalFormations > 0
                            ? round($inscriptions->where('paiement_valide', true)->avg('calculated_progression'))
                            : 0;
                    @endphp
                    <div class="col-3">
                        <div class="stat-card">
                            <div class="stat-number">{{ $totalFormations }}</div>
                            <div class="small opacity-75">Inscriptions</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="stat-card">
                            <div class="stat-number">{{ $formationsEnCours }}</div>
                            <div class="small opacity-75">En cours</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="stat-card">
                            <div class="stat-number">{{ $formationsTerminees }}</div>
                            <div class="small opacity-75">Terminées</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="stat-card">
                            <div class="stat-number">{{ $totalProgression }}%</div>
                            <div class="small opacity-75">Progression</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-3">
    <!-- Filtres -->
    <div class="filter-tabs" id="filterTabs">
        <div class="filter-tab active" data-filter="all">
            <i class="fas fa-th-large me-1"></i>Toutes ({{ $totalFormations }})
        </div>
        <div class="filter-tab" data-filter="in-progress">
            <i class="fas fa-play-circle me-1"></i>En cours ({{ $formationsEnCours }})
        </div>
        <div class="filter-tab" data-filter="completed">
            <i class="fas fa-check-circle me-1"></i>Terminées ({{ $formationsTerminees }})
        </div>
        <div class="filter-tab" data-filter="pending">
            <i class="fas fa-clock me-1"></i>En attente
        </div>
    </div>

    @if($inscriptions->isEmpty())
        <div class="empty-state card">
            <i class="fas fa-book-open"></i>
            <h5 class="text-muted mb-2">Aucune formation inscrite</h5>
            <p class="text-muted small mb-3">Découvrez nos formations et commencez votre apprentissage.</p>
            <a href="{{ route('formation.modules') }}" class="btn btn-success btn-sm rounded-2">
                <i class="fas fa-search me-1"></i>Explorer les formations
            </a>
        </div>
    @else
        <div class="row g-3" id="formationsGrid">
            @foreach($inscriptions as $inscription)
                @php
                    $formation = $inscription->formation;
                    $progression = $inscription->calculated_progression ?? 0;

                    // Déterminer le filtre
                    if (!$inscription->paiement_valide) {
                        $filterClass = 'pending';
                        $statusBadge = '<span class="badge bg-warning text-dark">En attente</span>';
                    } elseif ($progression >= 100) {
                        $filterClass = 'completed';
                        $statusBadge = '<span class="badge bg-success">Terminée</span>';
                    } elseif ($progression > 0) {
                        $filterClass = 'in-progress';
                        $statusBadge = '<span class="badge bg-primary">En cours</span>';
                    } else {
                        $filterClass = 'in-progress';
                        $statusBadge = '<span class="badge bg-info">Non commencée</span>';
                    }

                    // Trouver le prochain module/contenu à suivre
                    $nextModule = null;
                    if ($inscription->paiement_valide && $formation) {
                        foreach ($formation->modules as $module) {
                            $moduleCompleted = true;
                            foreach ($module->contenus as $contenu) {
                                $contenuProgression = \App\Models\UserModuleProgression::where('user_id', Auth::id())
                                    ->where('module_contenu_id', $contenu->id)
                                    ->where('completed', true)
                                    ->first();
                                if (!$contenuProgression) {
                                    $moduleCompleted = false;
                                    if (!$nextModule) {
                                        $nextModule = $module;
                                    }
                                    break;
                                }
                            }
                            if (!$moduleCompleted) break;
                        }
                    }
                @endphp

                <div class="col-sm-6 col-lg-4 formation-item" data-filter="{{ $filterClass }}">
                    <div class="card formation-card h-100">
                        <!-- Image -->
                        <div class="card-img-wrapper">
                            @if($formation && $formation->image)
                                <img src="{{ asset($formation->image) }}" alt="{{ $formation->titre }}">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, #1e7a2f 0%, #0b5e34 100%);">
                                    <i class="fas fa-graduation-cap fa-3x text-white opacity-50"></i>
                                </div>
                            @endif
                            <div class="status-badge">
                                {!! $statusBadge !!}
                            </div>
                        </div>

                        <div class="card-body p-3">
                            <h5 class="card-title fw-bold mb-2" style="font-size: 0.95rem;">
                                {{ $formation ? Str::limit($formation->titre, 35) : 'Formation indisponible' }}
                            </h5>

                            @if($formation)
                                <!-- Progression -->
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="position-relative">
                                        <svg class="progress-ring" viewBox="0 0 36 36">
                                            <path class="progress-ring-bg"
                                                  stroke="#e9ecef"
                                                  stroke-width="3"
                                                  fill="none"
                                                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                            <path class="progress-ring-circle"
                                                  stroke="{{ $progression >= 100 ? '#28a745' : '#1e7a2f' }}"
                                                  stroke-width="3"
                                                  stroke-linecap="round"
                                                  fill="none"
                                                  stroke-dasharray="{{ $progression }}, 100"
                                                  style="transform: rotate(-90deg); transform-origin: center;"
                                                  d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                                        </svg>
                                        <span class="progress-percentage">{{ $progression }}%</span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="small text-muted">{{ $inscription->completed_contenus ?? 0 }}/{{ $inscription->total_contenus ?? 0 }} contenus</div>
                                    </div>
                                </div>

                                <!-- Infos -->
                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    <span class="badge bg-light text-dark" style="font-size: 0.65rem;">
                                        <i class="fas fa-book me-1"></i>{{ $formation->modules->count() }} modules
                                    </span>
                                    @if($formation->duree)
                                        <span class="badge bg-light text-dark" style="font-size: 0.65rem;">
                                            <i class="fas fa-clock me-1"></i>{{ $formation->duree }}
                                        </span>
                                    @endif
                                </div>

                                @if($progression >= 100)
                                    <span class="achievement-badge badge-gold mb-2">
                                        <i class="fas fa-trophy"></i> Terminée
                                    </span>
                                    {{-- Statut du certificat --}}
                                    @php $cert = $inscription->certificat; @endphp
                                    @if($cert)
                                        <span class="achievement-badge mb-2" style="background: linear-gradient(135deg, #2ecc71, #27ae60); color: white;">
                                            <i class="fas fa-certificate"></i> Certificat disponible
                                        </span>
                                    @elseif($inscription->certificat_demande)
                                        <span class="achievement-badge mb-2" style="background: #fff3cd; color: #856404; border: 1px solid #ffc107;">
                                            <i class="fas fa-hourglass-half"></i> Certificat en cours
                                        </span>
                                    @endif
                                @endif
                            @endif
                        </div>

                        <div class="card-footer bg-transparent border-0 p-3 pt-0">
                            @if($formation)
                                @if(!$inscription->paiement_valide)
                                    <a href="{{ route('formation.paiement', $formation) }}" class="btn btn-warning btn-sm w-100 rounded-2">
                                        <i class="fas fa-credit-card me-1"></i>Payer
                                    </a>
                                @elseif($progression >= 100)
                                    @php $cert = $inscription->certificat; @endphp
                                    @if($cert)
                                        <a href="{{ route('admin.certifications.download', $cert) }}" class="btn btn-success btn-sm w-100 rounded-2 mb-1">
                                            <i class="fas fa-download me-1"></i>Certificat
                                        </a>
                                    @elseif(!$inscription->certificat_demande)
                                        <a href="{{ route('formation.show', $formation) }}" class="btn btn-warning btn-sm w-100 rounded-2 mb-1">
                                            <i class="fas fa-certificate me-1"></i>Demander certificat
                                        </a>
                                    @endif
                                    <a href="{{ route('formation.show', $formation) }}" class="btn btn-outline-success btn-sm w-100 rounded-2">
                                        <i class="fas fa-eye me-1"></i>Revoir
                                    </a>
                                @elseif($nextModule)
                                    <a href="{{ route('formation.module.show', [$formation, $nextModule]) }}" class="btn continue-btn text-white btn-sm w-100">
                                        <i class="fas fa-play me-1"></i>Continuer
                                    </a>
                                @else
                                    <a href="{{ route('formation.show', $formation) }}" class="btn continue-btn text-white btn-sm w-100">
                                        <i class="fas fa-play me-1"></i>Commencer
                                    </a>
                                @endif
                            @endif

                            <div class="text-center mt-2">
                                <small class="text-muted" style="font-size: 0.7rem;">
                                    Inscrit le {{ $inscription->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Lien vers la page des formations -->
    <div class="text-center mt-4">
        <a href="{{ route('formation.modules') }}" class="btn btn-outline-success btn-sm rounded-2">
            <i class="fas fa-plus-circle me-1"></i>Découvrir plus de formations
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const formationItems = document.querySelectorAll('.formation-item');

    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;

            formationItems.forEach(item => {
                if (filter === 'all' || item.dataset.filter === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endpush
