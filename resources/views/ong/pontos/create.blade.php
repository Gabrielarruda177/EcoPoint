@extends('layouts.ong')

@section('titulo', 'Cadastrar Ponto de Coleta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/pontos.css') }}?v=3.2">
@endsection

@section('conteudo')
<div class="ponto-form-container">
    <a href="{{ route('ong.pontos.index') }}" class="back-link">
        &larr; Voltar para Meus Pontos
    </a>

    <div class="ponto-form-card">
        <div class="ponto-form-header">
            <span class="badge badge-ong">Perfil: ONG</span>
            <h1 class="pontos-title">Cadastrar Novo Ponto de Coleta</h1>
            <p class="pontos-subtitle">
                Informe o endereço do local de arrecadação e selecione os materiais acadêmicos aceitos.
            </p>
        </div>

        @if ($errors->any())
            <div class="alert-errors">
                <div class="alert-errors-title">Corrija os erros encontrados:</div>
                <ul>
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('ong.pontos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Seção 1: Identificação -->
            <div class="form-section">
                <h2 class="form-section-title">1. Identificação do Ponto</h2>
                <p class="form-section-subtitle">Nome de referência e contato para os doadores</p>

                <div class="form-group">
                    <label for="nome" class="form-label">
                        Nome do Ponto de Coleta <span class="required-mark">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nome" 
                        id="nome" 
                        class="form-control" 
                        value="{{ old('nome') }}" 
                        placeholder="Ex.: Sede Central, Biblioteca Comunitária do Saber"
                        required 
                        autofocus
                    >
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="telefone_contato" class="form-label">Telefone de Contato (Opcional)</label>
                        <input 
                            type="text" 
                            name="telefone_contato" 
                            id="telefone_contato" 
                            class="form-control" 
                            value="{{ old('telefone_contato') }}" 
                            placeholder="(11) 98765-4321"
                        >
                    </div>

                    <div class="form-group">
                        <label for="horario_funcionamento" class="form-label">Horário de Funcionamento (Opcional)</label>
                        <input 
                            type="text" 
                            name="horario_funcionamento" 
                            id="horario_funcionamento" 
                            class="form-control" 
                            value="{{ old('horario_funcionamento') }}" 
                            placeholder="Ex.: Seg a Sex das 09h às 17h, Sáb das 09h às 13h"
                        >
                    </div>
                </div>

                <div class="form-group" style="margin-top: 0.5rem;">
                    <label class="checkbox-toggle-label">
                        <input type="hidden" name="ativo" value="0">
                        <input type="checkbox" name="ativo" value="1" {{ old('ativo', '1') == '1' ? 'checked' : '' }}>
                        <span>Ponto de coleta ativo e visível para consulta pública</span>
                    </label>
                </div>
            </div>

            <!-- Seção 2: Endereço -->
            <div class="form-section">
                <h2 class="form-section-title">2. Endereço e Localização</h2>
                <p class="form-section-subtitle">Onde os voluntários e estudantes devem entregar os livros</p>

                <div class="form-grid-3">
                    <div class="form-group" style="grid-column: span 1;">
                        <label for="cep" class="form-label">CEP (Opcional)</label>
                        <input 
                            type="text" 
                            name="cep" 
                            id="cep" 
                            class="form-control" 
                            value="{{ old('cep') }}" 
                            placeholder="00000-000" 
                            maxlength="9"
                        >
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label for="endereco" class="form-label">
                            Logradouro / Rua / Avenida <span class="required-mark">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="endereco" 
                            id="endereco" 
                            class="form-control" 
                            value="{{ old('endereco') }}" 
                            placeholder="Ex.: Avenida Paulista" 
                            required
                        >
                    </div>
                </div>

                <div class="form-grid-3">
                    <div class="form-group">
                        <label for="numero" class="form-label">Número</label>
                        <input 
                            type="text" 
                            name="numero" 
                            id="numero" 
                            class="form-control" 
                            value="{{ old('numero') }}" 
                            placeholder="Ex.: 1500"
                        >
                    </div>

                    <div class="form-group">
                        <label for="complemento" class="form-label">Complemento</label>
                        <input 
                            type="text" 
                            name="complemento" 
                            id="complemento" 
                            class="form-control" 
                            value="{{ old('complemento') }}" 
                            placeholder="Sala 204, Bloco B"
                        >
                    </div>

                    <div class="form-group">
                        <label for="bairro" class="form-label">Bairro</label>
                        <input 
                            type="text" 
                            name="bairro" 
                            id="bairro" 
                            class="form-control" 
                            value="{{ old('bairro') }}" 
                            placeholder="Bela Vista"
                        >
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="cidade" class="form-label">
                            Cidade <span class="required-mark">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="cidade" 
                            id="cidade" 
                            class="form-control" 
                            value="{{ old('cidade') }}" 
                            placeholder="São Paulo" 
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="estado" class="form-label">
                            Estado (UF) <span class="required-mark">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="estado" 
                            id="estado" 
                            class="form-control" 
                            value="{{ old('estado') }}" 
                            placeholder="SP" 
                            maxlength="2" 
                            style="text-transform: uppercase;" 
                            required
                        >
                        <span class="form-hint">Sigla com 2 letras (ex.: SP, RJ, MG, BA).</span>
                    </div>
                </div>
            </div>

            <!-- Seção 3: Materiais Aceitos -->
            <div class="form-section">
                <h2 class="form-section-title">3. Materiais Acadêmicos Aceitos</h2>
                <p class="form-section-subtitle">Marque quais categorias de livros e apostilas este ponto recebe</p>

                <div class="materiais-selection-grid">
                    @forelse ($materiais as $material)
                        <label class="material-checkbox-card">
                            <input 
                                type="checkbox" 
                                name="materiais[]" 
                                value="{{ $material->id }}"
                                {{ in_array($material->id, old('materiais', [])) ? 'checked' : '' }}
                            >
                            <div class="material-info">
                                <span class="material-nome">{{ $material->nome }}</span>
                                @if ($material->descricao)
                                    <span class="material-desc">{{ $material->descricao }}</span>
                                @endif
                            </div>
                        </label>
                    @empty
                        <p style="color: #718096; font-size: 0.9rem;">
                            Nenhuma categoria de material cadastrada ainda no sistema.
                        </p>
                    @endforelse
                </div>
            </div>

            <!-- Seção 4: Informações Adicionais -->
            <div class="form-section">
                <h2 class="form-section-title">4. Observações e Informações Adicionais</h2>
                <p class="form-section-subtitle">Instruções extras para quem for realizar a entrega (opcional)</p>

                <div class="form-group">
                    <label for="descricao" class="form-label">Instruções / Observações</label>
                    <textarea 
                        name="descricao" 
                        id="descricao" 
                        class="form-control" 
                        rows="3" 
                        placeholder="Ex.: Caixa de coleta localizada na recepção principal. Para doações em grande volume, favor entrar em contato antecipadamente."
                    >{{ old('descricao') }}</textarea>
                </div>

                <div class="form-group" style="margin-top: 1rem;">
                    <label class="form-label">Foto / Imagem do Ponto de Coleta (Opcional)</label>

                    <div class="img-upload-zone" id="imgUploadZone">
                        <input 
                            type="file" 
                            name="imagem" 
                            id="imagem" 
                            class="img-upload-input" 
                            accept="image/png, image/jpeg, image/jpg, image/webp"
                        >

                        <div class="img-upload-placeholder" id="imgPlaceholder">
                            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <span class="img-upload-title">Clique para selecionar uma foto</span>
                            <span class="img-upload-hint">PNG, JPG ou WEBP · até 3MB</span>
                        </div>

                        <div class="img-upload-preview" id="imgPreview" style="display: none;">
                            <img id="imgPreviewThumb" src="" alt="Prévia">
                            <div class="img-upload-overlay">
                                <span class="img-upload-change-label">Clique para trocar a foto</span>
                                <button type="button" class="img-upload-remove-btn" id="imgRemoveBtn" title="Remover imagem">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    Remover
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('ong.pontos.index') }}" class="btn-cancel">
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    Salvar Ponto de Coleta
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/form-helpers.js') }}?v=1.0"></script>
    <script>
        (function () {
            const zone      = document.getElementById('imgUploadZone');
            const input     = document.getElementById('imagem');
            const placeholder = document.getElementById('imgPlaceholder');
            const preview   = document.getElementById('imgPreview');
            const thumb     = document.getElementById('imgPreviewThumb');
            const removeBtn = document.getElementById('imgRemoveBtn');

            zone.addEventListener('click', function (e) {
                if (e.target === removeBtn || removeBtn.contains(e.target)) return;
                input.click();
            });

            zone.addEventListener('dragover', function (e) {
                e.preventDefault();
                zone.classList.add('drag-over');
            });

            zone.addEventListener('dragleave', function () { zone.classList.remove('drag-over'); });

            zone.addEventListener('drop', function (e) {
                e.preventDefault();
                zone.classList.remove('drag-over');
                const file = e.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    input.files = e.dataTransfer.files;
                    setPreview(file);
                }
            });

            input.addEventListener('change', function () {
                if (this.files[0]) setPreview(this.files[0]);
            });

            removeBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                input.value = '';
                thumb.src = '';
                preview.style.display = 'none';
                placeholder.style.display = '';
                zone.classList.remove('has-image');
            });

            function setPreview(file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    thumb.src = e.target.result;
                    placeholder.style.display = 'none';
                    preview.style.display = '';
                    zone.classList.add('has-image');
                };
                reader.readAsDataURL(file);
            }
        })();
    </script>
@endsection
