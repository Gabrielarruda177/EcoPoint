@extends('layouts.admin')

@section('titulo', 'Solicitações de Alteração')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/solicitacoes.css') }}?v=1.0">
@endsection

@section('conteudo')
<div class="solicitacoes-admin-container">

    {{-- Header Card --}}
    <div class="solicitacoes-header-card">
        <div class="solicitacoes-header-content">
            <div>
                <span class="badge badge-admin">Supervisão Cadastral</span>
                <h1 class="solicitacoes-title">Solicitações de Alteração</h1>
                <p class="solicitacoes-subtitle">
                    Supervisione, aprove ou recuse alterações de <strong>Nome</strong> e <strong>Endereço</strong> solicitadas pelas instituições parceiras.
                </p>
            </div>
            <div class="header-action-links">
                <a href="{{ route('admin.ongs.index') }}" class="btn-voltar-ongs">
                    ← Gerenciar ONGs
                </a>
            </div>
        </div>
    </div>

    {{-- Alertas / Feedback --}}
    @if (session('sucesso'))
        <div class="alert-box alert-success" role="alert">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <div>{{ session('sucesso') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert-box alert-danger" role="alert">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    {{-- Filtros por Status --}}
    <div class="filters-card">
        <div class="filters-nav">
            <a href="{{ route('admin.solicitacoes.index', ['status' => 'pendente']) }}" 
               class="filter-pill {{ $statusFiltro === 'pendente' ? 'active-pill pill-pendente' : '' }}">
                <span class="pill-dot dot-pendente"></span>
                Pendentes ({{ $totalPendentes }})
            </a>

            <a href="{{ route('admin.solicitacoes.index', ['status' => 'todas']) }}" 
               class="filter-pill {{ $statusFiltro === 'todas' ? 'active-pill' : '' }}">
                Todas
            </a>

            <a href="{{ route('admin.solicitacoes.index', ['status' => 'aprovada']) }}" 
               class="filter-pill {{ $statusFiltro === 'aprovada' ? 'active-pill pill-aprovada' : '' }}">
                <span class="pill-dot dot-aprovada"></span>
                Aprovadas ({{ $totalAprovadas }})
            </a>

            <a href="{{ route('admin.solicitacoes.index', ['status' => 'recusada']) }}" 
               class="filter-pill {{ $statusFiltro === 'recusada' ? 'active-pill pill-recusada' : '' }}">
                <span class="pill-dot dot-recusada"></span>
                Recusadas ({{ $totalRecusadas }})
            </a>
        </div>
    </div>

    {{-- Tabela de Solicitações --}}
    <div class="solicitacoes-table-card">
        <div class="table-responsive">
            <table class="solicitacoes-table">
                <thead>
                    <tr>
                        <th>ID / Envio</th>
                        <th>Instituição Solicitante</th>
                        <th>Tipo</th>
                        <th>Alteração Pretendida</th>
                        <th>Status</th>
                        <th class="th-actions">Ações / Parecer</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($solicitacoes as $item)
                        <tr>
                            <td class="col-id">
                                <span class="id-tag">#{{ $item->id }}</span>
                                <div class="col-date">{{ $item->created_at->format('d/m/Y') }}</div>
                                <div class="col-time">{{ $item->created_at->format('H:i') }}</div>
                            </td>

                            <td class="col-ong">
                                <div class="ong-name">{{ $item->ong->nome ?? 'Instituição Excluída' }}</div>
                                <div class="ong-meta">
                                    <span>CNPJ: {{ $item->ong->cnpj ?? 'Não informado' }}</span>
                                    <span>Login: {{ $item->ong->user->email ?? '-' }}</span>
                                </div>
                            </td>

                            <td class="col-tipo">
                                @if ($item->tipo === 'nome')
                                    <span class="type-pill type-nome">Nome</span>
                                @else
                                    <span class="type-pill type-endereco">Endereço</span>
                                @endif
                            </td>

                            <td class="col-dados">
                                @if ($item->tipo === 'nome')
                                    <div class="diff-box">
                                        <div class="diff-current">
                                            <span class="diff-label">Atual:</span>
                                            <span class="diff-val">{{ $item->dados_atuais['nome'] ?? '-' }}</span>
                                        </div>
                                        <div class="diff-arrow">↓</div>
                                        <div class="diff-proposed">
                                            <span class="diff-label">Proposto:</span>
                                            <strong class="diff-val-new">{{ $item->dados_propostos['nome'] ?? '-' }}</strong>
                                        </div>
                                    </div>
                                @else
                                    <div class="diff-box">
                                        <div class="diff-current">
                                            <span class="diff-label">Atual:</span>
                                            <span class="diff-val">
                                                {{ $item->dados_atuais['endereco'] ?? '-' }}, {{ $item->dados_atuais['numero'] ?? 'S/N' }} — {{ $item->dados_atuais['bairro'] ?? '-' }}, {{ $item->dados_atuais['cidade'] ?? '-' }}/{{ $item->dados_atuais['estado'] ?? '-' }} (CEP: {{ $item->dados_atuais['cep'] ?? '-' }})
                                            </span>
                                        </div>
                                        <div class="diff-arrow">↓</div>
                                        <div class="diff-proposed">
                                            <span class="diff-label">Proposto:</span>
                                            <strong class="diff-val-new">
                                                {{ $item->dados_propostos['endereco'] ?? '-' }}, {{ $item->dados_propostos['numero'] ?? 'S/N' }} — {{ $item->dados_propostos['bairro'] ?? '-' }}, {{ $item->dados_propostos['cidade'] ?? '-' }}/{{ $item->dados_propostos['estado'] ?? '-' }} (CEP: {{ $item->dados_propostos['cep'] ?? '-' }})
                                            </strong>
                                        </div>
                                    </div>
                                @endif

                                @if ($item->justificativa)
                                    <div class="justificativa-quote">
                                        <strong>Justificativa da ONG:</strong> "{{ $item->justificativa }}"
                                    </div>
                                @endif
                            </td>

                            <td class="col-status">
                                @if ($item->status === 'pendente')
                                    <span class="status-pill status-pending">
                                        <span class="dot-indicator"></span> Pendente
                                    </span>
                                @elseif ($item->status === 'aprovada')
                                    <span class="status-pill status-approved">
                                        <span class="dot-indicator"></span> Aprovada
                                    </span>
                                @elseif ($item->status === 'recusada')
                                    <span class="status-pill status-rejected">
                                        <span class="dot-indicator"></span> Recusada
                                    </span>
                                @endif
                            </td>

                            <td class="col-actions">
                                @if ($item->status === 'pendente')
                                    <div class="actions-buttons-row">
                                        <button type="button" 
                                                class="btn-action-aprovar"
                                                onclick="abrirModalAprovar('{{ $item->id }}', '{{ addslashes($item->ong->nome ?? '') }}', '{{ $item->tipo_label }}', '{{ route('admin.solicitacoes.aprovar', $item) }}')">
                                            Aprovar
                                        </button>

                                        <button type="button" 
                                                class="btn-action-recusar"
                                                onclick="abrirModalRecusar('{{ $item->id }}', '{{ addslashes($item->ong->nome ?? '') }}', '{{ $item->tipo_label }}', '{{ route('admin.solicitacoes.recusar', $item) }}')">
                                            Recusar
                                        </button>
                                    </div>
                                @elseif ($item->status === 'aprovada')
                                    <div class="review-meta">
                                        <div class="review-author">Aprovada por <strong>{{ $item->analisadoPor->name ?? 'Admin' }}</strong></div>
                                        <div class="review-date">{{ $item->analisado_em ? $item->analisado_em->format('d/m/Y H:i') : '' }}</div>
                                    </div>
                                @elseif ($item->status === 'recusada')
                                    <div class="review-meta">
                                        <div class="review-author">Recusada por <strong>{{ $item->analisadoPor->name ?? 'Admin' }}</strong></div>
                                        <div class="review-date">{{ $item->analisado_em ? $item->analisado_em->format('d/m/Y H:i') : '' }}</div>
                                        @if ($item->motivo_recusa)
                                            <div class="recusa-reason">
                                                <strong>Motivo:</strong> {{ $item->motivo_recusa }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <p>Nenhuma solicitação encontrada para o filtro selecionado.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($solicitacoes->hasPages())
            <div class="pagination-wrapper">
                {{ $solicitacoes->links() }}
            </div>
        @endif
    </div>

</div>

{{-- ============================================================
     MODAL — APROVAR SOLICITAÇÃO
     ============================================================ --}}
<div id="modalAprovar" class="custom-modal-overlay" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="modal-icon-header green-bg">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
        </div>

        <h3 class="custom-modal-title">Aprovar Solicitação de Alteração</h3>

        <p class="custom-modal-desc">
            Tem certeza que deseja aprovar a alteração de <strong id="modalAprovarTipo"></strong> da instituição<br>
            <strong id="modalAprovarNome" class="entity-highlight"></strong>?
        </p>

        <p class="modal-info-note">
            Ao confirmar, o cadastro oficial da ONG será atualizado imediatamente no sistema com os novos dados propostos.
        </p>

        <div class="custom-modal-actions">
            <button type="button" class="btn-modal-cancel" onclick="fecharModalAprovar()">
                Cancelar
            </button>
            <form id="formConfirmarAprovar" method="POST" action="">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-modal-confirm btn-green">
                    Sim, aprovar alteração
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ============================================================
     MODAL — RECUSAR SOLICITAÇÃO (COM MOTIVO)
     ============================================================ --}}
<div id="modalRecusar" class="custom-modal-overlay" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="modal-icon-header red-bg">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
        </div>

        <h3 class="custom-modal-title">Recusar Solicitação de Alteração</h3>

        <p class="custom-modal-desc">
            Você está recusando a alteração de <strong id="modalRecusarTipo"></strong> da instituição<br>
            <strong id="modalRecusarNome" class="entity-highlight"></strong>.
        </p>

        <form id="formConfirmarRecusar" method="POST" action="">
            @csrf
            @method('PATCH')

            <div class="form-group-modal">
                <label for="motivo_recusa" class="form-label-modal">
                    Motivo da Recusa (visível para a instituição):
                </label>
                <textarea 
                    name="motivo_recusa" 
                    id="motivo_recusa" 
                    rows="3" 
                    class="form-control-modal" 
                    placeholder="Informe o motivo para que a instituição compreenda o motivo da decisão..."
                    required
                ></textarea>
            </div>

            <p class="modal-info-note">
                Os dados cadastrais originais da ONG permanecerão inalterados.
            </p>

            <div class="custom-modal-actions">
                <button type="button" class="btn-modal-cancel" onclick="fecharModalRecusar()">
                    Cancelar
                </button>
                <button type="submit" class="btn-modal-confirm btn-red">
                    Confirmar Recusa
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModalAprovar(id, nome, tipo, url) {
        document.getElementById('modalAprovarNome').textContent = nome;
        document.getElementById('modalAprovarTipo').textContent = tipo;
        document.getElementById('formConfirmarAprovar').action = url;
        document.getElementById('modalAprovar').style.display = 'flex';
    }

    function fecharModalAprovar() {
        document.getElementById('modalAprovar').style.display = 'none';
    }

    function abrirModalRecusar(id, nome, tipo, url) {
        document.getElementById('modalRecusarNome').textContent = nome;
        document.getElementById('modalRecusarTipo').textContent = tipo;
        document.getElementById('formConfirmarRecusar').action = url;
        document.getElementById('motivo_recusa').value = '';
        document.getElementById('modalRecusar').style.display = 'flex';
        setTimeout(() => document.getElementById('motivo_recusa')?.focus(), 100);
    }

    function fecharModalRecusar() {
        document.getElementById('modalRecusar').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        const modalA = document.getElementById('modalAprovar');
        const modalR = document.getElementById('modalRecusar');
        if (e.target === modalA) fecharModalAprovar();
        if (e.target === modalR) fecharModalRecusar();
    });

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModalAprovar();
            fecharModalRecusar();
        }
    });
</script>
@endsection
