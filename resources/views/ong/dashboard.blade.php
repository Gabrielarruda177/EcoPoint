@extends('layouts.ong')

@section('titulo', 'Painel da ONG')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/dashboard.css') }}?v=2.0">
@endsection

@section('conteudo')
<div class="ong-dashboard-container">
    <div class="dashboard-header-card">
        <div class="dashboard-header-content">
            <div>
                <span class="badge badge-ong">Perfil: ONG</span>
                <h1 class="dashboard-title">Painel da Instituição</h1>
                <p class="dashboard-welcome">
                    Bem-vindo(a), <strong>{{ $ong->nome ?? auth()->user()->name }}</strong> ({{ auth()->user()->email }})
                </p>
            </div>
            <div>
                <a href="{{ route('ong.pontos.create') }}" class="dashboard-btn-create">
                    + Cadastrar Novo Ponto
                </a>
            </div>
        </div>
    </div>

    <!-- Estatísticas em Destaque -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📍</div>
            <div>
                <div class="stat-number">{{ $totalPontos }}</div>
                <div class="stat-label">Total de Pontos de Coleta</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon--active">✅</div>
            <div>
                <div class="stat-number">{{ $pontosAtivos }}</div>
                <div class="stat-label">Pontos Ativos no Momento</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon--org">🏢</div>
            <div>
                <div class="stat-number" style="font-size: 1.15rem;">
                    @if ($ong && $ong->ativo)
                        <span class="status-pill status-active">Instituição Ativa</span>
                    @else
                        <span class="status-pill status-inactive">Instituição Inativa</span>
                    @endif
                </div>
                <div class="stat-label">Status Institucional</div>
            </div>
        </div>
    </div>

    <!-- Pontos Recentes -->
    <div class="recent-pontos-card">
        <div class="recent-pontos-header">
            <h2 class="recent-pontos-title">Pontos de Coleta Recentes</h2>
            @if ($totalPontos > 0)
                <a href="{{ route('ong.pontos.index') }}" class="recent-pontos-link">
                    Ver todos os pontos ({{ $totalPontos }}) &rarr;
                </a>
            @endif
        </div>

        @if ($ultimosPontos->isNotEmpty())
            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Nome do Ponto</th>
                        <th>Endereço / Cidade</th>
                        <th>Materiais Aceitos</th>
                        <th>Status</th>
                        <th style="text-align: right;">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ultimosPontos as $ponto)
                        <tr>
                            <td>
                                <strong>{{ $ponto->nome }}</strong>
                            </td>
                            <td>
                                {{ $ponto->endereco }}{{ $ponto->numero ? ', ' . $ponto->numero : '' }}<br>
                                <small style="color: #718096;">{{ $ponto->cidade }}/{{ $ponto->estado }}</small>
                            </td>
                            <td>
                                <div class="materiais-badges">
                                    @forelse ($ponto->materiaisAceitos as $material)
                                        <span class="badge-material">{{ $material->nome }}</span>
                                    @empty
                                        <span style="color: #a0aec0; font-size: 0.8rem;">Nenhum material selecionado</span>
                                    @endforelse
                                </div>
                            </td>
                            <td>
                                @if ($ponto->ativo)
                                    <span class="status-pill status-active">Ativo</span>
                                @else
                                    <span class="status-pill status-inactive">Inativo</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('ong.pontos.edit', $ponto) }}" class="recent-pontos-link">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <p>Sua ONG ainda não possui pontos de coleta cadastrados.</p>
                <a href="{{ route('ong.pontos.create') }}" class="dashboard-btn-create">
                    + Cadastrar o Primeiro Ponto
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
