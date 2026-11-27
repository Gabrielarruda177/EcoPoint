@extends('layouts.app')

@section('titulo', 'Entrar no Sistema')
@section('semFooter', true)

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}?v=5.0">
@endsection

@section('conteudo')
@php
    $isOngInicial = old('perfil', 'admin') === 'ong';
@endphp

<div class="login-stage {{ $isOngInicial ? 'ong-theme' : '' }}" id="loginStage">
    <div class="auth-wrapper {{ $isOngInicial ? 'ong-active' : '' }}" id="authWrapper">

        {{-- Seletor Mobile --}}
        <div class="mobile-switch-bar">
            <button type="button" class="mobile-switch-tab {{ !$isOngInicial ? 'active-admin' : '' }}" id="mobileTabAdmin" onclick="switchAuthMode('admin')">
                Administrador
            </button>
            <button type="button" class="mobile-switch-tab {{ $isOngInicial ? 'active-ong' : '' }}" id="mobileTabOng" onclick="switchAuthMode('ong')">
                ONG Parceira
            </button>
        </div>

        {{-- Cortina Diagonal --}}
        <div class="diagonal-curtain" aria-hidden="true"></div>

        {{-- Formulário Administrador --}}
        <div class="form-box admin-box">
            <div class="form-inner">
                <span class="login-badge-pill badge-pill-admin">Perfil: Administrador</span>
                <h1 class="login-title">Entrar no EcoPoint</h1>
                <p class="login-subtitle">
                    Acesso restrito para administração, cadastro de instituições e aprovação de solicitações.
                </p>

                @if (session('status') && !$isOngInicial)
                    <div class="login-alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any() && !$isOngInicial)
                    <div class="login-alert-error">
                        <ul class="login-alert-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.attempt') }}" method="POST">
                    @csrf
                    <input type="hidden" name="perfil" value="admin">

                    <div class="login-form-group">
                        <label for="admin-email" class="login-label">E-mail de Acesso</label>
                        <div class="login-input-wrap">
                            <svg class="login-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <input
                                type="email"
                                name="email"
                                id="admin-email"
                                class="login-input"
                                value="{{ !$isOngInicial ? old('email') : '' }}"
                                required
                                placeholder="admin@ecopoint.com"
                            >
                        </div>
                    </div>

                    <div class="login-form-group">
                        <label for="admin-password" class="login-label">Senha</label>
                        <div class="login-input-wrap">
                            <svg class="login-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input
                                type="password"
                                name="password"
                                id="admin-password"
                                class="login-input"
                                required
                                placeholder="••••••••"
                            >
                        </div>
                    </div>

                    <label class="login-remember">
                        <input type="checkbox" name="remember">
                        Lembrar-me neste dispositivo
                    </label>

                    <button type="submit" class="login-btn-submit">
                        Entrar como Administrador
                    </button>
                </form>

                <div class="quick-cred-card" onclick="preencherAcesso('admin', 'admin@ecopoint.com', 'admin123')">
                    <div class="quick-cred-info">
                        <strong>Acesso Rápido (Seeder)</strong>
                        <span>admin@ecopoint.com &middot; Senha: admin123</span>
                    </div>
                    <span class="quick-cred-action">Preencher &rarr;</span>
                </div>
            </div>
        </div>

        {{-- Boas-vindas Administrador --}}
        <div class="info-box admin-info">
            <div class="info-logo-pill">
                <img src="{{ asset('img/logo-ecopoints.png') }}" alt="EcoPoints" class="info-logo-img">
            </div>
            <h2 class="info-heading">Bem-vindo de volta!</h2>
            <p class="info-sub">
                Gerencie organizações parceiras, valide solicitações cadastrais e acompanhe a rede de coleta de livros em todo o país.
            </p>
            <button type="button" class="info-switch-btn" onclick="switchAuthMode('ong')">
                Sou uma ONG Parceira
            </button>
        </div>

        {{-- Boas-vindas ONG --}}
        <div class="info-box ong-info">
            <div class="info-logo-pill">
                <img src="{{ asset('img/logo-ecopoints.png') }}" alt="EcoPoints" class="info-logo-img">
            </div>
            <h2 class="info-heading">Portal da Instituição</h2>
            <p class="info-sub">
                Acesse o painel da sua ONG para gerenciar pontos de coleta, visualizar métricas operacionais e atualizar seus canais de contato.
            </p>
            <button type="button" class="info-switch-btn" onclick="switchAuthMode('admin')">
                Acessar como Administrador
            </button>
        </div>

        {{-- Formulário ONG Parceira --}}
        <div class="form-box ong-box">
            <div class="form-inner">
                <span class="login-badge-pill badge-pill-ong">Perfil: Instituição Parceira</span>
                <h1 class="login-title">Entrar no EcoPoint</h1>
                <p class="login-subtitle">
                    Acesso institucional para gerenciar pontos de coleta e dados da sua organização.
                </p>

                @if (session('status') && $isOngInicial)
                    <div class="login-alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any() && $isOngInicial)
                    <div class="login-alert-error">
                        <ul class="login-alert-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.attempt') }}" method="POST">
                    @csrf
                    <input type="hidden" name="perfil" value="ong">

                    <div class="login-form-group">
                        <label for="ong-email" class="login-label">E-mail Institucional</label>
                        <div class="login-input-wrap">
                            <svg class="login-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <input
                                type="email"
                                name="email"
                                id="ong-email"
                                class="login-input"
                                value="{{ $isOngInicial ? old('email') : '' }}"
                                required
                                placeholder="ong@ecopoint.com"
                            >
                        </div>
                    </div>

                    <div class="login-form-group">
                        <label for="ong-password" class="login-label">Senha</label>
                        <div class="login-input-wrap">
                            <svg class="login-input-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input
                                type="password"
                                name="password"
                                id="ong-password"
                                class="login-input"
                                required
                                placeholder="••••••••"
                            >
                        </div>
                    </div>

                    <label class="login-remember">
                        <input type="checkbox" name="remember">
                        Lembrar-me neste dispositivo
                    </label>

                    <button type="submit" class="login-btn-submit login-btn-ong">
                        Entrar como ONG
                    </button>
                </form>

                <div class="quick-cred-card" onclick="preencherAcesso('ong', 'ong@ecopoint.com', 'ong123')">
                    <div class="quick-cred-info">
                        <strong>Acesso Rápido (Seeder)</strong>
                        <span>ong@ecopoint.com &middot; Senha: ong123</span>
                    </div>
                    <span class="quick-cred-action">Preencher &rarr;</span>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function switchAuthMode(mode) {
        const wrapper = document.getElementById('authWrapper');
        const stage = document.getElementById('loginStage');
        const tabAdmin = document.getElementById('mobileTabAdmin');
        const tabOng = document.getElementById('mobileTabOng');

        if (mode === 'ong') {
            wrapper.classList.add('ong-active');
            stage.classList.add('ong-theme');
            document.body.classList.add('login-ong-theme');
            if (tabAdmin) tabAdmin.className = 'mobile-switch-tab';
            if (tabOng) tabOng.className = 'mobile-switch-tab active-ong';
        } else {
            wrapper.classList.remove('ong-active');
            stage.classList.remove('ong-theme');
            document.body.classList.remove('login-ong-theme');
            if (tabAdmin) tabAdmin.className = 'mobile-switch-tab active-admin';
            if (tabOng) tabOng.className = 'mobile-switch-tab';
        }
    }

    @if ($isOngInicial)
        document.body.classList.add('login-ong-theme');
    @endif

    function preencherAcesso(perfil, email, senha) {
        switchAuthMode(perfil);
        if (perfil === 'ong') {
            document.getElementById('ong-email').value = email;
            document.getElementById('ong-password').value = senha;
        } else {
            document.getElementById('admin-email').value = email;
            document.getElementById('admin-password').value = senha;
        }
    }
</script>
@endsection
