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
        
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }
        
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
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
        
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        .action-buttons .btn {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 3px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('videos.index') }}">
                <i class="bi bi-play-circle-fill me-2"></i>VideoTube
            </a>
            <div class="d-flex">
                <a href="{{ route('videos.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i> Novo Vídeo
                </a>
            </div>
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
</body>
</html>