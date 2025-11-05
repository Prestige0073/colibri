<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Colibri Littéraire')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        .table-transition {
            transition: background-color 0.3s, color 0.3s;
        }
        body {
            background: #eaf1fb;
        }
        .admin-sidebar {
            background: linear-gradient(135deg, #1565c0 80%, #1976d2 100%);
            box-shadow: 2px 0 16px 0 rgba(21,101,192,0.10);
        }
        .admin-sidebar .nav-link {
            border-radius: 0.5rem;
            margin: 0.2rem 0.5rem;
            font-weight: 500;
            color: #e3f0ff !important;
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        }
        .admin-sidebar .nav-link.active, .admin-sidebar .nav-link:hover {
            background: #2196f3;
            color: #fff !important;
            box-shadow: 0 2px 8px 0 rgba(33,150,243,0.13);
        }
        .admin-sidebar .nav-link i {
            opacity: 0.85;
        }
        .admin-navbar {
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 12px 0 rgba(33,150,243,0.10);
            background: linear-gradient(90deg, #1976d2 60%, #42a5f5 100%) !important;
        }
        .admin-navbar .navbar-brand {
            color: #fff !important;
            letter-spacing: 1px;
            text-shadow: 0 2px 8px rgba(33,150,243,0.10);
        }
        .admin-navbar .btn-outline-primary {
            border-color: #fff;
            color: #fff;
        }
        .admin-navbar .btn-outline-primary:hover {
            background: #fff;
            color: #1976d2;
        }
        .admin-content {
            border-radius: 0.75rem;
            background: #fff;
            box-shadow: 0 2px 16px 0 rgba(33,150,243,0.10);
            min-height: 70vh;
        }
        .admin-footer {
            border-top: 1px solid #bbdefb;
            margin-top: 2rem;
            color: #1976d2;
        }
        h1, h2, h3, h4, h5, h6 {
            color: #1976d2;
            font-weight: 700;
        }
        @media (max-width: 991.98px) {
            .admin-navbar {
                border-radius: 0;
                margin-top: 0;
            }
            .admin-content {
                border-radius: 0.5rem;
            }
        }
    </style>
</head>

<body id="adminBody">
    <div class="container-fluid" id="adminContainer">
        <div class="row">
            <!-- Sidebar Offcanvas pour mobile -->
            <div class="offcanvas offcanvas-start text-white" tabindex="-1" id="sidebarOffcanvas" style="background-color: #1976d2;" aria-labelledby="sidebarOffcanvasLabel">
                <div class="offcanvas-header border-bottom" id="sidebarHeader">
                    <h5 class="offcanvas-title fw-bold text-bg-light" id="sidebarOffcanvasLabel"><i class="fa fa-feather-alt me-2"></i>Admin</h5>
                    <button type="button" class="btn-close btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Fermer"></button>
                </div>
                <div class="offcanvas-body p-0 admin-sidebar">
                    <ul class="nav flex-column mt-2">
                        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link text-white{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a></li>
                        <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link text-white{{ request()->routeIs('admin.users.index') ? ' active' : '' }}"><i class="fa fa-users me-2"></i>Utilisateurs</a></li>
                        <li class="nav-item"><a href="{{ route('admin.catalogue.index') }}" class="nav-link text-white{{ request()->routeIs('admin.catalogue.index') ? ' active' : '' }}"><i class="fa fa-book me-2"></i>Catalogue</a></li>
                        <li class="nav-item"><a href="{{ route('admin.emprunts.index') }}" class="nav-link text-white{{ request()->routeIs('admin.emprunts.index') ? ' active' : '' }}"><i class="fa fa-book me-2"></i>Emprunts</a></li>
                        <li class="nav-item">
                            <a href="{{ route('admin.commandes.index') }}" class="nav-link text-white{{ request()->routeIs('admin.commandes.*') ? ' active' : '' }}">
                                <i class="fa fa-truck me-2"></i>Commandes
                                @php $pendingCount = \App\Models\Commande::where('statut','pending')->count(); @endphp
                                @if($pendingCount > 0)
                                    <span class="badge bg-danger ms-2">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item"><a href="{{ route('admin.modules.index') }}" class="nav-link text-white{{ request()->routeIs('admin.modules.index') ? ' active' : '' }}"><i class="fa fa-graduation-cap me-2"></i>Modules</a></li>
                        <li class="nav-item"><a href="{{ route('admin.quiz.index') }}" class="nav-link text-white{{ request()->routeIs('admin.quiz.index') ? ' active' : '' }}"><i class="fa fa-question-circle me-2"></i>Quiz</a></li>
                        <li class="nav-item"><a href="{{ route('admin.certifications.index') }}" class="nav-link text-white{{ request()->routeIs('admin.certifications.index') ? ' active' : '' }}"><i class="fa fa-award me-2"></i>Certifications</a></li>
                        <li class="nav-item"><a href="{{ route('admin.achats.index') }}" class="nav-link text-white{{ request()->routeIs('admin.achats.index') ? ' active' : '' }}"><i class="fa fa-shopping-bag me-2"></i>Achats/Emprunts</a></li>
                        <li class="nav-item"><a href="{{ route('admin.contacts.index') }}" class="nav-link text-white{{ request()->routeIs('admin.contacts.index') ? ' active' : '' }}"><i class="fa fa-envelope me-2"></i>Contacts</a></li>
                        <li class="nav-item"><a href="{{ route('admin.team.index') }}" class="nav-link text-white{{ request()->routeIs('admin.team.index') ? ' active' : '' }}"><i class="fa fa-users-cog me-2"></i>Équipe</a></li>
                        <li class="nav-item"><a href="{{ route('admin.testimonials.index') }}" class="nav-link text-white{{ request()->routeIs('admin.testimonials.index') ? ' active' : '' }}"><i class="fa fa-comment-dots me-2"></i>Témoignages</a></li>
                        <li class="nav-item"><a href="{{ route('admin.events.index') }}" class="nav-link text-white{{ request()->routeIs('admin.events.index') ? ' active' : '' }}"><i class="fa fa-calendar-alt me-2"></i>Événements</a></li>
                        <li class="nav-item"><a href="{{ route('admin.donations.index') }}" class="nav-link text-white{{ request()->routeIs('admin.donations.index') ? ' active' : '' }}"><i class="fa fa-hand-holding-heart me-2"></i>Dons</a></li>
                    </ul>
                </div>
            </div>
            <!-- Sidebar visible sur desktop -->
            <nav class="col-md-3 col-lg-2 d-none d-md-block sidebar p-0 min-vh-100" style="background-color: #1976d2;">
                <div class="position-sticky pt-3 admin-sidebar" id="sidebarDesktop">
                    <ul class="nav flex-column mt-2 mb-4">
                        <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link text-white{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}"><i class="fa fa-tachometer-alt me-2"></i>Dashboard</a></li>
                        <li class="nav-item"><a href="{{ route('admin.users.index') }}" class="nav-link text-white{{ request()->routeIs('admin.users.index') ? ' active' : '' }}"><i class="fa fa-users me-2"></i>Utilisateurs</a></li>
                        <li class="nav-item"><a href="{{ route('admin.catalogue.index') }}" class="nav-link text-white{{ request()->routeIs('admin.catalogue.index') ? ' active' : '' }}"><i class="fa fa-book me-2"></i>Catalogue</a></li>
                        <li class="nav-item">
                            <a href="{{ route('admin.commandes.index') }}" class="nav-link text-white{{ request()->routeIs('admin.commandes.*') ? ' active' : '' }}">
                                <i class="fa fa-truck me-2"></i>Commandes
                                @php $pendingCount = \App\Models\Commande::where('statut','pending')->count(); @endphp
                                @if($pendingCount > 0)
                                    <span class="badge bg-danger ms-2">{{ $pendingCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="nav-item"><a href="{{ route('admin.formations.index') }}" class="nav-link text-white{{ request()->routeIs('admin.formations.index') ? ' active' : '' }}"><i class="fa fa-chalkboard-teacher me-2"></i>Formations</a></li>
                        <li class="nav-item"><a href="{{ route('admin.modules.index') }}" class="nav-link text-white{{ request()->routeIs('admin.modules.index') ? ' active' : '' }}"><i class="fa fa-graduation-cap me-2"></i>Modules</a></li>
                        <li class="nav-item"><a href="{{ route('admin.quiz.index') }}" class="nav-link text-white{{ request()->routeIs('admin.quiz.index') ? ' active' : '' }}"><i class="fa fa-question-circle me-2"></i>Quiz</a></li>
                        <li class="nav-item"><a href="{{ route('admin.certifications.index') }}" class="nav-link text-white{{ request()->routeIs('admin.certifications.index') ? ' active' : '' }}"><i class="fa fa-award me-2"></i>Certifications</a></li>
                        <li class="nav-item"><a href="{{ route('admin.achats.index') }}" class="nav-link text-white{{ request()->routeIs('admin.achats.index') ? ' active' : '' }}"><i class="fa fa-shopping-bag me-2"></i>Achats/Emprunts</a></li>
                        <li class="nav-item"><a href="{{ route('admin.contacts.index') }}" class="nav-link text-white{{ request()->routeIs('admin.contacts.index') ? ' active' : '' }}"><i class="fa fa-envelope me-2"></i>Contacts</a></li>
                        <li class="nav-item"><a href="{{ route('admin.team.index') }}" class="nav-link text-white{{ request()->routeIs('admin.team.index') ? ' active' : '' }}"><i class="fa fa-users-cog me-2"></i>Équipe</a></li>
                        <li class="nav-item"><a href="{{ route('admin.testimonials.index') }}" class="nav-link text-white{{ request()->routeIs('admin.testimonials.index') ? ' active' : '' }}"><i class="fa fa-comment-dots me-2"></i>Témoignages</a></li>
                        <li class="nav-item"><a href="{{ route('admin.events.index') }}" class="nav-link text-white{{ request()->routeIs('admin.events.index') ? ' active' : '' }}"><i class="fa fa-calendar-alt me-2"></i>Événements</a></li>
                        <li class="nav-item"><a href="{{ route('admin.donations.index') }}" class="nav-link text-white{{ request()->routeIs('admin.donations.index') ? ' active' : '' }}"><i class="fa fa-hand-holding-heart me-2"></i>Dons</a></li>
                    </ul>
                </div>
            </nav>
            <!-- Main content -->
            <main class="col-12 col-md-9 col-lg-10 ms-sm-auto px-md-4">
                <nav class="navbar navbar-expand navbar-light bg-white admin-navbar sticky-top py-2 px-3">
                    <button class="btn btn-outline-secondary d-md-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas" aria-controls="sidebarOffcanvas" aria-label="Ouvrir le menu">
                        <i class="fa fa-bars"></i>
                    </button>
                    <span class="navbar-brand mx-auto fw-bold text-center flex-grow-1">@yield('title', 'Espace Administration')</span>
                    <button class="btn btn-outline-primary ms-auto rounded-circle shadow-sm" id="themeToggle" title="Changer de mode" type="button" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa fa-user-cog"></i>
                    </button>
                </nav>
                <!-- Toast de notification -->
                <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 1.5rem; right: 1.5rem; min-width: 320px; z-index: 1080; pointer-events: none;">
                    @if(session('success'))
                        <div id="toast-success" class="toast align-items-center text-bg-success border-0 shadow-lg show animate__animated animate__slideInDown" role="alert" aria-live="assertive" aria-atomic="true" style="pointer-events:auto; background:linear-gradient(90deg,#e3ffe6 60%,#b2f7c1 100%); color:#1976d2; font-weight:500;">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                                </div>
                                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
                            </div>
                        </div>
                    @endif
                    @if(session('error'))
                        <div id="toast-error" class="toast align-items-center text-bg-danger border-0 shadow-lg show animate__animated animate__slideInDown" role="alert" aria-live="assertive" aria-atomic="true" style="pointer-events:auto; background:linear-gradient(90deg,#ffe3e3 60%,#f7b2b2 100%); color:#b71c1c; font-weight:500;">
                            <div class="d-flex">
                                <div class="toast-body">
                                    <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
                                </div>
                                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="admin-content py-4" id="adminContent">
                    @yield('content')
                </div>
                <footer class="admin-footer text-center py-3 small text-muted">
                    &copy; {{ date('Y') }} <span class="fw-bold text-primary">Colibri Littéraire</span> — Administration
                </footer>
            </main>
        </div>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script>
        // Animation d’apparition du contenu (fadeIn)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.admin-content').style.opacity = 1;
            // Toast auto-dismiss
            var toastSuccess = document.getElementById('toast-success');
            var toastError = document.getElementById('toast-error');
            if (toastSuccess) {
                setTimeout(function() {
                    toastSuccess.classList.remove('animate__slideInDown');
                    toastSuccess.classList.add('animate__slideOutUp');
                    setTimeout(function() { toastSuccess.remove(); }, 1000);
                }, 5000);
            }
            if (toastError) {
                setTimeout(function() {
                    toastError.classList.remove('animate__slideInDown');
                    toastError.classList.add('animate__slideOutUp');
                    setTimeout(function() { toastError.remove(); }, 1000);
                }, 5000);
            }
        });
        // Plus de JS custom pour la sidebar : tout est géré par Bootstrap Collapse
    </script>
    @stack('scripts')
</body>
</body>
</html>
