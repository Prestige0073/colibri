@extends('layouts.app')

@section('title', 'Mon Profil - Colibri Littéraire')
@section('meta_description',
    'Gérez votre profil, vos informations personnelles et suivez votre activité sur Colibri
    Littéraire.')

@section('content')
    @include('partials.notifications')

    @php
        $cartItems = Auth::user()->cartItems()->with('catalogue')->get();
        $cartCount = $cartItems->sum('quantite');
        $recentPurchases = Auth::user()->cartItems()->with('catalogue')->orderByDesc('created_at')->take(5)->get();
    @endphp

    <!-- Hero Profile Section -->
    <div class="profile-hero">
        <div class="profile-hero-bg"></div>
        <div class="container position-relative">
            <div class="profile-hero-content">
                <div class="profile-avatar-section">
                    <form id="avatarForm" action="{{ route('account.avatar.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <label for="avatarInput" class="profile-avatar-wrapper">
                            @if (Auth::user()->avatar)
                                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar"
                                    class="profile-avatar-img" id="avatarPreview">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1e7a2f&color=fff&size=180"
                                    alt="Avatar" class="profile-avatar-img" id="avatarPreview">
                            @endif
                            <div class="avatar-overlay">
                                <i class="fa fa-camera"></i>
                            </div>
                        </label>
                        <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display:none;">
                    </form>
                </div>

                <div class="profile-info-section">
                    <h2 class="profile-name">{{ Auth::user()->name }}</h2>
                    <div class="profile-details">
                        <span class="profile-detail-item">
                            <i class="fa fa-envelope"></i> {{ Auth::user()->email }}
                        </span>
                        <span class="profile-detail-item">
                            <i class="fa fa-phone-alt"></i> {{ Auth::user()->phone ?? 'Non renseigné' }}
                        </span>
                        <span class="profile-detail-item">
                            <i class="fa fa-map-marker-alt"></i> {{ Auth::user()->address ?? 'Non renseignée' }}
                        </span>
                    </div>
                    <div class="profile-actions">
                        <button type="button" class="profile-action-btn profile-action-edit"
                            data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="fa fa-edit"></i>
                            <span>Modifier</span>
                        </button>
                        <a href="{{ route('account.commandes') }}" class="profile-action-btn profile-action-orders">
                            <i class="fa fa-truck"></i>
                            <span>Commandes</span>
                            @if(($commandesEnLivraison->count() ?? 0) > 0)
                                <span class="action-badge">{{ $commandesEnLivraison->count() }}</span>
                            @endif
                        </a>
                        <button type="button" class="profile-action-btn profile-action-logout"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="fa fa-sign-out-alt"></i>
                            <span>Quitter</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="container" style="margin-top: -40px; position: relative; z-index: 10;">
        <div class="row g-3 justify-content-center">
            <div class="col-6 col-md-4">
                <div class="profile-stat-card">
                    <div class="stat-icon-wrap stat-icon-cart">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <div class="stat-value">{{ $cartCount }}</div>
                    <div class="stat-label">Articles au panier</div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="profile-stat-card">
                    <div class="stat-icon-wrap stat-icon-books">
                        <i class="fa fa-book-reader"></i>
                    </div>
                    <div class="stat-value">{{ $emprunts->count() }}</div>
                    <div class="stat-label">Emprunts</div>
                </div>
            </div>
            <div class="col-6 col-md-4">
                <div class="profile-stat-card">
                    <div class="stat-icon-wrap stat-icon-awards">
                        <i class="fa fa-award"></i>
                    </div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Certifications</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-4">

        <!-- Activité récente -->
        <div class="profile-section">
            <div class="profile-section-header" data-bs-toggle="collapse" data-bs-target="#recentActivity" role="button">
                <div class="section-title-wrap">
                    <div class="section-icon"><i class="fa fa-history"></i></div>
                    <h5 class="section-title">Activité récente</h5>
                </div>
                <i class="fa fa-chevron-up section-chevron"></i>
            </div>
            <div class="collapse show" id="recentActivity">
                <div class="profile-section-body">
                    @forelse($recentPurchases as $item)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="activity-content">
                                <span class="activity-text">Achat du livre <strong>{{ $item->catalogue->titre }}</strong></span>
                                <span class="activity-date">{{ $item->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-mini">
                            <i class="fa fa-clock"></i>
                            <span>Aucune activité récente</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Mes Formations -->
        <div class="profile-section">
            <div class="profile-section-header" data-bs-toggle="collapse" data-bs-target="#modulesSuivis" role="button">
                <div class="section-title-wrap">
                    <div class="section-icon section-icon-formations"><i class="fa fa-graduation-cap"></i></div>
                    <h5 class="section-title">Mes Formations</h5>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('account.formations') }}" class="section-link" onclick="event.stopPropagation();">
                        Voir tout <i class="fa fa-arrow-right"></i>
                    </a>
                    <i class="fa fa-chevron-up section-chevron"></i>
                </div>
            </div>
            <div class="collapse show" id="modulesSuivis">
                <div class="profile-section-body">
                    @php
                        $mesFormations = \App\Models\FormationInscription::where('user_id', Auth::id())
                            ->with('formation')
                            ->where('paiement_valide', true)
                            ->orderByDesc('created_at')
                            ->take(3)
                            ->get();
                    @endphp

                    @if($mesFormations->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fa fa-graduation-cap"></i></div>
                            <h6>Aucune formation en cours</h6>
                            <p>Découvrez nos formations pour développer vos compétences</p>
                            <a href="{{ route('formation.modules') }}" class="empty-state-btn">
                                <i class="fa fa-search me-1"></i>Explorer les formations
                            </a>
                        </div>
                    @else
                        <div class="row g-3">
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
                                <div class="col-md-6 col-lg-4">
                                    <div class="formation-card">
                                        @if($formation && $formation->image)
                                            <div class="formation-card-img">
                                                <img src="{{ asset($formation->image) }}" alt="{{ $formation->titre }}">
                                                @if($progression >= 100)
                                                    <span class="formation-badge formation-badge-done">Terminée</span>
                                                @elseif($progression > 0)
                                                    <span class="formation-badge formation-badge-progress">En cours</span>
                                                @else
                                                    <span class="formation-badge formation-badge-new">Non commencée</span>
                                                @endif
                                            </div>
                                        @endif
                                        <div class="formation-card-body">
                                            <h6 class="formation-card-title">
                                                {{ $formation ? Str::limit($formation->titre, 30) : 'Formation' }}
                                            </h6>
                                            <div class="formation-progress">
                                                <div class="formation-progress-header">
                                                    <span>Progression</span>
                                                    <span class="formation-progress-pct">{{ $progression }}%</span>
                                                </div>
                                                <div class="formation-progress-bar">
                                                    <div class="formation-progress-fill" style="width: {{ $progression }}%"></div>
                                                </div>
                                            </div>
                                            @if($formation)
                                                <a href="{{ route('formation.show', $formation) }}" class="formation-card-btn">
                                                    <i class="fa fa-play"></i> Continuer
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

        <!-- Emprunts -->
        <div class="profile-section">
            <div class="profile-section-header" data-bs-toggle="collapse" data-bs-target="#emprunts" role="button">
                <div class="section-title-wrap">
                    <div class="section-icon section-icon-emprunts"><i class="fa fa-book-reader"></i></div>
                    <h5 class="section-title">Mes emprunts ({{ $emprunts->count() }})</h5>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('emprunts.mes-emprunts') }}" class="section-link" onclick="event.stopPropagation();">
                        Voir tout <i class="fa fa-arrow-right"></i>
                    </a>
                    <i class="fa fa-chevron-up section-chevron"></i>
                </div>
            </div>
            <div class="collapse show" id="emprunts">
                <div class="profile-section-body">
                    @php
                        $empruntsActifs = $emprunts->whereIn('statut', ['en_cours', 'en_retard'])->take(6);
                    @endphp

                    @if ($empruntsActifs->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fa fa-book-open"></i></div>
                            <h6>Aucun emprunt en cours</h6>
                            <p>Explorez notre bibliothèque pour emprunter des livres</p>
                            <a href="{{ route('emprunts.index') }}" class="empty-state-btn">
                                <i class="fa fa-search me-1"></i>Parcourir la bibliothèque
                            </a>
                        </div>
                    @else
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            @foreach ($empruntsActifs as $emprunt)
                                <div class="col">
                                    <div class="emprunt-card">
                                        <div class="emprunt-card-img">
                                            @if ($emprunt->livre && $emprunt->livre->image)
                                                <img src="{{ asset($emprunt->livre->image) }}"
                                                    alt="{{ $emprunt->livre->titre }}" loading="lazy">
                                            @else
                                                <div class="emprunt-card-placeholder">
                                                    <i class="fa fa-book"></i>
                                                </div>
                                            @endif
                                            @php
                                                $now = now();
                                                $dateRetour = $emprunt->date_retour
                                                    ? \Carbon\Carbon::parse($emprunt->date_retour)
                                                    : null;
                                                $joursRestants = $dateRetour
                                                    ? $now->diffInDays($dateRetour, false)
                                                    : null;

                                                if ($emprunt->statut === 'en_attente' || !$emprunt->valide_le) {
                                                    $badgeClass = 'emprunt-badge-waiting';
                                                    $badgeText = 'Non validé';
                                                } elseif ($emprunt->statut === 'retourne') {
                                                    $badgeClass = 'emprunt-badge-returned';
                                                    $badgeText = 'Retourné';
                                                } elseif (
                                                    $emprunt->statut === 'en_retard' ||
                                                    ($joursRestants !== null && $joursRestants < 0)
                                                ) {
                                                    $badgeClass = 'emprunt-badge-late';
                                                    $badgeText = 'En retard';
                                                } elseif ($joursRestants !== null && $joursRestants <= 2) {
                                                    $badgeClass = 'emprunt-badge-warning';
                                                    $badgeText = $joursRestants . 'j restants';
                                                } else {
                                                    $badgeClass = 'emprunt-badge-active';
                                                    $badgeText = 'En cours';
                                                }
                                            @endphp
                                            <span class="emprunt-badge {{ $badgeClass }}">{{ $badgeText }}</span>
                                        </div>
                                        <div class="emprunt-card-body">
                                            <h6 class="emprunt-card-title" title="{{ $emprunt->livre ? $emprunt->livre->titre : 'Livre inconnu' }}">
                                                {{ $emprunt->livre ? Str::limit($emprunt->livre->titre, 35) : 'Livre inconnu' }}
                                            </h6>
                                            <p class="emprunt-card-author">
                                                <i class="fa fa-user-pen"></i>
                                                {{ $emprunt->livre ? Str::limit($emprunt->livre->auteur, 25) : 'N/A' }}
                                            </p>
                                            <div class="emprunt-card-dates">
                                                <div><i class="fa fa-calendar"></i> <strong>Emprunté:</strong> {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</div>
                                                <div><i class="fa fa-calendar-check"></i> <strong>Retour:</strong> {{ $dateRetour ? $dateRetour->format('d/m/Y') : 'N/A' }}</div>
                                                @if ($emprunt->access_expires_at && $emprunt->valide_le)
                                                    <div class="emprunt-countdown">
                                                        <strong>Accès restant:</strong>
                                                        <span class="countdown-timer" data-expires="{{ $emprunt->access_expires_at->toIso8601String() }}">
                                                            <i class="fa fa-clock"></i>
                                                            <span class="countdown-text">Calcul...</span>
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="emprunt-card-actions">
                                                @if ($emprunt->livre && $emprunt->livre->pdf)
                                                    @if ($emprunt->statut === 'en_attente' || !$emprunt->valide_le)
                                                        <button class="emprunt-btn emprunt-btn-disabled" disabled>
                                                            <i class="fa fa-clock"></i> Non validé
                                                        </button>
                                                    @elseif($emprunt->valide_le && $emprunt->statut !== 'retourne')
                                                        @if ($emprunt->access_expires_at && now()->greaterThan($emprunt->access_expires_at))
                                                            <button class="emprunt-btn emprunt-btn-disabled" disabled>
                                                                <i class="fa fa-lock"></i> Accès expiré
                                                            </button>
                                                        @else
                                                            <a href="{{ route('secure-pdf.view', $emprunt->livre->id) }}"
                                                                class="emprunt-btn emprunt-btn-read">
                                                                <i class="fa fa-book-reader"></i> Lire
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endif
                                                <a href="{{ route('emprunts.show', $emprunt->id) }}"
                                                    class="emprunt-btn emprunt-btn-details">
                                                    <i class="fa fa-info-circle"></i> Détails
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($emprunts->count() > 6)
                            <div class="text-center mt-4">
                                <a href="{{ route('emprunts.mes-emprunts') }}" class="see-all-btn">
                                    <i class="fa fa-eye me-2"></i>Voir tous mes emprunts ({{ $emprunts->count() }})
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <!-- Ma Bibliothèque -->
        <div class="profile-section">
            <div class="profile-section-header" data-bs-toggle="collapse" data-bs-target="#bibliotheque" role="button">
                <div class="section-title-wrap">
                    <div class="section-icon section-icon-biblio"><i class="fa fa-book"></i></div>
                    <h5 class="section-title">Ma Bibliothèque ({{ $livresAchetes->count() }})</h5>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('account.bibliotheque') }}" class="section-link" onclick="event.stopPropagation();">
                        Voir tout <i class="fa fa-arrow-right"></i>
                    </a>
                    <i class="fa fa-chevron-up section-chevron"></i>
                </div>
            </div>
            <div class="collapse show" id="bibliotheque">
                <div class="profile-section-body">
                    @if ($livresAchetes->isEmpty())
                        <div class="empty-state">
                            <div class="empty-state-icon empty-state-icon-biblio"><i class="fa fa-book-open"></i></div>
                            <h6>Votre bibliothèque est vide</h6>
                            <p>Achetez des livres pour les ajouter à votre bibliothèque personnelle</p>
                            <a href="{{ route('catalogue.decouvrir') }}" class="empty-state-btn empty-state-btn-biblio">
                                <i class="fa fa-shopping-cart me-1"></i>Découvrir le catalogue
                            </a>
                        </div>
                    @else
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                            @foreach ($livresAchetes as $livre)
                                <div class="col">
                                    <div class="biblio-card">
                                        <div class="biblio-card-img">
                                            @if ($livre->image)
                                                <img src="{{ asset($livre->image) }}" alt="{{ $livre->titre }}" loading="lazy">
                                            @else
                                                <div class="biblio-card-placeholder">
                                                    <i class="fa fa-book"></i>
                                                </div>
                                            @endif
                                            <span class="biblio-badge-owned">
                                                <i class="fa fa-check-circle"></i> Acheté
                                            </span>
                                        </div>
                                        <div class="biblio-card-body">
                                            <h6 class="biblio-card-title" title="{{ $livre->titre }}">
                                                {{ Str::limit($livre->titre, 40) }}
                                            </h6>
                                            @if($livre->auteur)
                                                <p class="biblio-card-author">
                                                    <i class="fa fa-user-pen"></i>
                                                    {{ Str::limit($livre->auteur, 30) }}
                                                </p>
                                            @endif
                                            @if($livre->categorie)
                                                <span class="biblio-card-category">{{ $livre->categorie }}</span>
                                            @endif
                                            @if($livre->resumer)
                                                <p class="biblio-card-desc">
                                                    {{ Str::limit(strip_tags($livre->resumer), 80) }}
                                                </p>
                                            @endif
                                            <div class="biblio-card-actions">
                                                @if($livre->pdf)
                                                    <a href="{{ route('bibliotheque.lire', $livre->id) }}" class="biblio-btn-read">
                                                        <i class="fa fa-book-open"></i> Lire maintenant
                                                    </a>
                                                @else
                                                    <button class="biblio-btn-unavailable" disabled>
                                                        <i class="fa fa-exclamation-circle"></i> PDF indisponible
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="biblio-card-footer">
                                            <i class="fa fa-infinity"></i> Accès à vie
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($livresAchetes->count() >= 6)
                            <div class="text-center mt-4">
                                <a href="{{ route('account.bibliotheque') }}" class="see-all-btn">
                                    <i class="fa fa-eye me-2"></i>Voir toute ma bibliothèque
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de modification du profil -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border:none; border-radius: 16px; overflow: hidden;">
                <div class="modal-header" style="background: #1e7a2f; color: white; border: none;">
                    <h5 class="modal-title" id="editProfileModalLabel">
                        <i class="fa fa-edit me-2"></i>Modifier mes informations
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form method="POST" action="{{ route('account.profil.update') }}">
                    @csrf
                    <div class="modal-body" style="padding: 1.5rem;">
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fa fa-user text-success me-1"></i>Nom complet <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                   style="border-radius: 10px; padding: 0.7rem 1rem;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fa fa-envelope text-success me-1"></i>Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                                   style="border-radius: 10px; padding: 0.7rem 1rem;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="fa fa-phone-alt text-success me-1"></i>Téléphone
                            </label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                                   placeholder="Ex: +237 6XX XX XX XX"
                                   style="border-radius: 10px; padding: 0.7rem 1rem;">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">
                                <i class="fa fa-map-marker-alt text-success me-1"></i>Adresse
                            </label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="3"
                                      placeholder="Ville, Quartier, Rue..."
                                      style="border-radius: 10px; padding: 0.7rem 1rem;">{{ old('address', Auth::user()->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="text-muted mb-3">
                            <i class="fa fa-lock me-2"></i>Changer le mot de passe (optionnel)
                        </h6>

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-semibold">
                                <i class="fa fa-key text-success me-1"></i>Mot de passe actuel
                            </label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                   id="current_password" name="current_password"
                                   placeholder="Laissez vide pour ne pas changer"
                                   style="border-radius: 10px; padding: 0.7rem 1rem;">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-semibold">
                                <i class="fa fa-lock text-success me-1"></i>Nouveau mot de passe
                            </label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                   id="new_password" name="new_password"
                                   placeholder="Minimum 8 caractères"
                                   style="border-radius: 10px; padding: 0.7rem 1rem;">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label fw-semibold">
                                <i class="fa fa-lock text-success me-1"></i>Confirmer le nouveau mot de passe
                            </label>
                            <input type="password" class="form-control"
                                   id="new_password_confirmation" name="new_password_confirmation"
                                   placeholder="Retapez le nouveau mot de passe"
                                   style="border-radius: 10px; padding: 0.7rem 1rem;">
                        </div>

                        <div class="alert alert-info mb-0" style="border-radius: 10px; border: none; background: #e8f5e9;">
                            <i class="fa fa-info-circle me-2 text-success"></i>
                            <small>
                                Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires.<br>
                                Pour changer votre mot de passe, remplissez tous les champs de mot de passe.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer" style="border: none; padding: 1rem 1.5rem;">
                        <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">
                            <i class="fa fa-times me-1"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-success rounded-3" style="background: #1e7a2f; border: none;">
                            <i class="fa fa-check me-1"></i>Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de déconnexion -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content" style="border: none; border-radius: 16px; overflow: hidden;">
                <div class="modal-body text-center py-4">
                    <div style="width: 60px; height: 60px; background: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
                        <i class="fa fa-sign-out-alt" style="font-size: 1.5rem; color: #dc3545;"></i>
                    </div>
                    <h6 class="fw-bold mb-2">Se déconnecter ?</h6>
                    <p class="text-muted small mb-3">Vous allez être déconnecté de votre compte.</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-secondary rounded-3 px-4" data-bs-dismiss="modal">Annuler</button>
                        <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                            @csrf
                            <button type="submit" class="btn btn-danger rounded-3 px-4">Quitter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* ═══════════════════════════════════════════
           PROFILE HERO
           ═══════════════════════════════════════════ */
        .profile-hero {
            position: relative;
            padding: 3rem 0 5rem;
            overflow: hidden;
        }

        .profile-hero-bg {
            position: absolute;
            inset: 0;
            background: #1e7a2f;
        }

        .profile-hero-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .profile-hero-content {
            display: flex;
            align-items: center;
            gap: 2.5rem;
        }

        /* Avatar */
        .profile-avatar-wrapper {
            position: relative;
            cursor: pointer;
            display: block;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .profile-avatar-img {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255,255,255,0.3);
            transition: transform 0.3s ease;
        }

        .avatar-overlay {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            background: rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .avatar-overlay i {
            color: white;
            font-size: 1.5rem;
        }

        .profile-avatar-wrapper:hover .avatar-overlay {
            opacity: 1;
        }

        .profile-avatar-wrapper:hover .profile-avatar-img {
            transform: scale(1.05);
        }

        /* Info */
        .profile-info-section {
            color: white;
        }

        .profile-name {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
            color: #ffffff;
        }

        .profile-details {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .profile-detail-item {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
            color: rgba(255,255,255,0.8);
        }

        .profile-detail-item i {
            font-size: 0.8rem;
            opacity: 0.7;
        }

        /* Actions */
        .profile-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
        }

        .profile-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            border: 1px solid rgba(255,255,255,0.25);
            background: rgba(255,255,255,0.1);
            color: white;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .profile-action-btn:hover {
            background: rgba(255,255,255,0.2);
            color: white;
            transform: translateY(-1px);
        }

        .profile-action-logout {
            border-color: rgba(220,53,69,0.5);
            background: rgba(220,53,69,0.15);
        }

        .profile-action-logout:hover {
            background: rgba(220,53,69,0.3);
            color: white;
        }

        .action-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            width: 20px;
            height: 20px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            border: 2px solid #1e7a2f;
        }

        /* ═══════════════════════════════════════════
           STAT CARDS
           ═══════════════════════════════════════════ */
        .profile-stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem 1rem;
            text-align: center;
            box-shadow: 0 6px 24px rgba(0,0,0,0.12);
            border: 1px solid #e0e0e0;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .profile-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 36px rgba(0,0,0,0.16);
        }

        .stat-icon-wrap {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 1.2rem;
        }

        .stat-icon-cart { background: #e8f5e9; color: #1e7a2f; }
        .stat-icon-books { background: #e3f2fd; color: #1565c0; }
        .stat-icon-awards { background: #fff8e1; color: #f9a825; }

        .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: #2d3436;
            line-height: 1;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #636e72;
        }

        /* ═══════════════════════════════════════════
           SECTIONS
           ═══════════════════════════════════════════ */
        .profile-section {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border: 1px solid #e0e0e0;
            margin-bottom: 1.25rem;
            overflow: hidden;
        }

        .profile-section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.1rem 1.5rem;
            cursor: pointer;
            user-select: none;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }

        .profile-section-header:hover {
            background: #fafafa;
        }

        .section-title-wrap {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            background: #e8f5e9;
            color: #1e7a2f;
        }

        .section-icon-formations { background: #fff3e0; color: #e65100; }
        .section-icon-emprunts { background: #e3f2fd; color: #1565c0; }
        .section-icon-biblio { background: #e8f5e9; color: #1e7a2f; }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            color: #2d3436;
            margin: 0;
        }

        .section-link {
            font-size: 0.85rem;
            color: #1e7a2f;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            transition: color 0.2s;
        }

        .section-link:hover {
            color: #155a22;
        }

        .section-chevron {
            transition: transform 0.25s ease;
            font-size: 0.85rem;
            color: #adb5bd;
        }

        .profile-section-body {
            padding: 1.25rem 1.5rem;
        }

        /* ═══════════════════════════════════════════
           ACTIVITY ITEMS
           ═══════════════════════════════════════════ */
        .activity-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e8f5e9;
            color: #1e7a2f;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .activity-content {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
            min-width: 0;
        }

        .activity-text {
            font-size: 0.9rem;
            color: #2d3436;
        }

        .activity-date {
            font-size: 0.78rem;
            color: #adb5bd;
        }

        /* ═══════════════════════════════════════════
           FORMATION CARDS
           ═══════════════════════════════════════════ */
        .formation-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #d5d5d5;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .formation-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-color: #1e7a2f;
        }

        .formation-card-img {
            height: 130px;
            overflow: hidden;
            position: relative;
        }

        .formation-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .formation-card:hover .formation-card-img img {
            transform: scale(1.05);
        }

        .formation-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
        }

        .formation-badge-done { background: #27ae60; }
        .formation-badge-progress { background: #2980b9; }
        .formation-badge-new { background: #f39c12; }

        .formation-card-body {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .formation-card-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 0.75rem;
        }

        .formation-progress {
            margin-bottom: 0.75rem;
        }

        .formation-progress-header {
            display: flex;
            justify-content: space-between;
            font-size: 0.75rem;
            color: #636e72;
            margin-bottom: 0.3rem;
        }

        .formation-progress-pct {
            font-weight: 600;
            color: #1e7a2f;
        }

        .formation-progress-bar {
            height: 6px;
            background: #e9ecef;
            border-radius: 3px;
            overflow: hidden;
        }

        .formation-progress-fill {
            height: 100%;
            background: #1e7a2f;
            border-radius: 3px;
            transition: width 0.5s ease;
        }

        .formation-card-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.5rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            color: #1e7a2f;
            border: 1px solid #1e7a2f;
            margin-top: auto;
            transition: all 0.2s;
        }

        .formation-card-btn:hover {
            background: #1e7a2f;
            color: white;
        }

        /* ═══════════════════════════════════════════
           EMPRUNT CARDS
           ═══════════════════════════════════════════ */
        .emprunt-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #d5d5d5;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .emprunt-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-color: #1565c0;
        }

        .emprunt-card-img {
            height: 180px;
            overflow: hidden;
            position: relative;
            background: #f0f2f5;
        }

        .emprunt-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .emprunt-card:hover .emprunt-card-img img {
            transform: scale(1.05);
        }

        .emprunt-card-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #adb5bd;
        }

        .emprunt-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            color: white;
        }

        .emprunt-badge-active { background: #2980b9; }
        .emprunt-badge-warning { background: #f39c12; }
        .emprunt-badge-late { background: #e74c3c; }
        .emprunt-badge-waiting { background: #f39c12; color: #333; }
        .emprunt-badge-returned { background: #27ae60; }

        .emprunt-card-body {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .emprunt-card-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .emprunt-card-author {
            font-size: 0.8rem;
            color: #636e72;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .emprunt-card-author i {
            color: #1e7a2f;
            font-size: 0.75rem;
        }

        .emprunt-card-dates {
            font-size: 0.78rem;
            color: #636e72;
            margin-bottom: 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.2rem;
        }

        .emprunt-card-dates i {
            color: #1e7a2f;
            width: 14px;
        }

        .emprunt-countdown {
            margin-top: 0.25rem;
        }

        .countdown-timer {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            background: #e3f2fd;
            color: #1565c0;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .countdown-timer.timer-danger {
            background: #fee2e2;
            color: #dc3545;
        }

        .countdown-timer.timer-warning {
            background: #fff3cd;
            color: #856404;
        }

        .emprunt-card-actions {
            margin-top: auto;
            display: flex;
            gap: 0.5rem;
        }

        .emprunt-btn {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            padding: 0.45rem 0.6rem;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .emprunt-btn-read {
            background: #1e7a2f;
            color: white;
        }

        .emprunt-btn-read:hover {
            background: #155a22;
            color: white;
        }

        .emprunt-btn-details {
            background: #f0f0f0;
            color: #2d3436;
        }

        .emprunt-btn-details:hover {
            background: #e0e0e0;
            color: #2d3436;
        }

        .emprunt-btn-disabled {
            background: #f5f5f5;
            color: #adb5bd;
            cursor: not-allowed;
        }

        /* ═══════════════════════════════════════════
           BIBLIOTHÈQUE CARDS
           ═══════════════════════════════════════════ */
        .biblio-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #d5d5d5;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .biblio-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            border-color: #1e7a2f;
        }

        .biblio-card-img {
            height: 220px;
            overflow: hidden;
            position: relative;
            background: #e8f5e9;
        }

        .biblio-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s;
        }

        .biblio-card:hover .biblio-card-img img {
            transform: scale(1.05);
        }

        .biblio-card-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #a5d6a7;
        }

        .biblio-badge-owned {
            position: absolute;
            top: 8px;
            left: 8px;
            padding: 0.2rem 0.6rem;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 600;
            background: #27ae60;
            color: white;
        }

        .biblio-card-body {
            padding: 1rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .biblio-card-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .biblio-card-author {
            font-size: 0.8rem;
            color: #636e72;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .biblio-card-author i {
            color: #1e7a2f;
            font-size: 0.75rem;
        }

        .biblio-card-category {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 600;
            background: #e8f5e9;
            color: #1e7a2f;
            margin-bottom: 0.5rem;
        }

        .biblio-card-desc {
            font-size: 0.82rem;
            color: #636e72;
            margin-bottom: 0.75rem;
            flex: 1;
        }

        .biblio-card-actions {
            margin-top: auto;
        }

        .biblio-btn-read {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.5rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            background: #1e7a2f;
            color: white;
            border: none;
            transition: all 0.2s;
            width: 100%;
        }

        .biblio-btn-read:hover {
            background: #155a22;
            color: white;
            transform: translateY(-1px);
        }

        .biblio-btn-unavailable {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            padding: 0.5rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            background: #f5f5f5;
            color: #adb5bd;
            border: none;
            width: 100%;
            cursor: not-allowed;
        }

        .biblio-card-footer {
            padding: 0.6rem 1rem;
            text-align: center;
            font-size: 0.78rem;
            color: #27ae60;
            font-weight: 500;
            background: #f0fdf0;
            border-top: 1px solid #e8f5e9;
        }

        /* ═══════════════════════════════════════════
           EMPTY STATE & SHARED
           ═══════════════════════════════════════════ */
        .empty-state {
            text-align: center;
            padding: 2.5rem 1rem;
        }

        .empty-state-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #e8f5e9;
            color: #1e7a2f;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
        }

        .empty-state-icon-biblio {
            background: #e8f5e9;
            color: #1e7a2f;
        }

        .empty-state h6 {
            font-weight: 600;
            color: #2d3436;
            margin-bottom: 0.25rem;
        }

        .empty-state p {
            font-size: 0.85rem;
            color: #636e72;
            margin-bottom: 1rem;
        }

        .empty-state-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            background: #1e7a2f;
            color: white;
            transition: all 0.2s;
        }

        .empty-state-btn:hover {
            background: #155a22;
            color: white;
        }

        .empty-state-btn-biblio {
            background: #1e7a2f;
        }

        .empty-state-btn-biblio:hover {
            background: #155a22;
        }

        .empty-state-mini {
            text-align: center;
            padding: 1.5rem;
            color: #adb5bd;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .see-all-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            background: #1e7a2f;
            color: white;
            transition: all 0.2s;
        }

        .see-all-btn:hover {
            background: #155a22;
            color: white;
            transform: translateY(-1px);
        }

        /* ═══════════════════════════════════════════
           RESPONSIVE
           ═══════════════════════════════════════════ */
        @media (max-width: 767px) {
            .profile-hero {
                padding: 2rem 0 4rem;
            }

            .profile-hero-content {
                flex-direction: column;
                text-align: center;
                gap: 1.25rem;
            }

            .profile-avatar-wrapper {
                width: 100px;
                height: 100px;
            }

            .profile-avatar-img {
                width: 100px;
                height: 100px;
            }

            .profile-name {
                font-size: 1.3rem;
            }

            .profile-details {
                justify-content: center;
                flex-direction: column;
                gap: 0.4rem;
            }

            .profile-actions {
                justify-content: center;
            }

            .profile-action-btn span {
                display: none;
            }

            .profile-action-btn {
                padding: 0.6rem;
                width: 40px;
                height: 40px;
                justify-content: center;
                border-radius: 50%;
            }

            .profile-action-btn i {
                margin: 0;
            }

            .profile-stat-card {
                padding: 1rem 0.5rem;
            }

            .stat-value {
                font-size: 1.4rem;
            }

            .stat-icon-wrap {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .profile-section-body {
                padding: 1rem;
            }

            .profile-section-header {
                padding: 0.9rem 1rem;
            }

            .section-title {
                font-size: 0.9rem;
            }

            .emprunt-card-img {
                height: 160px;
            }

            .biblio-card-img {
                height: 180px;
            }
        }

        @media (max-width: 575px) {
            .section-link {
                display: none;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chevron rotation for collapsible sections
            document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(btn) {
                var targetSelector = btn.getAttribute('data-bs-target');
                if (!targetSelector) return;
                var target = document.querySelector(targetSelector);
                var icon = btn.querySelector('.section-chevron') || btn.querySelector('.fa-chevron-up');
                if (!target || !icon) return;

                new bootstrap.Collapse(target, { toggle: false });

                icon.style.transition = 'transform 200ms ease';
                icon.style.transform = target.classList.contains('show') ? 'rotate(0deg)' : 'rotate(180deg)';

                target.addEventListener('show.bs.collapse', function() {
                    icon.style.transform = 'rotate(0deg)';
                });
                target.addEventListener('hide.bs.collapse', function() {
                    icon.style.transform = 'rotate(180deg)';
                });
            });

            // Avatar upload
            var avatarInput = document.getElementById('avatarInput');
            var avatarForm = document.getElementById('avatarForm');
            var avatarPreview = document.getElementById('avatarPreview');

            if (avatarInput) {
                avatarInput.addEventListener('change', function() {
                    var file = this.files[0];
                    if (!file) return;
                    var reader = new FileReader();
                    reader.onload = function(evt) {
                        if (avatarPreview) avatarPreview.src = evt.target.result;
                    };
                    reader.readAsDataURL(file);
                    if (avatarForm) avatarForm.submit();
                });
            }

            // Reopen edit modal if validation errors
            @if($errors->any())
                new bootstrap.Modal(document.getElementById('editProfileModal')).show();
            @endif

            // Password fields conditional requirement
            var currentPassword = document.getElementById('current_password');
            var newPassword = document.getElementById('new_password');
            var newPasswordConfirmation = document.getElementById('new_password_confirmation');

            if (currentPassword && newPassword && newPasswordConfirmation) {
                function updatePasswordRequirements() {
                    var anyFilled = currentPassword.value || newPassword.value || newPasswordConfirmation.value;
                    currentPassword.required = !!anyFilled;
                    newPassword.required = !!anyFilled;
                    newPasswordConfirmation.required = !!anyFilled;
                }
                currentPassword.addEventListener('input', updatePasswordRequirements);
                newPassword.addEventListener('input', updatePasswordRequirements);
                newPasswordConfirmation.addEventListener('input', updatePasswordRequirements);
            }

            // Countdown timers
            function updateCountdowns() {
                var timers = document.querySelectorAll('.countdown-timer');
                var now = new Date();

                timers.forEach(function(timer) {
                    var expiresAt = new Date(timer.getAttribute('data-expires'));
                    var textElement = timer.querySelector('.countdown-text');
                    var diff = expiresAt - now;

                    if (diff <= 0) {
                        textElement.textContent = 'Expiré';
                        timer.classList.add('timer-danger');
                        if (!sessionStorage.getItem('countdown_reload_' + timer.getAttribute('data-expires'))) {
                            sessionStorage.setItem('countdown_reload_' + timer.getAttribute('data-expires'), 'true');
                            setTimeout(function() { location.reload(); }, 2000);
                        }
                    } else {
                        var hours = Math.floor(diff / (1000 * 60 * 60));
                        var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((diff % (1000 * 60)) / 1000);
                        textElement.textContent = hours + 'h ' + minutes + 'm ' + seconds + 's';

                        if (hours < 1) {
                            timer.classList.add('timer-danger');
                        } else if (hours < 2) {
                            timer.classList.add('timer-warning');
                        }
                    }
                });
            }

            updateCountdowns();
            setInterval(updateCountdowns, 1000);
        });
    </script>
@endpush
