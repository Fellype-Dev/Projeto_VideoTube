@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-body p-0">
                    @if(str_contains($video->url, 'youtube.com') || str_contains($video->url, 'youtu.be'))
                        @php
                            // Extrai o ID do vídeo do YouTube
                            $videoId = null;
                            $patterns = [
                                '~youtube\.com/watch\?v=([^&]+)~',
                                '~youtube\.com/embed/([^/?]+)~',
                                '~youtube\.com/v/([^/?]+)~',
                                '~youtu\.be/([^/?]+)~',
                                '~youtube\.com/watch\?.+&v=([^&]+)~'
                            ];
                            
                            foreach ($patterns as $pattern) {
                                if (preg_match($pattern, $video->url, $matches)) {
                                    $videoId = $matches[1];
                                    break;
                                }
                            }
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
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h1 class="h3 fw-bold">{{ $video->titulo }}</h1>
                            @if($video->categoria)
                                <span class="badge bg-primary">{{ $video->categoria }}</span>
                            @endif
                        </div>
                        <div class="action-buttons">
                            <a href="{{ route('videos.edit', $video) }}" class="btn btn-outline-primary" 
                               data-bs-toggle="tooltip" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('videos.destroy', $video) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" 
                                        data-bs-toggle="tooltip" title="Excluir"
                                        onclick="return confirm('Tem certeza que deseja excluir este vídeo?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    @if($video->descricao)
                        <div class="mb-4">
                            <h5 class="fw-bold">Descrição</h5>
                            <p class="text-muted">{{ nl2br($video->descricao) }}</p>
                        </div>
                    @endif
                    
                    <div class="d-flex gap-2">
                        <a href="{{ $video->url }}" target="_blank" class="btn btn-outline-secondary">
                            <i class="bi bi-box-arrow-up-right me-1"></i> Abrir original
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        @if($video->thumbnail)
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Thumbnail</h5>
                </div>
                <div class="card-body text-center p-0">
                    <img src="{{ asset('storage/' . $video->thumbnail) }}" 
                         alt="Thumbnail do vídeo" 
                         class="img-fluid rounded">
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

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