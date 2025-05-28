@extends('layouts.app')

@section('title', 'Bem-vindo')

@section('content')
    <div class="text-center">
        <h1>Bem-vindo ao Catálogo de Vídeos</h1>
        <p>Cadastre, edite e visualize seus vídeos favoritos!</p>
        <a href="{{ route('videos.index') }}" class="btn btn-primary">Ver Vídeos</a>
    </div>
@endsection
