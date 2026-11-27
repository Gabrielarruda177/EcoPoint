<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoints - @yield('titulo', 'Mapeamento de Coleta de Livros e Apostilas')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.0">
    <link rel="shortcut icon" href="{{ asset('img/icon-ecopoints.webp') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"> <!--Font Awesome 6 free-->
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
                <h2> <a href="{{ route('publico.home') }}">INÍCIO</a> </h2>
                <h2> <a href="{{ route('publico.sobre') }}">SOBRE NÓS</a> </h2>
                <h2> <a href="{{ route('publico.ongs.index') }}">AS ONGS</a> </h2>
                <h2> <a href="{{ route('publico.contato')}}">FALE CONOSCO</a> </h2>

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

        <div class="footer-content">

            <div class="sobre-nos-footer">

                <img src="{{ asset('img/logotipo.png') }}" alt="logotipo"></img>

                

            <!--<h2>SOBRE NÓS</h2>-->

                <p>Uma plataforma acadêmica que busca aproximar cidadãos e ONGs para doação de livros didáticos/acadêmicos e apostilas.</p>

                <a href="{{ route('publico.home') }}#local"> SEU LIVRO, NO PRÓXIMO PONTO > </a>

            </div>

            <div class="ecopoints-footer">

                <h2>ECOPOINTS</h2>

                <ul>
                    <li> <a href="{{ route('publico.home') }}">Início</a> </li>
                    <li> <a href="{{ route('publico.sobre') }}">Sobre Nós</a> </li>
                    <li> <a href="{{ route('publico.ongs.index') }}">As ONGs</a> </li>
                    <li> <a href="{{ route('publico.contato')}}">Fale Conosco</a> </li>
                </ul>        

            </div>

            <div class="areas-restritas-footer">

                <h2>ÁREAS RESTRITAS</h2>

                <ul>
                    <li> <a href="{{ route('admin.dashboard') }}"> Acesso restrito ADM </a> </li>
                    <li> <a href="{{ route('ong.dashboard') }}"> Acesso restrito ONG </a> </li>
                    <li> <a href="{{ route('admin.ongs.create') }}"> Cadastrar nova ONG </a> </li>
                    <li> <a href="{{ route('ong.pontos.create') }}"> Cadastrar novo ecoponto </a> </li>
                </ul>

            </div>

            <div class="fale-conosco-footer">

                <h2>FALE CONOSCO</h2>

                <ul>
                    <li> <i class="fa-solid fa-phone"></i> (11) 9910-6070 </li>
                    <li> <i class="fa-brands fa-whatsapp"></i> (11) 99100-6070 </li>
                    <li> <i class="fa-solid fa-envelope"></i> ecopoints@eco.com.br </li>
                </ul>

            </div>

            <div class="academico-footer">

                <h3>ACADÊMICO</h3>

                <p>Projeto de Mapeamento de Pontos de Coleta para Livros e Materiais Didáticos desenvolvido para Fatec Itaquera.</p>

            </div>

        </div>

        <p class="copyright-txt">EcoPoint &copy; {{ date('Y') }} - Sistema de Mapeamento de Pontos de Coleta de Livros e Apostilas Acadêmicas.</p>
        
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
