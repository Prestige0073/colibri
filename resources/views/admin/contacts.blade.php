@extends('admin.layout')

@section('title', 'Messages de contact')
@section('subtitle', 'Gestion des messages reçus via le formulaire de contact')

@section('content')
@php
    $readCount = $contacts->total() - $unreadCount;
@endphp

<!-- Page Header -->
<div class="admin-page-header">
    <div class="admin-page-header-content">
        <div class="admin-page-icon">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="admin-page-info">
            <h1>Messages de contact</h1>
            <p>Gestion des messages reçus via le formulaire de contact</p>
        </div>
    </div>
    <div class="admin-page-actions">
        @if($unreadCount > 0)
            <span class="admin-badge admin-badge-danger admin-badge-lg">
                <i class="fas fa-bell"></i> {{ $unreadCount }} non lu{{ $unreadCount > 1 ? 's' : '' }}
            </span>
        @endif
    </div>
</div>

<!-- Stats Cards -->
<div class="admin-stats-row">
    <div class="admin-stat-card admin-stat-danger">
        <div class="admin-stat-icon">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $unreadCount }}</span>
            <span class="admin-stat-label">Non lus</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-success">
        <div class="admin-stat-icon">
            <i class="fas fa-envelope-open"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $readCount }}</span>
            <span class="admin-stat-label">Lus</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-primary">
        <div class="admin-stat-icon">
            <i class="fas fa-inbox"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $contacts->total() }}</span>
            <span class="admin-stat-label">Total messages</span>
        </div>
    </div>
</div>

<!-- Messages List -->
@if($contacts->isEmpty())
    <div class="admin-empty-state">
        <div class="admin-empty-icon">
            <i class="fas fa-inbox"></i>
        </div>
        <h3>Aucun message</h3>
        <p>Les messages des visiteurs apparaîtront ici.</p>
    </div>
@else
    <div class="admin-card">
        <div class="admin-card-body p-0">
            <!-- Messages Grid -->
            <div class="messages-list">
                @foreach($contacts as $contact)
                    <div class="message-item {{ !$contact->is_read ? 'message-unread' : '' }}">
                        <div class="message-status">
                            @if(!$contact->is_read)
                                <span class="status-dot status-unread" title="Non lu"></span>
                            @else
                                <span class="status-dot status-read" title="Lu"></span>
                            @endif
                        </div>

                        <div class="message-avatar">
                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                        </div>

                        <div class="message-content">
                            <div class="message-header">
                                <div class="message-sender">
                                    <span class="sender-name">{{ $contact->name }}</span>
                                    @if(!$contact->is_read)
                                        <span class="admin-badge admin-badge-danger admin-badge-sm">Nouveau</span>
                                    @endif
                                </div>
                                <div class="message-date">
                                    <i class="fas fa-clock"></i>
                                    {{ $contact->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <div class="message-email">
                                <a href="mailto:{{ $contact->email }}">
                                    <i class="fas fa-envelope"></i> {{ $contact->email }}
                                </a>
                            </div>

                            <div class="message-subject">
                                {{ $contact->subject }}
                            </div>

                            <div class="message-preview">
                                {{ Str::limit($contact->message, 120) }}
                            </div>
                        </div>

                        <div class="message-actions">
                            <a href="{{ route('admin.contacts.show', $contact->id) }}"
                               class="btn-admin btn-admin-primary btn-admin-sm"
                               title="Voir le message">
                                <i class="fas fa-eye"></i>
                            </a>

                            <form action="{{ route('admin.contacts.toggleRead', $contact->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="btn-admin btn-admin-{{ $contact->is_read ? 'warning' : 'success' }} btn-admin-sm"
                                        title="{{ $contact->is_read ? 'Marquer non lu' : 'Marquer lu' }}">
                                    <i class="fas fa-{{ $contact->is_read ? 'envelope' : 'check' }}"></i>
                                </button>
                            </form>

                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}"
                               class="btn-admin btn-admin-info btn-admin-sm"
                               title="Répondre">
                                <i class="fas fa-reply"></i>
                            </a>

                            <button type="button"
                                    class="btn-admin btn-admin-danger btn-admin-sm btn-delete-message"
                                    data-message-id="{{ $contact->id }}"
                                    data-message-name="{{ $contact->name }}"
                                    data-message-subject="{{ $contact->subject }}"
                                    title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if($contacts->hasPages())
            <div class="admin-card-footer">
                <div class="admin-pagination-wrapper">
                    {{ $contacts->links() }}
                </div>
            </div>
        @endif
    </div>
@endif

<!-- Delete Modal -->
<div class="modal fade" id="deleteMessageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content admin-modal">
            <div class="modal-header admin-modal-header admin-modal-header-danger">
                <h5 class="modal-title">
                    <i class="fas fa-trash"></i> Supprimer le message
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="admin-alert admin-alert-warning mb-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    Cette action est irréversible.
                </div>
                <p>Êtes-vous sûr de vouloir supprimer ce message ?</p>
                <div id="deleteMessageContent" class="admin-modal-info-card"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteMessageForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-admin btn-admin-danger">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Page Header */
    .admin-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .admin-page-header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .admin-page-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(30, 122, 47, 0.3);
    }

    .admin-page-info h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: var(--admin-gray-900);
    }

    .admin-page-info p {
        font-size: 0.875rem;
        color: var(--admin-gray-500);
        margin: 0;
    }

    /* Stats Row */
    .admin-stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .admin-stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-left: 4px solid;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .admin-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .admin-stat-card.admin-stat-danger { border-color: #ef4444; }
    .admin-stat-card.admin-stat-success { border-color: #10b981; }
    .admin-stat-card.admin-stat-primary { border-color: var(--admin-primary); }

    .admin-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .admin-stat-danger .admin-stat-icon { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
    .admin-stat-success .admin-stat-icon { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .admin-stat-primary .admin-stat-icon { background: rgba(30, 122, 47, 0.1); color: var(--admin-primary); }

    .admin-stat-content {
        display: flex;
        flex-direction: column;
    }

    .admin-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--admin-gray-900);
        line-height: 1.2;
    }

    .admin-stat-label {
        font-size: 0.8rem;
        color: var(--admin-gray-500);
    }

    /* Badge lg */
    .admin-badge-lg {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    /* Empty State */
    .admin-empty-state {
        background: white;
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .admin-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--admin-gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: var(--admin-gray-400);
    }

    .admin-empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--admin-gray-700);
        margin-bottom: 0.5rem;
    }

    .admin-empty-state p {
        color: var(--admin-gray-500);
        margin: 0;
    }

    /* Messages List */
    .messages-list {
        display: flex;
        flex-direction: column;
    }

    .message-item {
        display: grid;
        grid-template-columns: 24px 48px 1fr auto;
        gap: 1rem;
        padding: 1.25rem;
        border-bottom: 1px solid var(--admin-gray-200);
        align-items: start;
        transition: background 0.2s;
    }

    .message-item:last-child {
        border-bottom: none;
    }

    .message-item:hover {
        background: var(--admin-gray-50);
    }

    .message-item.message-unread {
        background: linear-gradient(90deg, rgba(239, 68, 68, 0.05) 0%, transparent 100%);
    }

    .message-item.message-unread:hover {
        background: linear-gradient(90deg, rgba(239, 68, 68, 0.08) 0%, var(--admin-gray-50) 100%);
    }

    /* Status Dot */
    .message-status {
        padding-top: 0.5rem;
    }

    .status-dot {
        display: block;
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    .status-dot.status-unread {
        background: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
        animation: pulse 2s infinite;
    }

    .status-dot.status-read {
        background: var(--admin-gray-300);
    }

    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2); }
        50% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0.1); }
    }

    /* Message Avatar */
    .message-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    /* Message Content */
    .message-content {
        min-width: 0;
    }

    .message-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 0.25rem;
    }

    .message-sender {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .sender-name {
        font-weight: 600;
        color: var(--admin-gray-900);
        font-size: 0.95rem;
    }

    .message-date {
        font-size: 0.75rem;
        color: var(--admin-gray-500);
        white-space: nowrap;
    }

    .message-date i {
        margin-right: 0.25rem;
    }

    .message-email {
        margin-bottom: 0.5rem;
    }

    .message-email a {
        font-size: 0.8rem;
        color: var(--admin-primary);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .message-email a:hover {
        text-decoration: underline;
    }

    .message-subject {
        font-weight: 600;
        color: var(--admin-gray-800);
        font-size: 0.9rem;
        margin-bottom: 0.375rem;
    }

    .message-preview {
        font-size: 0.85rem;
        color: var(--admin-gray-600);
        line-height: 1.5;
    }

    /* Message Actions */
    .message-actions {
        display: flex;
        gap: 0.375rem;
        flex-shrink: 0;
    }

    /* Alert */
    .admin-alert {
        padding: 1rem;
        border-radius: 8px;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        font-size: 0.875rem;
    }

    .admin-alert-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #b45309;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    /* Modal */
    .admin-modal .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .admin-modal-header {
        padding: 1rem 1.25rem;
        border: none;
    }

    .admin-modal-header .modal-title {
        color: white;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .admin-modal-header-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .admin-modal-info-card {
        background: var(--admin-gray-50);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
    }

    .admin-modal-info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--admin-gray-200);
    }

    .admin-modal-info-item:last-child {
        border-bottom: none;
    }

    .admin-modal-info-item i {
        width: 20px;
        color: var(--admin-primary);
    }

    /* Card Footer */
    .admin-card-footer {
        padding: 1rem 1.25rem;
        background: var(--admin-gray-50);
        border-top: 1px solid var(--admin-gray-200);
    }

    .admin-pagination-wrapper {
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .message-item {
            grid-template-columns: 24px 40px 1fr;
            grid-template-rows: auto auto;
        }

        .message-actions {
            grid-column: 3;
            margin-top: 0.75rem;
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            font-size: 0.95rem;
        }
    }

    @media (max-width: 768px) {
        .admin-page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .message-item {
            grid-template-columns: 1fr;
            gap: 0.75rem;
            padding: 1rem;
        }

        .message-status {
            display: none;
        }

        .message-avatar {
            display: none;
        }

        .message-header {
            flex-direction: column;
            gap: 0.25rem;
        }

        .message-actions {
            justify-content: flex-start;
            flex-wrap: wrap;
        }
    }

    @media (max-width: 576px) {
        .admin-stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteMessageModal'));

    document.querySelectorAll('.btn-delete-message').forEach(btn => {
        btn.addEventListener('click', function() {
            const messageId = this.dataset.messageId;
            const messageName = this.dataset.messageName;
            const messageSubject = this.dataset.messageSubject;

            document.getElementById('deleteMessageContent').innerHTML = `
                <div class="admin-modal-info-item">
                    <i class="fas fa-user"></i>
                    <strong>${messageName}</strong>
                </div>
                <div class="admin-modal-info-item">
                    <i class="fas fa-tag"></i>
                    ${messageSubject}
                </div>
            `;

            document.getElementById('deleteMessageForm').action = '/admin/contacts/' + messageId;
            deleteModal.show();
        });
    });
});
</script>
@endpush
