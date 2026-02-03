{{-- Modal Utilisateurs --}}
<div class="modal fade" id="usersModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));">
                <h5 class="modal-title text-white">
                    <i class="fas fa-users me-2"></i>Liste des utilisateurs récents
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Utilisateur</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Inscrit le</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                                <tr>
                                    <td>#{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($user->avatar)
                                                <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light)); font-size: 0.75rem; font-weight: 600;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <span class="fw-medium">{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="admin-badge admin-badge-info">{{ $user->role ?? 'utilisateur' }}</span></td>
                                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.users.index') }}" class="btn-admin btn-admin-primary">
                    <i class="fas fa-list me-1"></i>Voir tous les utilisateurs
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Ventes --}}
<div class="modal fade" id="salesModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #10b981, #059669);">
                <h5 class="modal-title text-white">
                    <i class="fas fa-shopping-cart me-2"></i>Détail des ventes
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Livre</th>
                                <th>Client</th>
                                <th>Qté</th>
                                <th>Prix unit.</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSales as $sale)
                                <tr>
                                    <td>#{{ $sale->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($sale->catalogue && $sale->catalogue->image)
                                                <img src="{{ asset($sale->catalogue->image) }}" alt="" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--admin-gray-200);">
                                                    <i class="fas fa-book text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-medium">{{ $sale->catalogue->titre ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $sale->catalogue->auteur ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $sale->user->name ?? 'N/A' }}</td>
                                    <td>{{ $sale->quantite }}</td>
                                    <td>{{ fcfa($sale->catalogue->prix ?? 0) }}</td>
                                    <td class="fw-bold text-success">{{ fcfa(($sale->catalogue->prix ?? 0) * $sale->quantite) }}</td>
                                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.commandes.index') }}" class="btn-admin btn-admin-primary">
                    <i class="fas fa-list me-1"></i>Voir toutes les commandes
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Emprunts --}}
<div class="modal fade" id="empruntsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <h5 class="modal-title text-white">
                    <i class="fas fa-book-reader me-2"></i>Détail des emprunts
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Livre</th>
                                <th>Utilisateur</th>
                                <th>Emprunt</th>
                                <th>Retour</th>
                                <th>Statut</th>
                                <th>Accès</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentEmprunts as $emprunt)
                                <tr>
                                    <td>#{{ $emprunt->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($emprunt->livre && $emprunt->livre->image)
                                                <img src="{{ asset($emprunt->livre->image) }}" alt="" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--admin-gray-200);">
                                                    <i class="fas fa-book text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-medium">{{ $emprunt->livre->titre ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $emprunt->livre->auteur ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $emprunt->user->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($emprunt->statut) {
                                                'en_cours' => 'success',
                                                'en_attente' => 'warning',
                                                'en_retard' => 'danger',
                                                'retourne' => 'secondary',
                                                default => 'info'
                                            };
                                        @endphp
                                        <span class="admin-badge admin-badge-{{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $emprunt->statut)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($emprunt->access_expires_at)
                                            @if(now()->greaterThan($emprunt->access_expires_at))
                                                <span class="admin-badge admin-badge-danger">Expiré</span>
                                            @else
                                                <span class="text-success small">{{ $emprunt->access_expires_at->diffForHumans() }}</span>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admin.emprunts.index') }}" class="btn-admin btn-admin-primary">
                    <i class="fas fa-list me-1"></i>Voir tous les emprunts
                </a>
            </div>
        </div>
    </div>
</div>

{{-- Modal Accès Expirés --}}
@if($empruntsAccesExpire->isNotEmpty())
<div class="modal fade" id="expiredAccessModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>Accès PDF expirés ({{ $empruntsAccesExpire->count() }})
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info d-flex align-items-center gap-2 mb-4">
                    <i class="fas fa-info-circle"></i>
                    <span>Ces utilisateurs ont dépassé leur période d'accès de 14 jours. Vous pouvez prolonger leur accès.</span>
                </div>
                <div class="admin-table-wrapper">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Utilisateur</th>
                                <th>Livre</th>
                                <th>Validé le</th>
                                <th>Expiré le</th>
                                <th>Depuis</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empruntsAccesExpire as $emprunt)
                                <tr>
                                    <td>#{{ $emprunt->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white" style="width: 32px; height: 32px; background: linear-gradient(135deg, #ef4444, #dc2626); font-size: 0.75rem; font-weight: 600;">
                                                {{ strtoupper(substr($emprunt->user->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $emprunt->user->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $emprunt->user->email ?? '' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            @if($emprunt->livre && $emprunt->livre->image)
                                                <img src="{{ asset($emprunt->livre->image) }}" alt="" class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: var(--admin-gray-200);">
                                                    <i class="fas fa-book text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="fw-medium">{{ $emprunt->livre->titre ?? 'N/A' }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $emprunt->valide_le ? $emprunt->valide_le->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ $emprunt->access_expires_at ? $emprunt->access_expires_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <span class="admin-badge admin-badge-danger">
                                            {{ $emprunt->access_expires_at->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.emprunts.renew-access', $emprunt->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-admin btn-admin-sm btn-admin-primary">
                                                <i class="fas fa-redo me-1"></i>+14j
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endif
