@extends('layouts.app')

@section('titulo', 'Editar Perfil Institucional')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/perfil-edit.css') }}?v=1.1">
@endsection

@section('conteudo')
<div class="perfil-container">
    <div class="perfil-card">
        <div class="perfil-header">
            <span class="badge badge-ong">Perfil: ONG</span>
            <h1 class="perfil-title">Perfil Institucional da Organização</h1>
            <p class="perfil-subtitle">
                Atualize as informações públicas da sua entidade e gerencie suas credenciais de acesso.
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

        <form action="{{ route('ong.perfil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Seção 1: Dados da Instituição -->
            <div class="form-section">
                <h2 class="form-section-title">1. Dados da Instituição</h2>
                <p class="form-section-subtitle">Identificação da sua organização parceira</p>

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
                        placeholder="Ex.: Instituto Esperança Viva" 
                        required
                    >
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="cnpj" class="form-label">CNPJ</label>
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
                        <label for="telefone" class="form-label">Telefone de Contato</label>
                        <input 
                            type="text" 
                            name="telefone" 
                            id="telefone" 
                            class="form-control" 
                            value="{{ old('telefone', $ong->telefone) }}" 
                            placeholder="(11) 98765-4321"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="email_contato" class="form-label">E-mail Institucional Público</label>
                    <input 
                        type="email" 
                        name="email_contato" 
                        id="email_contato" 
                        class="form-control" 
                        value="{{ old('email_contato', $ong->email_contato) }}" 
                        placeholder="contato@instituicao.org"
                    >
                    <span class="form-hint">E-mail de divulgação para voluntários e doadores entrarem em contato.</span>
                </div>

                <div class="form-group">
                    <label for="descricao" class="form-label">Descrição Institucional</label>
                    <textarea 
                        name="descricao" 
                        id="descricao" 
                        class="form-control" 
                        rows="3" 
                        placeholder="Conte sobre a missão da organização, projeto acadêmico de reciclagem de livros, público atendido..."
                    >{{ old('descricao', $ong->descricao) }}</textarea>
                </div>
            </div>

            <!-- Seção 2: Conta de Acesso e Senha -->
            <div class="form-section">
                <h2 class="form-section-title">2. Acesso ao Sistema e Senha</h2>
                <p class="form-section-subtitle">Para manter a senha atual, basta deixar os campos abaixo em branco</p>

                <div class="form-group">
                    <label for="email_acesso" class="form-label">E-mail de Login</label>
                    <input 
                        type="email" 
                        id="email_acesso" 
                        class="form-control" 
                        value="{{ $ong->user->email ?? auth()->user()->email }}" 
                        readonly
                    >
                    <span class="form-hint">O e-mail de acesso é gerenciado pelo administrador do sistema.</span>
                </div>

                <div class="form-group">
                    <label for="senha_atual" class="form-label">Senha Atual</label>
                    <input 
                        type="password" 
                        name="senha_atual" 
                        id="senha_atual" 
                        class="form-control" 
                        placeholder="Informe sua senha atual apenas se for alterá-la"
                    >
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="nova_senha" class="form-label">Nova Senha</label>
                        <input 
                            type="password" 
                            name="nova_senha" 
                            id="nova_senha" 
                            class="form-control" 
                            placeholder="Mínimo 8 caracteres"
                        >
                    </div>

                    <div class="form-group">
                        <label for="nova_senha_confirmation" class="form-label">Confirmar Nova Senha</label>
                        <input 
                            type="password" 
                            name="nova_senha_confirmation" 
                            id="nova_senha_confirmation" 
                            class="form-control" 
                            placeholder="Repita a nova senha"
                        >
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('ong.dashboard') }}" class="btn-cancel" style="border: 1px solid #cbd5e0; padding: 0.7rem 1.25rem; border-radius: 6px; text-decoration: none; color: #4a5568; font-weight: 600;">
                    Voltar ao Painel
                </a>
                <button type="submit" class="btn-submit">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
