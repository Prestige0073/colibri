@php
    use Illuminate\Support\Facades\Route;

    // Liste des routes où l'alerte doit s'afficher
    $allowedRoutes = [
        'emprunts.index',
        'emprunts.show',
        'emprunts.mes-emprunts',
        'account.profil',
        'account.commandes',
        'index'  // Page d'accueil
    ];

    // Vérifier si on est sur une route autorisée
    $currentRoute = Route::currentRouteName();
    $shouldShowAlert = $currentRoute && in_array($currentRoute, $allowedRoutes);

    // Récupérer les emprunts de l'utilisateur avec accès expiré (seulement si nécessaire)
    $empruntsExpires = ($shouldShowAlert && Auth::check()) ? \App\Models\Emprunt::with('livre')
        ->where('user_id', Auth::id())
        ->whereIn('statut', ['en_cours', 'en_retard'])
        ->whereNotNull('access_expires_at')
        ->where('access_expires_at', '<', now())
        ->get() : collect();
@endphp

@if($shouldShowAlert && $empruntsExpires->isNotEmpty())
@php
    // Créer une clé unique basée sur les IDs des emprunts expirés
    $expiredIds = $empruntsExpires->pluck('id')->sort()->join('-');
    $alertKey = 'expired_alert_dismissed_' . $expiredIds;
@endphp

<div class="alert alert-warning alert-dismissible fade show shadow-sm mb-4" role="alert" id="expired-access-alert" data-alert-key="{{ $alertKey }}" style="display: none;">
    <div class="d-flex align-items-start">
        <div class="me-3">
            <i class="fas fa-exclamation-triangle fa-2x text-warning"></i>
        </div>
        <div class="flex-grow-1">
            <h5 class="alert-heading mb-2">
                <i class="fas fa-clock me-2"></i>Votre accès PDF a expiré pour {{ $empruntsExpires->count() }} livre(s)
            </h5>
            <p class="mb-2">Vous avez dépassé la période d'accès de 14 jours pour les livres suivants :</p>
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
                <a href="{{ route('contact.index') }}" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-envelope me-1"></i>Contacter l'administration
                </a>
            </div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const expiredAccessAlert = document.getElementById('expired-access-alert');
        if (!expiredAccessAlert) return;

        const alertKey = expiredAccessAlert.getAttribute('data-alert-key');

        // Vérifier si l'alerte a déjà été fermée
        if (localStorage.getItem(alertKey)) {
            expiredAccessAlert.remove();
            return;
        }

        // Afficher l'alerte si elle n'a pas été fermée
        expiredAccessAlert.style.display = 'block';

        // Sauvegarder la fermeture lorsque l'utilisateur ferme manuellement l'alerte
        expiredAccessAlert.addEventListener('close.bs.alert', function() {
            localStorage.setItem(alertKey, 'true');
        });

        // Auto-fermeture après 15 secondes
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(expiredAccessAlert);
            bsAlert.close();
            // Sauvegarder aussi lors de la fermeture automatique
            localStorage.setItem(alertKey, 'true');
        }, 15000);
    });
</script>
@endif
