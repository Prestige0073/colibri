@extends('layouts.app')

@section('title', 'Profil utilisateur')
@section('meta_description',
    'Gérez votre profil, vos informations personnelles et suivez votre activité sur Colibri
    Littéraire.')

@section('content')
    @include('partials.notifications')

    @php
        $cartItems = Auth::user()->cartItems()->with('catalogue')->get();
        $cartCount = $cartItems->sum('quantite');
        $recentPurchases = Auth::user()->cartItems()->with('catalogue')->orderByDesc('created_at')->take(5)->get();
        // $emprunts et $commandesEnLivraison sont déjà passés par le contrôleur
    @endphp
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card border-0 rounded-4 shadow-lg p-4 profile-card mb-4">
                    <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                        <div class="text-center flex-shrink-0">
                            <form id="avatarForm" action="{{ route('account.avatar.update') }}" method="POST"
                                enctype="multipart/form-data" style="display:inline-block;">
                                @csrf
                                <label for="avatarInput" style="cursor:pointer;display:inline-block;">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar"
                                            class="rounded-circle shadow mb-3 profile-avatar img-fluid" id="avatarPreview"
                                            style="width:180px;height:180px;object-fit:cover;">
                                    @else
                                        <div class="position-relative d-inline-block">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=007bff&color=fff&size=180"
                                                alt="Avatar" class="rounded-circle shadow mb-3 profile-avatar img-fluid"
                                                id="avatarPreview" style="width:180px;height:180px;object-fit:cover;">
                                            <span
                                                class="position-absolute top-50 start-50 translate-middle bg-dark text-white small rounded-2 px-3 py-1"
                                                style="opacity:0.85;z-index:3;pointer-events:none;box-shadow:0 2px 6px rgba(0,0,0,0.35);">
                                                Cliquer pour changer
                                            </span>
                                        </div>
                                    @endif
                                </label>
                                <input type="file" name="avatar" id="avatarInput" accept="image/*"
                                    style="display:none;">
                            </form>

                            <h4 class="fw-bold text-success mb-1">{{ Auth::user()->name }}</h4>

                            <div class="mt-2 d-flex align-items-center gap-2">
                                <button type="button" class="btn btn-outline-success btn-sm rounded-2 profile-btn"
                                    data-bs-toggle="modal" data-bs-target="#editProfileModal"
                                    aria-label="Modifier le profil">
                                    <i class="fa fa-edit me-1" aria-hidden="true"></i>
                                    <span class="d-none d-sm-inline">Modifier le profil</span>
                                </button>
                                <a href="{{ route('account.commandes') }}"
                                    class="btn btn-outline-success btn-sm rounded-2 d-flex align-items-center gap-2 position-relative"
                                    style="padding-right:2.2rem;" aria-label="Suivre mes commandes">
                                    <i class="fa fa-truck me-1" aria-hidden="true"></i>
                                    <span class="d-none d-sm-inline">Suivre mes commandes</span>
                                    <span
                                        class="position-absolute top-0 end-0 translate-middle badge rounded-circle bg-danger text-white"
                                        style="width:1.5rem;height:1.5rem;display:inline-flex;align-items:center;justify-content:center;font-size:.75rem;border:2px solid #fff;">{{ $commandesEnLivraison->count() ?? 0 }}</span>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm rounded-2 ms-2"
                                    data-bs-toggle="modal" data-bs-target="#logoutModal" aria-label="Se déconnecter">
                                    <i class="fa fa-sign-out-alt me-1" aria-hidden="true"></i>
                                    <span class="d-none d-sm-inline">Se déconnecter</span>
                                </button>
                            </div>
                        </div>
                        <div class="flex-grow-1 w-100">
                            <div class="row mb-3 g-2">
                                <div class="col-12 col-sm-6">
                                    <i class="fa fa-envelope text-success me-2"></i>
                                    <span class="fw-semibold"></span> {{ Auth::user()->email }}
                                </div>
                                <div class="col-12 col-sm-6">
                                    <i class="fa fa-phone-alt text-success me-2"></i>
                                    <span class="fw-semibold"></span>
                                    {{ Auth::user()->phone ?? 'Non renseigné' }}
                                </div>
                                <div class="col-12">
                                    <i class="fa fa-map-marker-alt text-success me-2"></i>
                                    <span class="fw-semibold"></span>
                                    {{ Auth::user()->address ?? 'Non renseignée' }}
                                </div>
                            </div>
                            <div class="d-flex flex-wrap justify-content-between text-center mb-4 gap-3">
                                <div class="stat-box flex-fill">
                                    <i class="fa fa-shopping-cart fa-2x text-success mb-2"></i>
                                    <div class="fw-bold fs-4">{{ $cartCount }}</div>
                                    <div class="text-muted">Articles au panier</div>
                                </div>
                                <div class="stat-box flex-fill">
                                    <i class="fa fa-book-reader fa-2x text-success mb-2"></i>
                                    <div class="fw-bold fs-4">{{ $emprunts->count() }}</div>
                                    <div class="text-muted">Emprunts</div>
                                </div>
                                <div class="stat-box flex-fill">
                                    <i class="fa fa-award fa-2x text-warning mb-2"></i>
                                    <div class="fw-bold fs-4">0</div>
                                    <div class="text-muted">Certifications</div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h5 class="mb-0 text-secondary"><i class="fa fa-history me-2"></i>Activité récente</h5>
                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#recentActivity" aria-expanded="true" aria-controls="recentActivity">
                                    <i class="fa fa-chevron-up"></i>
                                </button>
                            </div>
                            <div class="collapse show" id="recentActivity">
                                <ul class="list-group mb-3">
                                    @forelse($recentPurchases as $item)
                                        <li class="list-group-item d-flex align-items-center">
                                            <i class="fa fa-shopping-cart text-success me-2"></i>
                                            Achat du livre <span class="fw-bold ms-1">{{ $item->catalogue->titre }}</span>
                                            le
                                            {{ $item->created_at->format('d/m/Y') }}
                                        </li>
                                    @empty
                                        <li class="list-group-item">Aucune activité récente.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card border-0 rounded-4 shadow-lg p-4 profile-card mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0 text-secondary"><i class="fa fa-graduation-cap me-2"></i>Mes Formations</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('account.formations') }}" class="btn btn-sm btn-success rounded-2">
                                <i class="fa fa-list me-1"></i>Voir tout
                            </a>
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#modulesSuivis" aria-expanded="true" aria-controls="modulesSuivis">
                                <i class="fa fa-chevron-up modules-chevron"></i>
                            </button>
                        </div>
                    </div>
                    <div class="collapse show" id="modulesSuivis">
                        @php
                            $mesFormations = \App\Models\FormationInscription::where('user_id', Auth::id())
                                ->with('formation')
                                ->where('paiement_valide', true)
                                ->orderByDesc('created_at')
                                ->take(3)
                                ->get();
                        @endphp

                        @if($mesFormations->isEmpty())
                            <div class="text-center py-4">
                                <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">Aucune formation en cours</h6>
                                <p class="text-muted small">Découvrez nos formations pour développer vos compétences</p>
                                <a href="{{ route('formation.modules') }}" class="btn btn-success btn-sm rounded-2 mt-2">
                                    <i class="fa fa-search me-1"></i>Explorer les formations
                                </a>
                            </div>
                        @else
                            <div class="row">
                                @foreach($mesFormations as $inscription)
                                    @php
                                        $formation = $inscription->formation;
                                        $totalContenus = 0;
                                        $completedContenus = 0;
                                        if ($formation) {
                                            foreach ($formation->modules as $module) {
                                                $totalContenus += $module->contenus->count();
                                                $completedContenus += \App\Models\UserModuleProgression::where('user_id', Auth::id())
                                                    ->where('module_id', $module->id)
                                                    ->where('completed', true)
                                                    ->count();
                                            }
                                        }
                                        $progression = $totalContenus > 0 ? round(($completedContenus / $totalContenus) * 100) : 0;
                                    @endphp
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card border-0 shadow-sm h-100">
                                            @if($formation && $formation->image)
                                                <img src="{{ asset($formation->image) }}" class="card-img-top" style="height: 120px; object-fit: cover;" alt="{{ $formation->titre }}">
                                            @endif
                                            <div class="card-body">
                                                <h6 class="card-title text-success mb-2">
                                                    <i class="fa fa-book me-1"></i>
                                                    {{ $formation ? Str::limit($formation->titre, 30) : 'Formation' }}
                                                </h6>
                                                <div class="mb-2">
                                                    <div class="d-flex justify-content-between small text-muted mb-1">
                                                        <span>Progression</span>
                                                        <span>{{ $progression }}%</span>
                                                    </div>
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar bg-success" style="width: {{ $progression }}%"></div>
                                                    </div>
                                                </div>
                                                @if($progression >= 100)
                                                    <span class="badge bg-success mb-2">Terminée</span>
                                                @elseif($progression > 0)
                                                    <span class="badge bg-primary mb-2">En cours</span>
                                                @else
                                                    <span class="badge bg-warning text-dark mb-2">Non commencée</span>
                                                @endif
                                                @if($formation)
                                                    <a href="{{ route('formation.show', $formation) }}" class="btn btn-outline-success btn-sm rounded-2 w-100">
                                                        <i class="fa fa-play me-1"></i>Continuer
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12">
                <hr class="my-2">
            </div>

            <div class="col-12">
                <div class="row g-3 mb-4 shadow p-4 rounded-4 profile-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0 text-secondary"><i class="fa fa-award me-2"></i>Certifications obtenues</h5>
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#certifications" aria-expanded="true" aria-controls="certifications">
                            <i class="fa fa-chevron-up certs-chevron"></i>
                        </button>
                    </div>
                    <div class="collapse show" id="certifications">
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-success mb-2"><i class="fa fa-certificate me-1"></i>
                                        Certification
                                        Colibri Littéraire</h6>
                                    <p class="card-text mb-2">Attestation officielle de vos compétences dans les métiers du
                                        livre
                                        africain.</p>
                                    <span class="badge bg-info text-dark mb-2">Obtenue le 15/09/2025</span>
                                    <a href="#" class="btn btn-outline-info btn-sm rounded-2">Voir la
                                        certification</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <hr class="my-2">
            </div>

            <div class="col-12">
                <div class="row g-3 mb-4 shadow p-4 rounded-4 profile-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0 text-secondary"><i class="fa fa-book-reader me-2"></i>Mes emprunts
                            ({{ $emprunts->count() }})</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('emprunts.mes-emprunts') }}" class="btn btn-sm btn-success rounded-2">
                                <i class="fa fa-list me-1"></i>Voir tout
                            </a>
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#emprunts" aria-expanded="true" aria-controls="emprunts">
                                <i class="fa fa-chevron-up purchases-chevron"></i>
                            </button>
                        </div>
                    </div>
                    <div class="collapse show" id="emprunts">
                        @php
                            $empruntsActifs = $emprunts->whereIn('statut', ['en_cours', 'en_retard'])->take(6);
                        @endphp

                        @if ($empruntsActifs->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                                <h6 class="text-muted">Aucun emprunt en cours</h6>
                                <p class="text-muted small">Explorez notre bibliothèque pour emprunter des livres</p>
                                <a href="{{ route('emprunts.index') }}" class="btn btn-success btn-sm rounded-2 mt-2">
                                    <i class="fa fa-search me-1"></i>Parcourir la bibliothèque
                                </a>
                            </div>
                        @else
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                @foreach ($empruntsActifs as $emprunt)
                                    <div class="col">
                                        <div class="card h-100 emprunt-card-profile border-0 shadow-sm">
                                            <!-- Image du livre -->
                                            <div class="emprunt-image-wrapper position-relative"
                                                style="height: 200px; overflow: hidden; background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
                                                @if ($emprunt->livre && $emprunt->livre->image)
                                                    <img src="{{ asset($emprunt->livre->image) }}"
                                                        alt="{{ $emprunt->livre->titre }}" class="card-img-top"
                                                        style="width: 100%; height: 100%; object-fit: cover;"
                                                        loading="lazy">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center h-100">
                                                        <i class="fas fa-book fa-4x text-muted"></i>
                                                    </div>
                                                @endif

                                                <!-- Badge statut -->
                                                <div class="position-absolute top-0 end-0 m-2">
                                                    @php
                                                        $now = now();
                                                        $dateRetour = $emprunt->date_retour
                                                            ? \Carbon\Carbon::parse($emprunt->date_retour)
                                                            : null;
                                                        $joursRestants = $dateRetour
                                                            ? $now->diffInDays($dateRetour, false)
                                                            : null;

                                                        // Vérifier d'abord si l'emprunt est validé
                                                        if ($emprunt->statut === 'en_attente' || !$emprunt->valide_le) {
                                                            $badgeClass = 'bg-warning text-dark';
                                                            $badgeText = 'Non validé';
                                                        } elseif ($emprunt->statut === 'retourne') {
                                                            $badgeClass = 'bg-success';
                                                            $badgeText = 'Retourné';
                                                        } elseif (
                                                            $emprunt->statut === 'en_retard' ||
                                                            ($joursRestants !== null && $joursRestants < 0)
                                                        ) {
                                                            $badgeClass = 'bg-danger';
                                                            $badgeText = 'En retard';
                                                        } elseif ($joursRestants !== null && $joursRestants <= 2) {
                                                            $badgeClass = 'bg-warning text-dark';
                                                            $badgeText = $joursRestants . 'j restants';
                                                        } else {
                                                            $badgeClass = 'bg-primary';
                                                            $badgeText = 'En cours';
                                                        }
                                                    @endphp
                                                    <span
                                                        class="badge {{ $badgeClass }} shadow-sm">{{ $badgeText }}</span>
                                                </div>
                                            </div>

                                            <!-- Informations du livre -->
                                            <div class="card-body d-flex flex-column">
                                                <h6 class="card-title mb-1 fw-bold"
                                                    title="{{ $emprunt->livre ? $emprunt->livre->titre : 'Livre inconnu' }}">
                                                    {{ $emprunt->livre ? Str::limit($emprunt->livre->titre, 35) : 'Livre inconnu' }}
                                                </h6>
                                                <p class="text-muted small mb-2">
                                                    <i class="fas fa-user-pen me-1 text-success"></i>
                                                    {{ $emprunt->livre ? Str::limit($emprunt->livre->auteur, 25) : 'N/A' }}
                                                </p>

                                                <div class="mb-2 small text-muted">
                                                    <div><i
                                                            class="fas fa-calendar me-1 text-success"></i><strong>Emprunté:</strong>
                                                        {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}
                                                    </div>
                                                    <div><i
                                                            class="fas fa-calendar-check me-1 text-success"></i><strong>Retour:</strong>
                                                        {{ $dateRetour ? $dateRetour->format('d/m/Y') : 'N/A' }}</div>
                                                    @if ($emprunt->access_expires_at && $emprunt->valide_le)
                                                        <div class="mt-2">
                                                            <strong>Accès restant:</strong>
                                                            <div class="countdown-timer badge bg-info text-dark d-inline-block"
                                                                data-expires="{{ $emprunt->access_expires_at->toIso8601String() }}">
                                                                <i class="fas fa-clock me-1"></i>
                                                                <span class="countdown-text">Calcul...</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Actions -->
                                                <div class="mt-auto d-grid gap-2">
                                                    @if ($emprunt->livre && $emprunt->livre->pdf)
                                                        @if ($emprunt->statut === 'en_attente' || !$emprunt->valide_le)
                                                            <button class="btn btn-warning btn-sm" disabled
                                                                title="En attente de validation par l'administrateur">
                                                                <i class="fas fa-clock me-1"></i>Non validé - En attente
                                                            </button>
                                                        @elseif($emprunt->valide_le && $emprunt->statut !== 'retourne')
                                                            @if ($emprunt->access_expires_at && now()->greaterThan($emprunt->access_expires_at))
                                                                <button class="btn btn-secondary btn-sm" disabled>
                                                                    <i class="fas fa-lock me-1"></i>Accès expiré
                                                                </button>
                                                            @else
                                                                <a href="{{ route('secure-pdf.view', $emprunt->livre->id) }}"
                                                                    class="btn btn-success btn-sm">
                                                                    <i class="fas fa-book-reader me-1"></i>Lire le PDF
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    <a href="{{ route('emprunts.show', $emprunt->id) }}"
                                                        class="btn btn-outline-success btn-sm">
                                                        <i class="fas fa-info-circle me-1"></i>Détails
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($emprunts->count() > 6)
                                <div class="text-center mt-4">
                                    <a href="{{ route('emprunts.mes-emprunts') }}" class="btn btn-success rounded-2">
                                        <i class="fa fa-eye me-2"></i>Voir tous mes emprunts ({{ $emprunts->count() }})
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

            <!-- Section Ma Bibliothèque -->
            <div class="col-12">
                <hr class="my-2">
            </div>

            <div class="col-12">
                <div class="row g-3 mb-4 shadow p-4 rounded-4 profile-card">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="mb-0 text-secondary">
                            <i class="fa fa-book me-2"></i>Ma Bibliothèque
                            ({{ $livresAchetes->count() }})
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('account.bibliotheque') }}" class="btn btn-sm btn-primary rounded-2">
                                <i class="fa fa-list me-1"></i>Voir tout
                            </a>
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#bibliotheque" aria-expanded="true" aria-controls="bibliotheque">
                                <i class="fa fa-chevron-up biblio-chevron"></i>
                            </button>
                        </div>
                    </div>
                    <div class="collapse show" id="bibliotheque">
                        @if ($livresAchetes->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-book-open fa-4x text-muted mb-3"></i>
                                <h6 class="text-muted">Votre bibliothèque est vide</h6>
                                <p class="text-muted small">Achetez des livres pour les ajouter à votre bibliothèque personnelle</p>
                                <a href="{{ route('catalogue.decouvrir') }}" class="btn btn-primary btn-sm rounded-2 mt-2">
                                    <i class="fa fa-shopping-cart me-1"></i>Découvrir le catalogue
                                </a>
                            </div>
                        @else
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                @foreach ($livresAchetes as $livre)
                                    <div class="col">
                                        <div class="card h-100 livre-card-profile border-0 shadow-sm position-relative">
                                            <!-- Badge "Acheté" -->
                                            <div class="position-absolute top-0 start-0 m-2" style="z-index: 10;">
                                                <span class="badge bg-success shadow-sm">
                                                    <i class="fa fa-check-circle me-1"></i>Acheté
                                                </span>
                                            </div>

                                            <!-- Image du livre -->
                                            <div class="livre-image-wrapper position-relative"
                                                style="height: 250px; overflow: hidden; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                @if ($livre->image)
                                                    <img src="{{ asset($livre->image) }}"
                                                        alt="{{ $livre->titre }}"
                                                        class="card-img-top"
                                                        style="width: 100%; height: 100%; object-fit: cover;"
                                                        loading="lazy">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center h-100">
                                                        <i class="fas fa-book fa-4x text-white opacity-50"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Informations du livre -->
                                            <div class="card-body d-flex flex-column">
                                                <h6 class="card-title mb-1 fw-bold" title="{{ $livre->titre }}">
                                                    {{ Str::limit($livre->titre, 40) }}
                                                </h6>

                                                @if($livre->auteur)
                                                    <p class="text-muted small mb-2">
                                                        <i class="fas fa-user-pen me-1 text-primary"></i>
                                                        {{ Str::limit($livre->auteur, 30) }}
                                                    </p>
                                                @endif

                                                @if($livre->categorie)
                                                    <span class="badge bg-primary mb-2">{{ $livre->categorie }}</span>
                                                @endif

                                                @if($livre->resumer)
                                                    <p class="card-text text-muted small mb-3" style="flex: 1;">
                                                        {{ Str::limit(strip_tags($livre->resumer), 80) }}
                                                    </p>
                                                @endif

                                                <!-- Actions -->
                                                <div class="mt-auto d-grid gap-2">
                                                    @if($livre->pdf)
                                                        <a href="{{ route('bibliotheque.lire', $livre->id) }}"
                                                           class="btn btn-primary btn-sm">
                                                            <i class="fas fa-book-open me-1"></i>Lire maintenant
                                                        </a>
                                                    @else
                                                        <button class="btn btn-secondary btn-sm" disabled>
                                                            <i class="fas fa-exclamation-circle me-1"></i>PDF indisponible
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Footer -->
                                            <div class="card-footer bg-light border-0 text-center small text-success">
                                                <i class="fa fa-infinity me-1"></i>Accès à vie
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($livresAchetes->count() >= 6)
                                <div class="text-center mt-4">
                                    <a href="{{ route('account.bibliotheque') }}" class="btn btn-primary rounded-2">
                                        <i class="fa fa-eye me-2"></i>Voir toute ma bibliothèque
                                    </a>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal de modification du profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <i class="fa fa-edit me-2"></i>Modifier mes informations
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form method="POST" action="{{ route('account.profil.update') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fa fa-user text-success me-1"></i>Nom complet <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fa fa-envelope text-success me-1"></i>Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                <i class="fa fa-phone-alt text-success me-1"></i>Téléphone
                            </label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                   placeholder="Ex: +237 6XX XX XX XX">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">
                                <i class="fa fa-map-marker-alt text-success me-1"></i>Adresse
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="3"
                                      placeholder="Ville, Quartier, Rue...">{{ old('address', Auth::user()->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="text-muted mb-3">
                            <i class="fa fa-lock me-2"></i>Changer le mot de passe (optionnel)
                        </h6>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">
                                <i class="fa fa-key text-success me-1"></i>Mot de passe actuel
                            </label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password"
                                   placeholder="Laissez vide pour ne pas changer">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">
                                <i class="fa fa-lock text-success me-1"></i>Nouveau mot de passe
                            </label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                   id="new_password" name="new_password"
                                   placeholder="Minimum 8 caractères">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">
                                <i class="fa fa-lock text-success me-1"></i>Confirmer le nouveau mot de passe
                            </label>
                            <input type="password" class="form-control"
                                   id="new_password_confirmation" name="new_password_confirmation"
                                   placeholder="Retapez le nouveau mot de passe">
                        </div>

                        <div class="alert alert-info mb-0">
                            <i class="fa fa-info-circle me-2"></i>
                            <small>
                                Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.<br>
                                Pour changer votre mot de passe, remplissez tous les champs de mot de passe.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-success rounded-2">
                            <i class="fa fa-check me-1"></i>Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de déconnexion -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir vous déconnecter ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-2"
                        data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                        <button type="button" class="btn btn-danger rounded-2"
                            onclick="document.getElementById('logoutForm').submit();">Se déconnecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .bg-gradient {
            background: linear-gradient(90deg, #007bff, #00c6a7) !important;
        }

        .profile-card {
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(2px);
            border-radius: 1.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.10);
            transition: box-shadow 0.2s;
        }

        .profile-card:hover {
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.16);
        }

        .profile-avatar {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border: 4px solid #00c6a7;
            box-shadow: 0 4px 16px rgba(0, 123, 255, 0.10);
            transition: transform 0.2s;
        }

        .profile-avatar:hover {
            transform: scale(1.05) rotate(-2deg);
        }

        .profile-btn {
            transition: background 0.2s, color 0.2s;
        }

        .profile-btn:hover {
            background: #00c6a7;
            color: #fff;
        }

        .stat-box {
            background: #f8f9fa;
            border-radius: 1rem;
            padding: 1.2rem 0.5rem;
            min-width: 120px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .stat-box:hover {
            box-shadow: 0 6px 24px rgba(0, 198, 167, 0.10);
            transform: scale(1.04);
        }

        /* Emprunt Cards in Profile */
        .emprunt-card-profile {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .emprunt-card-profile:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 198, 167, 0.2) !important;
        }

        .emprunt-image-wrapper img {
            transition: transform 0.3s ease;
        }

        .emprunt-card-profile:hover .emprunt-image-wrapper img {
            transform: scale(1.05);
        }

        .emprunt-card-profile .btn {
            transition: all 0.3s ease;
        }

        .emprunt-card-profile .btn:hover {
            transform: translateY(-2px);
        }

        /* Smooth fade/translate for collapse content - only for profile specific collapses */
        #modulesCollapse:not(.show),
        #certsCollapse:not(.show),
        #purchasesCollapse:not(.show) {
            display: block;
            height: 0;
            overflow: hidden;
            opacity: 0;
            transform: translateY(-6px);
            transition: height .35s ease, opacity .35s ease, transform .35s ease;
        }

        #modulesCollapse.show,
        #certsCollapse.show,
        #purchasesCollapse.show {
            opacity: 1;
            transform: translateY(0);
        }

        /* Ensure chevrons have transition */
        .modules-chevron,
        .certs-chevron,
        .purchases-chevron {
            transition: transform .25s ease;
        }

        @media (max-width: 767px) {
            .profile-card {
                padding: 1rem;
            }

            .profile-avatar {
                width: 80px;
                height: 80px;
            }

            .stat-box {
                min-width: 90px;
                padding: 0.8rem 0.2rem;
            }

            .emprunt-image-wrapper {
                height: 180px !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Rotate chevrons on collapse show/hide for modules and recent activity
        document.addEventListener('DOMContentLoaded', function() {
            var toggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
            toggles.forEach(function(btn) {
                var targetSelector = btn.getAttribute('data-bs-target');
                if (!targetSelector) return;
                var target = document.querySelector(targetSelector);
                var icon = btn.querySelector('i');
                if (!target || !icon) return;

                var bsCollapse = new bootstrap.Collapse(target, {
                    toggle: false
                });

                // set initial rotation based on state
                if (target.classList.contains('show')) {
                    icon.style.transform = 'rotate(0deg)';
                    icon.style.transition = 'transform 200ms';
                } else {
                    icon.style.transform = 'rotate(180deg)';
                    icon.style.transition = 'transform 200ms';
                }

                target.addEventListener('show.bs.collapse', function() {
                    icon.style.transform = 'rotate(0deg)';
                });
                target.addEventListener('hide.bs.collapse', function() {
                    icon.style.transform = 'rotate(180deg)';
                });

                // Optional: toggle collapse on button click (Bootstrap handles it) but ensure icon toggles when keyboard used
                btn.addEventListener('click', function() {
                    // nothing extra needed; events above handle rotation
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var avatarInput = document.getElementById('avatarInput');
            var avatarForm = document.getElementById('avatarForm');
            var avatarPreview = document.getElementById('avatarPreview');

            if (avatarInput) {
                avatarInput.addEventListener('change', function(e) {
                    var file = this.files[0];
                    if (!file) return;
                    // preview
                    var reader = new FileReader();
                    reader.onload = function(evt) {
                        if (avatarPreview) avatarPreview.src = evt.target.result;
                    };
                    reader.readAsDataURL(file);

                    // submit form
                    if (avatarForm) avatarForm.submit();
                });
            }

            // Rouvrir le modal si erreurs de validation
            @if($errors->any())
                var editProfileModal = new bootstrap.Modal(document.getElementById('editProfileModal'));
                editProfileModal.show();
            @endif

            // Validation du changement de mot de passe
            var currentPassword = document.getElementById('current_password');
            var newPassword = document.getElementById('new_password');
            var newPasswordConfirmation = document.getElementById('new_password_confirmation');

            if (currentPassword && newPassword && newPasswordConfirmation) {
                // Si un champ de mot de passe est rempli, les autres deviennent requis
                function updatePasswordRequirements() {
                    var anyFilled = currentPassword.value || newPassword.value || newPasswordConfirmation.value;

                    if (anyFilled) {
                        currentPassword.required = true;
                        newPassword.required = true;
                        newPasswordConfirmation.required = true;
                    } else {
                        currentPassword.required = false;
                        newPassword.required = false;
                        newPasswordConfirmation.required = false;
                    }
                }

                currentPassword.addEventListener('input', updatePasswordRequirements);
                newPassword.addEventListener('input', updatePasswordRequirements);
                newPasswordConfirmation.addEventListener('input', updatePasswordRequirements);
            }

            // Countdown timer function
            function updateCountdowns() {
                const timers = document.querySelectorAll('.countdown-timer');
                const now = new Date();

                timers.forEach(timer => {
                    const expiresAt = new Date(timer.getAttribute('data-expires'));
                    const textElement = timer.querySelector('.countdown-text');

                    const diff = expiresAt - now;

                    if (diff <= 0) {
                        textElement.textContent = 'Expiré';
                        timer.classList.remove('bg-info', 'bg-warning');
                        timer.classList.add('bg-danger', 'text-white');

                        // Ne recharger qu'une seule fois en utilisant sessionStorage
                        if (!sessionStorage.getItem('countdown_reload_' + timer.getAttribute(
                                'data-expires'))) {
                            sessionStorage.setItem('countdown_reload_' + timer.getAttribute('data-expires'),
                                'true');
                            setTimeout(() => location.reload(), 2000);
                        }
                    } else {
                        const hours = Math.floor(diff / (1000 * 60 * 60));
                        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        textElement.textContent = `${hours}h ${minutes}m ${seconds}s`;

                        // Change color based on remaining time
                        if (hours < 1) {
                            timer.classList.remove('bg-info');
                            timer.classList.add('bg-danger', 'text-white');
                        } else if (hours < 2) {
                            timer.classList.remove('bg-info');
                            timer.classList.add('bg-warning');
                        }
                    }
                });
            }

            // Update immediately
            updateCountdowns();

            // Update every second
            setInterval(updateCountdowns, 1000);
        });
    </script>
@endpush
