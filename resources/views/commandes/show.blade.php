@extends('layouts.app')

@section('title', 'Détails de la commande')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card p-4 shadow-sm rounded-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="mb-0"><i class="fa fa-receipt text-success me-1" aria-hidden="true"></i>Commande {{ $commande->id }}</h3>
                    <div class="d-flex gap-2">
                            <a href="{{ route('account.commandes') }}" class="btn btn-outline-success btn-sm">
                                <i class="fa fa-list" aria-hidden="true"></i>
                                <span class="d-none d-sm-inline ms-1">Retour aux commandes</span>
                            </a>
                            <a href="{{ route('account.profil') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                <span class="d-none d-sm-inline ms-1">Retour au profil</span>
                            </a>
                        </div>
                </div>
                <p class="text-muted">Passée le {{ $commande->created_at->format('d/m/Y H:i') }}</p>
                @php
                    // Utiliser l'accesseur `statut_label` et déterminer la classe/badge/icône en fonction du statut brut.
                    $raw = $commande->statut;
                    $statusLabel = $commande->statut_label;
                    $badgeClass = 'info';
                    $statusIcon = 'fa-info-circle';
                    if ($raw === 'pending') { $badgeClass = 'warning'; $statusIcon = 'fa-clock'; }
                    elseif ($raw === 'en_livraison') { $badgeClass = 'info'; $statusIcon = 'fa-truck'; }
                    elseif ($raw === 'livre' || $raw === 'livree') { $badgeClass = 'success'; $statusIcon = 'fa-check-circle'; }

                    $isEmail = isset($commande->adresse) && strpos($commande->adresse, '@') !== false;
                    $addressIcon = $isEmail ? 'fa-envelope' : 'fa-map-marker-alt';
                @endphp

                <div class="mb-3">
                    <div class="text-muted small"><i class="fa {{ $addressIcon }} me-1"></i>Adresse : {{ $commande->adresse ?? '—' }}</div>
                    <div class="mt-2">
                        <strong><i class="fa fa-coins text-warning me-1"></i>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</strong>
                        <span class="badge bg-{{ $badgeClass }} ms-2"><i class="fa {{ $statusIcon }} me-1"></i>{{ $statusLabel }}</span>
                    </div>
                </div>
                <h5>Articles</h5>
                <ul class="list-group mb-3">
                    @foreach($commande->items as $it)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><i class="fa fa-book text-secondary me-1" aria-hidden="true"></i>{{ $it->titre ?? 'Article' }}</strong>
                                <div class="small text-muted">Réf: {{ $it->catalogue_id ?? '—' }}</div>
                            </div>
                            <div class="badge bg-success rounded-pill">x{{ $it->quantite }}</div>
                        </li>
                    @endforeach
                </ul>

                @php
                    $phone = config('app.contact_phone', env('CONTACT_PHONE', '')) ?: (Auth::user()->phone ?? '');
                    $email = config('app.contact_email', env('CONTACT_EMAIL', '')) ?: (Auth::user()->email ?? '');
                    $waPhone = preg_replace('/[^0-9+]/', '', $phone);
                @endphp
                <div class="d-flex gap-2">
                    @if(!empty($waPhone))
                        <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode('Bonjour, je souhaite des informations sur ma commande #' . $commande->id) }}" target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline ms-1">WhatsApp</span>
                        </a>
                        <a href="tel:{{ $waPhone }}" class="btn btn-outline-success btn-sm">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline ms-1">Appel direct</span>
                        </a>
                    @endif
                    @if(!empty($email))
                        <a href="mailto:{{ $email }}?subject={{ urlencode('Commande #' . $commande->id) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline ms-1">Email</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
