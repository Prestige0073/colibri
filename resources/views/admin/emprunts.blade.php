@extends('admin.layout')
@section('title', 'Admin - Gestion des Emprunts')

@section('content')
<div class="container-fluid py-4">
    <!-- Toast notification -->
    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 1.5rem; right: 1.5rem; min-width: 320px; z-index: 1080; pointer-events: none;">
        @if (session('success'))
            <div id="toast-success" class="toast align-items-center border-0 shadow-lg show animate__animated animate__slideInDown"
                role="alert" aria-live="assertive" aria-atomic="true" style="pointer-events:auto; background:#1bc47d; color:#fff; font-weight:500;">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div id="toast-error" class="toast align-items-center border-0 shadow-lg show animate__animated animate__slideInDown"
                role="alert" aria-live="assertive" aria-atomic="true" style="pointer-events:auto; background:#e53935; color:#fff; font-weight:500;">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Fermer"></button>
                </div>
            </div>
        @endif
    </div>

    <h2 class="mb-4"><i class="fa fa-book-reader me-2 text-primary"></i>Gestion des Emprunts</h2>

    <!-- Section 1: Liste des livres empruntables -->
    <div class="card shadow border-0 mb-5">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h4 class="mb-0 fw-bold text-white"><i class="fa fa-books me-2"></i>Livres disponibles à l'emprunt</h4>
        </div>
        <div class="card-body">
            @if($livresEmpruntables->isEmpty())
                <p class="text-muted text-center">Aucun livre empruntable enregistré. Ajoutez-en via le formulaire ci-dessous.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th><i class="fa fa-image"></i></th>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Catégorie</th>
                                <th>Prix</th>
                                <th>Stock</th>
                                <th>Statut</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($livresEmpruntables as $livre)
                                <tr>
                                    <td>
                                        @if($livre->image)
                                            <img src="{{ asset($livre->image) }}" alt="{{ $livre->titre }}" class="img-thumbnail" style="width: 50px; height: 70px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 70px;">
                                                <i class="fa fa-book"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $livre->titre }}</strong></td>
                                    <td>{{ $livre->auteur }}</td>
                                    <td><span class="badge bg-info">{{ $livre->categorie }}</span></td>
                                    <td>{{ number_format($livre->prix, 0, ',', ' ') }} FCFA</td>
                                    <td><span class="badge {{ $livre->quantite > 0 ? 'bg-success' : 'bg-danger' }}">{{ $livre->quantite }}</span></td>
                                    <td>
                                        @if($livre->quantite > 0)
                                            <span class="badge bg-success">Disponible</span>
                                        @else
                                            <span class="badge bg-danger">Épuisé</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editLivreModal{{ $livre->id }}" title="Modifier">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteLivreModal{{ $livre->id }}" title="Supprimer">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal de modification -->
                                <div class="modal fade" id="editLivreModal{{ $livre->id }}" tabindex="-1" aria-labelledby="editLivreModalLabel{{ $livre->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-warning text-dark">
                                                <h5 class="modal-title" id="editLivreModalLabel{{ $livre->id }}">
                                                    <i class="fa fa-edit me-2"></i>Modifier le livre: {{ $livre->titre }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.emprunts.update', $livre->id) }}" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label for="edit_titre_{{ $livre->id }}" class="form-label fw-bold">Titre</label>
                                                            <input type="text" class="form-control" id="edit_titre_{{ $livre->id }}" name="titre" value="{{ $livre->titre }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="edit_auteur_{{ $livre->id }}" class="form-label fw-bold">Auteur</label>
                                                            <input type="text" class="form-control" id="edit_auteur_{{ $livre->id }}" name="auteur" value="{{ $livre->auteur }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="edit_categorie_{{ $livre->id }}" class="form-label fw-bold">Catégorie</label>
                                                            <input type="text" class="form-control" id="edit_categorie_{{ $livre->id }}" name="categorie" value="{{ $livre->categorie }}" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="edit_prix_{{ $livre->id }}" class="form-label fw-bold">Prix (FCFA)</label>
                                                            <input type="number" class="form-control" id="edit_prix_{{ $livre->id }}" name="prix" value="{{ $livre->prix }}" min="0" required>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label for="edit_quantite_{{ $livre->id }}" class="form-label fw-bold">Stock</label>
                                                            <input type="number" class="form-control" id="edit_quantite_{{ $livre->id }}" name="quantite" value="{{ $livre->quantite }}" min="0" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="edit_resumer_{{ $livre->id }}" class="form-label fw-bold">Résumé</label>
                                                            <textarea class="form-control" id="edit_resumer_{{ $livre->id }}" name="resumer" rows="3">{{ $livre->resumer }}</textarea>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="edit_image_{{ $livre->id }}" class="form-label fw-bold">Image (optionnel)</label>
                                                            <input type="file" class="form-control" id="edit_image_{{ $livre->id }}" name="image" accept="image/*">
                                                            @if($livre->image)
                                                                <small class="text-muted">Image actuelle: <img src="{{ asset($livre->image) }}" alt="Image" style="height: 30px;"></small>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="edit_pdf_{{ $livre->id }}" class="form-label fw-bold">PDF (optionnel)</label>
                                                            <input type="file" class="form-control" id="edit_pdf_{{ $livre->id }}" name="pdf" accept="application/pdf">
                                                            @if($livre->pdf)
                                                                <small class="text-muted">PDF actuel disponible</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-warning">
                                                        <i class="fa fa-save me-2"></i>Enregistrer les modifications
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal de suppression -->
                                <div class="modal fade" id="deleteLivreModal{{ $livre->id }}" tabindex="-1" aria-labelledby="deleteLivreModalLabel{{ $livre->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title text-white" id="deleteLivreModalLabel{{ $livre->id }}">
                                                    <i class="fa fa-exclamation-triangle me-2"></i>Confirmer la suppression
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                                    <i class="fa fa-exclamation-circle me-2 fs-4"></i>
                                                    <div>
                                                        <strong>Attention !</strong> Cette action est irréversible.
                                                    </div>
                                                </div>

                                                <p class="mb-3">Êtes-vous sûr de vouloir supprimer ce livre empruntable ?</p>

                                                <div class="card border-0 bg-light p-3 mb-3">
                                                    <div class="row g-2">
                                                        <div class="col-3">
                                                            @if($livre->image)
                                                                <img src="{{ asset($livre->image) }}" alt="{{ $livre->titre }}" class="img-fluid rounded" style="max-height: 100px; object-fit: cover;">
                                                            @else
                                                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="height: 100px;">
                                                                    <i class="fa fa-book fs-3"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-9">
                                                            <h6 class="fw-bold mb-2"><i class="fa fa-book text-primary me-1"></i> {{ $livre->titre }}</h6>
                                                            <p class="mb-1 small"><strong>Auteur :</strong> {{ $livre->auteur }}</p>
                                                            <p class="mb-1 small"><strong>Catégorie :</strong> <span class="badge bg-info">{{ $livre->categorie }}</span></p>
                                                            <p class="mb-1 small"><strong>Prix :</strong> {{ number_format($livre->prix, 0, ',', ' ') }} FCFA</p>
                                                            <p class="mb-0 small"><strong>Stock disponible :</strong> <span class="badge {{ $livre->quantite > 0 ? 'bg-success' : 'bg-danger' }}">{{ $livre->quantite }}</span></p>
                                                        </div>
                                                    </div>
                                                </div>

                                                @php
                                                    $empruntsEnCours = \App\Models\Emprunt::where('livre_id', $livre->id)
                                                        ->whereIn('statut', ['en_cours', 'en_retard'])
                                                        ->count();
                                                @endphp

                                                @if($empruntsEnCours > 0)
                                                    <div class="alert alert-danger" role="alert">
                                                        <i class="fa fa-times-circle me-2"></i>
                                                        <strong>Impossible de supprimer :</strong> Ce livre a actuellement <strong>{{ $empruntsEnCours }}</strong> emprunt(s) en cours ou en retard.
                                                    </div>
                                                @else
                                                    <div class="alert alert-success" role="alert">
                                                        <i class="fa fa-check-circle me-2"></i>
                                                        Aucun emprunt en cours. La suppression est possible.
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fa fa-times me-1"></i>Annuler
                                                </button>
                                                @if($empruntsEnCours == 0)
                                                    <form method="POST" action="{{ route('admin.emprunts.destroy', $livre->id) }}" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fa fa-trash me-1"></i>Supprimer définitivement
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Section 2: Formulaire d'ajout de livre empruntable -->
    <div class="card shadow border-0 mb-5">
        <div class="card-header bg-success text-white rounded-top-4">
            <h4 class="mb-0 fw-bold text-white"><i class="fa fa-plus-circle me-2"></i>Ajouter un Livre Empruntable</h4>
        </div>
        <div class="card-body bg-light">
            <form method="POST" action="{{ route('admin.emprunts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="titre" class="form-label fw-bold"><i class="fa fa-book me-1 text-primary"></i> Titre</label>
                        <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="auteur" class="form-label fw-bold"><i class="fa fa-user-pen me-1 text-primary"></i> Auteur</label>
                        <input type="text" class="form-control @error('auteur') is-invalid @enderror" id="auteur" name="auteur" value="{{ old('auteur') }}" required>
                        @error('auteur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="categorie" class="form-label fw-bold"><i class="fa fa-tags me-1 text-primary"></i> Catégorie</label>
                        <select class="form-select @error('categorie') is-invalid @enderror" id="categorie" name="categorie" required>
                            <option value="">Choisir...</option>
                            <option value="Roman" {{ old('categorie') == 'Roman' ? 'selected' : '' }}>Roman</option>
                            <option value="Essai" {{ old('categorie') == 'Essai' ? 'selected' : '' }}>Essai</option>
                            <option value="Jeunesse" {{ old('categorie') == 'Jeunesse' ? 'selected' : '' }}>Jeunesse</option>
                            <option value="Poésie" {{ old('categorie') == 'Poésie' ? 'selected' : '' }}>Poésie</option>
                            <option value="Théâtre" {{ old('categorie') == 'Théâtre' ? 'selected' : '' }}>Théâtre</option>
                            <option value="Biographie" {{ old('categorie') == 'Biographie' ? 'selected' : '' }}>Biographie</option>
                            <option value="Conte" {{ old('categorie') == 'Conte' ? 'selected' : '' }}>Conte</option>
                            <option value="Documentaire" {{ old('categorie') == 'Documentaire' ? 'selected' : '' }}>Documentaire</option>
                            <option value="Autre" {{ old('categorie') == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('categorie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="prix" class="form-label fw-bold"><i class="fa fa-money-bill-wave me-1 text-primary"></i> Prix (FCFA)</label>
                        <input type="number" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', 0) }}" min="0" required>
                        @error('prix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="quantite" class="form-label fw-bold"><i class="fa fa-box me-1 text-primary"></i> Quantité</label>
                        <input type="number" class="form-control @error('quantite') is-invalid @enderror" id="quantite" name="quantite" value="{{ old('quantite', 1) }}" min="0" required>
                        @error('quantite')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-12">
                        <label for="resumer" class="form-label fw-bold"><i class="fa fa-align-left me-1 text-primary"></i> Résumé</label>
                        <textarea class="form-control @error('resumer') is-invalid @enderror" id="resumer" name="resumer" rows="4">{{ old('resumer') }}</textarea>
                        @error('resumer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label for="image" class="form-label fw-bold"><i class="fa fa-image me-1 text-primary"></i> Image de couverture</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        <small class="text-muted">Formats: JPEG, PNG, JPG, GIF, WEBP (max 2MB)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="pdf" class="form-label fw-bold"><i class="fa fa-file-pdf me-1 text-danger"></i> Fichier PDF</label>
                        <input type="file" class="form-control @error('pdf') is-invalid @enderror" id="pdf" name="pdf" accept="application/pdf">
                        <small class="text-muted">Format: PDF (max 10MB)</small>
                        @error('pdf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-success px-4 py-2 fw-bold">
                        <i class="fa fa-plus me-1"></i> Ajouter le Livre
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Section 3: Liste des emprunts actifs -->
    <div class="card shadow border-0 mb-5">
        <div class="card-header bg-info text-white rounded-top-4">
            <h4 class="mb-0 fw-bold text-white"><i class="fa fa-list me-2"></i>Emprunts Enregistrés</h4>
        </div>
        <div class="card-body">
            @if($emprunts->isEmpty())
                <p class="text-muted text-center">Aucun emprunt enregistré.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-info">
                            <tr>
                                <th>#</th>
                                <th><i class="fa fa-user"></i> Utilisateur</th>
                                <th><i class="fa fa-book"></i> Livre</th>
                                <th><i class="fa fa-calendar-day"></i> Date d'emprunt</th>
                                <th><i class="fa fa-calendar-check"></i> Date de retour</th>
                                <th><i class="fa fa-info-circle"></i> Statut</th>
                                <th><i class="fa fa-cogs"></i> Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emprunts as $emprunt)
                                <tr>
                                    <td>{{ $emprunt->id }}</td>
                                    <td>
                                        <strong>{{ $emprunt->user->name ?? 'Utilisateur inconnu' }}</strong><br>
                                        <small class="text-muted">{{ $emprunt->user->email ?? '' }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $emprunt->livre->titre ?? 'Livre supprimé' }}</strong><br>
                                        <small class="text-muted">{{ $emprunt->livre->auteur ?? '' }}</small>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                                    <td>
                                        @if($emprunt->date_retour)
                                            {{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}
                                        @else
                                            <span class="text-muted">Non retourné</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($emprunt->statut === 'en_cours')
                                            <span class="badge bg-warning text-dark">En cours</span>
                                        @elseif($emprunt->statut === 'retourne')
                                            <span class="badge bg-success">Retourné</span>
                                        @elseif($emprunt->statut === 'en_retard')
                                            <span class="badge bg-danger">En retard</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $emprunt->statut }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($emprunt->statut !== 'retourne')
                                                <form action="{{ route('admin.emprunts.updateStatus', $emprunt) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <input type="hidden" name="statut" value="retourne">
                                                    <button type="submit" class="btn btn-sm btn-success" title="Marquer comme retourné">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $emprunt->id }}" title="Supprimer">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Modal de suppression -->
                                        <div class="modal fade" id="deleteModal{{ $emprunt->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $emprunt->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title text-white" id="deleteModalLabel{{ $emprunt->id }}">
                                                            <i class="fa fa-exclamation-triangle me-2"></i>Confirmer la suppression
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Êtes-vous sûr de vouloir supprimer cet emprunt ?
                                                        <br><br>
                                                        <strong>Utilisateur :</strong> {{ $emprunt->user->name ?? 'Inconnu' }}<br>
                                                        <strong>Livre :</strong> {{ $emprunt->livre->titre ?? 'Inconnu' }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                        <form action="{{ route('admin.emprunts.destroy', $emprunt) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fa fa-trash me-1"></i>Supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $emprunts->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Section 4: Créer un nouvel emprunt -->
    <div class="card shadow border-0 mb-5">
        <div class="card-header bg-warning text-dark rounded-top-4">
            <h4 class="mb-0 fw-bold"><i class="fa fa-hand-holding-heart me-2"></i>Créer un Nouvel Emprunt</h4>
        </div>
        <div class="card-body bg-light">
            <form method="POST" action="{{ route('admin.emprunts.addBooks') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="user_id" class="form-label fw-bold"><i class="fa fa-user me-1 text-primary"></i> Utilisateur</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                            <option value="">Sélectionner...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3">
                        <label for="livre_id" class="form-label fw-bold"><i class="fa fa-book me-1 text-primary"></i> Livre</label>
                        <select class="form-select @error('livre_id') is-invalid @enderror" id="livre_id" name="livre_id" required>
                            <option value="">Sélectionner...</option>
                            @foreach($livresEmpruntables as $livre)
                                <option value="{{ $livre->id }}" {{ old('livre_id') == $livre->id ? 'selected' : '' }}>
                                    {{ $livre->titre }} (Stock: {{ $livre->quantite }})
                                </option>
                            @endforeach
                        </select>
                        @error('livre_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="date_emprunt" class="form-label fw-bold"><i class="fa fa-calendar-day me-1 text-primary"></i> Date d'emprunt</label>
                        <input type="date" class="form-control @error('date_emprunt') is-invalid @enderror" id="date_emprunt" name="date_emprunt" value="{{ old('date_emprunt', now()->toDateString()) }}" required>
                        @error('date_emprunt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="date_retour" class="form-label fw-bold"><i class="fa fa-calendar-check me-1 text-success"></i> Date de retour prévue</label>
                        <input type="date" class="form-control @error('date_retour') is-invalid @enderror" id="date_retour" name="date_retour" value="{{ old('date_retour', now()->addDays(14)->toDateString()) }}">
                        @error('date_retour')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="statut" class="form-label fw-bold"><i class="fa fa-info-circle me-1 text-primary"></i> Statut</label>
                        <select class="form-select @error('statut') is-invalid @enderror" id="statut" name="statut" required>
                            <option value="en_cours" {{ old('statut') == 'en_cours' ? 'selected' : '' }}>En cours</option>
                            <option value="retourne" {{ old('statut') == 'retourne' ? 'selected' : '' }}>Retourné</option>
                            <option value="en_retard" {{ old('statut') == 'en_retard' ? 'selected' : '' }}>En retard</option>
                        </select>
                        @error('statut')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-warning px-4 py-2 fw-bold">
                        <i class="fa fa-plus me-1"></i> Créer l'Emprunt
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Auto-hide toasts après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const toasts = document.querySelectorAll('.toast');
            toasts.forEach(toast => {
                const bsToast = new bootstrap.Toast(toast);
                bsToast.hide();
            });
        }, 5000);
    });
</script>
@endpush
