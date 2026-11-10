@extends('layouts.app')

@section('titulo', 'Entrar no Sistema')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}?v=1.2">
@endsection

@section('conteudo')
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <span id="role-badge" class="badge {{ old('perfil', 'admin') === 'admin' ? 'badge-admin' : 'badge-ong' }}">
                {{ old('perfil', 'admin') === 'admin' ? 'Perfil: Administrador' : 'Perfil: Instituição Parceira' }}
            </span>
            <h1 class="login-title">Entrar no EcoPoint</h1>
            <p id="role-subtitle" class="login-subtitle">
                {{ old('perfil', 'admin') === 'admin' 
                    ? 'Acesso restrito para administração e moderação geral do sistema.' 
                    : 'Acesso institucional para gerenciar pontos de coleta e dados da sua ONG.' }}
            </p>
        </div>

        @if (session('status'))
            <div class="login-alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="login-alert-error">
                <ul class="login-alert-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.attempt') }}" method="POST" id="form-login">
            @csrf

            <!-- Seletor de Perfil (Admin vs ONG) -->
            <div class="role-selector">
                <label class="role-pill role-admin {{ old('perfil', 'admin') === 'admin' ? 'active' : '' }}" id="label-role-admin">
                    <input 
                        type="radio" 
                        name="perfil" 
                        value="admin" 
                        {{ old('perfil', 'admin') === 'admin' ? 'checked' : '' }}
                        onchange="setPerfil('admin')"
                    >
                    <span>🛡️ Administrador</span>
                </label>

                <label class="role-pill role-ong {{ old('perfil') === 'ong' ? 'active' : '' }}" id="label-role-ong">
                    <input 
                        type="radio" 
                        name="perfil" 
                        value="ong" 
                        {{ old('perfil') === 'ong' ? 'checked' : '' }}
                        onchange="setPerfil('ong')"
                    >
                    <span>🏢 ONG Parceira</span>
                </label>
            </div>

            <div class="login-form-group">
                <label for="email" class="login-label">
                    E-mail de Acesso
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="login-input"
                    value="{{ old('email') }}" 
                    required 
                    autofocus
                    placeholder="{{ old('perfil', 'admin') === 'admin' ? 'admin@ecopoint.com' : 'ong@ecopoint.com' }}"
                >
            </div>

            <div class="login-form-group">
                <label for="password" class="login-label">
                    Senha
                </label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="login-input"
                    required 
                    placeholder="••••••••"
                >
            </div>

            <label class="login-remember">
                <input type="checkbox" name="remember" id="remember">
                Lembrar-me neste dispositivo
            </label>

            <button type="submit" class="login-btn-submit" id="btn-submit-text">
                {{ old('perfil', 'admin') === 'admin' ? 'Entrar como Administrador' : 'Entrar como ONG' }}
            </button>
        </form>

        <!-- Caixa de Credenciais Prontas do Seeder -->
        <div class="login-credentials-box">
            <div class="login-credentials-title">
                🔑 Credenciais Rápidas de Teste (Seeders):
            </div>
            <div class="credentials-grid">
                <div class="credential-item" onclick="fillCredentials('admin', 'admin@ecopoint.com', 'admin123')">
                    <div class="credential-item-title credential-admin">🛡️ Administrador</div>
                    <div class="credential-item-code">admin@ecopoint.com</div>
                    <div class="credential-item-code">Senha: admin123</div>
                    <span class="btn-fill-hint">&darr; Preencher Admin</span>
                </div>

                <div class="credential-item" onclick="fillCredentials('ong', 'ong@ecopoint.com', 'ong123')">
                    <div class="credential-item-title credential-ong">🏢 ONG Parceira</div>
                    <div class="credential-item-code">ong@ecopoint.com</div>
                    <div class="credential-item-code">Senha: ong123</div>
                    <span class="btn-fill-hint">&darr; Preencher ONG</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setPerfil(perfil) {
        const badge = document.getElementById('role-badge');
        const subtitle = document.getElementById('role-subtitle');
        const emailInput = document.getElementById('email');
        const submitBtn = document.getElementById('btn-submit-text');
        const labelAdmin = document.getElementById('label-role-admin');
        const labelOng = document.getElementById('label-role-ong');

        if (perfil === 'admin') {
            labelAdmin.classList.add('active');
            labelOng.classList.remove('active');
            badge.className = 'badge badge-admin';
            badge.textContent = 'Perfil: Administrador';
            subtitle.textContent = 'Acesso restrito para administração e moderação geral do sistema.';
            emailInput.placeholder = 'admin@ecopoint.com';
            submitBtn.textContent = 'Entrar como Administrador';
        } else {
            labelOng.classList.add('active');
            labelAdmin.classList.remove('active');
            badge.className = 'badge badge-ong';
            badge.textContent = 'Perfil: Instituição Parceira';
            subtitle.textContent = 'Acesso institucional para gerenciar pontos de coleta e dados da sua ONG.';
            emailInput.placeholder = 'ong@ecopoint.com';
            submitBtn.textContent = 'Entrar como ONG';
        }
    }

    function fillCredentials(perfil, email, senha) {
        const radio = document.querySelector(`input[name="perfil"][value="${perfil}"]`);
        if (radio) {
            radio.checked = true;
            setPerfil(perfil);
        }
        document.getElementById('email').value = email;
        document.getElementById('password').value = senha;
    }
</script>
@endsection
