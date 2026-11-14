<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoint Admin - @yield('titulo', 'Painel de Controle')</title>

    <!-- Google Font Anton & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS da Sidebar e Layout Admin -->
    <link rel="stylesheet" href="{{ asset('css/admin/sidebar.css') }}?v=1.2">
    @yield('styles')
    @stack('styles')
</head>
<body class="admin-body">

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Navegação Administrativa">

    <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-link" title="Painel EcoPoint">
                <div class="sidebar-brand-icon">📚</div>
                <div class="sidebar-brand-text">
                    <span class="brand-title">EcoPoint</span>
                    <span class="brand-badge">PAINEL ADMIN</span>
                </div>
            </a>
        </div>


        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                <span class="sidebar-icon">📊</span>
                <span class="sidebar-label">Dashboard</span>
            </a>

            <a href="{{ route('admin.ongs.index') }}" class="sidebar-link {{ request()->routeIs('admin.ongs.index*') || request()->routeIs('admin.ongs.edit*') ? 'active' : '' }}" title="ONGs Parceiras">
                <span class="sidebar-icon">🏢</span>
                <span class="sidebar-label">ONGs Parceiras</span>
            </a>

            <a href="{{ route('admin.ongs.create') }}" class="sidebar-link {{ request()->routeIs('admin.ongs.create') ? 'active' : '' }}" title="Cadastrar Nova ONG">
                <span class="sidebar-icon">➕</span>
                <span class="sidebar-label">Nova Instituição</span>
            </a>

            <div class="sidebar-divider"></div>

            <a href="{{ route('publico.pontos.index') }}" class="sidebar-link" target="_blank" title="Ver Pontos de Coleta">
                <span class="sidebar-icon">📍</span>
                <span class="sidebar-label">Pontos de Coleta</span>
            </a>

            <a href="{{ route('publico.home') }}" class="sidebar-link" target="_blank" title="Abrir Site Público">
                <span class="sidebar-icon">🌐</span>
                <span class="sidebar-label">Ver Site Público</span>
            </a>
        </nav>


        <div class="sidebar-footer">
            <div class="sidebar-user-card" title="{{ auth()->user()->name }} ({{ auth()->user()->email }})">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <span class="sidebar-user-name">{{ auth()->user()->name }}</span>
                    <span class="sidebar-user-email">{{ auth()->user()->email }}</span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form">
                @csrf
                <button type="submit" class="sidebar-logout-btn" title="Sair da Conta">
                    <span class="sidebar-icon">🚪</span>
                    <span class="sidebar-label">Sair da Conta</span>
                </button>
            </form>
        </div>
    </aside>


    <main class="admin-main-wrapper">
        @if (session('status') || session('success'))
            <div class="alert-flash-success">
                {{ session('status') ?? session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-flash-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('conteudo')
    </main>

    @yield('scripts')
    @stack('scripts')
</body>
</html>

