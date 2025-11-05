@extends('admin.layout')
@section('title', 'Admin - Équipe')
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
        <h2 class="mb-4"><i class="fa fa-graduation-cap me-2 text-primary"></i>Gestion des formations</h2>
        <!-- Tableau des formations -->
        <div class="card shadow border-0 mb-5">
            <div class="card-header bg-primary text-white rounded-top-4">
                <h4 class="mb-0 fw-bold text-white"><i class="fa fa-table me-2"></i>Liste des formations</h4>
            </div>
            <div class="card-body bg-light">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border border-primary-subtle table-transition"
                        id="formationsTable">
                        <thead class="table-primary">
                            <tr>
                                <th><i class="fa fa-hashtag text-primary"></i></th>
                                <th><i class="fa fa-graduation-cap text-primary"></i> Titre</th>
                                <th><i class="fa fa-align-left text-primary"></i> Description</th>
                                <th><i class="fa fa-money-bill-wave text-success"></i> Prix</th>
                                <th><i class="fa fa-clock text-primary"></i> Durée</th>
                                <th><i class="fa fa-layer-group text-primary"></i> Niveau</th>
                                <th><i class="fa fa-image text-primary"></i> Image</th>
                                <th><i class="fa fa-edit text-info"></i> Modifier</th>
                                <th><i class="fa fa-trash text-danger"></i> Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($formations as $formation)
                                @php
                                    $formationData = [
                                        'id' => $formation->id,
                                        'titre' => $formation->titre,
                                        'description' => $formation->description,
                                        'prix' => $formation->prix,
                                        'duree' => $formation->duree,
                                        'niveau' => $formation->niveau,
                                        'image' => $formation->image ? asset($formation->image) : null,
                                    ];
                                @endphp
                                <tr class="formation-row" data-formation='@json($formationData)'>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $formation->titre }}</td>
                                    <td>
                                        @php $desc = $formation->description; @endphp
                                        {{ \Illuminate\Support\Str::limit($desc, 50) }}
                                        @if(strlen($desc) > 50)
                                            <a href="#" class="text-primary formation-lire-plus" style="font-size:0.95em;" data-id="{{ $formation->id }}">Lire plus</a>
                                        @endif
                                    </td>
                                    <td>{{ $formation->prix }}</td>
                                    <td>{{ $formation->duree }}</td>
                                    <td>{{ $formation->niveau }}</td>
                                    <td>
                                        @if($formation->image)
                                            <img src="{{ asset($formation->image) }}" alt="image" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-gradient-blue edit-formation" data-id="{{ $formation->id }}"
                                            data-titre="{{ $formation->titre }}" data-description="{{ $formation->description }}" data-prix="{{ $formation->prix }}" data-duree="{{ $formation->duree }}" data-niveau="{{ $formation->niveau }}">
                                            <i class="fa fa-edit"></i> Modifier
                                        </button>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.formations.destroy', $formation) }}" style="display:inline-block;" onsubmit="return confirm('Supprimer cette formation ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Aucune formation enregistrée</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                        <!-- Modal formation info -->
                        <div class="modal fade" id="formationModal" tabindex="-1" aria-labelledby="formationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title text-white" id="formationModalLabel"><i class="fa fa-graduation-cap me-2"></i>Détail de la formation</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-4 text-center">
                                                <img id="modalFormationImage" src="" alt="image" class="img-fluid rounded-3 mb-2" style="max-height:180px;object-fit:cover;">
                                            </div>
                                            <div class="col-md-8">
                                                <p><strong>Titre :</strong> <span id="modalFormationTitre"></span></p>
                                                <p><strong>Prix :</strong> <span id="modalFormationPrix"></span></p>
                                                <p><strong>Durée :</strong> <span id="modalFormationDuree"></span></p>
                                                <p><strong>Niveau :</strong> <span id="modalFormationNiveau"></span></p>
                                                <p><strong>Description :</strong> <span id="modalFormationDescription"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- Formulaire d'ajout de formation -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h4 class="mb-0 fw-bold text-white"><i class="fa fa-folder-plus me-2"></i>Formulaire d'ajout de
                            formation</h4>
                    </div>
                    <div class="card-body bg-light">
                        <form id="formationForm" method="POST" action="{{ route('admin.formations.store') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" id="_method" value="POST">
                        <input type="hidden" name="formation_id" id="formation_id">
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold"><i class="fa fa-image me-1 text-primary"></i> Image</label>
                            <input type="file" class="form-control rounded-3" id="image" name="image" accept="image/*">
                        </div>
                            @csrf
                            @if(isset($formation))
                                @method('PATCH')
                            @endif
                            <div class="row g-3 align-items-end">
                                <div class="col-md-4">
                                    <label for="titre" class="form-label fw-bold"><i
                                            class="fa fa-graduation-cap me-1 text-primary"></i> Titre</label>
                                    <input type="text" class="form-control rounded-3" id="titre" name="titre"
                                        placeholder="Titre de la formation" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="prix" class="form-label fw-bold"><i
                                            class="fa fa-money-bill-wave me-1 text-success"></i> Prix</label>
                                    <input type="number" class="form-control rounded-3" id="prix" name="prix"
                                        placeholder="Prix" min="0" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="duree" class="form-label fw-bold"><i class="fa fa-clock me-1 text-primary"></i> Durée</label>
                                    <select class="form-select rounded-3" id="duree" name="duree" required>
                                        <option value="">Choisir la durée</option>
                                        <option value="Longue durée">Longue durée</option>
                                        <option value="Courte durée">Courte durée</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-3 mt-2 align-items-end">
                                <div class="col-md-6">
                                    <label for="niveau" class="form-label fw-bold"><i class="fa fa-layer-group me-1 text-primary"></i> Niveau</label>
                                    <select class="form-select rounded-3" id="niveau" name="niveau" required>
                                        <option value="">Choisir le niveau</option>
                                        <option value="Débutant">Débutant</option>
                                        <option value="Intermédiaire">Intermédiaire</option>
                                        <option value="Avancé">Avancé</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="description" class="form-label fw-bold"><i
                                            class="fa fa-align-left me-1 text-primary"></i> Description</label>
                                    <textarea class="form-control rounded-3" id="description" name="description" rows="2"
                                        placeholder="Description de la formation" required></textarea>
                                </div>
                            </div>
                            <div class="text-end mt-4">
                                <button type="submit"
                                    class="btn btn-gradient-blue px-4 py-2 rounded-pill fw-bold shadow-sm">
                                    <span id="submitIcon"><i class="fa fa-plus me-1"></i></span><span id="submitText">Ajouter</span>
                                </button>
                                <button type="reset" id="cancelEditBtn" style="display:none;"
                                    class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-bold shadow-sm ms-2">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('formationForm');
                const methodInput = document.getElementById('_method');
                const idInput = document.getElementById('formation_id');
                const titreInput = document.getElementById('titre');
                const descriptionInput = document.getElementById('description');
                const prixInput = document.getElementById('prix');
                const dureeInput = document.getElementById('duree');
                const niveauInput = document.getElementById('niveau');
                const submitText = document.getElementById('submitText');
                const submitIcon = document.getElementById('submitIcon');
                const cancelEditBtn = document.getElementById('cancelEditBtn');

                // Gestion édition
                document.querySelectorAll('.edit-formation').forEach(btn => {
                    btn.addEventListener('click', function() {
                        form.action = `/admin/formations/${this.dataset.id}`;
                        methodInput.value = 'PATCH';
                        idInput.value = this.dataset.id;
                        titreInput.value = this.dataset.titre;
                        descriptionInput.value = this.dataset.description;
                        prixInput.value = this.dataset.prix;
                        dureeInput.value = this.dataset.duree;
                        niveauInput.value = this.dataset.niveau;
                        submitText.textContent = 'Modifier';
                        submitIcon.innerHTML = '<i class="fa fa-edit me-1"></i>';
                        cancelEditBtn.style.display = '';
                        window.scrollTo({top: form.offsetTop - 80, behavior: 'smooth'});
                    });
                });

                form.addEventListener('reset', function() {
                    form.action = "{{ route('admin.formations.store') }}";
                    methodInput.value = 'POST';
                    idInput.value = '';
                    submitText.textContent = 'Ajouter';
                    submitIcon.innerHTML = '<i class="fa fa-plus me-1"></i>';
                    cancelEditBtn.style.display = 'none';
                });

                // Gestion modale d'aperçu (ligne ou "lire plus")
                document.querySelectorAll('.formation-row').forEach(function(row) {
                    row.addEventListener('click', function(e) {
                        // Ignore click sur les boutons action
                        if (e.target.closest('button') || e.target.classList.contains('formation-lire-plus')) return;
                        const data = JSON.parse(this.dataset.formation);
                        document.getElementById('modalFormationTitre').textContent = data.titre;
                        document.getElementById('modalFormationPrix').textContent = data.prix;
                        document.getElementById('modalFormationDuree').textContent = data.duree;
                        document.getElementById('modalFormationNiveau').textContent = data.niveau;
                        document.getElementById('modalFormationDescription').textContent = data.description;
                        document.getElementById('modalFormationImage').src = data.image || '';
                        const modal = new bootstrap.Modal(document.getElementById('formationModal'));
                        modal.show();
                    });
                });
                document.querySelectorAll('.formation-lire-plus').forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const id = this.dataset.id;
                        const row = document.querySelector(`.formation-row[data-formation*='"id":${id}']`);
                        if (!row) return;
                        const data = JSON.parse(row.dataset.formation);
                        document.getElementById('modalFormationTitre').textContent = data.titre;
                        document.getElementById('modalFormationPrix').textContent = data.prix;
                        document.getElementById('modalFormationDuree').textContent = data.duree;
                        document.getElementById('modalFormationNiveau').textContent = data.niveau;
                        document.getElementById('modalFormationDescription').textContent = data.description;
                        document.getElementById('modalFormationImage').src = data.image || '';
                        const modal = new bootstrap.Modal(document.getElementById('formationModal'));
                        modal.show();
                    });
                });
            });
        </script>
    @endpush
@endsection
