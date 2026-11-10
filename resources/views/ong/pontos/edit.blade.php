@extends('layouts.app')

@section('titulo', 'Editar Ponto de Coleta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/pontos.css') }}?v=1.1">
@endsection

@section('conteudo')
<div class="ponto-form-container">
    <a href="{{ route('ong.pontos.index') }}" class="back-link">
        &larr; Voltar para Meus Pontos
    </a>

    <div class="ponto-form-card">
        <div class="ponto-form-header">
            <span class="badge badge-ong">Perfil: ONG</span>
            <h1 class="pontos-title">Editar Ponto de Coleta</h1>
            <p class="pontos-subtitle">
                Atualize as informações do local de arrecadação e os tipos de materiais acadêmicos aceitos.
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

        <form action="{{ route('ong.pontos.update', $ponto) }}" method="POST">
            @csrf
            @method('PUT')

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
                        value="{{ old('nome', $ponto->nome) }}" 
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
                            value="{{ old('telefone_contato', $ponto->telefone_contato) }}" 
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
                            value="{{ old('horario_funcionamento', $ponto->horario_funcionamento) }}" 
                            placeholder="Ex.: Seg a Sex das 09h às 17h, Sáb das 09h às 13h"
                        >
                    </div>
                </div>

                <div class="form-group" style="margin-top: 0.5rem;">
                    <label class="checkbox-toggle-label">
                        <input type="hidden" name="ativo" value="0">
                        <input 
                            type="checkbox" 
                            name="ativo" 
                            value="1" 
                            {{ old('ativo', $ponto->ativo ? '1' : '0') == '1' ? 'checked' : '' }}
                        >
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
                            value="{{ old('cep', $ponto->cep) }}" 
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
                            value="{{ old('endereco', $ponto->endereco) }}" 
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
                            value="{{ old('numero', $ponto->numero) }}" 
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
                            value="{{ old('complemento', $ponto->complemento) }}" 
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
                            value="{{ old('bairro', $ponto->bairro) }}" 
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
                            value="{{ old('cidade', $ponto->cidade) }}" 
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
                            value="{{ old('estado', $ponto->estado) }}" 
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

                @php
                    $materiaisMarcados = old('materiais', $ponto->materiaisAceitos->pluck('id')->toArray());
                @endphp

                <div class="materiais-selection-grid">
                    @forelse ($materiais as $material)
                        <label class="material-checkbox-card">
                            <input 
                                type="checkbox" 
                                name="materiais[]" 
                                value="{{ $material->id }}"
                                {{ in_array($material->id, $materiaisMarcados) ? 'checked' : '' }}
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
                    <textarea 
                        name="descricao" 
                        id="descricao" 
                        class="form-control" 
                        rows="3" 
                        placeholder="Ex.: Caixa de coleta localizada na recepção principal..."
                    >{{ old('descricao', $ponto->descricao) }}</textarea>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('ong.pontos.index') }}" class="btn-cancel">
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    Atualizar Ponto de Coleta
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
