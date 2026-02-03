@extends('admin.layout')

@section('title', 'Nouvel Administrateur')
@section('subtitle', 'Créer un nouvel administrateur avec permissions personnalisées')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.admins.store') }}" method="POST" id="adminForm">
        @csrf

        <div class="row">
            <!-- Left Column - Info -->
            <div class="col-lg-4">
                <!-- Informations Personnelles -->
                <div class="card border-0 shadow-sm mb-4 sticky-top" style="top: 20px;">
                    <div class="card-header bg-primary bg-opacity-10 border-0">
                        <h5 class="mb-0"><i class="fas fa-user text-primary me-2"></i>Informations Personnelles</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nom complet <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Adresse email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Mot de passe <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                            </div>
                            <small class="text-muted">Min. 8 caractères, avec majuscule, chiffre et caractère spécial</small>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-semibold">Confirmer le mot de passe <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Permissions -->
            <div class="col-lg-8">
                <!-- Rôle & Permissions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning bg-opacity-10 border-0">
                        <h5 class="mb-0"><i class="fas fa-user-tag text-warning me-2"></i>Rôle & Permissions</h5>
                    </div>
                    <div class="card-body">
                        <!-- Type de rôle -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Type de rôle <span class="text-danger">*</span></label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="role_type" id="role_predefined" value="predefined" checked>
                                <label class="btn btn-outline-primary" for="role_predefined">
                                    <i class="fas fa-tag me-2"></i>Rôle Prédéfini
                                </label>

                                <input type="radio" class="btn-check" name="role_type" id="role_custom" value="custom">
                                <label class="btn btn-outline-secondary" for="role_custom">
                                    <i class="fas fa-user-cog me-2"></i>Personnalisé
                                </label>
                            </div>
                        </div>

                        <!-- Rôles prédéfinis -->
                        <div id="predefined-roles" class="role-section">
                            <label class="form-label fw-semibold">Sélectionner un rôle prédéfini</label>
                            <select name="role_id" id="role_select" class="form-select @error('role_id') is-invalid @enderror">
                                <option value="">-- Choisir un rôle --</option>
                                @foreach($roles->where('is_predefined', true) as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                        @if($role->description) - {{ $role->description }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Permissions personnalisées -->
                        <div id="custom-permissions" class="role-section d-none">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label fw-semibold mb-0">Configuration des Permissions</label>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-success" onclick="selectAllPermissions()">
                                        <i class="fas fa-check-double me-1"></i>Tout sélectionner
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="deselectAllPermissions()">
                                        <i class="fas fa-times me-1"></i>Tout désélectionner
                                    </button>
                                </div>
                            </div>

                            @error('permissions')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="permissions-matrix table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 200px;">Module</th>
                                            <th class="text-center" style="width: 80px;">
                                                <i class="fas fa-eye" title="Voir"></i>
                                            </th>
                                            <th class="text-center" style="width: 80px;">
                                                <i class="fas fa-plus" title="Créer"></i>
                                            </th>
                                            <th class="text-center" style="width: 80px;">
                                                <i class="fas fa-edit" title="Modifier"></i>
                                            </th>
                                            <th class="text-center" style="width: 80px;">
                                                <i class="fas fa-trash" title="Supprimer"></i>
                                            </th>
                                            <th class="text-center" style="width: 80px;">
                                                <i class="fas fa-cog" title="Gérer"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $moduleIcons = [
                                                'dashboard' => 'th-large',
                                                'users' => 'users',
                                                'catalogue' => 'book',
                                                'emprunts' => 'book-reader',
                                                'commandes' => 'shopping-cart',
                                                'formations' => 'graduation-cap',
                                                'modules' => 'cubes',
                                                'quizzes' => 'question-circle',
                                                'certifications' => 'award',
                                                'contacts' => 'envelope',
                                                'testimonials' => 'comment-dots',
                                                'blog' => 'newspaper',
                                                'team' => 'users-cog',
                                                'security' => 'shield-alt',
                                            ];
                                        @endphp

                                        @foreach($permissions as $module => $modulePermissions)
                                            <tr>
                                                <td class="fw-semibold">
                                                    <i class="fas fa-{{ $moduleIcons[$module] ?? 'folder' }} text-primary me-2"></i>
                                                    {{ ucfirst($module) }}
                                                </td>
                                                @foreach(['view', 'create', 'update', 'delete', 'manage'] as $action)
                                                    @php
                                                        $permission = $modulePermissions->firstWhere('action', $action);
                                                    @endphp
                                                    <td class="text-center">
                                                        @if($permission)
                                                            <div class="form-check d-inline-block">
                                                                <input class="form-check-input permission-check"
                                                                    type="checkbox"
                                                                    name="permissions[]"
                                                                    value="{{ $permission->id }}"
                                                                    id="perm_{{ $permission->id }}"
                                                                    data-module="{{ $module }}"
                                                                    data-action="{{ $action }}"
                                                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                            </div>
                                                        @else
                                                            <span class="text-muted">—</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Légende:</strong>
                                <i class="fas fa-eye ms-3 me-1"></i> Voir
                                <i class="fas fa-plus ms-2 me-1"></i> Créer
                                <i class="fas fa-edit ms-2 me-1"></i> Modifier
                                <i class="fas fa-trash ms-2 me-1"></i> Supprimer
                                <i class="fas fa-cog ms-2 me-1"></i> Gérer
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Créer l'administrateur
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .permissions-matrix {
        max-height: 600px;
        overflow-y: auto;
    }

    .permissions-matrix .form-check-input {
        cursor: pointer;
        width: 20px;
        height: 20px;
    }

    .role-section {
        transition: all 0.3s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    // Toggle role type
    document.querySelectorAll('input[name="role_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'predefined') {
                document.getElementById('predefined-roles').classList.remove('d-none');
                document.getElementById('custom-permissions').classList.add('d-none');
                document.getElementById('role_select').required = true;
            } else {
                document.getElementById('predefined-roles').classList.add('d-none');
                document.getElementById('custom-permissions').classList.remove('d-none');
                document.getElementById('role_select').required = false;
            }
        });
    });

    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(fieldId + '-icon');

        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Select/Deselect all permissions
    function selectAllPermissions() {
        document.querySelectorAll('.permission-check').forEach(checkbox => {
            checkbox.checked = true;
        });
    }

    function deselectAllPermissions() {
        document.querySelectorAll('.permission-check').forEach(checkbox => {
            checkbox.checked = false;
        });
    }

    // Load role permissions when selecting predefined role
    document.getElementById('role_select')?.addEventListener('change', function() {
        const roleId = this.value;
        if (!roleId) return;

        fetch(`/admin/admins/roles/${roleId}/permissions`)
            .then(response => response.json())
            .then(data => {
                // Show preview or info about role permissions
                console.log('Role permissions:', data.permissions);
            });
    });
</script>
@endpush
@endsection
