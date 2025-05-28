<div class="mb-3">
    <label for="titulo" class="form-label fw-bold">Título do Vídeo</label>
    <input type="text" name="titulo" id="titulo"
           value="{{ old('titulo', $video->titulo ?? '') }}"
           class="form-control @error('titulo') is-invalid @enderror"
           placeholder="Digite o título do vídeo" required>
    @error('titulo')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="descricao" class="form-label fw-bold">Descrição</label>
    <textarea name="descricao" id="descricao" rows="4"
              class="form-control @error('descricao') is-invalid @enderror"
              placeholder="Adicione uma descrição para o vídeo">{{ old('descricao', $video->descricao ?? '') }}</textarea>
    @error('descricao')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="url" class="form-label fw-bold">URL do Vídeo</label>
        <input type="url" name="url" id="url"
               value="{{ old('url', $video->url ?? '') }}"
               class="form-control @error('url') is-invalid @enderror"
               placeholder="https://www.youtube.com/watch?v=..." required>
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

<div class="mb-4">
    <label for="thumbnail" class="form-label fw-bold">Thumbnail (Imagem de capa)</label>
    <input type="file" name="thumbnail" id="thumbnail"
           class="form-control @error('thumbnail') is-invalid @enderror"
           accept="image/jpeg, image/png, image/webp">
    @error('thumbnail')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    @if(isset($video) && $video->thumbnail)
        <div class="mt-3">
            <p class="small text-muted mb-1">Thumbnail atual:</p>
            <img src="{{ asset('storage/' . $video->thumbnail) }}" 
                 class="img-thumbnail" 
                 alt="Thumbnail atual" 
                 width="200">
        </div>
    @endif
</div>