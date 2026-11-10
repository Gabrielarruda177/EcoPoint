@extends('layouts.app')

@section('titulo', 'Painel do Administrador')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v=1.1">
@endsection

@section('conteudo')
<div class="admin-dashboard-container">
    <div class="dashboard-header-card">
        <div class="dashboard-header-content">
            <div>
                <span class="badge badge-admin">Perfil: Administrador</span>
                <h1 class="dashboard-title">Painel de Controle do Administrador</h1>
                <p class="dashboard-welcome">
                    Bem-vindo(a), <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->email }})
                </p>
            </div>
            <div>
                <a href="{{ route('admin.ongs.create') }}" class="dashboard-btn-create">
                    + Cadastrar Nova ONG
                </a>
            </div>
        </div>
    </div>

    <div class="dashboard-grid">
        <div class="module-card">
            <div>
                <span class="module-card-tag">Gerenciamento</span>
                <h2 class="module-card-title">ONGs Parceiras</h2>
                <p class="module-card-desc">
                    Consulte todas as organizações cadastradas no sistema, edite dados institucionais ou alterne seu status de ativação.
                </p>
            </div>
            <a href="{{ route('admin.ongs.index') }}" class="module-card-link">
                Acessar Gestão de ONGs &rarr;
            </a>
        </div>

        <div class="module-card">
            <div>
                <span class="module-card-tag">Cadastro Rápido</span>
                <h2 class="module-card-title">Nova Instituição</h2>
                <p class="module-card-desc">
                    Cadastre uma nova ONG com seus dados básicos e gere as credenciais iniciais de login institucional.
                </p>
            </div>
            <a href="{{ route('admin.ongs.create') }}" class="module-card-link">
                Cadastrar Instituição &rarr;
            </a>
        </div>
    </div>
</div>
@endsection
