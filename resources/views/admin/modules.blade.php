@extends('admin.layout')
@section('title', 'Admin - Modules de formation')
@section('content')
    <div class="container-fluid py-4">
        <h2 class="mb-4"><i class="fa fa-graduation-cap me-2"></i>Gestion des modules de formation</h2>
        <div class="card shadow border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Liste des modules</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModuleModal">Ajouter un module</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle border border-primary-subtle table-transition">
                        <thead class="table-primary">
                            <tr>
                                <th style="width:40px;">#</th>
                                <th>Formation</th>
                                <th>Module</th>
                                <th>Description</th>
                                <th style="width:80px;">Ordre</th>
                                <th style="width:80px;">Image</th>
                                <th style="width:80px;">Vidéo</th>
                                <th style="width:160px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($modules ?? [] as $module)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $module->formation->titre ?? '-' }}</td>
                                <td>{{ $module->titre }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($module->description, 80) }}</td>
                                <td>{{ $module->ordre }}</td>
                                <td>
                                    @if($module->image)
                                        <img src="{{ asset($module->image) }}" alt="mini" style="width:60px;height:40px;object-fit:cover;border-radius:4px;">
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($module->video_path || $module->video_url)
                                        <i class="fa fa-video text-success" title="Contient une vidéo"></i>
                                    @else
                                        <i class="fa fa-ban text-muted" title="Aucune vidéo"></i>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.modules.show', $module) }}" class="btn btn-sm btn-outline-primary me-1">Voir</a>
                                    <a href="{{ route('admin.modules.edit', $module) }}" class="btn btn-sm btn-outline-secondary me-1">Éditer</a>
                                    <form method="POST" action="{{ route('admin.modules.destroy', $module) }}" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Supprimer ce module ?')">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Aucun module enregistré</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Modal création module -->
                <div class="modal fade" id="createModuleModal" tabindex="-1" aria-labelledby="createModuleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="createModuleModalLabel">Ajouter un module</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('admin.modules.store') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="formation_id" class="form-label">Formation</label>
                                        <select name="formation_id" id="formation_id" class="form-select" required>
                                            <option value="">-- Sélectionner une formation --</option>
                                            @foreach($formations as $f)
                                                <option value="{{ $f->id }}">{{ $f->titre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="titre" class="form-label">Titre du module</label>
                                        <input type="text" name="titre" id="titre" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image (miniature)</label>
                                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                    </div>
                                    <div class="mb-3">
                                        <label for="video" class="form-label">Fichier vidéo (optionnel)</label>
                                        <input type="file" name="video" id="video" class="form-control" accept="video/*">
                                    </div>
                                    <div class="mb-3">
                                        <label for="video_url" class="form-label">Ou URL de la vidéo (YouTube/Vimeo)</label>
                                        <input type="url" name="video_url" id="video_url" class="form-control" placeholder="https://...">
                                    </div>
                                    <div class="mb-3">
                                        <label for="ordre" class="form-label">Ordre</label>
                                        <input type="number" name="ordre" id="ordre" class="form-control" value="1" required>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary">Créer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
