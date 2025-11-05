<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Colibri Littéraire - Plateforme du livre africain, formations et catalogue')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Colibri Littéraire : plateforme dédiée à la formation, à la promotion et à la diffusion du livre africain. Découvrez nos formations, notre catalogue et rejoignez la communauté littéraire africaine.')">
    <meta name="keywords" content="@yield('meta_keywords', 'livre africain, formation, édition, catalogue, Bénin, francophonie, Colibri Littéraire, culture, lecture, formation métiers du livre')">
    <meta name="author" content="Colibri Littéraire">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="@yield('title', 'Colibri Littéraire - Plateforme du livre africain')">
    <meta property="og:description" content="@yield('meta_description', 'Plateforme dédiée à la formation et à la promotion du livre africain.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('img/about.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'Colibri Littéraire')">
    <meta name="twitter:description" content="@yield('meta_description', 'Plateforme dédiée à la formation et à la promotion du livre africain.')">
    <meta name="twitter:image" content="{{ asset('img/about.jpg') }}">
    @yield('seo')

    <!-- CSRF token for AJAX -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@600;700&family=Open+Sans&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        /* Toast container responsive rules */
        .toast-container-custom{
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 1080;
            pointer-events: none;
            width: auto;
            max-width: calc(100% - 3rem);
            padding: 0 0.25rem;
        }
        .toast-container-custom .toast{
            pointer-events: auto;
            width: auto;
            max-width: 480px;
        }
        @media (max-width: 576px){
            .toast-container-custom{
                left: 50%;
                right: auto;
                transform: translateX(-50%);
                top: 1rem;
                padding: 0 0.5rem;
            }
            .toast-container-custom .toast{
                max-width: 95vw;
            }
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;"></div>
    </div>
    <!-- Spinner End -->

    @php
        // Nombre d'articles dans le panier (utilisé pour le badge du menu burger)
        $cartCount = Auth::check() ? Auth::user()->cartItems->sum('quantite') : 0;
    @endphp

    <!-- Topbar Start -->
    <div class="container-fluid bg-white top-bar wow fadeIn" data-wow-delay="0.1s">
        <div class="row align-items-center h-100">
            <div class="col-12">
                <div class="row align-items-center mt-2">
                    <div class="col-4 text-start d-none d-sm-block topbar-logo">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('img/asso.png') }}" alt="Association écrivains Humanistes"
                                class="img-fluid" style="max-height:60px;">
                        </a>
                    </div>
                    <div class="col-4 text-center d-none d-sm-block topbar-logo">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('img/LOGO-COLIBRI-LITTERAIRE.png') }}" alt="Colibri Littéraire" class="img-fluid"
                                style="max-height:60px;">
                        </a>
                    </div>
                    <div class="col-4 text-end d-none d-sm-block topbar-logo">
                        <a href="{{ route('index') }}">
                            <img src="{{ asset('img/Logo_OIF.png') }}" alt="OIF" class="img-fluid"
                                style="max-height:60px;">
                        </a>
                    </div>

                    <!-- Mobile view: keep logos side-by-side (flex row, no wrap) -->
                    <div
                        class="d-flex d-sm-none justify-content-center align-items-center flex-row gap-2 flex-nowrap mt-2 w-100 topbar-logos">
                        <a href="{{ route('index') }}" class="d-inline-block topbar-logo">
                            <img src="{{ asset('img/asso.png') }}" alt="Association écrivains Humanistes" class="img-fluid">
                        </a>
                        <a href="{{ route('index') }}" class="d-inline-block topbar-logo">
                            <img src="{{ asset('img/LOGO-COLIBRI-LITTERAIRE.png') }}" alt="Colibri Littéraire" class="img-fluid">
                        </a>
                        <a href="{{ route('index') }}" class="d-inline-block topbar-logo">
                            <img src="{{ asset('img/Logo_OIF.png') }}" alt="OIF" class="img-fluid">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid bg-white px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="nav-bar">
            <nav class="navbar navbar-expand-lg bg-success navbar-dark px-4 py-lg-0">
                <h4 class="d-lg-none m-0">
                    <a href="{{ route('index') }}" class="text-white text-decoration-none">Menu</a>
                </h4>
                <button type="button" class="navbar-toggler me-0" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse" aria-label="Menu" style="overflow:visible;">
                    <span class="navbar-toggler-icon position-relative">
                        <span class="badge rounded-pill bg-danger position-absolute"
                            style="top:-6px; right:-6px; font-size:0.75rem; min-width:1.1em; z-index:1051;">{{ $cartCount }}</span>
                    </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav me-auto">
                        <a href="{{ route('index') }}"
                            class="nav-item nav-link{{ request()->routeIs('index') ? ' active' : '' }}"><i
                                class="fa fa-home me-1"></i>
                            Accueil</a>
                        <div class="nav-item dropdown">
                            <a href="#"
                                class="nav-link dropdown-toggle{{ request()->routeIs('formation.*') ? ' active' : '' }}"
                                data-bs-toggle="dropdown"><i class="fa fa-graduation-cap me-1"></i> Apprendre</a>
                            <div class="dropdown-menu bg-light m-0">
                                <a href="{{ route('formation.modules') }}"
                                    class="dropdown-item{{ request()->routeIs('formation.modules') ? ' active' : '' }}"><i
                                        class="fa fa-book me-1"></i> Modules de formation</a>
                                <a href="{{ route('formation.quiz') }}"
                                    class="dropdown-item{{ request()->routeIs('formation.quiz') ? ' active' : '' }}"><i
                                        class="fa fa-question-circle me-1"></i> Quiz & évaluations</a>
                                <a href="{{ route('formation.certification') }}"
                                    class="dropdown-item{{ request()->routeIs('formation.certification') ? ' active' : '' }}"><i
                                        class="fa fa-certificate me-1"></i> Certification</a>
                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <a href="#"
                                class="nav-link dropdown-toggle{{ request()->routeIs('catalogue.*') ? ' active' : '' }}"
                                data-bs-toggle="dropdown"><i class="fa fa-book-open me-1"></i> Catalogue</a>
                            <div class="dropdown-menu bg-light m-0">
                                <a href="{{ route('catalogue.decouvrir') }}"
                                    class="dropdown-item{{ request()->routeIs('catalogue.decouvrir') ? ' active' : '' }}"><i
                                        class="fa fa-search me-1"></i> Découvrir les livres</a>
                                <a href="{{ route('catalogue.acheter') }}"
                                    class="dropdown-item{{ request()->routeIs('catalogue.acheter') ? ' active' : '' }}"><i
                                        class="fa fa-shopping-bag me-1"></i> Acheter / Prêter</a>
                            </div>
                        </div>
                        <a href="{{ route('about.index') }}"
                            class="nav-item nav-link{{ request()->routeIs('about.*') ? ' active' : '' }}"><i
                                class="fa fa-info-circle me-1"></i> À propos</a>
                        <a href="{{ route('blog.index') }}"
                            class="nav-item nav-link{{ request()->routeIs('blog.*') ? ' active' : '' }}"><i class="fa fa-blog me-1"></i> Blog</a>
                        <div class="nav-item dropdown">
                            <a href="#"
                                class="nav-link dropdown-toggle{{ request()->routeIs('account.*') || request()->routeIs('login') || request()->routeIs('register') ? ' active' : '' }}"
                                data-bs-toggle="dropdown"><i class="fa fa-user-circle me-1"></i> Mon compte</a>
                            <div class="dropdown-menu bg-light m-0">
                                @auth
                                    <a href="{{ route('account.profil') }}"
                                        class="dropdown-item{{ request()->routeIs('account.profil') ? ' active' : '' }}"><i
                                            class="fa fa-user me-1"></i> Profil utilisateur</a>
                                @endauth
                                @guest
                                    <a href="{{ route('login') }}"
                                        class="dropdown-item{{ request()->routeIs('login') ? ' active' : '' }}"><i
                                            class="fa fa-sign-in-alt me-1"></i> Connexion</a>
                                    <a href="{{ route('register') }}"
                                        class="dropdown-item{{ request()->routeIs('register') ? ' active' : '' }}"><i
                                            class="fa fa-user-plus me-1"></i> Inscription</a>
                                @endguest
                            </div>

                        </div>
                        <a href="{{ route('contact.index') }}"
                            class="nav-item nav-link{{ request()->routeIs('contact.*') ? ' active' : '' }}"><i
                                class="fa fa-envelope me-1"></i> Contact</a>
                    </div>
                    <!-- Panier responsive : affiché une seule fois, badge toujours visible -->
                    <div class="ms-auto align-items-center d-flex">
                        @php
                            $cartItems = Auth::check() ? Auth::user()->cartItems : collect();
                            $cartCount = $cartItems->sum('quantite');
                        @endphp
                        <button type="button" class="btn btn-square btn-dark ms-2 position-relative"
                            data-bs-toggle="modal" data-bs-target="#cartModal" aria-label="Voir le panier"
                            style="font-size: 1.3rem;">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="badge rounded-pill bg-danger position-absolute"
                                style="top:-8px; right:-8px; font-size:0.85rem; min-width:1.3em; z-index:2;">{{ $cartCount }}</span>
                        </button>
                    </div>
                </div>
        </div>
        </nav>
    </div>
    </div>
    <!-- Navbar End -->

    <!-- Ticker Start -->
    <div class="container-fluid ticker-wrap bg-light">
        <div class="container">
            <div class="ticker" role="status" aria-live="polite" aria-atomic="true">
                <div class="ticker__move">
                    <span class="ticker-item">Bienvenue sur Colibri Littéraire</span>
                    <span class="ticker-item">Un projet soutenu par l'OIF dans le cadre du dispositif FORCE</span>
                    <span class="ticker-item">Consultez notre catalogue en ligne</span>
                    <span class="ticker-item">Bénéficiez de nos offres spéciales |</span>
                    <!-- duplicated content to create seamless loop -->
                    <span class="ticker-item">Bienvenue sur Colibri Littéraire</span>
                    <span class="ticker-item">Un projet soutenu par l'OIF dans le cadre du dispositif FORCE</span>
                    <span class="ticker-item">Consultez notre catalogue en ligne</span>
                    <span class="ticker-item">Bénéficiez de nos offres spéciales |</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Ticker End -->

    <!-- Contenu de la page -->
    @yield('content')


    <!-- Footer Start -->
    <div class="container-fluid footer py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-5 py-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Notre bureau</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i> Abomey-Calavi – Cocotomey Tannou – C/SB . Ms Vignon</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+33 7 46 52 61 63</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+229 01 66 54 78 08</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>colibrilitteraire@gmail.com</p>
                    <div class="d-flex pt-3">
                        <a class="btn btn-square btn-success me-2" href="#"><i
                                class="fab fa-x-twitter"></i></a>
                        <a class="btn btn-square btn-success me-2" href="#"><i
                                class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-success me-2" href="#"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-success me-2" href="#"><i
                                class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Liens utiles</h4>
                    <a class="btn btn-link" href="{{ route('about.index') }}">À propos</a>
                    <a class="btn btn-link" href="{{ route('contact.index') }}">Contact</a>
                        <a class="btn btn-link" href="{{ route('blog.index') }}">Blog</a>
                    <a class="btn btn-link" href="#">Conditions d’utilisation</a>
                    <a class="btn btn-link" href="#">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Horaires d’ouverture</h4>
                    <p class="mb-1">Lundi - Vendredi</p>
                    <h6 class="text-light">09h00 - 19h00</h6>
                    <p class="mb-1">Samedi</p>
                    <h6 class="text-light">09h00 - 12h00</h6>
                    <p class="mb-1">Dimanche</p>
                    <h6 class="text-light">Fermé</h6>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-light mb-4">Galerie</h4>
                    <div class="row g-2">
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-1.jpg') }}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-2.jpg') }}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-3.jpg') }}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-4.jpg') }}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-5.jpg') }}" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid w-100" src="{{ asset('img/gallery-6.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright pt-5">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="fw-semi-bold text-white" href="#">Colibri Littéraire</a>, Tous droits réservés.
                        Plateforme portée par l’ONG Ecrivains Humanistes et les Editions Encres Universelles, avec le
                        soutien de l’OIF.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        Créé par l'équipe <a class="fw-semi-bold text-white" href="#">Colibri Littéraire</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    @php
        $cartItems = Auth::check() ? Auth::user()->cartItems()->with('catalogue')->get() : collect();
    @endphp
    <!-- Modal Panier Start -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Votre panier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>Prix</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cartItems as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ asset($item->catalogue->image) }}" alt="Livre"
                                                width="50" class="me-2">
                                            <span>{{ $item->catalogue->titre }}</span>
                                        </td>
                                        <td>{{ $item->quantite }}</td>
                                        <td>{{ $item->catalogue->prix }} FCFA</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmDeleteModal{{ $item->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <!-- Modal de confirmation -->
                                            <div class="modal fade" id="confirmDeleteModal{{ $item->id }}"
                                                tabindex="-1"
                                                aria-labelledby="confirmDeleteLabel{{ $item->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header"
                                                            style="background: #e53935; color: #fff;">
                                                            <h5 class="modal-title"
                                                                id="confirmDeleteLabel{{ $item->id }}">Confirmer
                                                                la suppression</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Fermer"
                                                                style="filter: invert(1);"></button>
                                                        </div>
                                                        <div class="modal-body"
                                                            style="background: #ffebee; color: #b71c1c; font-weight: 500;">
                                                            Voulez-vous vraiment retirer
                                                            <strong>{{ $item->catalogue->titre }}</strong> du panier ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form method="POST"
                                                                action="{{ route('panier.supprimer', $item->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn"
                                                                    style="background: #e53935; color: #fff; font-weight: 600;">Oui,
                                                                    retirer</button>
                                                            </form>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Annuler</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Votre panier est vide.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <h5 class="me-4">Total : <span
                                class="text-success">{{ $cartItems->sum(fn($i) => $i->catalogue->prix * $i->quantite) }}
                                FCFA</span></h5>
                        @if ($cartItems->count() > 0)
                            <form method="POST" action="{{ route('panier.payer') }}">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-shopping-bag me-2"></i>Valider mon panier
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Panier End -->

    <a href="#" class="btn btn-lg btn-success btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('lib/counterup/counterup.min.js') }}"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- Stack for view scripts --}}
    <script>
        // Fix: ensure dismiss buttons actually hide modals even if modals are created dynamically
        document.addEventListener('click', function(e){
            try{
                var btn = e.target.closest('[data-bs-dismiss="modal"]');
                if (!btn) return;
                // find the modal container
                var modalEl = btn.closest('.modal');
                if (modalEl) {
                    var instance = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    instance.hide();
                    return;
                }
                // fallback: if button references a target
                var target = btn.getAttribute('data-bs-target') || btn.getAttribute('data-target');
                if (target) {
                    var sel = document.querySelector(target);
                    if (sel) {
                        var instance2 = bootstrap.Modal.getInstance(sel) || new bootstrap.Modal(sel);
                        instance2.hide();
                    }
                }
            }catch(err){
                // noop
                console.error('Modal dismiss helper error', err);
            }
        });

        // Ensure dynamic modals respond to Escape and backdrop clicks
        document.addEventListener('shown.bs.modal', function(e){
            try{
                var modal = e.target;
                // allow closing with Escape if keyboard option missing
                if (modal && modal._config && modal._config.keyboard === undefined) {
                    // nothing to change on instance, but ensure keydown listener
                }
                // ensure backdrop click closes modal unless explicitly static
                // (Bootstrap handles this by default, but some dynamic modals may not be initialized properly)
                var instance = bootstrap.Modal.getInstance(modal) || new bootstrap.Modal(modal);
                // re-enable default options
                instance._config = Object.assign({}, instance._config, { backdrop: true, keyboard: true });
            }catch(err){ console.error('Modal shown helper error', err); }
        });

        // Toasts: ensure server-rendered toasts (session) are initialised and can be dismissed
        document.addEventListener('DOMContentLoaded', function(){
            try{
                document.querySelectorAll('.toast').forEach(function(t){
                    // create instance if not present
                    var inst = bootstrap.Toast.getInstance(t) || new bootstrap.Toast(t, { autohide: true, delay: 4000 });
                    // if element has class show, call show() to wire events
                    if (t.classList.contains('show')) inst.show();
                });
            }catch(err){ console.error('Toast init error', err); }
        });

        // For buttons that dismiss toasts, ensure they hide the right instance even if dynamic
        document.addEventListener('click', function(e){
            try{
                var btn = e.target.closest('[data-bs-dismiss="toast"]');
                if (!btn) return;
                var toastEl = btn.closest('.toast');
                if (toastEl){
                    var ti = bootstrap.Toast.getInstance(toastEl) || new bootstrap.Toast(toastEl);
                    ti.hide();
                }
            }catch(err){ console.error('Toast dismiss helper error', err); }
        });
    </script>
    @stack('scripts')
</body>

</html>
