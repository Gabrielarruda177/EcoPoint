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

    <link rel="stylesheet" href="{{ asset('css/admin/sidebar.css') }}?v=4.0">
    <link rel="stylesheet" href="{{ asset('css/ong/layout.css') }}?v=1.0">
    @yield('styles')
    @stack('styles')
</head>
<body class="admin-body ong-body">

    @php
        $usuarioLogado = auth()->user();
        $nomeExibicao = $usuarioLogado->ong->nome ?? $usuarioLogado->name;
    @endphp

    {{-- TOPBAR MOBILE --}}
    <header class="admin-mobile-topbar" id="ongMobileTopbar">
        <button type="button" class="mobile-hamburger-btn" id="mobileMenuBtn" aria-label="Abrir Menu Lateral">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="3" y1="12" x2="21" y2="12"></line>
                <line x1="3" y1="6" x2="21" y2="6"></line>
                <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
        </button>

        <a href="{{ route('ong.dashboard') }}" class="mobile-brand-link">
            <div class="mobile-brand-icon">
                <svg width="20" height="20" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="18" cy="14" r="10" fill="#BCE39A"/>
                    <path d="M18 6C13.5817 6 10 9.58172 10 14C10 19.25 18 26 18 26C18 26 26 19.25 26 14C26 9.58172 22.4183 6 18 6ZM18 17C16.3431 17 15 15.6569 15 14C15 12.3431 16.3431 11 18 11C19.6569 11 21 12.3431 21 14C21 15.6569 19.6569 17 18 17Z" fill="#8FD14F"/>
                    <path d="M7 22.5L18 31L29 22.5" stroke="#3BA9E6" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="mobile-brand-text">
                <span class="brand-eco">Eco</span><span class="brand-points">Points</span>
                <span class="mobile-admin-tag">ONG</span>
            </div>
        </a>

        <div class="mobile-user-avatar">
            {{ strtoupper(substr($nomeExibicao ?? 'O', 0, 1)) }}
        </div>
    </header>

    {{-- BACKDROP PARA TELAS MENORES --}}
    <div class="sidebar-backdrop" id="sidebarBackdrop" aria-hidden="true"></div>

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

            {{-- BOTÃO FECHAR NO MOBILE --}}
            <button type="button" class="sidebar-close-btn mobile-only" id="mobileSidebarClose" title="Fechar Menu" aria-label="Fechar menu">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('ong.dashboard') }}" class="sidebar-link {{ request()->routeIs('ong.dashboard') ? 'active' : '' }}" title="Dashboard da Instituição">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="2"/><rect x="14" y="3" width="7" height="7" rx="2"/><rect x="14" y="14" width="7" height="7" rx="2"/><rect x="3" y="14" width="7" height="7" rx="2"/>
                    </svg>
                </span>
                <span class="sidebar-label">Dashboard</span>
            </a>

            <a href="{{ route('ong.pontos.index') }}" class="sidebar-link {{ request()->routeIs('ong.pontos.*') ? 'active' : '' }}" title="Gerenciar Meus Pontos de Coleta">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>
                    </svg>
                </span>
                <span class="sidebar-label">Pontos de Coleta</span>
            </a>

            <a href="{{ route('ong.perfil.edit') }}" class="sidebar-link {{ request()->routeIs('ong.perfil.*') ? 'active' : '' }}" title="Dados da Instituição">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </span>
                <span class="sidebar-label">Meu Perfil</span>
            </a>

            <div class="sidebar-divider"></div>

            <a href="{{ route('publico.pontos.index') }}" class="sidebar-link" target="_blank" title="Ver no Mapa Público">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
                    </svg>
                </span>
                <span class="sidebar-label">Mapa Público</span>
            </a>

            <a href="{{ route('publico.home') }}" class="sidebar-link" target="_blank" title="Página Inicial do EcoPoints">
                <span class="sidebar-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
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
            <div class="alert-flash alert-flash-success">
                {{ session('status') ?? session('success') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert-flash alert-flash-warning">
                {{ session('warning') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-flash alert-flash-error">
                {{ session('error') }}
            </div>
        @endif

        @yield('conteudo')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const body = document.body;
            const sidebar = document.getElementById('ongSidebar');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const mobileCloseBtn = document.getElementById('mobileSidebarClose');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (sidebar) {
                sidebar.addEventListener('mouseenter', function() {
                    if (window.innerWidth >= 992) {
                        body.classList.add('sidebar-hovered');
                    }
                });

                sidebar.addEventListener('mouseleave', function() {
                    if (window.innerWidth >= 992) {
                        body.classList.remove('sidebar-hovered');
                    }
                });

                sidebar.addEventListener('transitionend', function(e) {
                    if (e.propertyName === 'width' && window.innerWidth >= 992) {
                        window.dispatchEvent(new Event('resize'));
                    }
                });
            }

            function abrirMenuMobile() {
                body.classList.add('mobile-sidebar-open');
                if (backdrop) backdrop.classList.add('active');
            }

            function fecharMenuMobile() {
                body.classList.remove('mobile-sidebar-open');
                if (backdrop) backdrop.classList.remove('active');
            }

            if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', abrirMenuMobile);
            if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', fecharMenuMobile);
            if (backdrop) backdrop.addEventListener('click', fecharMenuMobile);

            window.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && body.classList.contains('mobile-sidebar-open')) {
                    fecharMenuMobile();
                }
            });

            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    fecharMenuMobile();
                }
            });
        });
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
