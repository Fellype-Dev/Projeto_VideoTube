@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Coluna principal do vídeo -->
        <div class="col-lg-8 col-xl-9">
            <div class="video-container mb-4">
                @if(str_contains($video->url, 'youtube.com') || str_contains($video->url, 'youtu.be'))
                    @php
                        $videoId = $video->getYoutubeId();
                    @endphp
                    
                    @if($videoId)
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                                    title="{{ $video->titulo }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen></iframe>
                        </div>
                    @else
                        <div class="ratio ratio-16x9 bg-dark">
                            <a href="{{ $video->url }}" target="_blank" class="d-flex align-items-center justify-content-center text-decoration-none">
                                <div class="text-center text-white">
                                    <i class="bi bi-play-circle-fill" style="font-size: 3rem;"></i>
                                    <p class="mt-2">Assistir no YouTube</p>
                                </div>
                            </a>
                        </div>
                    @endif
                @else
                    <div class="ratio ratio-16x9 bg-dark">
                        <a href="{{ $video->url }}" target="_blank" class="d-flex align-items-center justify-content-center text-decoration-none">
                            <div class="text-center text-white">
                                <i class="bi bi-play-circle-fill" style="font-size: 3rem;"></i>
                                <p class="mt-2">Assistir no site original</p>
                            </div>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Informações do vídeo -->
            <div class="video-info mb-4">
                <h1 class="fw-bold mb-3">{{ $video->titulo }}</h1>
                
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-2">
                        <span class="badge bg-primary">
                            {{ App\Models\Video::CATEGORIAS[$video->categoria] ?? $video->categoria }}
                        </span>
                        <span class="text-muted">{{ $video->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div class="action-buttons">
                        <a href="{{ route('videos.edit', $video) }}" class="btn btn-outline-primary btn-sm" 
                           data-bs-toggle="tooltip" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('videos.destroy', $video) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm" 
                                    data-bs-toggle="tooltip" title="Excluir"
                                    onclick="return confirm('Tem certeza que deseja excluir este vídeo?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                @if($video->descricao)
                    <div class="description-box p-3 bg-light rounded">
                        <p class="mb-0">{{ nl2br($video->descricao) }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Coluna lateral com lista de vídeos -->
        <div class="col-lg-4 col-xl-3">
            <div class="related-videos">
                <h5 class="fw-bold mb-3">Mais vídeos</h5>
                
                @foreach($videos as $relatedVideo)
                    @if($relatedVideo->id != $video->id)
                        <div class="card mb-3 border-0">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <a href="{{ route('videos.show', $relatedVideo) }}" class="text-decoration-none">
                                        @if($relatedVideo->thumbnail)
                                            <img src="{{ asset('storage/' . $relatedVideo->thumbnail) }}" 
                                                 class="img-fluid rounded-start" 
                                                 alt="Thumbnail"
                                                 style="width: 100%; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary d-flex align-items-center justify-content-center" 
                                                 style="width: 100%; height: 80px;">
                                                <i class="bi bi-play-circle-fill text-white"></i>
                                            </div>
                                        @endif
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body py-1 px-2">
                                        <h6 class="card-title mb-1">
                                            <a href="{{ route('videos.show', $relatedVideo) }}" class="text-decoration-none text-dark">
                                                {{ Str::limit($relatedVideo->titulo, 40) }}
                                            </a>
                                        </h6>
                                        <p class="card-text small text-muted mb-0">
                                            {{ App\Models\Video::CATEGORIAS[$relatedVideo->categoria] ?? $relatedVideo->categoria }}
                                        </p>
                                        <p class="card-text small text-muted">
                                            {{ $relatedVideo->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .video-container {
        background-color: #000;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .description-box {
        background-color: #f8f9fa;
        border-left: 3px solid var(--primary);
    }
    
    .related-videos .card:hover {
        background-color: #f8f9fa;
    }
    
    @media (max-width: 991.98px) {
        .related-videos {
            margin-top: 2rem;
            border-top: 1px solid #dee2e6;
            padding-top: 1.5rem;
        }
    }
</style>

<script>
    // Ativa tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    })
</script>
@endsection