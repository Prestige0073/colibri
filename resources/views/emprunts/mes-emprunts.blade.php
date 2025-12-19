@extends('layouts.app')

@section('title', 'Mes Emprunts')

@section('content')
<style>
    /* Hero Section */
    .hero-mes-emprunts {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        padding: 60px 0 40px;
        position: relative;
        overflow: hidden;
        margin-bottom: 40px;
    }

    .hero-mes-emprunts::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        animation: float 5s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    .hero-mes-emprunts h1 {
        color: white;
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 15px rgba(0,0,0,0.2);
    }

    .hero-mes-emprunts p {
        color: rgba(255, 255, 255, 0.95);
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .hero-icon {
        font-size: 3rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 15px;
        animation: float 3s ease-in-out infinite;
    }

    .btn-back {
        background: white;
        color: #4facfe;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0,0,0,0.2);
        color: #4facfe;
    }

    /* Stats Summary */
    .stats-summary {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 20px;
    }

    .stat-item {
        text-align: center;
        flex: 1;
        min-width: 150px;
    }

    .stat-item i {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
    }

    .stat-item.active i { color: #4facfe; }
    .stat-item.late i { color: #f56565; }
    .stat-item.returned i { color: #48bb78; }

    .stat-item h3 {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-item p {
        color: #718096;
        margin: 0;
        font-size: 0.9rem;
    }

    /* Toast Notifications */
    .toast-container {
        position: fixed;
        top: 1.5rem;
        right: 1.5rem;
        z-index: 1080;
        pointer-events: none;
    }

    .custom-toast {
        pointer-events: auto;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        animation: slideInDown 0.5s ease;
        min-width: 320px;
    }

    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .toast-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .toast-error {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        color: white;
    }

    /* Section Cards */
    .section-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        margin-bottom: 30px;
        transition: all 0.3s;
    }

    .section-card:hover {
        box-shadow: 0 8px 35px rgba(0,0,0,0.12);
    }

    .section-header {
        padding: 25px 30px;
        font-weight: 700;
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-header.late {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
        color: white;
    }

    .section-header.active {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .section-header.history {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
        color: white;
    }

    .section-body {
        padding: 30px;
    }

    /* Emprunt Cards */
    .emprunt-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        border: 2px solid #e2e8f0;
        transition: all 0.3s;
        height: 100%;
    }

    .emprunt-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border-color: #4facfe;
    }

    .emprunt-card.late {
        border-color: #f56565;
    }

    .emprunt-image {
        height: 200px;
        overflow: hidden;
        position: relative;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    }

    .emprunt-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .emprunt-card:hover .emprunt-image img {
        transform: scale(1.1);
    }

    .emprunt-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .emprunt-badge.success {
        background: #48bb78;
        color: white;
    }

    .emprunt-badge.danger {
        background: #f56565;
        color: white;
    }

    .emprunt-card-body {
        padding: 20px;
    }

    .emprunt-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2d3748;
        margin-bottom: 10px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 55px;
    }

    .emprunt-author {
        color: #718096;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .emprunt-author i {
        color: #4facfe;
    }

    .emprunt-info {
        background: #f7fafc;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .emprunt-info-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 0;
        font-size: 0.95rem;
    }

    .emprunt-info-item i {
        width: 20px;
        text-align: center;
    }

    /* Table Styles */
    .modern-table {
        border-radius: 10px;
        overflow: hidden;
    }

    .modern-table thead {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    }

    .modern-table thead th {
        border: none;
        padding: 15px;
        font-weight: 600;
        color: #2d3748;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .modern-table tbody tr {
        transition: all 0.2s;
    }

    .modern-table tbody tr:hover {
        background: #f7fafc;
        transform: scale(1.01);
    }

    .modern-table tbody td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
    }

    /* Info Box */
    .info-box-modern {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
    }

    .info-box-modern h5 {
        font-weight: 700;
        margin-bottom: 20px;
        font-size: 1.4rem;
    }

    .info-box-modern ul {
        margin: 0;
        padding-left: 20px;
    }

    .info-box-modern li {
        padding: 8px 0;
        font-size: 1.05rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 5rem;
        color: #cbd5e0;
        margin-bottom: 20px;
        display: block;
    }

    .empty-state h3 {
        color: #718096;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #a0aec0;
    }

    /* Warning Alert */
    .warning-alert {
        background: linear-gradient(135deg, #fbd38d 0%, #f6ad55 100%);
        color: #744210;
        padding: 20px;
        border-radius: 15px;
        margin-top: 20px;
        border: none;
        box-shadow: 0 4px 15px rgba(251, 211, 141, 0.3);
    }

    .warning-alert i {
        font-size: 1.2rem;
    }

    /* Animations */
    .fadeIn {
        animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-mes-emprunts h1 {
            font-size: 2rem;
        }

        .hero-mes-emprunts p {
            font-size: 1rem;
        }

        .stats-summary {
            padding: 20px;
        }

        .stat-item {
            min-width: 100%;
        }

        .section-header {
            padding: 20px;
            font-size: 1.1rem;
        }

        .section-body {
            padding: 20px;
        }

        .emprunt-image {
            height: 180px;
        }
    }
</style>

<!-- Toast Notifications -->
<div class="toast-container">
    @if (session('success'))
        <div class="toast custom-toast toast-success align-items-center border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
    @if (session('error'))
        <div class="toast custom-toast toast-error align-items-center border-0 show" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
</div>

<!-- Hero Section -->
<div class="hero-mes-emprunts">
    <div class="container text-center fadeIn">
        <i class="fas fa-list-check hero-icon"></i>
        <h1>Mes Emprunts</h1>
        <p>Consultez vos emprunts en cours et votre historique</p>
        <a href="{{ route('emprunts.index') }}" class="btn btn-back">
            <i class="fas fa-arrow-left me-2"></i>Retour à la bibliothèque
        </a>
    </div>
</div>

<div class="container pb-5">
    <!-- Stats Summary -->
    <div class="stats-summary fadeIn">
        <div class="stat-item active">
            <i class="fas fa-book-open"></i>
            <h3>{{ $empruntsActifs->count() }}</h3>
            <p>En cours</p>
        </div>
        <div class="stat-item late">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>{{ $empruntsRetard->count() }}</h3>
            <p>En retard</p>
        </div>
        <div class="stat-item returned">
            <i class="fas fa-check-circle"></i>
            <h3>{{ $empruntsHistorique->total() }}</h3>
            <p>Retournés</p>
        </div>
    </div>

    <!-- Emprunts en retard -->
    @if($empruntsRetard->isNotEmpty())
        <div class="section-card fadeIn">
            <div class="section-header late">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Emprunts en Retard ({{ $empruntsRetard->count() }})</span>
            </div>
            <div class="section-body">
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>Livre</th>
                                <th>Auteur</th>
                                <th>Date d'emprunt</th>
                                <th>Date de retour prévue</th>
                                <th>Retard</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empruntsRetard as $emprunt)
                                <tr>
                                    <td><strong>{{ $emprunt->livre->titre ?? 'N/A' }}</strong></td>
                                    <td>{{ $emprunt->livre->auteur ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}</td>
                                    <td>
                                        <span class="badge bg-danger">
                                            {{ \Carbon\Carbon::parse($emprunt->date_retour)->diffForHumans() }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="warning-alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Veuillez contacter la bibliothèque pour régulariser votre situation.</strong>
                </div>
            </div>
        </div>
    @endif

    <!-- Emprunts en cours -->
    <div class="section-card fadeIn" style="animation-delay: 0.1s;">
        <div class="section-header active">
            <i class="fas fa-book-open"></i>
            <span>Emprunts en Cours ({{ $empruntsActifs->count() }})</span>
        </div>
        <div class="section-body">
            @if($empruntsActifs->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-book-open"></i>
                    <h3>Aucun emprunt en cours</h3>
                    <p>Explorez notre bibliothèque pour emprunter des livres!</p>
                    <a href="{{ route('emprunts.index') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-search me-2"></i>Parcourir la bibliothèque
                    </a>
                </div>
            @else
                <div class="row g-4">
                    @foreach($empruntsActifs as $emprunt)
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <div class="emprunt-card @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($emprunt->date_retour))) late @endif">
                                <div class="emprunt-image">
                                    @if($emprunt->livre->image)
                                        <img src="{{ asset('img/' . $emprunt->livre->image) }}" alt="{{ $emprunt->livre->titre }}">
                                    @else
                                        <img src="{{ asset('img/default-book.jpg') }}" alt="{{ $emprunt->livre->titre }}">
                                    @endif

                                    @php
                                        $joursRestants = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($emprunt->date_retour), false);
                                    @endphp

                                    @if($joursRestants >= 0)
                                        <div class="emprunt-badge success">
                                            {{ $joursRestants }} jour(s)
                                        </div>
                                    @else
                                        <div class="emprunt-badge danger">
                                            Retard: {{ abs($joursRestants) }} j
                                        </div>
                                    @endif
                                </div>

                                <div class="emprunt-card-body">
                                    <h3 class="emprunt-title">{{ $emprunt->livre->titre ?? 'N/A' }}</h3>

                                    <div class="emprunt-author">
                                        <i class="fas fa-user"></i>
                                        <span>{{ $emprunt->livre->auteur ?? 'N/A' }}</span>
                                    </div>

                                    <div class="emprunt-info">
                                        <div class="emprunt-info-item">
                                            <i class="fas fa-calendar-day text-primary"></i>
                                            <div>
                                                <strong>Emprunté:</strong><br>
                                                {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}
                                            </div>
                                        </div>
                                        <div class="emprunt-info-item">
                                            <i class="fas fa-calendar-check text-success"></i>
                                            <div>
                                                <strong>Retour prévu:</strong><br>
                                                {{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}
                                            </div>
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

    <!-- Historique -->
    <div class="section-card fadeIn" style="animation-delay: 0.2s;">
        <div class="section-header history">
            <i class="fas fa-history"></i>
            <span>Historique des Emprunts</span>
        </div>
        <div class="section-body">
            @if($empruntsHistorique->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-clock-rotate-left"></i>
                    <h3>Historique vide</h3>
                    <p>Vous n'avez pas encore retourné de livres.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>Livre</th>
                                <th>Auteur</th>
                                <th>Date d'emprunt</th>
                                <th>Date de retour</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empruntsHistorique as $emprunt)
                                <tr>
                                    <td><strong>{{ $emprunt->livre->titre ?? 'N/A' }}</strong></td>
                                    <td>{{ $emprunt->livre->auteur ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($emprunt->date_retour)
                                            {{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Retourné
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $empruntsHistorique->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Info Box -->
    <div class="info-box-modern fadeIn" style="animation-delay: 0.3s;">
        <h5><i class="fas fa-info-circle me-2"></i>Informations Importantes</h5>
        <ul>
            <li><i class="fas fa-clock me-2"></i>La durée d'emprunt est de <strong>14 jours</strong></li>
            <li><i class="fas fa-books me-2"></i>Vous pouvez emprunter plusieurs livres simultanément</li>
            <li><i class="fas fa-exclamation-triangle me-2"></i>En cas de retard, veuillez contacter l'administration</li>
            <li><i class="fas fa-download me-2"></i>Les livres empruntés ne peuvent pas être téléchargés</li>
        </ul>
    </div>
</div>

<script>
    // Auto-hide toasts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(function(toast) {
            setTimeout(function() {
                const bsToast = new bootstrap.Toast(toast);
                bsToast.hide();
            }, 5000);
        });
    });
</script>
@endsection
