@extends('admin.layout')
@section('title', 'Admin - Gestion des Emprunts')

@section('content')
<div class="container-fluid py-4">
    @include('partials.notifications')

    <h2 class="mb-4"><i class="fa fa-book-reader me-2 text-primary"></i>Gestion des Emprunts</h2>

    <!-- Section 0: Demandes en attente de validation -->
    @if($demandesEnAttente->isNotEmpty())
    <div class="card shadow border-0 mb-5 border-start border-warning border-5">
        <div class="card-header bg-warning text-dark rounded-top-4">
            <h4 class="mb-0 fw-bold"><i class="fa fa-clock me-2"></i>Demandes en attente de validation ({{ $demandesEnAttente->count() }})</h4>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fa fa-info-circle me-2"></i>
                Ces demandes d'emprunt nécessitent votre validation avant que les utilisateurs puissent accéder aux PDFs.
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-warning">
                        <tr>
                            <th>#</th>
                            <th><i class="fa fa-user"></i> Utilisateur</th>
                            <th><i class="fa fa-book"></i> Livre</th>
                            <th><i class="fa fa-calendar-day"></i> Date demande</th>
                            <th><i class="fa fa-calendar-check"></i> Retour prévu</th>
                            <th><i class="fa fa-box"></i> Stock</th>
                            <th class="text-center"><i class="fa fa-cogs"></i> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($demandesEnAttente as $demande)
                            <tr>
                                <td>{{ $demande->id }}</td>
                                <td>
                                    <strong>{{ $demande->user->name ?? 'Utilisateur inconnu' }}</strong><br>
                                    <small class="text-muted">{{ $demande->user->email ?? '' }}</small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        @if($demande->livre && $demande->livre->image)
                                            <img src="{{ asset($demande->livre->image) }}" alt="{{ $demande->livre->titre }}" class="img-thumbnail" style="width: 40px; height: 55px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <strong>{{ $demande->livre->titre ?? 'Livre supprimé' }}</strong><br>
                                            <small class="text-muted">{{ $demande->livre->auteur ?? '' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($demande->date_emprunt)->format('d/m/Y') }}<br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($demande->created_at)->diffForHumans() }}</small>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($demande->date_retour)->format('d/m/Y') }}</td>
                                <td>
                                    @if($demande->livre)
                                        <span class="badge {{ $demande->livre->quantite > 0 ? 'bg-success' : 'bg-danger' }}">
                                            {{ $demande->livre->quantite }} disponible(s)
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <select class="form-select form-select-sm action-select-demande" data-demande-id="{{ $demande->id }}" style="min-width: 140px;">
                                        <option value="">-- Action --</option>
                                        @if($demande->livre && $demande->livre->quantite > 0)
                                            <option value="valider">✓ Valider</option>
                                        @else
                                            <option value="" disabled>✓ Valider (stock épuisé)</option>
                                        @endif
                                        <option value="rejeter">✕ Rejeter</option>
                                    </select>

                                    <!-- Forms cachés -->
                                    <form id="form-valider-demande-{{ $demande->id }}" action="{{ route('admin.emprunts.valider', $demande) }}" method="POST" style="display:none;">
                                        @csrf
                                    </form>
                                    <form id="form-rejeter-demande-{{ $demande->id }}" action="{{ route('admin.emprunts.rejeter', $demande) }}" method="POST" style="display:none;">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

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
                                            <form method="POST" action="{{ route('admin.emprunts.updateLivre', $livre->id) }}" enctype="multipart/form-data">
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
                                                    <form method="POST" action="{{ route('admin.emprunts.destroyLivre', $livre->id) }}" style="display: inline;">
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
                                <th><i class="fa fa-check-circle"></i> Validé</th>
                                <th class="text-center"><i class="fa fa-cogs"></i> Actions</th>
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
                                        @if($emprunt->valide_le)
                                            <span class="badge bg-success">
                                                <i class="fa fa-check"></i> Oui
                                            </span>
                                            <br><small class="text-muted">{{ \Carbon\Carbon::parse($emprunt->valide_le)->format('d/m/Y H:i') }}</small>
                                        @else
                                            <span class="badge bg-warning text-dark">
                                                <i class="fa fa-clock"></i> Non validé
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <select class="form-select form-select-sm action-select"
                                                data-emprunt-id="{{ $emprunt->id }}"
                                                data-user-name="{{ $emprunt->user->name ?? 'Inconnu' }}"
                                                data-livre-titre="{{ $emprunt->livre->titre ?? 'Inconnu' }}"
                                                data-delete-url="{{ route('admin.emprunts.destroy', $emprunt) }}"
                                                style="min-width: 140px;">
                                            <option value="">-- Action --</option>
                                            @if(!$emprunt->valide_le && $emprunt->statut !== 'retourne')
                                                @if($emprunt->livre && $emprunt->livre->quantite > 0)
                                                    <option value="valider">✓ Valider</option>
                                                @else
                                                    <option value="" disabled>✓ Valider (stock épuisé)</option>
                                                @endif
                                            @endif
                                            @if($emprunt->statut !== 'retourne')
                                                <option value="retourner">↺ Retourner</option>
                                            @endif
                                            <option value="supprimer">✕ {{ $emprunt->valide_le ? 'Annuler' : 'Rejeter' }}</option>
                                        </select>

                                        <!-- Forms cachés pour soumettre les actions -->
                                        <form id="form-valider-{{ $emprunt->id }}" action="{{ route('admin.emprunts.valider', $emprunt) }}" method="POST" style="display:none;">
                                            @csrf
                                        </form>
                                        <form id="form-retourner-{{ $emprunt->id }}" action="{{ route('admin.emprunts.updateStatus', $emprunt) }}" method="POST" style="display:none;">
                                            @csrf
                                            <input type="hidden" name="statut" value="retourne">
                                        </form>
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

    <!-- Modal de validation d'une demande -->
    <div class="modal fade" id="validerModal" tabindex="-1" aria-labelledby="validerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title text-white" id="validerModalLabel">
                        <i class="fa fa-check-circle me-2"></i>Confirmer la validation
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <i class="fa fa-info-circle me-2"></i>
                        <strong>Cette action va :</strong>
                        <ul class="mb-0 mt-2">
                            <li>Valider la demande d'emprunt</li>
                            <li>Décrémenter le stock du livre</li>
                            <li>Permettre à l'utilisateur d'accéder au PDF</li>
                        </ul>
                    </div>
                    <p class="mb-2"><strong>Êtes-vous sûr de vouloir valider cette demande ?</strong></p>
                    <div id="validerModalContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i>Annuler
                    </button>
                    <form id="validerForm" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check me-1"></i>Valider la demande
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de rejet d'une demande -->
    <div class="modal fade" id="rejeterModal" tabindex="-1" aria-labelledby="rejeterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="rejeterModalLabel">
                        <i class="fa fa-exclamation-triangle me-2"></i>Confirmer le rejet
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning mb-3">
                        <i class="fa fa-exclamation-triangle me-2"></i>
                        <strong>Attention :</strong> Cette action va supprimer définitivement la demande d'emprunt.
                    </div>
                    <p class="mb-2"><strong>Êtes-vous sûr de vouloir rejeter cette demande ?</strong></p>
                    <div id="rejeterModalContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fa fa-times me-1"></i>Annuler
                    </button>
                    <form id="rejeterForm" method="POST" style="display:inline-block;">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="fa fa-ban me-1"></i>Rejeter la demande
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal unique de suppression (dynamique) -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title text-white" id="deleteModalLabel">
                        <i class="fa fa-exclamation-triangle me-2"></i>Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer cet emprunt ?</p>
                    <div id="deleteModalContent"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form id="deleteForm" method="POST" style="display:inline-block;">
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

</div>
@endsection

@push('styles')
<style>
    /* Style pour les selects d'action */
    .action-select, .action-select-demande {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e9ecef;
        background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        font-weight: 500;
    }

    .action-select:hover, .action-select-demande:hover {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        transform: translateY(-1px);
    }

    .action-select:focus, .action-select-demande:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }

    /* Animation pour les cartes */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1) !important;
    }

    /* Style pour les badges */
    .badge {
        font-weight: 600;
        padding: 0.5em 0.75em;
    }

    /* Table responsive améliorée */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: background-color 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Références aux modals
        const deleteModal = document.getElementById('deleteModal');
        const deleteModalContent = document.getElementById('deleteModalContent');
        const deleteForm = document.getElementById('deleteForm');

        const validerModal = document.getElementById('validerModal');
        const validerModalContent = document.getElementById('validerModalContent');
        const validerForm = document.getElementById('validerForm');

        const rejeterModal = document.getElementById('rejeterModal');
        const rejeterModalContent = document.getElementById('rejeterModalContent');
        const rejeterForm = document.getElementById('rejeterForm');

        // Initialiser les instances des modals
        let deleteModalInstance = null;
        let validerModalInstance = null;
        let rejeterModalInstance = null;

        if (deleteModal) deleteModalInstance = new bootstrap.Modal(deleteModal);
        if (validerModal) validerModalInstance = new bootstrap.Modal(validerModal);
        if (rejeterModal) rejeterModalInstance = new bootstrap.Modal(rejeterModal);

        // Gestion des actions pour les demandes en attente
        document.querySelectorAll('.action-select-demande').forEach(select => {
            select.addEventListener('change', function(e) {
                const action = this.value;
                const demandeId = this.getAttribute('data-demande-id');

                if (!action) return;

                const selectElement = this;

                // Récupérer les infos de la ligne du tableau
                const row = this.closest('tr');
                const userName = row.querySelector('td:nth-child(2) strong').textContent;
                const userEmail = row.querySelector('td:nth-child(2) small').textContent;
                const livreTitre = row.querySelector('td:nth-child(3) strong').textContent;
                const livreAuteur = row.querySelector('td:nth-child(3) small').textContent;

                switch(action) {
                    case 'valider':
                        // Afficher le modal de validation
                        if (validerModalContent && validerForm && validerModalInstance) {
                            validerModalContent.innerHTML = `
                                <div class="border-start border-primary border-4 ps-3 mb-2">
                                    <strong class="text-primary"><i class="fa fa-user me-1"></i>Utilisateur :</strong><br>
                                    <span class="ms-3">${userName}</span><br>
                                    <small class="text-muted ms-3">${userEmail}</small>
                                </div>
                                <div class="border-start border-success border-4 ps-3">
                                    <strong class="text-success"><i class="fa fa-book me-1"></i>Livre :</strong><br>
                                    <span class="ms-3">${livreTitre}</span><br>
                                    <small class="text-muted ms-3">${livreAuteur}</small>
                                </div>
                            `;
                            validerForm.setAttribute('action', document.getElementById('form-valider-demande-' + demandeId).action);
                            validerModalInstance.show();
                        }
                        selectElement.value = '';
                        break;

                    case 'rejeter':
                        // Afficher le modal de rejet
                        if (rejeterModalContent && rejeterForm && rejeterModalInstance) {
                            rejeterModalContent.innerHTML = `
                                <div class="border-start border-warning border-4 ps-3 mb-2">
                                    <strong class="text-dark"><i class="fa fa-user me-1"></i>Utilisateur :</strong><br>
                                    <span class="ms-3">${userName}</span><br>
                                    <small class="text-muted ms-3">${userEmail}</small>
                                </div>
                                <div class="border-start border-warning border-4 ps-3">
                                    <strong class="text-dark"><i class="fa fa-book me-1"></i>Livre :</strong><br>
                                    <span class="ms-3">${livreTitre}</span><br>
                                    <small class="text-muted ms-3">${livreAuteur}</small>
                                </div>
                            `;
                            rejeterForm.setAttribute('action', document.getElementById('form-rejeter-demande-' + demandeId).action);
                            rejeterModalInstance.show();
                        }
                        selectElement.value = '';
                        break;
                }
            }, { once: false });
        });

        // Gestion des actions via select pour les emprunts enregistrés
        document.querySelectorAll('.action-select').forEach(select => {
            select.addEventListener('change', function(e) {
                const action = this.value;
                const empruntId = this.getAttribute('data-emprunt-id');
                const userName = this.getAttribute('data-user-name');
                const livreTitre = this.getAttribute('data-livre-titre');
                const deleteUrl = this.getAttribute('data-delete-url');

                if (!action) return;

                const selectElement = this;

                switch(action) {
                    case 'valider':
                        // Afficher le modal de validation
                        if (validerModalContent && validerForm && validerModalInstance) {
                            validerModalContent.innerHTML = `
                                <div class="border-start border-primary border-4 ps-3 mb-2">
                                    <strong class="text-primary"><i class="fa fa-user me-1"></i>Utilisateur :</strong><br>
                                    <span class="ms-3">${userName}</span>
                                </div>
                                <div class="border-start border-success border-4 ps-3">
                                    <strong class="text-success"><i class="fa fa-book me-1"></i>Livre :</strong><br>
                                    <span class="ms-3">${livreTitre}</span>
                                </div>
                            `;
                            validerForm.setAttribute('action', document.getElementById('form-valider-' + empruntId).action);
                            validerModalInstance.show();
                        }
                        selectElement.value = '';
                        break;

                    case 'retourner':
                        if (confirm('Marquer cet emprunt comme retourné ?')) {
                            document.getElementById('form-retourner-' + empruntId).submit();
                        } else {
                            selectElement.value = '';
                        }
                        break;

                    case 'supprimer':
                        // Mettre à jour le contenu du modal unique
                        if (deleteModalContent && deleteForm && deleteModalInstance) {
                            deleteModalContent.innerHTML = `
                                <strong>Utilisateur :</strong> ${userName}<br>
                                <strong>Livre :</strong> ${livreTitre}
                            `;
                            deleteForm.setAttribute('action', deleteUrl);
                            deleteModalInstance.show();
                        }
                        selectElement.value = '';
                        break;
                }
            }, { once: false });
        });

        // Auto-hide toasts après 5 secondes
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
