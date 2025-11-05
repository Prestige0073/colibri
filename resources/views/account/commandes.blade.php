@extends('layouts.app')

@section('title','Mes commandes')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="d-flex align-items-center justify-content-between flex-nowrap mb-4">
                <div>
                    <h2 class="mb-1"><i class="fa fa-truck text-success me-2"></i>Suivi de commandes</h2>
                    <p class="text-muted mb-0 d-none d-sm-block">Retrouvez ici l'historique et le statut de vos commandes. Pour toute question, utilisez les actions de contact.</p>
                </div>
                <div>
                    <a href="{{ route('account.profil') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-user me-1" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline">Retour au profil</span>
                    </a>
                </div>
            </div>

            @if($commandes->isEmpty())
                <div class="card p-4 shadow-sm rounded-4 text-center">
                    <i class="fa fa-box-open fa-3x text-muted mb-3"></i>
                    <h5 class="mb-1">Aucune commande enregistrée</h5>
                    <p class="text-muted">Vous n'avez pas encore passé de commande. Commencez par ajouter des livres au panier.</p>
                    <a href="{{ route('catalogue.index') ?? '/' }}" class="btn btn-success">Voir le catalogue</a>
                </div>
            @else
                <div class="row g-3">
                    @foreach($commandes as $c)
                        @php
                            $badge = 'secondary';
                            $raw = $c->statut;
                            $label = $c->statut_label;
                            if ($raw === 'pending') { $badge = 'warning'; }
                            elseif ($raw === 'en_livraison') { $badge = 'info'; }
                            elseif ($raw === 'livre' || $raw === 'livree') { $badge = 'success'; }
                        @endphp

                        <div class="col-12">
                            <div class="card shadow-sm rounded-4">
                                <div class="card-body d-flex flex-column flex-md-row justify-content-between gap-3 align-items-start">
                                    <div class="d-flex align-items-start gap-3">
                                        <div class="icon-circle bg-light border rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
                                            <i class="fa fa-receipt text-success fs-4"></i>
                                        </div>
                                        <div>
                                            <div class="d-flex align-items-baseline gap-2">
                                                <h5 class="mb-1"><i class="fa fa-receipt text-success me-1" aria-hidden="true"></i>Commande {{ $c->id }}</h5>
                                                <span class="text-muted small">• {{ $c->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            @php
                                                $isEmail = isset($c->adresse) && strpos($c->adresse, '@') !== false;
                                                $addressIcon = $isEmail ? 'fa-envelope' : 'fa-map-marker-alt';
                                                // status icon
                                                $statusIcon = 'fa-info-circle';
                                                if ($raw === 'pending') $statusIcon = 'fa-clock';
                                                elseif ($raw === 'en_livraison') $statusIcon = 'fa-truck';
                                                elseif ($raw === 'livre' || $raw === 'livree') $statusIcon = 'fa-check-circle';
                                            @endphp
                                            <div class="text-muted small"><i class="fa {{ $addressIcon }} me-1"></i>{{ $c->adresse ?? '—' }}</div>
                                            <div class="mt-2">
                                                <strong><i class="fa fa-coins text-warning me-1"></i>{{ number_format($c->total,0,',',' ') }} FCFA</strong>
                                                <span class="badge bg-{{ $badge }} ms-2"><i class="fa {{ $statusIcon }} me-1"></i>{{ $label }}</span>
                                            </div>
                                            <div class="mt-2 small">
                                                @foreach($c->items as $it)
                                                    <div><i class="fa fa-book text-secondary me-1" aria-hidden="true"></i>{{ \Illuminate\Support\Str::limit($it->titre ?? 'Article', 60) }} x{{ $it->quantite }} — {{ number_format($it->prix,0,',',' ') }} FCFA</div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end d-flex flex-column align-items-end justify-content-between">
                                        <div>
                                            <a href="{{ route('commandes.show', $c->id) }}" class="btn btn-sm btn-outline-success mb-2"><i class="fa fa-eye me-1"></i>Détails</a>
                                        </div>
                                        <div class="d-flex gap-2">
                                            @php
                                                $phone = config('app.contact_phone', env('CONTACT_PHONE', '')) ?: (Auth::user()->phone ?? '');
                                                $email = config('app.contact_email', env('CONTACT_EMAIL', '')) ?: (Auth::user()->email ?? '');
                                                // normalize phone for wa.me (digits only)
                                                $waPhone = preg_replace('/[^0-9+]/', '', $phone);
                                            @endphp
                                            @if(!empty($waPhone))
                                                <a href="https://wa.me/{{ $waPhone }}?text={{ urlencode('Bonjour, je souhaite des informations sur ma commande #' . $c->id) }}" target="_blank" class="btn btn-success btn-sm"><i class="fab fa-whatsapp me-1" aria-hidden="true"></i><span class="d-none d-md-inline">WhatsApp</span></a>
                                                <a href="tel:{{ $waPhone }}" class="btn btn-outline-success btn-sm"><i class="fa fa-phone me-1" aria-hidden="true"></i><span class="d-none d-md-inline">Appel</span></a>
                                            @endif
                                            @if(!empty($email))
                                                <a href="mailto:{{ $email }}?subject={{ urlencode('Commande #' . $c->id) }}" class="btn btn-outline-secondary btn-sm"><i class="fa fa-envelope me-1" aria-hidden="true"></i><span class="d-none d-md-inline">Email</span></a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .icon-circle i { font-size: 22px; }
    .card .small { line-height: 1.3; }
    @media (max-width: 575px) {
        .card-body { padding: 1rem; }
    }
</style>
@endpush
