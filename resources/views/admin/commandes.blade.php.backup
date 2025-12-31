@extends('admin.layout')

@section('title','Administration')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><i class="fa fa-truck me-2"></i>Commandes par utilisateur</h3>
        <form method="GET" class="d-flex gap-2">
            <select name="statut" class="form-select form-select-sm">
                <option value="">Tous</option>
                <option value="pending">En préparation</option>
                <option value="en_livraison">En livraison</option>
                <option value="livre">Livré</option>
            </select>
            <select name="sort" class="form-select form-select-sm">
                <option value="date" {{ (isset($sort) && $sort==='date') ? 'selected' : '' }}>Trier par date</option>
                <option value="amount" {{ (isset($sort) && $sort==='amount') ? 'selected' : '' }}>Trier par montant</option>
            </select>
            <button class="btn btn-sm btn-primary">Filtrer</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($users->isEmpty())
        <div class="alert alert-info">Aucun utilisateur avec commandes trouvé.</div>
    @endif

    @foreach($users as $user)
        <div class="card mb-3">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                <div>
                    <strong>{{ $user->name ?? $user->email }}</strong>
                    <div class="small text-muted">{{ $user->email }} — {{ $user->phone ?? '—' }}</div>
                </div>
                <div class="mt-2 mt-md-0">
                    <button
                        class="btn btn-sm btn-outline-secondary toggle-user-orders"
                        data-target="#collapse-user-{{ $user->id }}"
                        data-show-text="Voir ses commandes"
                        data-hide-text="Masquer ses commandes"
                    >
                        <i class="fa fa-chevron-down me-1"></i>
                        <span class="d-none d-sm-inline">Voir ses commandes</span>
                    </button>
                    <form method="POST" action="{{ route('admin.commandes.bulkStatus', $user->id) }}" class="d-inline-block ms-2">
                            @csrf
                            <select name="statut" class="form-select form-select-sm d-inline-block" style="width:auto;">
                                <option value="">Actions massives</option>
                                <option value="pending">Mettre en préparation</option>
                                <option value="en_livraison">Mettre en livraison</option>
                                <option value="livre">Marquer comme livré</option>
                            </select>
                            <button class="btn btn-sm btn-outline-danger ms-1">
                                <i class="fa fa-bolt me-1"></i>
                                <span class="d-none d-sm-inline">Appliquer</span>
                            </button>
                        </form>
                </div>
            </div>
            <div class="card-body collapse" id="collapse-user-{{ $user->id }}">
                @if($user->commandes_active->isEmpty())
                    <div class="text-muted">Aucune commande active pour cet utilisateur.</div>
                @else
                    @foreach($user->commandes_active as $c)
                        <div class="border rounded p-2 mb-2 d-flex flex-column flex-md-row justify-content-between align-items-start">
                            <div>
                                <div class="fw-bold">Commande {{ $c->id }} — <i class="fa fa-calendar-alt me-1"></i>{{ $c->created_at->format('d/m/Y H:i') }}</div>
                                <div class="small text-muted"><i class="fa fa-map-marker-alt me-1"></i>Adresse: {{ $c->adresse ?? '—' }}</div>
                                <div class="mt-2 small">
                                    @foreach($c->items as $it)
                                        <div><i class="fa fa-book me-1"></i>{{ $it->titre }} x{{ $it->quantite }}</div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="mt-3 mt-md-0 text-md-end">
                                <div class="fw-bold"><i class="fa fa-coins me-1"></i>{{ number_format($c->total,0,',',' ') }} FCFA</div>
                                @php
                                    // coordonnées : préférence aux champs de la commande puis à l'utilisateur
                                    $tel = $c->telephone ?? $c->tel ?? $user->phone ?? '';
                                    $email = $c->email ?? $user->email ?? '';
                                    $wa = $tel ? 'https://wa.me/'.preg_replace('/[^0-9+]/','',$tel) : '#';
                                @endphp
                                <div class="mt-2 d-flex flex-column align-items-md-end align-items-start">
                                    <div class="mb-2">
                                        <a href="{{ route('admin.commandes.show', $c->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            <span class="d-none d-sm-inline ms-1">Voir</span>
                                        </a>
                                    </div>
                                    <div class="d-flex gap-2">
                                        @if(!empty($tel))
                                            <a href="{{ $wa }}" target="_blank" class="btn btn-sm btn-outline-success">
                                                <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                                <span class="d-none d-sm-inline ms-1">WhatsApp</span>
                                            </a>
                                            <a href="tel:{{ $tel }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-phone" aria-hidden="true"></i>
                                                <span class="d-none d-sm-inline ms-1">Appel</span>
                                            </a>
                                        @endif
                                        @if(!empty($email))
                                            <a href="mailto:{{ $email }}?subject={{ urlencode('Commande #' . $c->id) }}" class="btn btn-sm btn-outline-secondary">
                                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                                <span class="d-none d-sm-inline ms-1">Email</span>
                                            </a>
                                        @endif
                                    </div>
                                    <div class="small text-muted mt-1 d-none d-sm-block">
                                        @if(!empty($tel))<span>Téléphone : <a href="tel:{{ $tel }}">{{ $tel }}</a></span>@endif
                                        @if(!empty($email))<span class="ms-3">Email : <a href="mailto:{{ $email }}">{{ $email }}</a></span>@endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            @if($user->commandes_archives && $user->commandes_archives->isNotEmpty())
                <div class="card-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="small text-muted"><i class="fa fa-archive me-1"></i>Archives ({{ $user->commandes_archives->count() }})</div>
                        <button class="btn btn-sm btn-outline-secondary toggle-user-archives" data-target="#collapse-archives-{{ $user->id }}"><i class="fa fa-archive me-1"></i>Voir les archives</button>
                    </div>
                    <div class="collapse mt-2" id="collapse-archives-{{ $user->id }}">
                        @foreach($user->commandes_archives as $ac)
                            <div class="border rounded p-2 mb-2">
                                <div class="fw-bold">Commande {{ $ac->id }} — <i class="fa fa-calendar-alt me-1"></i>{{ $ac->created_at->format('d/m/Y H:i') }}</div>
                                <div class="small text-muted"><i class="fa fa-map-marker-alt me-1"></i>Adresse: {{ $ac->adresse ?? '—' }}</div>
                                <div class="mt-2 small">
                                    @foreach($ac->items as $it)
                                        <div><i class="fa fa-book me-1"></i>{{ $it->titre }} x{{ $it->quantite }}</div>
                                    @endforeach
                                </div>
                                <div class="mt-2 text-end"><i class="fa fa-coins me-1"></i>{{ number_format($ac->total,0,',',' ') }} FCFA</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endforeach

    <div class="mt-3">{{ $users->links() }}</div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.toggle-user-orders').forEach(function(btn) {
        var target = document.querySelector(btn.dataset.target);
        var span = btn.querySelector('span');
        var showText = btn.dataset.showText || 'Voir ses commandes';
        var hideText = btn.dataset.hideText || 'Masquer ses commandes';
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var bs = bootstrap.Collapse.getOrCreateInstance(target);
            bs.toggle();
            // toggle button text but preserve icon
            setTimeout(function() {
                if (span) {
                    span.textContent = target.classList.contains('show') ? hideText : showText;
                } else {
                    // fallback: replace aria-label
                    btn.setAttribute('aria-pressed', target.classList.contains('show'));
                }
            }, 150);
        });
    });
    document.querySelectorAll('.toggle-user-archives').forEach(function(btn) {
        var target = document.querySelector(btn.dataset.target);
        var span = btn.querySelector('span');
        var showText = btn.dataset.showText || 'Voir les archives';
        var hideText = btn.dataset.hideText || 'Masquer les archives';
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var bs = bootstrap.Collapse.getOrCreateInstance(target);
            bs.toggle();
            setTimeout(function() {
                if (span) {
                    span.textContent = target.classList.contains('show') ? hideText : showText;
                } else {
                    btn.setAttribute('aria-pressed', target.classList.contains('show'));
                }
            }, 150);
        });
    });
});
</script>
@endpush
