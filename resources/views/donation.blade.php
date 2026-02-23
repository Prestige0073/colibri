@extends('layouts.app')

@section('title', 'Faire un don | Colibri Littéraire')

@section('content')

<!-- Hero Section -->
<div class="don-hero">
    <div class="container">
        <nav class="don-breadcrumb">
            <a href="{{ route('index') }}"><i class="fa fa-home"></i></a>
            <i class="fa fa-chevron-right"></i>
            <span>Faire un don</span>
        </nav>

        <div class="don-hero-main">
            <div class="don-hero-text">
                <h1>
                    <i class="fa fa-hand-holding-heart"></i>
                    Soutenez le livre africain
                </h1>
                <p>Votre don contribue au rayonnement de la littérature africaine, au soutien des auteurs et à la promotion de la lecture sur le continent.</p>
            </div>

            <div class="don-hero-stats">
                <div class="hero-stat">
                    <span class="hero-stat-value">100%</span>
                    <span class="hero-stat-label">Dédié au livre</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-value">60+</span>
                    <span class="hero-stat-label">Auteurs soutenus</span>
                </div>
                <div class="hero-stat">
                    <span class="hero-stat-value">3</span>
                    <span class="hero-stat-label">Pays couverts</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pourquoi donner -->
<div class="container don-page-container">

    <!-- Causes -->
    <div class="don-section">
        <div class="don-section-header">
            <div class="don-section-icon">
                <i class="fa fa-seedling"></i>
            </div>
            <div class="don-section-text">
                <h2>Pourquoi nous soutenir ?</h2>
                <p>Vos dons financent directement ces actions</p>
            </div>
        </div>

        <div class="don-causes-grid">
            <div class="don-cause-card">
                <div class="don-cause-icon" style="background: linear-gradient(135deg, #1e7a2f, #0b5e34);">
                    <i class="fa fa-book-open"></i>
                </div>
                <h3>Soutien à la lecture</h3>
                <p>Rendre les livres africains accessibles au plus grand nombre et encourager la lecture dès le plus jeune âge.</p>
            </div>

            <div class="don-cause-card">
                <div class="don-cause-icon" style="background: linear-gradient(135deg, #f39c12, #e67e22);">
                    <i class="fa fa-pen-fancy"></i>
                </div>
                <h3>Soutien à l'édition</h3>
                <p>Accompagner les auteurs africains dans la publication et la diffusion de leurs oeuvres littéraires.</p>
            </div>

            <div class="don-cause-card">
                <div class="don-cause-icon" style="background: linear-gradient(135deg, #3498db, #2980b9);">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <h3>Soutien à la formation</h3>
                <p>Former les professionnels du livre aux outils numériques et aux nouvelles pratiques du marché.</p>
            </div>
        </div>
    </div>

    <!-- Formulaire de don avec KKiaPay -->
    <div class="don-section" id="don-form">
        <div class="don-form-wrapper">
            <div class="don-form-left">
                <div class="don-form-left-content">
                    <div class="don-form-badge">
                        <i class="fa fa-heart"></i> Don sécurisé
                    </div>
                    <h2>Faites votre don maintenant</h2>
                    <p>Chaque contribution, quelle que soit sa taille, fait une différence. Votre générosité permet de construire un avenir meilleur pour la littérature africaine.</p>

                    <div class="don-form-features">
                        <div class="don-form-feature">
                            <i class="fa fa-shield-alt"></i>
                            <span>Paiement 100% sécurisé</span>
                        </div>
                        <div class="don-form-feature">
                            <i class="fa fa-mobile-alt"></i>
                            <span>Mobile Money & Carte bancaire</span>
                        </div>
                        <div class="don-form-feature">
                            <i class="fa fa-receipt"></i>
                            <span>Reçu de don envoyé par email</span>
                        </div>
                    </div>

                    <div class="don-payment-methods">
                        <span class="don-method mtn">MTN Money</span>
                        <span class="don-method moov">Moov Money</span>
                        <span class="don-method visa"><i class="fab fa-cc-visa"></i> Visa</span>
                        <span class="don-method mastercard"><i class="fab fa-cc-mastercard"></i> MC</span>
                    </div>
                </div>
            </div>

            <div class="don-form-right">
                <form id="donationForm">
                    <div class="don-form-group">
                        <label>
                            <i class="fa fa-user"></i> Votre nom
                        </label>
                        <input type="text" id="donorName" class="don-form-input" placeholder="Ex: Jean Dupont"
                            value="{{ Auth::user()->name ?? '' }}">
                    </div>

                    <div class="don-form-group">
                        <label>
                            <i class="fa fa-envelope"></i> Votre email
                        </label>
                        <input type="email" id="donorEmail" class="don-form-input" placeholder="Ex: jean@exemple.com"
                            value="{{ Auth::user()->email ?? '' }}">
                    </div>

                    <div class="don-form-group">
                        <label>
                            <i class="fa fa-coins"></i> Choisissez un montant
                        </label>
                        <div class="don-amount-grid">
                            <button type="button" class="don-amount-btn" data-amount="2000">2 000 FCFA</button>
                            <button type="button" class="don-amount-btn active" data-amount="5000">5 000 FCFA</button>
                            <button type="button" class="don-amount-btn" data-amount="10000">10 000 FCFA</button>
                            <button type="button" class="don-amount-btn" data-amount="15000">15 000 FCFA</button>
                            <button type="button" class="don-amount-btn" data-amount="25000">25 000 FCFA</button>
                            <button type="button" class="don-amount-btn" data-amount="50000">50 000 FCFA</button>
                        </div>
                    </div>

                    <div class="don-form-group">
                        <label>
                            <i class="fa fa-edit"></i> Ou saisissez un montant libre
                        </label>
                        <div class="don-custom-amount">
                            <input type="number" id="customAmount" class="don-form-input" placeholder="Montant en FCFA" min="100">
                            <span class="don-currency">FCFA</span>
                        </div>
                    </div>

                    <div class="don-selected-amount">
                        Montant sélectionné : <strong id="displayAmount">5 000 FCFA</strong>
                    </div>

                    <button type="button" class="don-submit-btn" id="payDonationBtn" onclick="launchDonation()">
                        <span class="don-btn-text">
                            <i class="fa fa-hand-holding-heart me-2"></i>
                            Faire mon don
                        </span>
                        <span class="don-btn-spinner" style="display:none;">
                            <i class="fa fa-spinner fa-spin me-2"></i>
                            Traitement...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- FAQ Dons -->
    <div class="don-section">
        <div class="don-section-header">
            <div class="don-section-icon">
                <i class="fa fa-question-circle"></i>
            </div>
            <div class="don-section-text">
                <h2>Questions fréquentes</h2>
                <p>Tout ce que vous devez savoir sur les dons</p>
            </div>
        </div>

        <div class="don-faq-grid">
            <div class="don-faq-card">
                <div class="don-faq-question">
                    <i class="fa fa-lock"></i>
                    <span>Mon paiement est-il sécurisé ?</span>
                </div>
                <p class="don-faq-answer">Oui, tous les paiements sont traités par KKiaPay, une plateforme de paiement certifiée et sécurisée. Vos données bancaires ne sont jamais stockées sur notre site.</p>
            </div>
            <div class="don-faq-card">
                <div class="don-faq-question">
                    <i class="fa fa-money-bill-wave"></i>
                    <span>Comment mon don est-il utilisé ?</span>
                </div>
                <p class="don-faq-answer">100% de votre don est investi dans nos projets : achat de livres, formation des professionnels du livre, soutien aux auteurs africains et promotion de la lecture.</p>
            </div>
            <div class="don-faq-card">
                <div class="don-faq-question">
                    <i class="fa fa-credit-card"></i>
                    <span>Quels moyens de paiement acceptés ?</span>
                </div>
                <p class="don-faq-answer">Nous acceptons MTN Money, Moov Money, les cartes Visa et Mastercard. Les paiements sont disponibles depuis tous les pays d'Afrique francophone.</p>
            </div>
            <div class="don-faq-card">
                <div class="don-faq-question">
                    <i class="fa fa-redo"></i>
                    <span>Puis-je faire un don récurrent ?</span>
                </div>
                <p class="don-faq-answer">Pour le moment, les dons sont ponctuels. Vous pouvez revenir à tout moment pour faire un nouveau don et soutenir nos actions.</p>
            </div>
        </div>
    </div>

</div>

<!-- Modal de succès -->
<div class="modal fade" id="donSuccessModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border:none; border-radius:20px; overflow:hidden;">
            <div class="modal-body text-center p-5">
                <div class="don-success-icon">
                    <i class="fa fa-heart"></i>
                </div>
                <h3 style="font-weight:700; color:#2d3436; margin:1rem 0 0.5rem;">Merci pour votre générosité !</h3>
                <p style="color:#636e72; margin-bottom:1.5rem;">Votre don a été reçu avec succès. Vous contribuez au rayonnement du livre africain.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <button type="button" class="btn px-4 py-2" style="background:#f1f3f4; border-radius:12px; font-weight:600;" data-bs-dismiss="modal">Fermer</button>
                    <a href="{{ route('index') }}" class="btn px-4 py-2 text-white" style="background:linear-gradient(135deg,#1e7a2f,#0b5e34); border-radius:12px; font-weight:600;">Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --don-primary: #1e7a2f;
    --don-primary-dark: #155a22;
    --don-primary-light: #e8f5e9;
    --don-secondary: #f39c12;
    --don-text: #2d3436;
    --don-text-muted: #636e72;
    --don-bg: #f8faf9;
    --don-card: #ffffff;
    --don-border: #e9ecef;
    --don-radius: 16px;
    --don-shadow: 0 4px 20px rgba(0,0,0,0.08);
    --don-shadow-hover: 0 8px 30px rgba(0,0,0,0.12);
}

.don-hero {
    background: linear-gradient(135deg, var(--don-primary) 0%, var(--don-primary-dark) 100%);
    padding: 2rem 0 3rem;
    color: white;
    position: relative;
    overflow: hidden;
}
.don-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 60%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
}
.don-breadcrumb {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 2rem;
    font-size: 0.9rem;
    opacity: 0.8;
}
.don-breadcrumb a { color: white; text-decoration: none; }
.don-breadcrumb a:hover { opacity: 0.8; }
.don-hero-main { display: flex; align-items: center; justify-content: space-between; gap: 3rem; flex-wrap: wrap; }
.don-hero-text { flex: 1; min-width: 300px; }
.don-hero-text h1 { font-size: 2.2rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.2; }
.don-hero-text h1 i { margin-right: 0.75rem; opacity: 0.9; }
.don-hero-text p { font-size: 1.1rem; opacity: 0.9; line-height: 1.6; max-width: 550px; }
.don-hero-stats { display: flex; gap: 1.5rem; }
.hero-stat {
    background: rgba(255,255,255,0.15);
    backdrop-filter: blur(10px);
    padding: 1.25rem 1.5rem;
    border-radius: 16px;
    text-align: center;
    min-width: 100px;
    border: 1px solid rgba(255,255,255,0.2);
}
.hero-stat-value { display: block; font-size: 1.5rem; font-weight: 800; }
.hero-stat-label { display: block; font-size: 0.8rem; opacity: 0.8; margin-top: 0.25rem; }

.don-page-container { padding: 3rem 0 4rem; }
.don-section { margin-bottom: 3rem; }
.don-section-header { display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem; }
.don-section-icon {
    width: 50px; height: 50px;
    background: var(--don-primary-light);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: var(--don-primary);
    font-size: 1.2rem;
    flex-shrink: 0;
}
.don-section-text h2 { font-size: 1.4rem; font-weight: 700; color: var(--don-text); margin: 0; }
.don-section-text p { font-size: 0.9rem; color: var(--don-text-muted); margin: 0.25rem 0 0; }

/* Causes */
.don-causes-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
.don-cause-card {
    background: var(--don-card);
    border: 1px solid var(--don-border);
    border-radius: var(--don-radius);
    padding: 2rem;
    transition: all 0.3s ease;
}
.don-cause-card:hover { transform: translateY(-4px); box-shadow: var(--don-shadow-hover); }
.don-cause-icon {
    width: 60px; height: 60px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-size: 1.4rem;
    margin-bottom: 1.25rem;
}
.don-cause-card h3 { font-size: 1.15rem; font-weight: 700; color: var(--don-text); margin-bottom: 0.75rem; }
.don-cause-card p { font-size: 0.9rem; color: var(--don-text-muted); line-height: 1.6; margin: 0; }

/* Formulaire de don */
.don-form-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    border-radius: var(--don-radius);
    overflow: hidden;
    box-shadow: var(--don-shadow);
    border: 1px solid var(--don-border);
}
.don-form-left {
    background: linear-gradient(135deg, var(--don-primary), var(--don-primary-dark));
    color: white;
    padding: 3rem;
    display: flex;
    align-items: center;
}
.don-form-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255,255,255,0.2);
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
}
.don-form-left h2 { font-size: 1.6rem; font-weight: 800; margin-bottom: 1rem; }
.don-form-left p { opacity: 0.9; line-height: 1.7; margin-bottom: 2rem; }
.don-form-features { display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 2rem; }
.don-form-feature {
    display: flex; align-items: center; gap: 0.75rem;
    font-size: 0.9rem; opacity: 0.9;
}
.don-form-feature i { width: 20px; text-align: center; }
.don-payment-methods { display: flex; flex-wrap: wrap; gap: 0.5rem; }
.don-method {
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    background: rgba(255,255,255,0.15);
    border: 1px solid rgba(255,255,255,0.25);
}
.don-form-right {
    background: var(--don-card);
    padding: 2.5rem;
}
.don-form-group { margin-bottom: 1.25rem; }
.don-form-group label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--don-text);
    margin-bottom: 0.5rem;
}
.don-form-group label i { color: var(--don-primary); margin-right: 0.4rem; }
.don-form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--don-border);
    border-radius: 12px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: var(--don-bg);
    outline: none;
}
.don-form-input:focus { border-color: var(--don-primary); background: white; }

.don-amount-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.5rem;
}
.don-amount-btn {
    padding: 0.7rem;
    border: 2px solid var(--don-border);
    border-radius: 12px;
    background: var(--don-bg);
    font-weight: 600;
    font-size: 0.85rem;
    color: var(--don-text);
    cursor: pointer;
    transition: all 0.3s ease;
}
.don-amount-btn:hover { border-color: var(--don-primary); color: var(--don-primary); }
.don-amount-btn.active {
    background: var(--don-primary-light);
    border-color: var(--don-primary);
    color: var(--don-primary);
}
.don-custom-amount { position: relative; }
.don-currency {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-weight: 700;
    color: var(--don-text-muted);
    font-size: 0.9rem;
}
.don-selected-amount {
    text-align: center;
    padding: 0.75rem;
    background: var(--don-primary-light);
    border-radius: 12px;
    font-size: 0.9rem;
    color: var(--don-primary-dark);
    margin-bottom: 1.25rem;
}
.don-selected-amount strong { font-size: 1.1rem; }
.don-submit-btn {
    width: 100%;
    padding: 1rem;
    border: none;
    border-radius: 14px;
    background: linear-gradient(135deg, var(--don-primary), var(--don-primary-dark));
    color: white;
    font-weight: 700;
    font-size: 1.05rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(30,122,47,0.35);
}
.don-submit-btn:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(30,122,47,0.45); }

/* FAQ */
.don-faq-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem; }
.don-faq-card {
    background: var(--don-card);
    border: 1px solid var(--don-border);
    border-radius: var(--don-radius);
    padding: 1.5rem;
    transition: all 0.3s ease;
}
.don-faq-card:hover { box-shadow: var(--don-shadow); }
.don-faq-question {
    display: flex; align-items: center; gap: 0.75rem;
    font-weight: 700; color: var(--don-text);
    margin-bottom: 0.75rem; font-size: 0.95rem;
}
.don-faq-question i { color: var(--don-primary); width: 20px; text-align: center; }
.don-faq-answer { font-size: 0.88rem; color: var(--don-text-muted); line-height: 1.6; margin: 0; }

/* Success icon */
.don-success-icon {
    width: 80px; height: 80px;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 1rem;
    box-shadow: 0 10px 30px rgba(231,76,60,0.3);
    animation: donPulse 0.6s ease;
}
.don-success-icon i { font-size: 2.2rem; color: white; }
@keyframes donPulse {
    0% { transform: scale(0); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}

@media (max-width: 992px) {
    .don-form-wrapper { grid-template-columns: 1fr; }
    .don-form-left { padding: 2rem; }
    .don-form-right { padding: 2rem; }
}
@media (max-width: 768px) {
    .don-hero-main { flex-direction: column; gap: 2rem; }
    .don-hero-stats { width: 100%; justify-content: center; }
    .don-hero-text h1 { font-size: 1.6rem; }
    .don-amount-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 576px) {
    .don-hero-stats { flex-wrap: wrap; }
    .hero-stat { flex: 1; min-width: 80px; padding: 1rem; }
}
</style>

<!-- KKiaPay SDK -->
<script src="https://cdn.kkiapay.me/k.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let selectedAmount = 5000;

    // Sélection des montants prédéfinis
    document.querySelectorAll('.don-amount-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.don-amount-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            selectedAmount = parseInt(this.dataset.amount);
            document.getElementById('customAmount').value = '';
            updateDisplay();
        });
    });

    // Montant libre
    document.getElementById('customAmount').addEventListener('input', function() {
        if (this.value && parseInt(this.value) > 0) {
            document.querySelectorAll('.don-amount-btn').forEach(b => b.classList.remove('active'));
            selectedAmount = parseInt(this.value);
            updateDisplay();
        }
    });

    function updateDisplay() {
        document.getElementById('displayAmount').textContent =
            new Intl.NumberFormat('fr-FR').format(selectedAmount) + ' FCFA';
    }

    // Rendre accessible globalement
    window.getSelectedAmount = function() { return selectedAmount; };
});

function launchDonation() {
    var amount = window.getSelectedAmount();

    if (!amount || amount < 100) {
        alert('Veuillez sélectionner ou saisir un montant (minimum 100 FCFA).');
        return;
    }

    if (typeof openKkiapayWidget !== 'function') {
        alert('Le module de paiement n\'est pas encore chargé. Veuillez patienter ou rafraîchir la page.');
        return;
    }

    // Afficher le spinner
    document.querySelector('.don-btn-text').style.display = 'none';
    document.querySelector('.don-btn-spinner').style.display = 'inline-flex';
    document.getElementById('payDonationBtn').disabled = true;

    openKkiapayWidget({
        amount: amount,
        position: "center",
        data: "donation",
        theme: "#1e7a2f",
        key: "{{ config('services.kkiapay.public_key') }}",
        sandbox: {{ config('services.kkiapay.sandbox') ? 'true' : 'false' }}
    });

    // Réactiver le bouton après 3 secondes
    setTimeout(function() {
        document.querySelector('.don-btn-text').style.display = 'inline-flex';
        document.querySelector('.don-btn-spinner').style.display = 'none';
        document.getElementById('payDonationBtn').disabled = false;
    }, 3000);
}

// Écouter le succès KKiaPay
if (typeof addKkiapayListener === 'function') {
    addKkiapayListener('success', function(response) {
        console.log('Don KKiaPay réussi:', response);

        // Enregistrer le don en base de données
        fetch("{{ route('donation.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                transaction_id: response.transactionId,
                amount: window.getSelectedAmount(),
                donor_name: document.getElementById('donorName') ? document.getElementById('donorName').value : '',
                donor_email: document.getElementById('donorEmail') ? document.getElementById('donorEmail').value : ''
            })
        })
        .then(r => r.json())
        .then(data => console.log('Don enregistré:', data))
        .catch(err => console.error('Erreur enregistrement don:', err));

        // Afficher le modal de succès
        var modal = new bootstrap.Modal(document.getElementById('donSuccessModal'));
        modal.show();
    });

    addKkiapayListener('failed', function(response) {
        console.error('Don KKiaPay échoué:', response);
        alert('Le paiement a échoué. Veuillez réessayer.');
        document.querySelector('.don-btn-text').style.display = 'inline-flex';
        document.querySelector('.don-btn-spinner').style.display = 'none';
        document.getElementById('payDonationBtn').disabled = false;
    });
}
</script>

@endsection
