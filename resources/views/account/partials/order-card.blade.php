@php
    $rawStatus = strtolower($order->statut ?? 'pending');
    $statusLabel = $order->statut_label ?? ucfirst($rawStatus);
    $isOnline = $order->isOnlinePayment();
    $isCOD = $order->isCOD();

    $statusConfig = [
        // Achat en ligne
        'paid' => [
            'class' => 'status-paid',
            'icon' => 'fa-check-circle',
            'color' => '#27ae60',
            'bg' => '#d4edda'
        ],
        // Commande COD
        'pending' => [
            'class' => 'status-pending',
            'icon' => 'fa-clock',
            'color' => '#f39c12',
            'bg' => '#fff8e6'
        ],
        'en_preparation' => [
            'class' => 'status-preparation',
            'icon' => 'fa-box-open',
            'color' => '#3498db',
            'bg' => '#e3f2fd'
        ],
        'en_livraison' => [
            'class' => 'status-shipping',
            'icon' => 'fa-truck',
            'color' => '#9b59b6',
            'bg' => '#f3e5f5'
        ],
        'livre' => [
            'class' => 'status-delivered',
            'icon' => 'fa-check-double',
            'color' => '#1e8449',
            'bg' => '#d5f4e6'
        ],
        'livree' => [
            'class' => 'status-delivered',
            'icon' => 'fa-check-double',
            'color' => '#1e8449',
            'bg' => '#d5f4e6'
        ],
        'annule' => [
            'class' => 'status-cancelled',
            'icon' => 'fa-times-circle',
            'color' => '#e74c3c',
            'bg' => '#fadbd8'
        ],
        // Rétrocompatibilité
        'confirmed' => [
            'class' => 'status-paid',
            'icon' => 'fa-check-circle',
            'color' => '#27ae60',
            'bg' => '#d4edda'
        ],
    ];

    $config = $statusConfig[$rawStatus] ?? $statusConfig['pending'];
    $isDelivered = in_array($rawStatus, ['livre', 'livree']);
@endphp

<div class="order-card {{ $isRecentlyPaid ? 'order-card-highlight' : '' }} {{ $isDelivered ? 'order-card-delivered' : '' }}">
    @if($isRecentlyPaid)
        <div class="order-new-badge">
            <i class="fa fa-star"></i> Nouveau
        </div>
    @endif

    <div class="order-card-header">
        <div class="order-info">
            <div class="order-number">
                @if($isOnline)
                    <i class="fa fa-shopping-bag"></i>
                    Achat #{{ $order->id }}
                @else
                    <i class="fa fa-truck"></i>
                    Commande #{{ $order->id }}
                @endif
            </div>
            <div class="order-date">
                <i class="fa fa-calendar-alt"></i>
                {{ $order->created_at->format('d/m/Y') }}
                <span class="order-time">{{ $order->created_at->format('H:i') }}</span>
            </div>
        </div>

        <div class="order-status {{ $config['class'] }}" style="--status-color: {{ $config['color'] }}; --status-bg: {{ $config['bg'] }}">
            <i class="fa {{ $config['icon'] }}"></i>
            <span>{{ $statusLabel }}</span>
        </div>
    </div>

    <div class="order-card-body">
        <div class="order-items">
            @foreach($order->items->take(3) as $item)
                <div class="order-item">
                    <div class="item-icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <div class="item-details">
                        <span class="item-title">{{ \Illuminate\Support\Str::limit($item->titre ?? 'Article', 40) }}</span>
                        <span class="item-meta">
                            <span class="item-qty">x{{ $item->quantite }}</span>
                            <span class="item-price">{{ fcfa($item->prix * $item->quantite) }}</span>
                        </span>
                    </div>
                </div>
            @endforeach

            @if($order->items->count() > 3)
                <div class="order-items-more">
                    <i class="fa fa-ellipsis-h"></i>
                    +{{ $order->items->count() - 3 }} autre(s) article(s)
                </div>
            @endif
        </div>

        <div class="order-summary">
            <div class="order-total">
                <span class="total-label">Total</span>
                <span class="total-amount">{{ fcfa($order->total) }}</span>
            </div>

            @if($order->paiement_valide)
                <div class="payment-badge payment-paid">
                    <i class="fa fa-check-circle"></i> Payé
                </div>
            @else
                <div class="payment-badge payment-pending">
                    <i class="fa fa-clock"></i> En attente
                </div>
            @endif
        </div>
    </div>

    <div class="order-card-footer">
        @if($isOnline && $order->paiement_valide)
            <a href="{{ route('account.bibliotheque') }}" class="order-btn order-btn-library">
                <i class="fa fa-book-open"></i>
                <span>Ma bibliothèque</span>
            </a>
        @endif

        <a href="{{ route('commandes.show', $order->id) }}" class="order-btn order-btn-primary">
            <i class="fa fa-eye"></i>
            <span>Voir détails</span>
        </a>

        <div class="order-quick-actions">
            <a href="https://wa.me/2290166547808?text={{ urlencode('Bonjour, je souhaite des informations sur ma commande #' . $order->id) }}"
               target="_blank"
               class="order-btn order-btn-whatsapp"
               title="Contacter via WhatsApp">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="mailto:colibrilitteraire@gmail.com?subject={{ urlencode('Commande #' . $order->id) }}"
               class="order-btn order-btn-email"
               title="Envoyer un email">
                <i class="fa fa-envelope"></i>
            </a>
        </div>
    </div>
</div>

<style>
    /* Order Card Styles */
    .order-card {
        background: var(--orders-card, #ffffff);
        border-radius: var(--orders-radius, 16px);
        box-shadow: var(--orders-shadow, 0 4px 20px rgba(0,0,0,0.08));
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .order-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .order-card-highlight {
        border: 2px solid var(--orders-success, #27ae60);
        animation: highlightPulse 2s ease-in-out 3;
    }

    @keyframes highlightPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(39, 174, 96, 0.4); }
        50% { box-shadow: 0 0 0 10px rgba(39, 174, 96, 0); }
    }

    .order-card-delivered {
        opacity: 0.9;
    }

    .order-new-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        padding: 0.35rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        z-index: 10;
        animation: badgeBounce 0.5s ease;
    }

    @keyframes badgeBounce {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }

    /* Header */
    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--orders-border, #e9ecef);
        background: linear-gradient(to right, #fafbfc, #ffffff);
    }

    .order-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .order-number {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--orders-text, #2d3436);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .order-number i {
        color: var(--orders-primary, #1e7a2f);
    }

    .order-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--orders-text-muted, #636e72);
        font-size: 0.85rem;
    }

    .order-date i {
        opacity: 0.7;
    }

    .order-time {
        opacity: 0.6;
    }

    .order-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        background: var(--status-bg);
        color: var(--status-color);
        border: 1px solid var(--status-color);
        opacity: 0.9;
    }

    .order-status i {
        font-size: 0.9rem;
    }

    /* Body */
    .order-card-body {
        padding: 1.25rem 1.5rem;
        display: flex;
        gap: 1.5rem;
        text-align: left;
    }

    .order-items {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .order-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .item-icon {
        width: 36px;
        height: 36px;
        background: var(--orders-primary-light, #e8f5e9);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .item-icon i {
        color: var(--orders-primary, #1e7a2f);
        font-size: 0.9rem;
    }

    .item-details {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.15rem;
        min-width: 0;
    }

    .item-title {
        color: var(--orders-text, #2d3436);
        font-size: 0.9rem;
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.8rem;
    }

    .item-qty {
        background: #f0f0f0;
        padding: 0.1rem 0.4rem;
        border-radius: 4px;
        color: var(--orders-text-muted, #636e72);
    }

    .item-price {
        color: var(--orders-text-muted, #636e72);
        font-weight: 500;
    }

    .order-items-more {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        text-align: left;
        gap: 0.5rem;
        color: var(--orders-text-muted, #636e72);
        font-size: 0.85rem;
        font-style: italic;
        padding-left: 2.75rem;
    }

    .order-summary {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.75rem;
        padding-left: 1.5rem;
        border-left: 1px solid var(--orders-border, #e9ecef);
        min-width: 120px;
    }

    .order-total {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .total-label {
        font-size: 0.75rem;
        color: var(--orders-text-muted, #636e72);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .total-amount {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--orders-primary, #1e7a2f);
    }

    .payment-badge {
        display: flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .payment-paid {
        background: #d4edda;
        color: #155724;
    }

    .payment-pending {
        background: #fff3cd;
        color: #856404;
    }

    /* Footer */
    .order-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        border-top: 1px solid var(--orders-border, #e9ecef);
    }

    .order-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.6rem 1.25rem;
        border-radius: 8px;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .order-btn-primary {
        background: linear-gradient(135deg, var(--orders-primary, #1e7a2f) 0%, #155a22 100%);
        color: white;
    }

    .order-btn-primary:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 122, 47, 0.3);
    }

    .order-btn-library {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
    }

    .order-btn-library:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    }

    .order-quick-actions {
        display: flex;
        gap: 0.5rem;
    }

    .order-btn-whatsapp,
    .order-btn-email {
        width: 40px;
        height: 40px;
        padding: 0;
        border-radius: 50%;
    }

    .order-btn-whatsapp {
        background: #25D366;
        color: white;
    }

    .order-btn-whatsapp:hover {
        background: #1da851;
        color: white;
        transform: scale(1.1);
    }

    .order-btn-email {
        background: #6c757d;
        color: white;
    }

    .order-btn-email:hover {
        background: #545b62;
        color: white;
        transform: scale(1.1);
    }

    /* Responsive */
    @media (max-width: 767px) {
        .order-card-header {
            flex-direction: column;
            gap: 1rem;
            padding: 1rem;
        }

        .order-status {
            align-self: flex-start;
        }

        .order-new-badge {
            top: 8px;
            right: 8px;
        }

        .order-card-body {
            flex-direction: column;
            padding: 1rem;
        }

        .order-summary {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            border-left: none;
            border-top: 1px dashed var(--orders-border, #e9ecef);
            padding-left: 0;
            padding-top: 1rem;
            margin-top: 0.5rem;
        }

        .order-total {
            align-items: flex-start;
        }

        .order-card-footer {
            flex-direction: column;
            gap: 1rem;
            padding: 1rem;
        }

        .order-btn-primary {
            width: 100%;
        }

        .order-quick-actions {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 575px) {
        .order-number {
            font-size: 1rem;
        }

        .item-icon {
            width: 32px;
            height: 32px;
        }

        .item-title {
            font-size: 0.85rem;
        }

        .total-amount {
            font-size: 1.1rem;
        }
    }
</style>
