@extends('admin.layout')
@section('title', 'Admin - Catalogue')
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
        <h2 class="mb-4"><i class="fa fa-book me-2"></i>Gestion du catalogue</h2>
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle border border-primary-subtle table-transition">
                        <thead class="table-primary">
                            <tr>
                                <th><i class="fa fa-hashtag text-primary"></i></th>
                                <th><i class="fa fa-book text-primary"></i> Titre</th>
                                <th><i class="fa fa-user-pen text-primary"></i> Auteur</th>
                                <th><i class="fa fa-tags text-primary"></i> Catégorie</th>
                                <th><i class="fa fa-money-bill-wave text-success"></i> Prix</th>
                                <th><i class="fa fa-box text-primary"></i> Quantité</th>
                                <th><i class="fa fa-traffic-light text-primary"></i> Statut</th>
                                <th><i class="fa fa-align-left text-primary"></i> Résumé</th>
                                <th><i class="fa fa-image text-primary"></i> Image</th>
                                <th><i class="fa fa-file-pdf text-danger"></i> PDF</th>
                                <th><i class="fa fa-edit text-info"></i> Modifier</th>
                                <th><i class="fa fa-trash text-danger"></i> Supprimer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($catalogues as $cat)
                                <tr class="catalogue-row" data-catalogue='{!! json_encode([
                                    'id' => $cat->id,
                                    'titre' => $cat->titre,
                                    'auteur' => $cat->auteur,
                                    'categorie' => $cat->categorie,
                                    'prix' => number_format($cat->prix, 0, ',', ' ') . ' FCFA',
                                    'quantite' => $cat->quantite,
                                    'image' => $cat->image ? asset($cat->image) : null,
                                    'pdf' => $cat->pdf ? asset($cat->pdf) : null,
                                    'resumer' => strip_tags($cat->resumer),
                                ]) !!}'>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $cat->titre }}</td>
                                    <td>{{ $cat->auteur }}</td>
                                    <td>{{ $cat->categorie }}</td>
                                    <td>{{ number_format($cat->prix, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ $cat->quantite }}</td>
                                    <td>
                                        @php
                                            $q = $cat->quantite;
                                            if ($q == 0) {
                                                $statut = 'Épuisé';
                                                $badgeClass = 'bg-danger text-white';
                                                $blink = 'badge-blink';
                                            } else {
                                                $statut = 'OK';
                                                $badgeClass = 'bg-success text-white';
                                                $blink = '';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }} {{ $blink }}">{{ $statut }}</span>
                                    </td>
                                    <td>{{ Str::limit(strip_tags($cat->resumer), 20) }}</td>
                                    <td>
                                        @if ($cat->image)
                                            <img src="{{ asset($cat->image) }}" alt="image"
                                                style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($cat->pdf)
                                            <a href="{{ asset($cat->pdf) }}" target="_blank"
                                                class="btn btn-sm btn-outline-danger"><i class="fa fa-file-pdf"></i></a>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-gradient-blue"><i class="fa fa-edit"></i>
                                            Modifier</button>
                                    </td>
                                    <td>
                                        <!-- Bouton Supprimer avec modal -->
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteCatalogueModal{{ $cat->id }}">
                                            <i class="fa fa-trash"></i> Supprimer
                                        </button>
                                        <!-- Modal de confirmation Suppression -->
                                        <div class="modal fade" id="deleteCatalogueModal{{ $cat->id }}" tabindex="-1"
                                            aria-labelledby="deleteCatalogueModalLabel{{ $cat->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteCatalogueModalLabel{{ $cat->id }}">
                                                            Confirmation de suppression
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Fermer"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Êtes-vous sûr de vouloir supprimer le livre
                                                        <strong>{{ $cat->titre }}</strong> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Annuler</button>
                                                        <form method="POST"
                                                            action="{{ route('admin.catalogue.destroy', $cat->id) }}"
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
                                    <td colspan="8" class="text-center text-muted">Aucun livre enregistré</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <!-- Modal catalogue info -->
                        <div class="modal fade" id="catalogueModal" tabindex="-1" aria-labelledby="catalogueModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title text-white" id="catalogueModalLabel"><i
                                                class="fa fa-book-open me-2"></i><i
                                                class="fa fa-info-circle me-1"></i>Détail du livre</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Fermer"></button>
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
                    </table>
                </div>
            </div>
        </div>
        <!-- Formulaire d'ajout de catalogue -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h4 class="mb-0 fw-bold text-white"><i class="fa fa-folder-plus me-2"></i>Formulaire d'ajout de
                            livre</h4>
                    </div>
                    <div class="card-body bg-light">
                        <form id="catalogueForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="catalogue_id" name="catalogue_id" value="">
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
                                    <label for="quantite" class="form-label fw-bold"><i class="fa fa-box me-1 text-primary"></i> Quantité</label>
                                    <input type="number" class="form-control rounded-3" id="quantite" name="quantite" placeholder="Quantité" min="0" required>
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
        .badge-blink {
            animation: blink 1s linear infinite;
        }
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.3; }
            100% { opacity: 1; }
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
            form.action = "{{ route('admin.catalogue.store') }}";
            form.method = "POST";

            form.addEventListener('submit', function(e) {
                if (catalogueEditorInstance) {
                    textarea.value = catalogueEditorInstance.getData();
                }
                if (editMode) {
                    form.action = `/admin/catalogue/${editId}`;
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
                    form.action = "{{ route('admin.catalogue.store') }}";
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
                    document.getElementById('modalStatut').innerHTML = `<span class='badge ${badgeClass} ${blink}'>${statut}</span>`;
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
