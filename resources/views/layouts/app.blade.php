<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoTube - Plataforma de Vídeos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #3E78B2;
            --primary-dark: #004BA8;
            --secondary: #4A525A;
            --dark: #24272B;
            --black: #07070A;
        }

        /* Adicione na seção de estilo */
        .character-counter {
            font-size: 0.75rem;
            text-align: right;
            margin-top: 0.25rem;
        }

        .character-counter.warning {
            color: #dc3545;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa;
            color: var(--black);
        }

        .navbar {
            background-color: var(--dark) !important;
        }

        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .video-thumbnail {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background-color: var(--dark);
        }

        footer {
            background-color: var(--dark);
            color: white;
            margin-top: auto;
            padding: 1.5rem 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('videos.index') }}">
                <i class="bi bi-play-circle-fill me-2"></i>VideoTube
            </a>
            <!-- Botão único movido para o navbar -->
            <a href="{{ route('videos.create') }}" class="btn btn-danger" data-cy="create-video-button">
                <i class="bi bi-plus-lg me-1"></i> Novo Vídeo
            </a>
        </div>
    </nav>

    <main class="container py-4 flex-grow-1">
        @yield('content')
    </main>

    <footer class="mt-5">
        <div class="container text-center">
            <p class="mb-0">© {{ date('Y') }} VideoTube - Todos os direitos reservados</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>