<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoPoint - @yield('titulo', 'Mapeamento de Coleta de Livros e Apostilas')</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f7fafc; color: #2d3748; line-height: 1.6; }
        header { background: #2f855a; color: white; padding: 1rem 2rem; }
        header .nav-container { display: flex; justify-content: space-between; align-items: center; max-width: 1100px; margin: 0 auto; }
        header a { color: white; text-decoration: none; font-weight: bold; margin-left: 1rem; }
        header a:hover { text-decoration: underline; }
        main { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; border-radius: 8px; padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 1.5rem; }
        footer { text-align: center; padding: 2rem; color: #718096; font-size: 0.9rem; }
        .badge { display: inline-block; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.8rem; background: #e2e8f0; color: #4a5568; }
        .badge-admin { background: #fed7d7; color: #9b2c2c; }
        .badge-ong { background: #c6f6d5; color: #22543d; }
    </style>
</head>
<body>
    <header>
        <div class="nav-container">
            <div>
                <a href="{{ route('publico.home') }}" style="margin-left: 0; font-size: 1.25rem;">📚 EcoPoint</a>
            </div>
            <nav>
                <a href="{{ route('publico.home') }}">Início</a>
                <a href="{{ route('publico.pontos.index') }}">Pontos de Coleta</a>
                <a href="{{ route('ong.dashboard') }}">Painel ONG</a>
                <a href="{{ route('admin.dashboard') }}">Painel Admin</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('conteudo')
    </main>

    <footer>
        <p>EcoPoint &copy; {{ date('Y') }} - Sistema de Mapeamento de Pontos de Coleta de Livros e Apostilas Acadêmicas.</p>
    </footer>
</body>
</html>

