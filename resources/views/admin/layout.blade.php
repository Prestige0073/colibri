<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - Colibri Littéraire</title>

    <!-- Google Fonts - Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- Admin Modern CSS -->
    <link href="{{ asset('css/admin-modern.css') }}" rel="stylesheet">

    @stack('styles')
</head>

<body class="admin-body">
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="admin-sidebar-wrapper" id="adminSidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <div class="sidebar-brand-logo">
                <img src="{{ asset('img/LOGO-COLIBRI-LITTERAIRE.png') }}" alt="Logo">
            </div>
            <div class="sidebar-brand-text">
                <h2 class="sidebar-brand-title">Colibri</h2>
                <p class="sidebar-brand-subtitle">Administration</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="sidebar-nav">
            <!-- Main Section -->
            <div class="sidebar-section">
                <p class="sidebar-section-title">Principal</p>
                <ul class="sidebar-menu">
                    @if(App\Services\PermissionService::canAccessModule('dashboard'))
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-th-large"></i>
                            <span>Tableau de bord</span>
                        </a>
                    </li>
                    @endif

                    @if(App\Services\PermissionService::canAccessModule('users'))
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.users.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i>
                            <span>Utilisateurs</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>

            <!-- Catalogue Section -->
            @if(App\Services\PermissionService::canAccessModule('catalogue') || App\Services\PermissionService::canAccessModule('emprunts') || App\Services\PermissionService::canAccessModule('commandes'))
            <div class="sidebar-section">
                <p class="sidebar-section-title">Catalogue & Ventes</p>
                <ul class="sidebar-menu">
                    @if(App\Services\PermissionService::canAccessModule('catalogue'))
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.catalogue.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.catalogue.*') ? 'active' : '' }}">
                            <i class="fas fa-book"></i>
                            <span>Catalogue</span>
                        </a>
                    </li>
                    @endif

                    @if(App\Services\PermissionService::canAccessModule('emprunts'))
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.emprunts.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.emprunts.*') ? 'active' : '' }}">
                            <i class="fas fa-book-reader"></i>
                            <span>Emprunts</span>
                        </a>
                    </li>
                    @endif

                    @if(App\Services\PermissionService::canAccessModule('commandes'))
                    <li class="sidebar-menu-item">
                        @php
                            $pendingCount = 0;
                            if (Schema::hasTable('commandes') && class_exists(\App\Models\Commande::class)) {
                                $pendingCount = \App\Models\Commande::where('statut','pending')->count();
                            }
                        @endphp
                        <a href="{{ route('admin.commandes.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.commandes.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Commandes</span>
                            @if($pendingCount > 0)
                                <span class="sidebar-badge sidebar-badge-danger">{{ $pendingCount }}</span>
                            @endif
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif

            <!-- E-Learning Section -->
            @if(App\Services\PermissionService::canAccessModule('formations') || App\Services\PermissionService::canAccessModule('modules') || App\Services\PermissionService::canAccessModule('quizzes') || App\Services\PermissionService::canAccessModule('certifications'))
            <div class="sidebar-section">
                <p class="sidebar-section-title">E-Learning</p>
                <ul class="sidebar-menu">
                    @if(App\Services\PermissionService::canAccessModule('formations'))
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.formations.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.formations.*') ? 'active' : '' }}">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Formations</span>
                        </a>
                    </li>
                    @endif

                    @if(App\Services\PermissionService::canAccessModule('modules'))
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.modules.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.modules.*') ? 'active' : '' }}">
                            <i class="fas fa-cubes"></i>
                            <span>Modules</span>
                        </a>
                    </li>
                    @endif

                    @if(App\Services\PermissionService::canAccessModule('quizzes'))
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.quizzes.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.quizzes.*') ? 'active' : '' }}">
                            <i class="fas fa-question-circle"></i>
                            <span>Quiz</span>
                        </a>
                    </li>
                    @endif

                    @if(App\Services\PermissionService::canAccessModule('certifications'))
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.certifications.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.certifications.*') ? 'active' : '' }}">
                            <i class="fas fa-award"></i>
                            <span>Certifications</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif

            <!-- Communication Section -->
            @if(App\Services\PermissionService::canAccessModule('contacts') || App\Services\PermissionService::canAccessModule('testimonials') || App\Services\PermissionService::canAccessModule('blog'))
            <div class="sidebar-section">
                <p class="sidebar-section-title">Communication</p>
                <ul class="sidebar-menu">
                    @if(App\Services\PermissionService::canAccessModule('contacts'))
                    <li class="sidebar-menu-item">
                        @php
                            $unreadContactsCount = \App\Models\Contact::unread()->count();
                        @endphp
                        <a href="{{ route('admin.contacts.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                            <i class="fas fa-envelope"></i>
                            <span>Messages</span>
                            @if($unreadContactsCount > 0)
                                <span class="sidebar-badge sidebar-badge-danger">{{ $unreadContactsCount }}</span>
                            @endif
                        </a>
                    </li>
                    @endif

                    @if(App\Services\PermissionService::canAccessModule('testimonials'))
                    <li class="sidebar-menu-item">
                        @php
                            $pendingTestimonialsCount = \App\Models\Testimonial::pending()->count();
                        @endphp
                        <a href="{{ route('admin.testimonials.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                            <i class="fas fa-comment-dots"></i>
                            <span>Témoignages</span>
                            @if($pendingTestimonialsCount > 0)
                                <span class="sidebar-badge sidebar-badge-warning">{{ $pendingTestimonialsCount }}</span>
                            @endif
                        </a>
                    </li>
                    @endif

                    @if(App\Services\PermissionService::canAccessModule('blog'))
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.blog.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.blog.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper"></i>
                            <span>Blog</span>
                        </a>
                    </li>
                    @endif

                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.donations.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                            <i class="fas fa-hand-holding-heart"></i>
                            <span>Dons</span>
                        </a>
                    </li>
                </ul>
            </div>
            @endif

            <!-- Gestion Section -->
            @if(App\Services\PermissionService::canAccessModule('team') || Auth::guard('admin')->user()->isSuperAdmin() || App\Services\PermissionService::canAccessModule('security'))
            <div class="sidebar-section">
                <p class="sidebar-section-title">Gestion</p>
                <ul class="sidebar-menu">
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.banners.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                            <i class="fas fa-images"></i>
                            <span>Bannières</span>
                        </a>
                    </li>

                    @if(App\Services\PermissionService::canAccessModule('team'))
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.team.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
                            <i class="fas fa-users-cog"></i>
                            <span>Équipe</span>
                        </a>
                    </li>
                    @endif

                    @if(Auth::guard('admin')->user()->isSuperAdmin())
                    <li class="sidebar-menu-item">
                        <a href="{{ route('admin.admins.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                            <i class="fas fa-user-shield"></i>
                            <span>Administrateurs</span>
                        </a>
                    </li>
                    @endif

                    @if(App\Services\PermissionService::canAccessModule('security'))
                    <li class="sidebar-menu-item">
                        @php
                            $blockedUsersCount = \App\Models\User::where('blocked', true)->count();
                        @endphp
                        <a href="{{ route('admin.security.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.security.*') ? 'active' : '' }}">
                            <i class="fas fa-shield-alt"></i>
                            <span>Sécurité</span>
                            @if($blockedUsersCount > 0)
                                <span class="sidebar-badge sidebar-badge-danger">{{ $blockedUsersCount }}</span>
                            @endif
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif
        </nav>

        <!-- User Footer -->
        <div class="sidebar-footer">
            <div class="sidebar-user" data-bs-toggle="dropdown">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <p class="sidebar-user-name">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</p>
                    <p class="sidebar-user-role">
                        @if(Auth::guard('admin')->user()->is_super_admin)
                            Super Admin
                        @else
                            Administrateur
                        @endif
                    </p>
                </div>
                <i class="fas fa-chevron-down text-muted" style="font-size: 0.75rem;"></i>
            </div>
            <ul class="dropdown-menu dropdown-menu-dark w-100 mt-2">
                <li>
                    <a class="dropdown-item" href="{{ route('index') }}" target="_blank">
                        <i class="fas fa-external-link-alt me-2"></i>Voir le site
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="fas fa-sign-out-alt me-2"></i>Déconnexion
                    </button>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Navbar -->
        <header class="admin-topbar">
            <div class="topbar-left">
                <button class="topbar-toggle" id="sidebarToggle" type="button" aria-label="Toggle sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="topbar-title">
                    <h1>@yield('title', 'Tableau de bord')</h1>
                    <p>@yield('subtitle', 'Bienvenue sur votre espace administration')</p>
                </div>
            </div>

            <div class="topbar-right">
                <!-- Search -->
                <div class="topbar-search-wrapper">
                    <div class="topbar-search">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Rechercher..." id="globalSearch" autocomplete="off">
                    </div>
                    <div class="search-results-dropdown" id="searchResultsDropdown">
                        <div class="search-results-content" id="searchResultsContent">
                            <!-- Results will be loaded here -->
                        </div>
                    </div>
                </div>

                <!-- Date -->
                <div class="topbar-date">
                    <i class="fas fa-calendar-alt"></i>
                    <span>{{ now()->locale('fr')->isoFormat('D MMM YYYY') }}</span>
                </div>

                <!-- Notifications -->
                <div class="notifications-wrapper">
                    <button class="topbar-btn" type="button" title="Notifications" id="notificationBtn">
                        <i class="fas fa-bell"></i>
                        @if(($pendingCount ?? 0) + ($unreadContactsCount ?? 0) > 0)
                            <span class="badge">{{ ($pendingCount ?? 0) + ($unreadContactsCount ?? 0) }}</span>
                        @endif
                    </button>
                    <div class="notifications-dropdown" id="notificationsDropdown">
                        <div class="notifications-header">
                            <h6><i class="fas fa-bell me-2"></i>Notifications</h6>
                            <span class="notifications-count">{{ ($pendingCount ?? 0) + ($unreadContactsCount ?? 0) }}</span>
                        </div>
                        <div class="notifications-body">
                            @if(($pendingCount ?? 0) > 0)
                                <a href="{{ route('admin.commandes.index') }}" class="notification-item notification-warning">
                                    <div class="notification-icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text"><strong>{{ $pendingCount }}</strong> commande(s) en attente</p>
                                        <span class="notification-time">Nécessite votre attention</span>
                                    </div>
                                </a>
                            @endif
                            @if(($unreadContactsCount ?? 0) > 0)
                                <a href="{{ route('admin.contacts.index') }}" class="notification-item notification-info">
                                    <div class="notification-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-text"><strong>{{ $unreadContactsCount }}</strong> message(s) non lu(s)</p>
                                        <span class="notification-time">Nouveau contact</span>
                                    </div>
                                </a>
                            @endif
                            @if(($pendingCount ?? 0) + ($unreadContactsCount ?? 0) == 0)
                                <div class="notifications-empty">
                                    <i class="fas fa-check-circle"></i>
                                    <p>Aucune notification</p>
                                </div>
                            @endif
                        </div>
                        <div class="notifications-footer">
                            <a href="{{ route('admin.dashboard') }}">Voir tout</a>
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <a href="{{ route('index') }}" class="topbar-btn" title="Voir le site" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </header>

        <!-- Toast Notifications -->
        <div class="toast-container" id="toastContainer">
            @if(session('success'))
                <div class="admin-toast admin-toast-success animate__animated animate__fadeInRight" role="alert">
                    <div class="admin-toast-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="admin-toast-content">
                        <div class="admin-toast-title">Succès</div>
                        <div class="admin-toast-message">{{ session('success') }}</div>
                    </div>
                    <button class="admin-toast-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="admin-toast admin-toast-error animate__animated animate__fadeInRight" role="alert">
                    <div class="admin-toast-icon">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="admin-toast-content">
                        <div class="admin-toast-title">Erreur</div>
                        <div class="admin-toast-message">{{ session('error') }}</div>
                    </div>
                    <button class="admin-toast-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            @if(session('warning'))
                <div class="admin-toast admin-toast-warning animate__animated animate__fadeInRight" role="alert">
                    <div class="admin-toast-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="admin-toast-content">
                        <div class="admin-toast-title">Attention</div>
                        <div class="admin-toast-message">{{ session('warning') }}</div>
                    </div>
                    <button class="admin-toast-close" onclick="this.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif
        </div>

        <!-- Content Wrapper -->
        <div class="admin-content-wrapper">
            <div class="admin-content animate-slideUp">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="admin-footer">
            <span>&copy; {{ date('Y') }} <a href="{{ route('index') }}">Colibri Littéraire</a> — Panneau d'Administration</span>
        </footer>
    </div>

    <!-- Permission Denied Modal -->
    @if(session('permission_denied'))
    <div class="modal fade show" id="permissionDeniedModal" tabindex="-1" aria-labelledby="permissionDeniedModalLabel" style="display: block; background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 bg-danger text-white">
                    <h5 class="modal-title" id="permissionDeniedModalLabel">
                        <i class="fas fa-shield-alt me-2"></i>Accès Refusé
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer" onclick="closePermissionModal()"></button>
                </div>
                <div class="modal-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-lock text-danger" style="font-size: 4rem; opacity: 0.8;"></i>
                    </div>
                    <h4 class="mb-3 text-danger">Permission Insuffisante</h4>
                    <p class="text-muted mb-4" style="font-size: 1.1rem;">
                        {{ session('permission_message') }}
                    </p>
                    <div class="alert alert-warning border-0 mx-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <small>
                            Si vous pensez qu'il s'agit d'une erreur, contactez le super administrateur pour modifier vos permissions.
                        </small>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-primary px-5" onclick="closePermissionModal()">
                        <i class="fas fa-check me-2"></i>Compris
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 bg-danger text-white">
                    <h5 class="modal-title" id="logoutModalLabel">
                        <i class="fas fa-sign-out-alt me-2"></i>Confirmation de déconnexion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="fas fa-user-shield text-muted" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mb-2">Êtes-vous sûr de vouloir vous déconnecter ?</h5>
                    <p class="text-muted mb-0">Vous serez redirigé vers la page de connexion.</p>
                </div>
                <div class="modal-footer border-0 justify-content-center gap-2">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Annuler
                    </button>
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger px-4">
                            <i class="fas fa-sign-out-alt me-1"></i>Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Admin JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggle = document.getElementById('sidebarToggle');

            // Toggle sidebar on mobile
            if (toggle) {
                toggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });
            }

            // Close sidebar when clicking overlay
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }

            // Auto-dismiss toasts after 5 seconds
            const toasts = document.querySelectorAll('.admin-toast');
            toasts.forEach(function(toast) {
                setTimeout(function() {
                    toast.classList.remove('animate__fadeInRight');
                    toast.classList.add('animate__fadeOutRight');
                    setTimeout(function() {
                        toast.remove();
                    }, 500);
                }, 5000);
            });

            // Global search functionality
            const globalSearch = document.getElementById('globalSearch');
            const searchDropdown = document.getElementById('searchResultsDropdown');
            const searchContent = document.getElementById('searchResultsContent');
            let searchTimeout = null;

            if (globalSearch && searchDropdown && searchContent) {
                // Search on input
                globalSearch.addEventListener('input', function(e) {
                    const query = this.value.trim();

                    if (searchTimeout) clearTimeout(searchTimeout);

                    if (query.length < 2) {
                        searchDropdown.classList.remove('show');
                        return;
                    }

                    searchTimeout = setTimeout(function() {
                        performSearch(query);
                    }, 300);
                });

                // Search on Enter
                globalSearch.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        const query = this.value.trim();
                        if (query) {
                            window.location.href = '/admin/users?search=' + encodeURIComponent(query);
                        }
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.topbar-search-wrapper')) {
                        searchDropdown.classList.remove('show');
                    }
                });

                function performSearch(query) {
                    searchContent.innerHTML = '<div class="search-loading"><i class="fas fa-spinner fa-spin"></i> Recherche...</div>';
                    searchDropdown.classList.add('show');

                    // Search via AJAX
                    fetch('/admin/search?q=' + encodeURIComponent(query), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.results && data.results.length > 0) {
                            let html = '';
                            data.results.forEach(item => {
                                html += `
                                    <a href="${item.url}" class="search-result-item">
                                        <div class="search-result-icon" style="background: ${item.color || '#1e7a2f'}20; color: ${item.color || '#1e7a2f'}">
                                            <i class="${item.icon || 'fas fa-file'}"></i>
                                        </div>
                                        <div class="search-result-content">
                                            <span class="search-result-title">${item.title}</span>
                                            <span class="search-result-type">${item.type}</span>
                                        </div>
                                    </a>
                                `;
                            });
                            html += `<a href="/admin/users?search=${encodeURIComponent(query)}" class="search-view-all">Voir tous les résultats <i class="fas fa-arrow-right"></i></a>`;
                            searchContent.innerHTML = html;
                        } else {
                            searchContent.innerHTML = `
                                <div class="search-no-results">
                                    <i class="fas fa-search"></i>
                                    <p>Aucun résultat pour "${query}"</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        // Fallback: redirect to search page
                        searchContent.innerHTML = `
                            <a href="/admin/users?search=${encodeURIComponent(query)}" class="search-view-all">
                                Rechercher "${query}" <i class="fas fa-arrow-right"></i>
                            </a>
                        `;
                    });
                }
            }

            // Notifications dropdown
            const notificationBtn = document.getElementById('notificationBtn');
            const notificationsDropdown = document.getElementById('notificationsDropdown');

            if (notificationBtn && notificationsDropdown) {
                notificationBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationsDropdown.classList.toggle('show');
                    // Close search if open
                    if (searchDropdown) searchDropdown.classList.remove('show');
                });

                // Close when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.notifications-wrapper')) {
                        notificationsDropdown.classList.remove('show');
                    }
                });
            }

            // Active menu item scroll into view
            const activeItem = document.querySelector('.sidebar-menu-link.active');
            if (activeItem) {
                activeItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            // Afficher automatiquement le modal de permission refusée
            @if(session('permission_denied'))
                const permissionModal = document.getElementById('permissionDeniedModal');
                if (permissionModal) {
                    permissionModal.classList.add('show');
                    document.body.classList.add('modal-open');
                }
            @endif
        });

        // Fonction pour fermer le modal de permission
        function closePermissionModal() {
            const modal = document.getElementById('permissionDeniedModal');
            if (modal) {
                modal.classList.remove('show');
                modal.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
