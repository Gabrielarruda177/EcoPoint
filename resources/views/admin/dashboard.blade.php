@extends('layouts.admin')

@section('titulo', 'Painel do Administrador')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v=1.3">
@endsection

@section('conteudo')
<div class="admin-dashboard-container">
    
    <div class="dashboard-header-card">
        <div class="dashboard-header-content">
            <div>
                <h1 class="dashboard-title">Painel de Controle do Administrador</h1>
                <p class="dashboard-welcome">
                   Seja bem-vindo(a), <strong>{{ auth()->user()->name }}</strong> 
                </p>
            </div>
            <div>
                <a href="{{ route('admin.ongs.create') }}" class="dashboard-btn-create">
                    + Cadastrar Nova ONG
                </a>
            </div>
        </div>
    </div>

    <div class="metrics-section-title">
        <span> Métricas do Sistema</span>
    </div>

    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-card-title">ONGs Cadastradas</span>
            </div>
            <div class="metric-value">{{ $totalOngs }}</div>
            <div class="metric-card-footer">Total de instituições no sistema</div>
        </div>

        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-card-title">ONGs Ativas</span>
            </div>
            <div class="metric-value">{{ $ongAtivas }}</div>
            <div class="metric-card-footer">Instituições ativas e operantes</div>
        </div>

        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-card-title">ONGs Inativas</span>
            </div>
            <div class="metric-value">{{ $ongInativas }}</div>
            <div class="metric-card-footer">Aguardando ativação ou suspensas</div>
        </div>

        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-card-title">Pontos de Coleta</span>
            </div>
            <div class="metric-value">{{ $totalPontos }}</div>
            <div class="metric-card-footer">Locais de arrecadação cadastrados</div>
        </div>
    </div>


<div class="metrics-section-title">
        <span>Visão Geral das ONGs</span>
    </div>

    <div class="dashboard-charts">
        {{-- Gráfico 1 — Donut: Status das ONGs --}}
        <div class="chart-card">
            <h2 class="chart-titulo">Status das ONGs</h2>
            <p class="chart-descricao">
                Distribuição das instituições ativas e inativas.
            </p>
            <div class="chart-container">
                <canvas id="ongsStatusChart"></canvas>
            </div>
        </div>

        {{-- Gráfico 2 — Barras: Pontos de Coleta por ONG --}}
        <div class="chart-card">
            <h2 class="chart-titulo">Pontos de Coleta por ONG</h2>
            <p class="chart-descricao">
                Quantidade de pontos de coleta cadastrados por instituição.
            </p>
            <div class="chart-container">
                <canvas id="pontosOngChart"></canvas>
            </div>
        </div>

        {{-- Gráfico 3 — Barras: Cadastros por Mês --}}
        <div class="chart-card">
            <h2 class="chart-titulo">Cadastros por Mês</h2>
            <p class="chart-descricao">
                Evolução mensal de novas ONGs cadastradas no sistema.
            </p>
            <div class="chart-container">
                <canvas id="ongsMesChart"></canvas>
            </div>
        </div>
    </div>
    


    <div class="metrics-section-title">
        <span> Ações Rápidas de Gestão</span>
    </div>

    <div class="modules-grid">
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


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
   
    new Chart(document.getElementById('ongsStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['ONGs Ativas', 'ONGs Inativas'],
            datasets: [{
                data: [{{ $ongAtivas }}, {{ $ongInativas }}],
                backgroundColor: ['#22c55e', '#ef4444'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 20, usePointStyle: true }
                }
            },
            cutout: '65%'
        }
    });

    const pontosData = @json($pontosPorOng);

    new Chart(document.getElementById('pontosOngChart'), {
        type: 'bar',
        data: {
            labels: pontosData.map(item => item.nome),
            datasets: [{
                label: 'Pontos de Coleta',
                data: pontosData.map(item => item.total),
                backgroundColor: '#4554db',
                borderRadius: 6,
                maxBarThickness: 50
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });


    const mesData = @json($ongsPorMes);

    new Chart(document.getElementById('ongsMesChart'), {
        type: 'bar',
        data: {
            labels: mesData.map(item => item.mes),
            datasets: [{
                label: 'ONGs Cadastradas',
                data: mesData.map(item => item.total),
                backgroundColor: '#0618b9',
                borderRadius: 6,
                maxBarThickness: 50
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
</script>

@endsection
