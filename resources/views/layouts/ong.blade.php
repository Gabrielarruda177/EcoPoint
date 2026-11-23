<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoints ONG - @yield('titulo', 'Painel da Instituição')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('img/icon-ecopoints.webp') }}" type="image/x-icon">

    {{-- A sidebar é a mesma do painel Admin; o layout.css traz apenas os ajustes específicos da ONG --}}
    <link rel="stylesheet" href="{{ asset('css/admin/sidebar.css') }}?v=2.0">
    <link rel="stylesheet" href="{{ asset('css/ong/layout.css') }}?v=1.0">
    @yield('styles')
    @stack('styles')
</head>
<body class="admin-body ong-body">

    @php
        $usuarioLogado = auth()->user();
        $nomeExibicao = $usuarioLogado->ong->nome ?? $usuarioLogado->name;
    @endphp

    <aside class="admin-sidebar" id="ongSidebar" aria-label="Navegação da Instituição">

        <div class="sidebar-header">
            <a href="{{ route('ong.dashboard') }}" class="sidebar-brand-link" title="Painel EcoPoints">
                <div class="sidebar-brand-icon">
                    <svg width="26" height="26" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="18" cy="14" r="10" fill="#BCE39A"/>
                        <path d="M18 6C13.5817 6 10 9.58172 10 14C10 19.25 18 26 18 26C18 26 26 19.25 26 14C26 9.58172 22.4183 6 18 6ZM18 17C16.3431 17 15 15.6569 15 14C15 12.3431 16.3431 11 18 11C19.6569 11 21 12.3431 21 14C21 15.6569 19.6569 17 18 17Z" fill="#8FD14F"/>
                        <path d="M7 22.5L18 31L29 22.5" stroke="#3BA9E6" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="sidebar-brand-text">
                    <span class="brand-title">
                        <span class="brand-eco">Eco</span><span class="brand-points">Points</span>
                    </span>
                    <span class="brand-badge">Painel da ONG</span>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('ong.dashboard') }}" class="sidebar-link {{ request()->routeIs('ong.dashboard') ? 'active' : '' }}" title="Dashboard">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="2"/><rect x="14" y="3" width="7" height="7" rx="2"/><rect x="14" y="14" width="7" height="7" rx="2"/><rect x="3" y="14" width="7" height="7" rx="2"/>
                    </svg>
                </span>
                <span class="sidebar-label">Dashboard</span>
            </a>

            <a href="{{ route('ong.pontos.index') }}" class="sidebar-link {{ request()->routeIs('ong.pontos.index') || request()->routeIs('ong.pontos.edit') ? 'active' : '' }}" title="Meus Pontos de Coleta">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                </span>
                <span class="sidebar-label">Meus Pontos de Coleta</span>
            </a>

            <a href="{{ route('ong.pontos.create') }}" class="sidebar-link {{ request()->routeIs('ong.pontos.create') ? 'active' : '' }}" title="Novo Ponto de Coleta">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="9"/><path d="M12 8v8"/><path d="M8 12h8"/>
                    </svg>
                </span>
                <span class="sidebar-label">Novo Ponto de Coleta</span>
            </a>

            <a href="{{ route('ong.perfil.edit') }}" class="sidebar-link {{ request()->routeIs('ong.perfil.*') ? 'active' : '' }}" title="Perfil da Organização">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M8 10h.01"/><path d="M16 10h.01"/><path d="M12 10h.01"/><path d="M8 14h.01"/><path d="M16 14h.01"/><path d="M12 14h.01"/>
                    </svg>
                </span>
                <span class="sidebar-label">Perfil da Organização</span>
            </a>

            <div class="sidebar-divider"></div>

            <a href="{{ route('publico.pontos.index') }}" class="sidebar-link" target="_blank" title="Ver Pontos de Coleta">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"/><line x1="9" y1="3" x2="9" y2="18"/><line x1="15" y1="6" x2="15" y2="21"/>
                    </svg>
                </span>
                <span class="sidebar-label">Pontos de Coleta</span>
            </a>

            <a href="{{ route('publico.home') }}" class="sidebar-link" target="_blank" title="Abrir Site Público">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                    </svg>
                </span>
                <span class="sidebar-label">Ver Site Público</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="sidebar-user-card" title="{{ $nomeExibicao }} ({{ $usuarioLogado->email }})">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr($nomeExibicao ?? 'O', 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <span class="sidebar-user-name">{{ $nomeExibicao }}</span>
                    <span class="sidebar-user-email">{{ $usuarioLogado->email }}</span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="sidebar-logout-form">
                @csrf
                <button type="submit" class="sidebar-logout-btn" title="Sair da Conta">
                    <span class="sidebar-icon">
                        <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                    </span>
                    <span class="sidebar-label">Sair da Conta</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="admin-main-wrapper ong-main-wrapper">
        @if (session('status') || session('success'))
            <div class="alert-flash-success">
                {{ session('status') ?? session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert-flash-warning">
                {{ session('warning') }}
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
