@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 fw-bold text-dark mb-4">Nossos Vídeos</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        @foreach ($videos as $video)
        <div class="col">
            <div class="card h-100">
                <a href="{{ route('videos.show', $video) }}" class="text-decoration-none">
                    @if ($video->thumbnail)
                        <img src="{{ asset('storage/' . $video->thumbnail) }}" class="video-thumbnail card-img-top" alt="Thumbnail">
                    @else
                        <div class="video-thumbnail d-flex align-items-center justify-content-center">
                            <i class="bi bi-play-circle-fill text-white" style="font-size: 3rem;"></i>
                        </div>
                    @endif
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{ Str::limit($video->titulo, 50) }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($video->descricao, 70) }}</p>
                </div>
                <div class="card-footer bg-white border-top-0 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-secondary">
                            {{ App\Models\Video::CATEGORIAS[$video->categoria] ?? $video->categoria }}
                        </span>
                        <div class="action-buttons">
                            <a href="{{ route('videos.edit', $video) }}" class="btn btn-sm btn-outline-primary" 
                               data-bs-toggle="tooltip" title="Editar" data-cy="edit-button">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('videos.destroy', $video) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                        data-bs-toggle="tooltip" title="Excluir" data-cy="delete-button"
                                        onclick="return confirm('Tem certeza que deseja excluir este vídeo?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
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