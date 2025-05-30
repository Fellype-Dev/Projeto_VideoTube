<div class="mb-3">
    <label for="titulo" class="form-label fw-bold">Título do Vídeo</label>
    <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $video->titulo ?? '') }}"
        class="form-control @error('titulo') is-invalid @enderror" placeholder="Digite o título do vídeo"
        maxlength="150" required>
    @error('titulo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="descricao" class="form-label fw-bold">Descrição</label>
    <textarea name="descricao" id="descricao" rows="4" class="form-control @error('descricao') is-invalid @enderror"
        placeholder="Adicione uma descrição para o vídeo"
        maxlength="2048">{{ old('descricao', $video->descricao ?? '') }}</textarea>
    @error('descricao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="url" class="form-label fw-bold">URL do Vídeo</label>
        <input type="url" name="url" id="url" value="{{ old('url', $video->url ?? '') }}"
            class="form-control @error('url') is-invalid @enderror" placeholder="https://www.youtube.com/watch?v=..."
            maxlength="2048" required>
        @error('url')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="categoria" class="form-label fw-bold">Categoria</label>
        <select name="categoria" id="categoria" class="form-select @error('categoria') is-invalid @enderror" required>
            <option value="">Selecione uma categoria</option>
            @foreach(App\Models\Video::CATEGORIAS as $key => $value)
                <option value="{{ $key }}" {{ old('categoria', $video->categoria ?? '') == $key ? 'selected' : '' }}>
                    {{ $value }}
                </option>
            @endforeach
        </select>
        @error('categoria')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

    @if(isset($video) && $video->thumbnail)
        <div class="mt-3">
            <p class="small text-muted mb-1">Thumbnail atual:</p>
            <img src="{{ asset('storage/' . $video->thumbnail) }}" class="img-thumbnail" alt="Thumbnail atual" width="200">
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Configura contadores de caracteres
        setupCharacterCounter('titulo', 150);
        setupCharacterCounter('descricao', 2048);
        setupCharacterCounter('url', 2048);

        // Configura validação do formulário
        setupFormValidation();

        function setupCharacterCounter(fieldId, maxLength) {
            const field = document.getElementById(fieldId);
            if (!field) return;

            // Cria o elemento do contador
            const counter = document.createElement('div');
            counter.className = 'form-text text-end small text-muted mt-1';
            counter.id = `${fieldId}-counter`;
            field.parentNode.appendChild(counter);

            // Atualiza o contador
            function updateCounter() {
                const remaining = maxLength - field.value.length;
                counter.textContent = `${field.value.length}/${maxLength} caracteres`;

                if (remaining < 10) {
                    counter.classList.add('text-danger');
                    counter.classList.remove('text-muted');
                } else {
                    counter.classList.remove('text-danger');
                    counter.classList.add('text-muted');
                }
            }

            // Event listeners
            field.addEventListener('input', updateCounter);
            field.addEventListener('change', updateCounter);

            // Inicializa
            updateCounter();
        }

        function setupFormValidation() {
            const form = document.querySelector('form');
            const urlInput = document.getElementById('url');
            
            // Cria ou obtém o elemento de feedback
            let feedbackElement = urlInput.nextElementSibling;
            if (!feedbackElement || !feedbackElement.classList.contains('invalid-feedback')) {
                feedbackElement = document.createElement('div');
                feedbackElement.className = 'invalid-feedback';
                urlInput.parentNode.appendChild(feedbackElement);
            }

            // Função de validação do YouTube
            function validateYouTubeUrl(url) {
                const patterns = [
                    /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/,
                    /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/embed\/)([^\/?]+)/,
                    /^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/v\/)([^\/?]+)/
                ];
                return patterns.some(pattern => pattern.test(url));
            }

            // Validação em tempo real
            function validateUrl() {
                const url = urlInput.value.trim();
                const isValid = url === '' || validateYouTubeUrl(url);

                if (!isValid && url !== '') {
                    urlInput.classList.add('is-invalid');
                    feedbackElement.textContent = 'Apenas URLs do YouTube são permitidas';
                    return false;
                } else {
                    urlInput.classList.remove('is-invalid');
                    feedbackElement.textContent = '';
                    return true;
                }
            }

            // Validação no envio do formulário
            form.addEventListener('submit', function(event) {
                if (!validateUrl()) {
                    event.preventDefault();
                    event.stopPropagation();
                    
                    // Rolagem suave para o campo com erro
                    urlInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    urlInput.focus();
                }
            });

            // Event listeners para validação em tempo real
            urlInput.addEventListener('input', validateUrl);
            urlInput.addEventListener('change', validateUrl);
            urlInput.addEventListener('blur', validateUrl);
        }
    });
</script>
@endpush