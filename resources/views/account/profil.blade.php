@extends('layouts.app')

@section('title', 'Profil utilisateur')
@section('meta_description',
    'Gérez votre profil, vos informations personnelles et suivez votre activité sur Colibri
    Littéraire.')

@section('content')
    @php
        $cartItems = Auth::user()->cartItems()->with('catalogue')->get();
        $cartCount = $cartItems->sum('quantite');
        $recentPurchases = Auth::user()->cartItems()->with('catalogue')->orderByDesc('created_at')->take(5)->get();
        $emprunts = Auth::user()->emprunts()->with('livre')->get();
    @endphp
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="card border-0 rounded-4 shadow-lg p-4 profile-card">
                <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                    <div class="text-center flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=007bff&color=fff&size=180"
                            alt="Avatar" class="rounded-circle shadow mb-3 profile-avatar">
                        <h4 class="fw-bold text-success mb-1">{{ Auth::user()->name }}</h4>

                        <div class="mt-2 d-flex align-items-center gap-2">
                            <a href="#" class="btn btn-outline-success btn-sm rounded-pill profile-btn" aria-label="Modifier le profil">
                                <i class="fa fa-edit me-1" aria-hidden="true"></i>
                                <span class="d-none d-sm-inline">Modifier le profil</span>
                            </a>
                            <a href="{{ route('account.commandes') }}" class="btn btn-outline-success btn-sm rounded-pill d-flex align-items-center gap-2 position-relative" style="padding-right:2.2rem;" aria-label="Suivre mes commandes">
                                <i class="fa fa-truck me-1" aria-hidden="true"></i>
                                <span class="d-none d-sm-inline">Suivre mes commandes</span>
                                <span class="position-absolute top-0 end-0 translate-middle badge rounded-circle bg-danger text-white"
                                      style="width:1.5rem;height:1.5rem;display:inline-flex;align-items:center;justify-content:center;font-size:.75rem;border:2px solid #fff;">{{ $commandesEnLivraison->count() ?? 0 }}</span>
                            </a>
                            <button type="button" class="btn btn-outline-danger btn-sm rounded-pill ms-2" data-bs-toggle="modal" data-bs-target="#logoutModal" aria-label="Se déconnecter">
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
                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#recentActivity" aria-expanded="true" aria-controls="recentActivity">
                                <i class="fa fa-chevron-up"></i>
                            </button>
                        </div>
                        <div class="collapse show" id="recentActivity">
                            <ul class="list-group mb-3">
                                @forelse($recentPurchases as $item)
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fa fa-shopping-cart text-success me-2"></i>
                                        Achat du livre <span class="fw-bold ms-1">{{ $item->catalogue->titre }}</span> le
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
            <div class="row g-3 mb-4 shadow p-4 rounded-4 profile-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0 text-secondary"><i class="fa fa-graduation-cap me-2"></i>Modules suivis</h5>
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#modulesSuivis" aria-expanded="true" aria-controls="modulesSuivis">
                        <i class="fa fa-chevron-up modules-chevron"></i>
                    </button>
                </div>
                <div class="collapse show" id="modulesSuivis">
                    <div class="row">
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-success mb-2"><i class="fa fa-book me-1"></i> Introduction à
                                        l’édition</h6>
                                    <p class="card-text mb-2">Découverte du métier d’éditeur et du processus de publication.</p>
                                    <span class="badge bg-success mb-2">En cours</span>
                                    <a href="#" class="btn btn-outline-success btn-sm rounded-pill">Voir le module</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h6 class="card-title text-success mb-2"><i class="fa fa-pencil-alt me-1"></i> Techniques de
                                        rédaction</h6>
                                    <p class="card-text mb-2">Apprendre à structurer et enrichir ses écrits.</p>
                                    <span class="badge bg-warning text-dark mb-2">À venir</span>
                                    <a href="#" class="btn btn-outline-success btn-sm rounded-pill">Voir le module</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-2">
            <div class="row g-3 mb-4 shadow p-4 rounded-4 profile-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0 text-secondary"><i class="fa fa-award me-2"></i>Certifications obtenues</h5>
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#certifications" aria-expanded="true" aria-controls="certifications">
                        <i class="fa fa-chevron-up certs-chevron"></i>
                    </button>
                </div>
                <div class="collapse show" id="certifications">
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="card-title text-success mb-2"><i class="fa fa-certificate me-1"></i> Certification
                                    Colibri Littéraire</h6>
                                <p class="card-text mb-2">Attestation officielle de vos compétences dans les métiers du livre
                                    africain.</p>
                                <span class="badge bg-info text-dark mb-2">Obtenue le 15/09/2025</span>
                                <a href="#" class="btn btn-outline-info btn-sm rounded-pill">Voir la certification</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-2">
            <div class="row g-3 mb-4 shadow p-4 rounded-4 profile-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0 text-secondary"><i class="fa fa-book-reader me-2"></i>Mes emprunts</h5>
                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#emprunts" aria-expanded="true" aria-controls="emprunts">
                        <i class="fa fa-chevron-up purchases-chevron"></i>
                    </button>
                </div>
                <div class="collapse show" id="emprunts">
                    <div class="table-responsive">
                        <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Livre</th>
                                <th>Date d'emprunt</th>
                                <th>Date de retour</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emprunts as $emprunt)
                                <tr>
                                    <td><strong>{{ $emprunt->livre ? $emprunt->livre->titre : 'Livre inconnu' }}</strong>
                                    </td>
                                    <td>{{ $emprunt->date_emprunt ? \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') : 'date inconnue' }}
                                    </td>
                                    <td>{{ $emprunt->date_retour ? \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') : 'Non rendu' }}
                                    </td>
                                        <td>
                                            @php
                                                $statusLabel = $emprunt->date_retour ? 'Livré' : 'En cours';
                                                if (!$emprunt->date_retour && $emprunt->date_emprunt) {
                                                    $statusLabel = 'En préparation';
                                                }
                                            @endphp
                                            <span class="badge {{ $emprunt->date_retour ? 'bg-success' : 'bg-warning text-dark' }}">{{ $statusLabel }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Aucun emprunt enregistré.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                        </table>
                    </div>
                </div>
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
                    <button type="button" class="btn btn-secondary rounded-pill"
                        data-bs-dismiss="modal">Annuler</button>
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                        <button type="button" class="btn btn-danger rounded-pill"
                            onclick="document.getElementById('logoutForm').submit();">Se déconnecter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
            }
        </style>
    @endpush
    @push('styles')
        <style>
            /* Smooth fade/translate for collapse content */
            .collapse:not(.show) {
                display: block;
                height: 0;
                overflow: hidden;
                opacity: 0;
                transform: translateY(-6px);
                transition: height .35s ease, opacity .35s ease, transform .35s ease;
            }
            .collapse.show {
                opacity: 1;
                transform: translateY(0);
            }
            /* Ensure chevrons have transition */
            .modules-chevron, .certs-chevron, .purchases-chevron { transition: transform .25s ease; }
        </style>
    @endpush
@endsection

@push('scripts')
    <script>
        // Rotate chevrons on collapse show/hide for modules and recent activity
        document.addEventListener('DOMContentLoaded', function () {
            var toggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
            toggles.forEach(function (btn) {
                var targetSelector = btn.getAttribute('data-bs-target');
                if (!targetSelector) return;
                var target = document.querySelector(targetSelector);
                var icon = btn.querySelector('i');
                if (!target || !icon) return;

                var bsCollapse = new bootstrap.Collapse(target, { toggle: false });

                // set initial rotation based on state
                if (target.classList.contains('show')) {
                    icon.style.transform = 'rotate(0deg)';
                    icon.style.transition = 'transform 200ms';
                } else {
                    icon.style.transform = 'rotate(180deg)';
                    icon.style.transition = 'transform 200ms';
                }

                target.addEventListener('show.bs.collapse', function () {
                    icon.style.transform = 'rotate(0deg)';
                });
                target.addEventListener('hide.bs.collapse', function () {
                    icon.style.transform = 'rotate(180deg)';
                });

                // Optional: toggle collapse on button click (Bootstrap handles it) but ensure icon toggles when keyboard used
                btn.addEventListener('click', function () {
                    // nothing extra needed; events above handle rotation
                });
            });
        });
    </script>
@endpush
