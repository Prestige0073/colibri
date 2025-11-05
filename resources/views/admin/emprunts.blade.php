@extends('admin.layout')
@section('title', 'Admin - Emprunts')
@section('content')
    <div class="container-fluid py-4">
        <!-- Toast notification -->
        <div aria-live="polite" aria-atomic="true"
            style="position: fixed; top: 1.5rem; right: 1.5rem; min-width: 320px; z-index: 1080; pointer-events: none;">
            @if (session('success'))
                <div id="toast-success"
                    class="toast align-items-center border-0 shadow-lg show animate__animated animate__slideInDown"
                    role="alert" aria-live="assertive" aria-atomic="true"
                    style="pointer-events:auto; background:#1bc47d; color:#fff; font-weight:500;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Fermer"></button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="toast-error"
                    class="toast align-items-center border-0 shadow-lg show animate__animated animate__slideInDown"
                    role="alert" aria-live="assertive" aria-atomic="true"
                    style="pointer-events:auto; background:#e53935; color:#fff; font-weight:500;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Fermer"></button>
                    </div>
                </div>
            @endif
        </div>
        <h2 class="mb-4"><i class="fa fa-book me-2"></i>Gestion des emprunts</h2>

        <!-- Tableau des livres empruntables -->
        <div class="card shadow border-0 mb-5">
            <div class="card-header bg-primary text-white rounded-top-4">
                <h4 class="mb-0 fw-bold text-white"><i class="fa fa-book me-2"></i>Livres disponibles à l'emprunt</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border border-primary-subtle table-transition">
                        <thead class="table-primary">
                    <div class="mb-3">
                        <a class="btn btn-success" href="#">Ajouter un emprunt</a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="accordion" id="usersEmprunts">
                        @foreach($users as $user)
                            <div class="card mb-2">
                                <div class="card-header d-flex justify-content-between align-items-center" id="heading-user-{{ $user->id }}">
                                    <div>
                                        <strong>{{ $user->name }}</strong>
                                        <div class="text-muted small">Membre depuis {{ optional($user->created_at)->format('Y') }} • {{ $user->email }}</div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-primary">{{ $user->emprunts()->count() }} emprunt(s)</span>
                                        <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-user-{{ $user->id }}" aria-expanded="false" aria-controls="collapse-user-{{ $user->id }}">Voir</button>
                                    </div>
                                </div>

                                <div id="collapse-user-{{ $user->id }}" class="collapse" aria-labelledby="heading-user-{{ $user->id }}" data-bs-parent="#usersEmprunts">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h5>Emprunts en cours</h5>
                                                @if($user->emprunts_active->isEmpty())
                                                    <p class="text-muted">Aucun emprunt actif.</p>
                                                @else
                                                    <ul class="list-group mb-3">
                                                        @foreach($user->emprunts_active as $emprunt)
                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <strong>#{{ $emprunt->id }}</strong> — {{ $emprunt->livre->titre ?? '—' }}
                                                                    <div class="small text-muted">Demandé le {{ $emprunt->created_at->format('d/m/Y H:i') }}</div>
                                                                </div>
                                                                <div class="text-end">
                                                                    <span class="badge bg-warning text-dark">{{ $emprunt->statut }}</span>
                                                                    <div class="btn-group mt-2">
                                                                        <form action="{{ route('admin.emprunts.updateStatus', $emprunt) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="statut" value="retourne">
                                                                            {{-- date au format ISO (Y-m-d) ; si vous préférez laisser vide pour utiliser la date du jour, remplacez by "" --}}
                                                                            <input type="hidden" name="date_retour" value="{{ now()->toDateString() }}">
                                                                            <button class="btn btn-sm btn-success">Marquer retourné</button>
                                                                        </form>
                                                                        <a href="{{ route('admin.emprunts.edit', $emprunt) }}" class="btn btn-sm btn-primary">Éditer</a>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif

                                                <h5>Archives</h5>
                                                @if($user->emprunts_archives->isEmpty())
                                                    <p class="text-muted">Aucune archive.</p>
                                                @else
                                                    <ul class="list-group">
                                                        @foreach($user->emprunts_archives as $archive)
                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <strong>#{{ $archive->id }}</strong> — {{ $archive->livre->titre ?? '—' }}
                                                                    <div class="small text-muted">Retour le {{ optional($archive->date_retour)->format('d/m/Y') ?? $archive->created_at->format('d/m/Y') }}</div>
                                                                </div>
                                                                <div>
                                                                    <span class="badge bg-secondary">{{ $archive->statut }}</span>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>

                                            <div class="col-md-4">
                                                <h5>Actions utilisateur</h5>
                                                <form action="{{ route('admin.emprunts.bulkUpdateStatus', $user) }}" method="POST">
                                                    @csrf
                                                    <div class="mb-2">
                                                        <label class="form-label">Mettre tous les emprunts à :</label>
                                                        <select name="statut" class="form-select">
                                                            <option value="en_attente">en_attente</option>
                                                            <option value="emprunte">emprunte</option>
                                                            <option value="retourne">retourne</option>
                                                        </select>
                                                    </div>
                                                    <button class="btn btn-warning">Appliquer</button>
                                                </form>

                                                <hr>

                                                <h6>Informations</h6>
                                                <p class="small">Téléphone: {{ $user->tel ?? '—' }}<br>Email: {{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">{{ $users->links() }}</div>

                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-4 text-center">
                                                <img id="modalImage" src="" alt="image"
                                                    class="img-fluid rounded-3 mb-2"
                                                    style="max-height:180px;object-fit:cover;">
                                                <div id="modalPdfLink"></div>
                                            </div>
                                            <div class="col-md-8">
                                                <p><strong>Titre :</strong> <span id="modalTitre"></span></p>
                                                <p><strong>Auteur :</strong> <span id="modalAuteur"></span></p>
                                                <p><strong>Catégorie :</strong> <span id="modalCategorie"></span></p>
                                                <p><strong>Prix :</strong> <span id="modalPrix"></span></p>
                                                <p><strong>Quantité :</strong> <span id="modalQuantite"></span></p>
                                                <p><strong>Statut :</strong> <span id="modalStatut"></span></p>
                                                <p><strong>Résumé :</strong> <span id="modalResumerShort"></span><span
                                                        id="modalResumerFull" style="display:none;"></span>
                                                    <button id="modalResumerToggle" class="btn btn-link btn-sm p-0 ms-2"
                                                        style="vertical-align:baseline;display:none;">Lire la
                                                        suite</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-muted">Aucun livre d'emprunt enregistré</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border border-primary-subtle table-transition">
                        <thead class="table-primary">
                            <tr>
                                <th><i class="fa fa-hashtag text-primary"></i></th>
                                <th><i class="fa fa-user text-primary"></i> Utilisateur</th>
                                <th><i class="fa fa-book text-primary"></i> Livre</th>
                                <th><i class="fa fa-calendar-day text-primary"></i> Date d'emprunt</th>
                                <th><i class="fa fa-calendar-check text-success"></i> Date de retour</th>
                                <th><i class="fa fa-info-circle text-primary"></i> Statut</th>
                                <th><i class="fa fa-edit text-info"></i> Modifier</th>
                                <th><i class="fa fa-trash text-danger"></i> Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emprunts as $emprunt)
                                <tr class="emprunt-row" data-emprunt='{!! json_encode([
                                    'id' => $emprunt->id,
                                    'user' => $emprunt->user->name ?? '',
                                    'user_id' => $emprunt->user_id ?? '',
                                    'livre' => $emprunt->livre->titre ?? '',
                                    'livre_id' => $emprunt->livre_id ?? '',
                                    'date_emprunt' => $emprunt->date_emprunt,
                                    'date_retour' => $emprunt->date_retour,
                                    'statut' => $emprunt->statut,
                                ]) !!}'>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $emprunt->user->name ?? '' }}</td>
                                    <td>{{ $emprunt->livre->titre ?? '' }}</td>
                                    <td>{{ $emprunt->date_emprunt }}</td>
                                    <td>{{ $emprunt->date_retour }}</td>
                                    <td>{{ ucfirst($emprunt->statut) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-gradient-blue"><i class="fa fa-edit"></i>
                                            Modifier</button>
                                    </td>
                                    <td>
                                        <!-- Bouton Supprimer avec modal -->
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteEmpruntModal{{ $emprunt->id }}">
                                            <i class="fa fa-trash"></i> Supprimer
                                        </button>
                                        <!-- Modal de confirmation Suppression -->
                                        <div class="modal fade" id="deleteEmpruntModal{{ $emprunt->id }}" tabindex="-1"
                                            aria-labelledby="deleteEmpruntModalLabel{{ $emprunt->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteEmpruntModalLabel{{ $emprunt->id }}">
                                                            Confirmation de suppression
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Fermer"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Êtes-vous sûr de vouloir supprimer l'emprunt de
                                                        <strong>{{ $emprunt->user->name ?? '' }}</strong> pour le livre
                                                        <strong>{{ $emprunt->livre->titre ?? '' }}</strong> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Annuler</button>
                                                        <form method="POST"
                                                            action="{{ route('admin.emprunts.destroy', $emprunt->id) }}"
                                                            style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Oui,
                                                                supprimer</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">Aucun emprunt enregistré</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <!-- Modal emprunt info -->
                        <div class="modal fade" id="empruntModal" tabindex="-1" aria-labelledby="empruntModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title text-white" id="empruntModalLabel"><i
                                                class="fa fa-book-open me-2"></i><i
                                                class="fa fa-info-circle me-1"></i>Détail de l'emprunt</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <p><strong>Utilisateur :</strong> <span id="modalUser"></span></p>
                                                <p><strong>Livre :</strong> <span id="modalLivre"></span></p>
                                                <p><strong>Date d'emprunt :</strong> <span id="modalDateEmprunt"></span>
                                                </p>
                                                <p><strong>Date de retour :</strong> <span id="modalDateRetour"></span></p>
                                                <p><strong>Statut :</strong> <span id="modalStatut"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </table>
                </div>
            </div>
        </div>
        <!-- Formulaire d'ajout d'emprunt -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h4 class="mb-0 fw-bold text-white"><i class="fa fa-folder-plus me-2"></i>Formulaire d'ajout
                            d'emprunt</h4>
                    </div>
                    <div class="card-body bg-light">
                        <form id="empruntForm" method="POST" action="{{ route('admin.emprunts.addBooks') }}">
                            @csrf
                            <input type="hidden" id="emprunt_id" name="emprunt_id" value="">
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="user_id" class="form-label fw-bold"><i
                                            class="fa fa-user me-1 text-primary"></i> Utilisateur</label>
                                    <select class="form-select rounded-3" id="user_id" name="user_id" required>
                                        <option value="">Sélectionner un utilisateur</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="livre_id" class="form-label fw-bold"><i
                                            class="fa fa-book me-1 text-primary"></i> Livre</label>
                                    <select class="form-select rounded-3" id="livre_id" name="livre_id" required>
                                        <option value="">Sélectionner un livre</option>
                                        @foreach ($livres as $livre)
                                            @if($livre->type_categorie === 'emprunt')
                                                <option value="{{ $livre->id }}">{{ $livre->titre }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="date_emprunt" class="form-label fw-bold"><i
                                            class="fa fa-calendar-day me-1 text-primary"></i> Date d'emprunt</label>
                                    <input type="date" class="form-control rounded-3" id="date_emprunt"
                                        name="date_emprunt" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="date_retour" class="form-label fw-bold"><i
                                            class="fa fa-calendar-check me-1 text-success"></i> Date de retour</label>
                                    <input type="date" class="form-control rounded-3" id="date_retour"
                                        name="date_retour">
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-md-4">
                                    <label for="statut" class="form-label fw-bold"><i
                                            class="fa fa-info-circle me-1 text-primary"></i> Statut</label>
                                    <select class="form-select rounded-3" id="statut" name="statut" required>
                                        <option value="en_cours">En cours</option>
                                        <option value="retourne">Retourné</option>
                                        <option value="en_retard">En retard</option>
                                    </select>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" id="empruntSubmitBtn"
                                    class="btn btn-gradient-blue px-4 py-2 rounded-pill fw-bold shadow-sm">
                                    <i class="fa fa-plus me-1"></i><span id="empruntSubmitText">Ajouter</span>
                                </button>
                                <button type="button" id="empruntCancelEdit"
                                    class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-bold shadow-sm"
                                    style="display:none;">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h4 class="mb-0 fw-bold text-white"><i class="fa fa-folder-plus me-2"></i>Formulaire d'ajout de
                            livre (emprunt)</h4>
                    </div>
                    <div class="card-body bg-light">
                        <form id="catalogueForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="catalogue_id" name="catalogue_id" value="">
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    document.getElementById('catalogueForm').action = "{{ route('admin.emprunts.store') }}";
                                });
                            </script>
                            <div class="row g-3 align-items-end">
                                <div class="col-md-3">
                                    <label for="titre" class="form-label fw-bold"><i
                                            class="fa fa-book me-1 text-primary"></i> Titre</label>
                                    <input type="text" class="form-control rounded-3" id="titre" name="titre"
                                        placeholder="Titre du livre" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="auteur" class="form-label fw-bold"><i
                                            class="fa fa-user-pen me-1 text-primary"></i> Auteur</label>
                                    <input type="text" class="form-control rounded-3" id="auteur" name="auteur"
                                        placeholder="Auteur" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="categorie" class="form-label fw-bold"><i
                                            class="fa fa-tags me-1 text-primary"></i> Catégorie</label>
                                    <select class="form-select rounded-3" id="categorie" name="categorie" required>
                                        <option value="">Choisir une catégorie</option>
                                        <option value="Roman">Roman</option>
                                        <option value="Essai">Essai</option>
                                        <option value="Jeunesse">Jeunesse</option>
                                        <option value="Poésie">Poésie</option>
                                        <option value="Théâtre">Théâtre</option>
                                        <option value="Biographie">Biographie</option>
                                        <option value="Conte">Conte</option>
                                        <option value="Documentaire">Documentaire</option>
                                        <option value="Autre">Autre</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="prix" class="form-label fw-bold"><i
                                            class="fa fa-money-bill-wave me-1 text-primary"></i> Prix</label>
                                    <input type="number" class="form-control rounded-3" id="prix" name="prix"
                                        placeholder="Prix" min="0" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="quantite" class="form-label fw-bold"><i
                                            class="fa fa-box me-1 text-primary"></i> Quantité</label>
                                    <input type="number" class="form-control rounded-3" id="quantite" name="quantite"
                                        placeholder="Quantité" min="0" required>
                                </div>
                            </div>
                            <div class="row g-3 mt-2">
                                <div class="col-12">
                                    <label for="resumer" class="form-label fw-bold"><i
                                            class="fa fa-align-left me-1 text-primary"></i> Résumé</label>
                                    <textarea class="form-control rounded-3" id="resumer-catalogue-editor" name="resumer" rows="5"
                                        placeholder="Résumé du livre"></textarea>
                                </div>
                            </div>
                            <div class="row g-3 mt-2 align-items-end">
                                <div class="col-md-6">
                                    <label for="image" class="form-label fw-bold"><i
                                            class="fa fa-image me-1 text-primary"></i> Image de couverture</label>
                                    <input type="file" class="form-control rounded-3" id="image" name="image"
                                        accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label for="pdf" class="form-label fw-bold"><i
                                            class="fa fa-file-pdf me-1 text-danger"></i> Fichier PDF</label>
                                    <input type="file" class="form-control rounded-3" id="pdf" name="pdf"
                                        accept="application/pdf">
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit" id="catalogueSubmitBtn"
                                    class="btn btn-gradient-blue px-4 py-2 rounded-pill fw-bold shadow-sm">
                                    <i class="fa fa-plus me-1"></i><span id="catalogueSubmitText">Ajouter</span>
                                </button>
                                <button type="button" id="catalogueCancelEdit"
                                    class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-bold shadow-sm"
                                    style="display:none;">Annuler</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .btn-gradient-blue {
            background: linear-gradient(90deg, #1976d2 60%, #42a5f5 100%);
            color: #fff;
            border: none;
            box-shadow: 0 2px 8px 0 rgba(33, 150, 243, 0.10);
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        }

        .btn-gradient-blue:hover {
            background: #2196f3;
            color: #fff;
            box-shadow: 0 4px 16px 0 rgba(33, 150, 243, 0.13);
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        let catalogueEditorInstance = null;
        let editMode = false;
        let editId = null;
        document.addEventListener('DOMContentLoaded', function() {
            var textarea = document.getElementById('resumer-catalogue-editor');
            if (textarea) {
                ClassicEditor.create(textarea, {
                    toolbar: [
                        'undo', 'redo', '|', 'bold', 'italic', 'underline', 'bulletedList',
                        'numberedList', 'link', 'removeFormat'
                    ],
                    language: 'fr',
                }).then(editor => {
                    catalogueEditorInstance = editor;
                }).catch(error => {
                    console.error(error);
                });
            }

            // Gestion du formulaire (ajout/édition)
            var form = document.getElementById('catalogueForm');
            var submitBtn = document.getElementById('catalogueSubmitBtn');
            var submitText = document.getElementById('catalogueSubmitText');
            var cancelEditBtn = document.getElementById('catalogueCancelEdit');
            form.action = "{{ route('admin.emprunts.store') }}";
            form.method = "POST";

            form.addEventListener('submit', function(e) {
                if (catalogueEditorInstance) {
                    textarea.value = catalogueEditorInstance.getData();
                }
                if (editMode) {
                    form.action = `/admin/emprunts/${editId}`;
                    form.method = "POST";
                    // Ajoute le spoofing PATCH
                    if (!form.querySelector('input[name="_method"]')) {
                        let methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PATCH';
                        form.appendChild(methodInput);
                    } else {
                        form.querySelector('input[name="_method"]').value = 'PATCH';
                    }
                } else {
                    form.action = "{{ route('admin.emprunts.store') }}";
                    if (form.querySelector('input[name="_method"]')) {
                        form.querySelector('input[name="_method"]').remove();
                    }
                }
            });

            cancelEditBtn.addEventListener('click', function() {
                editMode = false;
                editId = null;
                form.reset();
                if (catalogueEditorInstance) catalogueEditorInstance.setData('');
                submitText.textContent = 'Ajouter';
                submitBtn.classList.remove('btn-warning');
                submitBtn.classList.add('btn-gradient-blue');
                cancelEditBtn.style.display = 'none';
            });

            // Bouton Modifier : pré-remplit le formulaire
            document.querySelectorAll('.btn-gradient-blue').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    const row = this.closest('tr');
                    if (!row || !row.dataset.catalogue) return;
                    const data = JSON.parse(row.dataset.catalogue);
                    editMode = true;
                    editId = data.id;
                    document.getElementById('catalogue_id').value = editId;
                    document.getElementById('titre').value = data.titre;
                    document.getElementById('auteur').value = data.auteur;
                    document.getElementById('categorie').value = data.categorie;
                    document.getElementById('prix').value = parseInt(data.prix);
                    if (catalogueEditorInstance) catalogueEditorInstance.setData(data.resumer);
                    submitText.textContent = 'Modifier';
                    submitBtn.classList.remove('btn-gradient-blue');
                    submitBtn.classList.add('btn-warning');
                    cancelEditBtn.style.display = '';
                    window.scrollTo({
                        top: form.offsetTop - 80,
                        behavior: 'smooth'
                    });
                });
            });

            // Modal catalogue info
            document.querySelectorAll('.catalogue-row').forEach(function(row) {
                row.addEventListener('click', function(e) {
                    // Ignore click on action buttons
                    if (e.target.closest('button')) return;
                    const data = JSON.parse(this.dataset.catalogue);
                    document.getElementById('modalTitre').textContent = data.titre;
                    document.getElementById('modalAuteur').textContent = data.auteur;
                    document.getElementById('modalCategorie').textContent = data.categorie;
                    document.getElementById('modalPrix').textContent = data.prix;
                    document.getElementById('modalImage').src = data.image || '';
                    document.getElementById('modalQuantite').textContent = data.quantite;
                    // Statut dynamique simplifié : 0 = Épuisé, sinon OK
                    let statut = '';
                    let badgeClass = '';
                    let blink = '';
                    let q = parseInt(data.quantite);
                    if (q === 0) {
                        statut = 'Épuisé';
                        badgeClass = 'bg-danger text-white';
                        blink = 'badge-blink';
                    } else {
                        statut = 'OK';
                        badgeClass = 'bg-success text-white';
                        blink = '';
                    }
                    document.getElementById('modalStatut').innerHTML =
                        `<span class='badge ${badgeClass} ${blink}'>${statut}</span>`;
                    if (data.pdf) {
                        document.getElementById('modalPdfLink').innerHTML =
                            `<a href="${data.pdf}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fa fa-file-pdf"></i> PDF</a>`;
                    } else {
                        document.getElementById('modalPdfLink').innerHTML = '';
                    }
                    // Résumé tronqué et dépliable
                    const resumer = data.resumer || '';
                    const short = resumer.substring(0, 50);
                    const full = resumer.substring(50);
                    document.getElementById('modalResumerShort').textContent = short;
                    document.getElementById('modalResumerFull').textContent = full;
                    document.getElementById('modalResumerFull').style.display = 'none';
                    const toggleBtn = document.getElementById('modalResumerToggle');
                    if (full.length > 0) {
                        toggleBtn.style.display = '';
                        toggleBtn.textContent = 'Lire la suite';
                        toggleBtn.onclick = function() {
                            const fullSpan = document.getElementById('modalResumerFull');
                            if (fullSpan.style.display === 'none') {
                                fullSpan.style.display = '';
                                toggleBtn.textContent = 'Réduire';
                            } else {
                                fullSpan.style.display = 'none';
                                toggleBtn.textContent = 'Lire la suite';
                            }
                        };
                    } else {
                        toggleBtn.style.display = 'none';
                    }
                    const modal = new bootstrap.Modal(document.getElementById('catalogueModal'));
                    modal.show();
                });
            });
        });
    </script>
@endpush
@push('scripts')
    <script>
        let editMode = false;
        let editId = null;
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du formulaire (ajout/édition)
            var form = document.getElementById('empruntForm');
            var submitBtn = document.getElementById('empruntSubmitBtn');
            var submitText = document.getElementById('empruntSubmitText');
            var cancelEditBtn = document.getElementById('empruntCancelEdit');
            form.action = "{{ route('admin.emprunts.store') }}";
            form.method = "POST";

            form.addEventListener('submit', function(e) {
                if (editMode) {
                    form.action = `/admin/emprunt/${editId}`;
                    form.method = "POST";
                    // Ajoute le spoofing PATCH
                    if (!form.querySelector('input[name="_method"]')) {
                        let methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PATCH';
                        form.appendChild(methodInput);
                    } else {
                        form.querySelector('input[name="_method"]').value = 'PATCH';
                    }
                } else {
                    form.action = "{{ route('admin.emprunts.store') }}";
                    if (form.querySelector('input[name="_method"]')) {
                        form.querySelector('input[name="_method"]').remove();
                    }
                }
            });

            cancelEditBtn.addEventListener('click', function() {
                editMode = false;
                editId = null;
                form.reset();
                submitText.textContent = 'Ajouter';
                submitBtn.classList.remove('btn-warning');
                submitBtn.classList.add('btn-gradient-blue');
                cancelEditBtn.style.display = 'none';
            });

            // Bouton Modifier : pré-remplit le formulaire
            document.querySelectorAll('.btn-gradient-blue').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    const row = this.closest('tr');
                    if (!row || !row.dataset.emprunt) return;
                    const data = JSON.parse(row.dataset.emprunt);
                    editMode = true;
                    editId = data.id;
                    document.getElementById('emprunt_id').value = editId;
                    if (data.user_id !== undefined) document.getElementById('user_id').value = data
                        .user_id;
                    if (data.livre_id !== undefined) document.getElementById('livre_id').value =
                        data.livre_id;
                    document.getElementById('date_emprunt').value = data.date_emprunt || '';
                    document.getElementById('date_retour').value = data.date_retour || '';
                    document.getElementById('statut').value = data.statut || '';
                    submitText.textContent = 'Modifier';
                    submitBtn.classList.remove('btn-gradient-blue');
                    submitBtn.classList.add('btn-warning');
                    cancelEditBtn.style.display = '';
                    window.scrollTo({
                        top: form.offsetTop - 80,
                        behavior: 'smooth'
                    });
                });
            });

            // Modal emprunt info
            document.querySelectorAll('.emprunt-row').forEach(function(row) {
                row.addEventListener('click', function(e) {
                    // Ignore click on action buttons
                    if (e.target.closest('button')) return;
                    const data = JSON.parse(this.dataset.emprunt);
                    document.getElementById('modalUser').textContent = data.user;
                    document.getElementById('modalLivre').textContent = data.livre;
                    document.getElementById('modalDateEmprunt').textContent = data.date_emprunt;
                    document.getElementById('modalDateRetour').textContent = data.date_retour;
                    document.getElementById('modalStatut').textContent = data.statut;
                    const modal = new bootstrap.Modal(document.getElementById('empruntModal'));
                    modal.show();
                });
            });
        });
    </script>
@endpush
