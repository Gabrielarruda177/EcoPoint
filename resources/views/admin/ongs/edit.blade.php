@extends('layouts.admin')

@section('titulo', 'Editar ONG')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/ongs-create.css') }}?v=1.2">
@endsection

@section('conteudo')
<div class="create-ong-container">
    <a href="{{ route('admin.ongs.index') }}" class="back-link">
        &larr; Voltar para lista de ONGs
    </a>

    <div class="create-ong-card">
        <div class="create-ong-header">
            <span class="badge badge-admin">Perfil: Administrador</span>
            <h1 class="create-ong-title">Editar ONG: {{ $ong->nome }}</h1>
            <p class="create-ong-subtitle">
                Atualize as informações institucionais ou as credenciais de acesso da organização.
            </p>
        </div>

        @if ($errors->any())
            <div class="alert-errors">
                <div class="alert-errors-title">Corrija os erros encontrados:</div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.ongs.update', $ong) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-section">
                <h2 class="form-section-title">Dados da Instituição</h2>
                <p class="form-section-subtitle">Informações gerais sobre a organização parceira</p>

                <div class="form-group">
                    <label for="nome" class="form-label">
                        Nome da Instituição / ONG <span class="required-mark">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="nome" 
                        id="nome" 
                        class="form-control"
                        value="{{ old('nome', $ong->nome) }}" 
                        required 
                    >
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="cnpj" class="form-label">CNPJ (Opcional)</label>
                        <input 
                            type="text" 
                            name="cnpj" 
                            id="cnpj" 
                            class="form-control"
                            value="{{ old('cnpj', $ong->cnpj) }}" 
                            placeholder="00.000.000/0000-00"
                        >
                    </div>

                    <div class="form-group">
                        <label for="telefone" class="form-label">Telefone (Opcional)</label>
                        <input 
                            type="text" 
                            name="telefone" 
                            id="telefone" 
                            class="form-control"
                            value="{{ old('telefone', $ong->telefone) }}" 
                            placeholder="(11) 99999-9999"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="email_contato" class="form-label">E-mail de Contato Público (Opcional)</label>
                    <input 
                        type="email" 
                        name="email_contato" 
                        id="email_contato" 
                        class="form-control"
                        value="{{ old('email_contato', $ong->email_contato) }}" 
                        placeholder="contato@instituicao.org"
                    >
                </div>

                <div class="form-group">
                    <label for="descricao" class="form-label">Descrição (Opcional)</label>
                    <textarea 
                        name="descricao" 
                        id="descricao" 
                        rows="3" 
                        class="form-control"
                        placeholder="Breve resumo da missão e das atividades da ONG..."
                    >{{ old('descricao', $ong->descricao) }}</textarea>
                </div>
            </div>

            <hr class="form-divider">

            <div class="form-section">
                <h2 class="form-section-title">Localização da Sede</h2>
                <p class="form-section-subtitle">Endereço institucional e estado da organização</p>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="cep" class="form-label">CEP (Opcional)</label>
                        <input 
                            type="text" 
                            name="cep" 
                            id="cep" 
                            class="form-control"
                            value="{{ old('cep', $ong->cep) }}" 
                            placeholder="00000-000"
                        >
                    </div>

                    <div class="form-group">
                        <label for="estado" class="form-label">Estado / UF (Opcional)</label>
                        <input 
                            type="text" 
                            name="estado" 
                            id="estado" 
                            class="form-control"
                            value="{{ old('estado', $ong->estado) }}" 
                            placeholder="SP"
                            maxlength="2"
                        >
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="cidade" class="form-label">Cidade (Opcional)</label>
                        <input 
                            type="text" 
                            name="cidade" 
                            id="cidade" 
                            class="form-control"
                            value="{{ old('cidade', $ong->cidade) }}" 
                            placeholder="São Paulo"
                        >
                    </div>

                    <div class="form-group">
                        <label for="bairro" class="form-label">Bairro (Opcional)</label>
                        <input 
                            type="text" 
                            name="bairro" 
                            id="bairro" 
                            class="form-control"
                            value="{{ old('bairro', $ong->bairro) }}" 
                            placeholder="Centro"
                        >
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label for="endereco" class="form-label">Endereço / Logradouro (Opcional)</label>
                        <input 
                            type="text" 
                            name="endereco" 
                            id="endereco" 
                            class="form-control"
                            value="{{ old('endereco', $ong->endereco) }}" 
                            placeholder="Av. Paulista, Rua das Flores..."
                        >
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="numero" class="form-label">Número (Opcional)</label>
                        <input 
                            type="text" 
                            name="numero" 
                            id="numero" 
                            class="form-control"
                            value="{{ old('numero', $ong->numero) }}" 
                            placeholder="123 ou S/N"
                        >
                    </div>

                    <div class="form-group">
                        <label for="complemento" class="form-label">Complemento (Opcional)</label>
                        <input 
                            type="text" 
                            name="complemento" 
                            id="complemento" 
                            class="form-control"
                            value="{{ old('complemento', $ong->complemento) }}" 
                            placeholder="Sala 101, Bloco B"
                        >
                    </div>
                </div>
            </div>

            <hr class="form-divider">

            <div class="form-section">
                <h2 class="form-section-title">Acesso ao Sistema</h2>
                <p class="form-section-subtitle">Credenciais de autenticação da instituição</p>

                <div class="form-group">
                    <label for="email" class="form-label">
                        E-mail de Login <span class="required-mark">*</span>
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control"
                        value="{{ old('email', $ong->user->email ?? '') }}" 
                        required
                    >
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="senha" class="form-label">Nova Senha</label>
                        <input 
                            type="password" 
                            name="senha" 
                            id="senha" 
                            class="form-control"
                            placeholder="Deixe em branco para manter a atual"
                        >
                        <span class="form-hint">Preencha apenas caso deseje alterar a senha existente.</span>
                    </div>

                    <div class="form-group">
                        <label for="senha_confirmation" class="form-label">Confirmar Nova Senha</label>
                        <input 
                            type="password" 
                            name="senha_confirmation" 
                            id="senha_confirmation" 
                            class="form-control"
                            placeholder="Repita a nova senha"
                        >
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.ongs.index') }}" class="btn-cancel">
                    Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
