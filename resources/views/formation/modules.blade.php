@extends('layouts.app')

@section('title', 'Modules de formation')
@section('meta_description', 'Découvrez tous les modules de formation proposés par Colibri Littéraire.')

@section('content')
    <!-- Event Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-success px-3">Modules de formation</p>
                <h1 class="display-6 mb-4">Développez vos compétences avec nos modules spécialisés</h1>
            </div>
            <div class="row g-4">
                @forelse($formations as $formation)
                    <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="event-item h-100 p-4">
                            @if($formation->image)
                                <img class="img-fluid w-100 mb-4" src="{{ asset($formation->image) }}" alt="{{ $formation->titre }}">
                            @else
                                <img class="img-fluid w-100 mb-4" src="{{ asset('img/event-1.jpg') }}" alt="{{ $formation->titre }}">
                            @endif
                            <a href="#" class="h3 d-inline-block">{{ $formation->titre }}</a>
                            <p>{{ \Illuminate\Support\Str::limit($formation->description, 150) }}</p>
                            <div class="bg-light p-4">
                                <p class="mb-1"><i class="fa fa-level-up-alt text-success me-2"></i>{{ $formation->niveau ?? 'Tous niveaux' }}</p>
                                <p class="mb-0"><i class="fa fa-book text-success me-2"></i>{{ $formation->modules_count }} module(s)</p>
                            </div>
                            @php
                                $totalContenus = 0;
                                $videosCount = 0;
                                $pdfsCount = 0;
                                foreach($formation->modules as $module) {
                                    foreach($module->contenus as $contenu) {
                                        $totalContenus++;
                                        if($contenu->type === 'video') {
                                            $videosCount++;
                                        } elseif($contenu->type === 'pdf') {
                                            $pdfsCount++;
                                        }
                                    }
                                }
                            @endphp
                            <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                                @if($videosCount > 0)
                                    <span><i class="fa fa-video text-success me-2"></i>{{ $videosCount }} vidéo{{ $videosCount > 1 ? 's' : '' }}</span>
                                @endif
                                @if($pdfsCount > 0)
                                    <span><i class="fa fa-file-pdf text-success me-2"></i>{{ $pdfsCount }} PDF</span>
                                @endif
                                @if($videosCount == 0 && $pdfsCount == 0 && $totalContenus > 0)
                                    <span><i class="fa fa-file text-success me-2"></i>{{ $totalContenus }} contenu{{ $totalContenus > 1 ? 's' : '' }}</span>
                                @endif
                                <span><i class="fa fa-money-bill text-success me-2"></i>{{ $formation->prix > 0 ? fcfa($formation->prix) : 'Gratuit' }}</span>
                            </div>
                            <a href="{{ route('formation.show', $formation) }}" class="btn btn-success btn-block w-100 mt-3">
                                <i class="fa fa-graduation-cap me-2"></i>Suis la formation
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p>Aucune formation disponible pour le moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $formations->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Event End -->
@endsection
