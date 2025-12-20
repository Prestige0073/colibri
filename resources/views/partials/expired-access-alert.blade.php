@php
    // Récupérer les emprunts de l'utilisateur avec accès expiré
    $empruntsExpires = Auth::check() ? \App\Models\Emprunt::with('livre')
        ->where('user_id', Auth::id())
        ->whereIn('statut', ['en_cours', 'en_retard'])
        ->whereNotNull('access_expires_at')
        ->where('access_expires_at', '<', now())
        ->get() : collect();
@endphp

@if($empruntsExpires->isNotEmpty())
<div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4" role="alert">
    <div class="d-flex align-items-start">
        <div class="me-3">
            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
        </div>
        <div class="flex-grow-1">
            <h5 class="alert-heading mb-2">
                <i class="fas fa-clock me-2"></i>Votre accès PDF a expiré pour {{ $empruntsExpires->count() }} livre(s)
            </h5>
            <p class="mb-2">Vous avez dépassé la période d'accès de 6 heures pour les livres suivants :</p>
            <ul class="mb-2">
                @foreach($empruntsExpires as $emprunt)
                    <li>
                        <strong>{{ $emprunt->livre->titre ?? 'N/A' }}</strong>
                        - Expiré {{ $emprunt->access_expires_at->diffForHumans() }}
                    </li>
                @endforeach
            </ul>
            <p class="mb-0">
                <i class="fas fa-info-circle me-1"></i>
                Veuillez contacter l'administration pour prolonger votre accès ou consulter vos emprunts.
            </p>
            <div class="mt-3">
                <a href="{{ route('emprunts.mes-emprunts') }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-list me-1"></i>Voir mes emprunts
                </a>
                <a href="{{ route('contact') }}" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-envelope me-1"></i>Contacter l'administration
                </a>
            </div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
