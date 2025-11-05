@extends('layouts.app')

@section('title', $module->titre)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $module->titre }}</h1>
            <p>{{ $module->description ?? '' }}</p>

            @if($module->video_url)
                <div class="embed-responsive embed-responsive-16by9 mb-4">
                    <iframe class="embed-responsive-item" src="{{ $module->video_url }}" allowfullscreen style="width:100%;height:450px;border:0;"></iframe>
                </div>
            @elseif($module->video_path)
                <video controls width="100%">
                    <source src="{{ \Illuminate\Support\Facades\Storage::url($module->video_path) }}" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture de vidéos.
                </video>
            @endif

            <h4 class="mt-4">Ressources</h4>
            @if($module->resources && is_array(json_decode($module->resources ?? '[]', true)))
                <ul>
                    @foreach(json_decode($module->resources, true) as $res)
                        <li><a href="{{ $res['url'] ?? '#' }}" target="_blank">{{ $res['title'] ?? 'Ressource' }}</a></li>
                    @endforeach
                </ul>
            @else
                <p>Aucune ressource fournie pour ce module.</p>
            @endif

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <p><strong>Durée :</strong> {{ $module->duree ?? 'N/A' }}</p>
                    <p><strong>Type :</strong> {{ $module->type ?? 'Vidéo' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
