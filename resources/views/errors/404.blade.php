@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="error-container py-5">
                <h1 class="display-1 text-danger mb-4">404</h1>
                <h2 class="display-4 mb-3">Página não encontrada</h2>
                <p class="lead mb-4">Oops! A página que você está procurando não existe ou foi removida.</p>
                
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-house-door"></i> Voltar à página inicial
                    </a>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left"></i> Voltar à página anterior
                    </a>
                </div>
                
                <!-- Ilustração opcional -->
                <div class="mt-5">
                    <img src="{{ asset('images/404-error.svg') }}" alt="Erro 404" class="img-fluid" style="max-height: 300px;">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .error-container {
        max-width: 600px;
        margin: 0 auto;
    }
    
    /* Efeito de animação no número 404 */
    .display-1 {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
@endsection