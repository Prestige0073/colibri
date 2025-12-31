@extends('layouts.app')

@section('title', 'Contact | Colibri Littéraire - Nous contacter, informations et formulaire')
@section('meta_description', "Contactez Colibri Littéraire pour toute demande d'information, partenariat ou suggestion.
    Formulaire de contact et coordonnées.")
@section('meta_keywords', 'contact, formulaire, informations, partenariat, Colibri Littéraire, livre africain, culture,
    édition, francophonie')

@section('content')
@include('partials.notifications')

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Contact</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('index') }}">Accueil</a></li>
                    <li class="breadcrumb-item"><a class="text-muted" href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Video Start -->
    <div class="container-fluid bg-success mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-11">
                    <div class="h-100 py-5 d-flex align-items-center">
                        <button type="button" class="btn-play" data-bs-toggle="modal"
                            data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                        <h3 class="ms-5 mb-0 text-white">Ensemble, nous construisons un avenir où chaque
                            passionné du livre peut accéder facilement au livre
                            africain et chaque acteur, se former aux métiers du
                            secteur</h3>
                    </div>
                </div>
                <div class="d-none d-lg-block col-lg-1">
                    <div class="h-100 w-100 bg-secondary d-flex align-items-center justify-content-center">
                        <span class="text-white" style="transform: rotate(-90deg);">Faire défiler</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video End -->

    <!-- Video Modal Start -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Vidéo Youtube</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                            allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Modal End -->

    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5 wow fadeIn" data-wow-delay="0.1s">
                    <p class="section-title bg-white text-start text-success pe-3">Contact</p>
                    <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">Une question ? Contactez-nous !</h1>
                    <iframe class="w-100"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.726027964635!2d2.420964314800964!3d6.370292995404027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102354f7e2e2e2e3%3A0x2e2e2e2e2e2e2e2e!2sCotonou%2C%20B%C3%A9nin!5e0!3m2!1sfr!2sbj!4v1603794290143!5m2!1sfr!2sbj"
                        frameborder="0" style="height: 425px; border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
                <div class="col-lg-7 wow fadeIn" data-wow-delay="0.3s">
                    <h3>Formulaire de contact</h3>
                    <p class="mb-4">Pour toute demande d'information, suggestion ou partenariat, merci de remplir le
                        formulaire ci-dessous. Notre équipe vous répondra dans les meilleurs délais.</p>
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Votre nom" value="{{ old('name') }}" required>
                                    <label for="name">Votre nom</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Votre email" value="{{ old('email') }}" required>
                                    <label for="email">Votre email</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" id="subject" name="subject" placeholder="Sujet" value="{{ old('subject') }}" required>
                                    <label for="subject">Sujet</label>
                                    @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control @error('message') is-invalid @enderror" placeholder="Votre message ici" id="message" name="message" style="height: 250px" required>{{ old('message') }}</textarea>
                                    <label for="message">Message</label>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success text-white py-3 px-4" type="submit">
                                    <i class="fas fa-paper-plane me-2"></i>Envoyer le message
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Full width contact actions (redesign) -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="mb-4 text-center">
                        <p class="section-title bg-white text-success pe-3">Contact rapide</p>
                        <h2 class="h4 mb-1">Contactez-nous directement</h2>
                        <p class="text-muted mb-0">Choisissez un mode de contact : appel, WhatsApp ou email. Nous répondons généralement sous 48h.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 rounded-3">
                        <div class="card-body py-4">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                    <!-- Hidden spans used by copyContact() -->
                                    <span id="phone-fr" class="d-none">+33 7 46 52 61 63</span>
                                    <span id="phone-bj" class="d-none">+229 01 66 54 78 08</span>

                                    <div class="d-grid gap-3">
                                        <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-white">
                                            <div>
                                                <div class="h6 mb-1 fw-semibold">📞 Appeler — France</div>
                                                <div class="small text-muted">Disponible 9h–18h (UTC+1)</div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a href="tel:+33746526163" class="btn btn-sm btn-success me-2" aria-label="Appeler France">+33 7 46 52 61 63</a>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="copyContact('phone-fr')" aria-label="Copier numéro France">Copier</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-white">
                                            <div>
                                                <div class="h6 mb-1 fw-semibold">📞 Appeler — Bénin</div>
                                                <div class="small text-muted">Heures locales : 8h–17h</div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a href="tel:+2290166547808" class="btn btn-sm btn-success me-2" aria-label="Appeler Benin">+229 01 66 54 78 08</a>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="copyContact('phone-bj')" aria-label="Copier numéro Benin">Copier</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-white">
                                            <div>
                                                <div class="h6 mb-1 fw-semibold">💬 WhatsApp</div>
                                                <div class="small text-muted">Réponse rapide via message</div>
                                            </div>
                                            <div class="d-flex flex-column align-items-end">
                                                <div class="d-flex">
                                                    <a href="https://wa.me/33746526163" target="_blank" rel="noopener" class="btn btn-sm btn-success me-2" aria-label="WhatsApp France">WhatsApp (FR)</a>
                                                    <a href="https://wa.me/2290166547808" target="_blank" rel="noopener" class="btn btn-sm btn-success" aria-label="WhatsApp Benin">WhatsApp (BJ)</a>
                                                </div>
                                                <small class="text-muted mt-1">Click pour ouvrir une conversation</small>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-between p-3 border rounded bg-white">
                                            <div>
                                                <div class="h6 mb-1 fw-semibold">✉️ Email</div>
                                                <div class="small text-muted">Réponse sous 48h</div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <a href="mailto:colibrilitteraire@gmail.com" class="btn btn-sm btn-outline-secondary me-2" aria-label="Envoyer un email">Envoyer</a>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="copyContact('email')" aria-label="Copier email">Copier</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection

@push('scripts')
    <script>
        function copyContact(id) {
            var text = document.getElementById(id).innerText.trim();
            if (!navigator.clipboard) {
                // Fallback
                var ta = document.createElement('textarea');
                ta.value = text;
                document.body.appendChild(ta);
                ta.select();
                try { document.execCommand('copy'); } catch (e) { /* ignore */ }
                document.body.removeChild(ta);
                showCopiedToast('Copié : ' + text);
                return;
            }
            navigator.clipboard.writeText(text).then(function() {
                showCopiedToast('Copié : ' + text);
            }, function() {
                showCopiedToast('Impossible de copier');
            });
        }

        function showCopiedToast(message) {
            var id = 'copied-toast';
            var el = document.getElementById(id);
            if (!el) {
                el = document.createElement('div');
                el.id = id;
                el.style.position = 'fixed';
                el.style.right = '20px';
                el.style.bottom = '20px';
                el.style.background = 'rgba(0,0,0,0.8)';
                el.style.color = 'white';
                el.style.padding = '10px 14px';
                el.style.borderRadius = '6px';
                el.style.zIndex = 9999;
                document.body.appendChild(el);
            }
            el.innerText = message;
            el.style.opacity = '1';
            setTimeout(function() { el.style.transition = 'opacity 400ms'; el.style.opacity = '0'; }, 1800);
        }
    </script>
@endpush
