@extends('layouts.admin')

@section('titulo', 'Painel do Administrador')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}?v=3.0">
@endsection

@section('conteudo')
<div class="admin-dashboard-container">

    {{-- ============================================================
         BANNER DE BOAS-VINDAS
         ============================================================ --}}
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

    {{-- ============================================================
         SEÇÃO 1 — MÉTRICAS DO SISTEMA
         ============================================================ --}}
    <div class="section-title">
        <span>Métricas do Sistema</span>
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

        {{-- Card Pontos de Coleta com ícone de mapa do Brasil (como na Imagem 1) --}}
        <div class="metric-card metric-card-pontos">
            <div class="metric-card-top">
                <span class="metric-card-title">Pontos de Coleta</span>
            </div>
            <div class="metric-value-row">
                <span class="metric-value">{{ $totalPontos }}</span>
                <img src="{{ asset('img/icon-mapa.png') }}" class="metric-mini-mapa" alt="Mapa do Brasil">
            </div>
            <div class="metric-card-footer">Locais de arrecadação cadastrados</div>
        </div>

        {{-- Indicador: Média de Pontos por ONG --}}
        <div class="metric-card">
            <div class="metric-card-top">
                <span class="metric-card-title">Média Pontos / ONG</span>
            </div>
            <div class="metric-value">{{ $mediaPontosPorOng }}</div>
            <div class="metric-card-footer">Média de pontos vinculados por entidade</div>
        </div>
    </div>

    {{-- ============================================================
         SEÇÃO 2 — MAPA DO BRASIL (COBERTURA REGIONAL)
         ============================================================ --}}
    <div class="section-title">
        <span>Distribuição Geográfica no Brasil</span>
    </div>

    <div class="mapa-brasil-card">
        <div class="mapa-card-header">
            <div>
                <span class="module-card-tag">Cobertura Nacional</span>
                <h2 class="mapa-card-title">Pontos de Coleta por Macrorregião</h2>
                <p class="mapa-card-subtitle">Mapeamento em tempo real da infraestrutura ecológica do EcoPoint no território brasileiro</p>
            </div>
            <div>
                <span class="status-pill status-active">{{ $regioesAtendidasCount }}/5 Regiões Atendidas</span>
            </div>
        </div>

        <div class="mapa-card-body">
            {{-- Lado Esquerdo: Mapa SVG do Brasil (como na Imagem 2) --}}
            <div class="mapa-svg-wrapper">
                <div id="mapa-tooltip" class="mapa-tooltip"></div>

                <svg viewBox="0 0 540 560" class="mapa-brasil-svg" xmlns="http://www.w3.org/2000/svg">
                    {{-- REGIÃO NORTE --}}
                    <g class="mapa-regiao" data-regiao="Norte" data-total="{{ $pontosPorRegiao['Norte'] ?? 0 }}" data-ongs="{{ $ongsPorRegiao['Norte'] ?? 0 }}">
                        <path class="regiao-path" d="M 30,240 C 45,210 55,185 85,160 C 115,135 150,90 190,55 C 215,35 240,40 265,50 C 300,45 330,65 355,85 C 380,105 385,120 380,140 C 370,165 350,185 340,215 C 330,245 315,255 290,255 C 250,255 210,270 180,280 C 140,290 100,280 60,265 Z"
                              fill="#4554db" />
                        <text x="210" y="160" class="regiao-label">Norte</text>
                        <text x="210" y="182" class="regiao-badge">{{ $pontosPorRegiao['Norte'] ?? 0 }} pontos</text>
                    </g>

                    {{-- REGIÃO NORDESTE --}}
                    <g class="mapa-regiao" data-regiao="Nordeste" data-total="{{ $pontosPorRegiao['Nordeste'] ?? 0 }}" data-ongs="{{ $ongsPorRegiao['Nordeste'] ?? 0 }}">
                        <path class="regiao-path" d="M 380,140 C 400,120 435,115 465,125 C 495,135 520,160 525,185 C 530,215 500,245 480,270 C 460,295 445,330 425,345 C 405,355 385,340 370,320 C 355,300 345,280 340,255 C 335,230 350,185 365,165 Z"
                              fill="#0618b9" />
                        <text x="440" y="215" class="regiao-label">Nordeste</text>
                        <text x="440" y="237" class="regiao-badge">{{ $pontosPorRegiao['Nordeste'] ?? 0 }} pontos</text>
                    </g>

                    {{-- REGIÃO CENTRO-OESTE --}}
                    <g class="mapa-regiao" data-regiao="Centro-Oeste" data-total="{{ $pontosPorRegiao['Centro-Oeste'] ?? 0 }}" data-ongs="{{ $ongsPorRegiao['Centro-Oeste'] ?? 0 }}">
                        <path class="regiao-path" d="M 180,280 C 210,270 250,255 290,255 C 315,255 330,265 340,285 C 350,305 340,335 320,350 C 300,365 280,380 270,405 C 255,410 235,405 215,385 C 195,360 190,340 160,325 C 145,315 160,295 180,280 Z"
                              fill="#548D95" />
                        <text x="260" y="325" class="regiao-label">Centro-Oeste</text>
                        <text x="260" y="347" class="regiao-badge">{{ $pontosPorRegiao['Centro-Oeste'] ?? 0 }} pontos</text>
                    </g>

                    {{-- REGIÃO SUDESTE --}}
                    <g class="mapa-regiao" data-regiao="Sudeste" data-total="{{ $pontosPorRegiao['Sudeste'] ?? 0 }}" data-ongs="{{ $ongsPorRegiao['Sudeste'] ?? 0 }}">
                        <path class="regiao-path" d="M 370,320 C 385,340 405,355 425,345 C 445,365 440,390 415,415 C 390,430 365,435 340,435 C 315,435 290,425 270,405 C 280,380 300,365 320,350 C 340,335 350,305 370,320 Z"
                              fill="#04108a" />
                        <text x="365" y="380" class="regiao-label">Sudeste</text>
                        <text x="365" y="402" class="regiao-badge">{{ $pontosPorRegiao['Sudeste'] ?? 0 }} pontos</text>
                    </g>

                    {{-- REGIÃO SUL --}}
                    <g class="mapa-regiao" data-regiao="Sul" data-total="{{ $pontosPorRegiao['Sul'] ?? 0 }}" data-ongs="{{ $ongsPorRegiao['Sul'] ?? 0 }}">
                        <path class="regiao-path" d="M 270,405 C 290,425 315,435 340,435 C 330,465 315,505 295,535 C 275,555 255,545 240,520 C 225,485 220,455 245,425 Z"
                              fill="#76C1C3" />
                        <text x="285" y="475" class="regiao-label">Sul</text>
                        <text x="285" y="497" class="regiao-badge">{{ $pontosPorRegiao['Sul'] ?? 0 }} pontos</text>
                    </g>
                </svg>
            </div>

            {{-- Lado Direito: Legenda e Desempenho Regional (como na Imagem 2) --}}
            <div class="mapa-legendas-wrapper">
                <h3 class="legendas-title">Desempenho por Região</h3>
                <div class="legendas-list">
                    @php
                        $coresRegiao = [
                            'Norte'        => ['cor' => '#4554db', 'ufs' => 'AC, AP, AM, PA, RO, RR, TO'],
                            'Nordeste'     => ['cor' => '#0618b9', 'ufs' => 'AL, BA, CE, MA, PB, PE, PI, RN, SE'],
                            'Centro-Oeste' => ['cor' => '#548D95', 'ufs' => 'DF, GO, MT, MS'],
                            'Sudeste'      => ['cor' => '#04108a', 'ufs' => 'ES, MG, RJ, SP'],
                            'Sul'          => ['cor' => '#76C1C3', 'ufs' => 'PR, RS, SC'],
                        ];
                    @endphp

                    @foreach ($coresRegiao as $regiaoNome => $meta)
                        @php
                            $qtdPontos = $pontosPorRegiao[$regiaoNome] ?? 0;
                            $percent = $totalPontos > 0 ? round(($qtdPontos / $totalPontos) * 100) : 0;
                        @endphp
                        <div class="legenda-card" data-regiao="{{ $regiaoNome }}">
                            <div class="legenda-card-left">
                                <span class="legenda-dot" style="background-color: {{ $meta['cor'] }};"></span>
                                <div>
                                    <div class="legenda-nome">{{ $regiaoNome }}</div>
                                    <div class="legenda-ufs">{{ $meta['ufs'] }}</div>
                                </div>
                            </div>
                            <div class="legenda-card-right">
                                <div class="legenda-total">{{ $qtdPontos }}</div>
                                <div class="legenda-percent">{{ $percent }}% do total</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Rodapé do Card: Estatísticas Rápidas (como na Imagem 2) --}}
        <div class="mapa-card-footer">
            <div class="mapa-stat-item">
                <span class="mapa-stat-label">Total de Pontos</span>
                <span class="mapa-stat-value">{{ $totalPontos }}</span>
            </div>
            <div class="mapa-stat-item">
                <span class="mapa-stat-label">Regiões Atendidas</span>
                <span class="mapa-stat-value">{{ $regioesAtendidasCount }} / 5</span>
            </div>
            <div class="mapa-stat-item">
                <span class="mapa-stat-label">Estados com Pontos</span>
                <span class="mapa-stat-value">{{ $estadosAtendidosCount }}</span>
            </div>
            <div class="mapa-stat-item">
                <span class="mapa-stat-label">Cidades Atendidas</span>
                <span class="mapa-stat-value">{{ $cidadesAtendidasCount }}</span>
            </div>
        </div>
    </div>

    {{-- ============================================================
         SEÇÃO 3 — GRÁFICOS (VISÃO ANALÍTICA)
         ============================================================ --}}
    <div class="section-title">
        <span>Visão Analítica do Sistema</span>
    </div>

    <div class="charts-grid">
        {{-- Grafico 1 --}}
        <div class="chart-card">
            <h2 class="chart-titulo">Status das ONGs</h2>
            <p class="chart-descricao">Distribuição das instituições ativas e inativas.</p>
            @if($ongAtivas === 0 && $ongInativas === 0)
                <div class="chart-empty">Nenhuma ONG cadastrada até o momento.</div>
            @else
                <div class="chart-container">
                    <canvas id="ongsStatusChart"></canvas>
                </div>
            @endif
        </div>

        {{-- Grafico 2 --}}
        <div class="chart-card">
            <h2 class="chart-titulo">Pontos de Coleta por ONG</h2>
            <p class="chart-descricao">Quantidade de pontos de coleta cadastrados por instituição.</p>
            @if($pontosPorOng->isEmpty())
                <div class="chart-empty">Nenhum dado cadastrado até o momento.</div>
            @else
                <div class="chart-container">
                    <canvas id="pontosOngChart"></canvas>
                </div>
            @endif
        </div>

        {{-- Grafico 3 --}}
        <div class="chart-card">
            <h2 class="chart-titulo">Cadastros por Mês</h2>
            <p class="chart-descricao">Evolução mensal de novas ONGs cadastradas no sistema.</p>
            @if($ongsPorMes->isEmpty())
                <div class="chart-empty">Nenhum dado cadastrado até o momento.</div>
            @else
                <div class="chart-container">
                    <canvas id="ongsMesChart"></canvas>
                </div>
            @endif
        </div>

        {{-- Grafico 4
        <div class="chart-card">
            <h2 class="chart-titulo">Materiais Mais Aceitos</h2>
            <p class="chart-descricao">Distribuição dos materiais recebidos nos pontos de coleta.</p>
            @if(isset($materiaisMaisAceitos) && $materiaisMaisAceitos->isEmpty())
                <div class="chart-empty">Nenhum material cadastrado até o momento.</div>
            @else
                <div class="chart-container">
                    <canvas id="materiaisChart"></canvas>
                </div>
            @endif
        </div>
        --}}

        {{-- Grafico 5
        <div class="chart-card">
            <h2 class="chart-titulo">Cobertura por Cidade</h2>
            <p class="chart-descricao">Distribuição dos pontos de coleta por município.</p>
            @if(isset($pontosPorCidade) && $pontosPorCidade->isEmpty())
                <div class="chart-empty">Nenhum ponto com cidade informado até o momento.</div>
            @else
                <div class="chart-container">
                    <canvas id="cidadesChart"></canvas>
                </div>
            @endif
        </div>
        --}}
    </div>

    {{-- ============================================================
         SEÇÃO 4 — AÇÕES RÁPIDAS DE GESTÃO
         ============================================================ --}}
    <div class="section-title">
        <span>Ações Rápidas de Gestão</span>
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

{{-- ============================================================
     SCRIPTS: CHART.JS + INTERATIVIDADE DO MAPA DO BRASIL
     ============================================================ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    /* ----------------------------------------------------------
       Interatividade do Mapa do Brasil (Tooltip e Destaque)
       ---------------------------------------------------------- */
    const tooltip = document.getElementById('mapa-tooltip');
    const regioes = document.querySelectorAll('.mapa-regiao');
    const legendaCards = document.querySelectorAll('.legenda-card');

    regioes.forEach(regiao => {
        regiao.addEventListener('mousemove', function(e) {
            const nome = this.dataset.regiao;
            const total = this.dataset.total;
            const ongs = this.dataset.ongs;
            
            tooltip.innerHTML = `<strong>Região ${nome}</strong><br>${total} pontos de coleta<br>${ongs} ONGs ativas`;
            tooltip.style.display = 'block';

            const rect = this.closest('.mapa-svg-wrapper').getBoundingClientRect();
            tooltip.style.left = (e.clientX - rect.left) + 'px';
            tooltip.style.top = (e.clientY - rect.top) + 'px';
        });

        regiao.addEventListener('mouseleave', function() {
            tooltip.style.display = 'none';
        });
    });

    legendaCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const regiaoNome = this.dataset.regiao;
            const path = document.querySelector(`.mapa-regiao[data-regiao="${regiaoNome}"] .regiao-path`);
            if (path) {
                path.style.filter = 'brightness(1.35)';
                path.style.strokeWidth = '4.5px';
            }
        });

        card.addEventListener('mouseleave', function() {
            const regiaoNome = this.dataset.regiao;
            const path = document.querySelector(`.mapa-regiao[data-regiao="${regiaoNome}"] .regiao-path`);
            if (path) {
                path.style.filter = '';
                path.style.strokeWidth = '';
            }
        });
    });

    /* Grafico 1 */
    @if($ongAtivas > 0 || $ongInativas > 0)
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
            rotation: -90,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 20, usePointStyle: true }
                }
            },
            cutout: '65%'
        }
    });
    @endif

    /* Grafico 2 */
    @if($pontosPorOng->isNotEmpty())
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
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 5,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });
    @endif

    /* Grafico 3 */
    @if($ongsPorMes->isNotEmpty())
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
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 5,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: { grid: { display: false } }
            }
        }
    });
    @endif

    /* Grafico 4 */
    /*
    @if(isset($materiaisMaisAceitos) && $materiaisMaisAceitos->isNotEmpty())
    const materiaisData = @json($materiaisMaisAceitos);

    new Chart(document.getElementById('materiaisChart'), {
        type: 'bar',
        data: {
            labels: materiaisData.map(item => item.nome),
            datasets: [{
                label: 'Pontos Aceitando',
                data: materiaisData.map(item => item.total),
                backgroundColor: '#294E21',
                borderRadius: 6,
                maxBarThickness: 28
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    beginAtZero: true,
                    suggestedMax: 5,
                    ticks: { stepSize: 1, precision: 0 },
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                y: { grid: { display: false } }
            }
        }
    });
    @endif
    */

    /* Grafico 5 */
    /*
    @if(isset($pontosPorCidade) && $pontosPorCidade->isNotEmpty())
    const cidadesData = @json($pontosPorCidade);
    const paletaCidades = ['#0618b9', '#789342', '#76C1C3', '#548D95', '#4554db', '#294E21'];

    new Chart(document.getElementById('cidadesChart'), {
        type: 'doughnut',
        data: {
            labels: cidadesData.map(item => item.cidade),
            datasets: [{
                data: cidadesData.map(item => item.total),
                backgroundColor: cidadesData.map((_, i) => paletaCidades[i % paletaCidades.length]),
                borderWidth: 0,
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 15, usePointStyle: true }
                }
            },
            cutout: '60%'
        }
    });
    @endif
    */
</script>

@endsection
