<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoints - @yield('titulo', 'Mapeamento de Coleta de Livros e Apostilas')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.0">
    <link rel="shortcut icon" href="{{ asset('img/icon-ecopoints.webp') }}" type="image/x-icon">
    @yield('styles')
    @stack('styles')
</head>
<body>
    <header>
        <div class="nav-container">
            <div>
                <a href="{{ route('publico.home') }}">
                    <img src="{{ asset('img/logo-ecopoints.webp') }}" alt="Logo">
                </a>
            </div>
            
            <button class="menu-toggle" id="menu-toggle" aria-label="Abrir menu" >
                <span></span>
                <span></span>
                <span></span>
            </button>
                    
            <nav id="nav-links">
                <a href="{{ route('publico.home') }}">INÍCIO</a>
                <a href="{{ route('publico.sobre') }}">SOBRE NÓS</a>
                <a href="{{ route('publico.ongs.index') }}">ONGS</a>
                <a href="{{ route('publico.contato')}}">FALE CONOSCO</a>

                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-btn-panel">
                            <p>Área da Administrador</p>
                        </a>
                    @elseif(auth()->user()->isOng())
                        <a href="{{ route('ong.dashboard') }}" class="nav-btn-panel">
                            <p>Área da ONG</p>
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-logout-btn">
                            <p>Sair</p>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" id="nav-btn-login">
                        <p>Sua Conta</p>
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

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
