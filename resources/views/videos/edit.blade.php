@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 fw-bold text-dark">Editar Vídeo</h1>
            <a href="{{ route('videos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        <form action="{{ route('videos.update', $video) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('videos.partials.form')

            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Atualizar Vídeo
                </button>
            </div>
        </form>
    </div>
</div>
@endsection