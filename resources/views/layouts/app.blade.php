<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoint - @yield('titulo', 'Mapeamento de Coleta de Livros e Apostilas')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.0">
    @yield('styles')
    @stack('styles')
</head>
<body>
    <header>
        <div class="nav-container">
            <div>
                <a href="{{ route('publico.home') }}" class="nav-brand">📚 EcoPoint</a>
            </div>
            <nav class="nav-links">
                <a href="{{ route('publico.home') }}">Início</a>
                <a href="{{ route('publico.pontos.index') }}">Pontos de Coleta</a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-btn-panel">Painel Admin</a>
                    @elseif(auth()->user()->isOng())
                        <a href="{{ route('ong.dashboard') }}" class="nav-btn-panel">Painel ONG</a>
                    @endif

                    <span class="nav-user-name">
                        👤 {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="nav-logout-form">
                        @csrf
                        <button type="submit" class="nav-logout-btn">
                            Sair
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="nav-btn-login">
                        Entrar
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        @if ((session('status') || session('success')) && !request()->routeIs('login'))
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

    <footer>
        <p>EcoPoint &copy; {{ date('Y') }} - Sistema de Mapeamento de Pontos de Coleta de Livros e Apostilas Acadêmicas.</p>
    </footer>
</body>
</html>
