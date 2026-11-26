@extends('layouts.ong')

@section('titulo', 'Meus Pontos de Coleta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/pontos.css') }}?v=3.0">
@endsection

@section('conteudo')
<div class="pontos-container">

    {{-- ============================================================
         HEADER CARD
         ============================================================ --}}
    <div class="pontos-header-card">
        <div>
            <span class="badge badge-ong">Perfil: Instituição / ONG</span>
            <h1 class="pontos-title">Meus Pontos de Coleta</h1>
            <p class="pontos-subtitle">
                Gerencie os locais cadastrados pela sua organização para recebimento de livros e materiais acadêmicos.
            </p>
        </div>
        <div>
            <a href="{{ route('ong.pontos.create') }}" class="btn-new-ponto">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
                + Novo Ponto de Coleta
            </a>
        </div>
    </div>

    {{-- ============================================================
         BARRA DE BUSCA E FILTROS RÁPIDOS
         ============================================================ --}}
    <div class="pontos-search-bar">
        <form method="GET" action="{{ route('ong.pontos.index') }}" class="search-form">
            <div class="search-input-wrapper">
                <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input
                    type="text"
                    name="busca"
                    value="{{ request('busca') }}"
                    placeholder="Buscar por nome do ponto, endereço, bairro ou cidade..."
                    class="search-input"
                    autocomplete="off"
                >
                @if(request('busca'))
                    <a href="{{ route('ong.pontos.index', array_filter(['status' => request('status')])) }}" class="search-clear-btn" title="Limpar busca">
                        ✕
                    </a>
                @endif
            </div>

            <div class="filter-pills">
                <a href="{{ route('ong.pontos.index', array_filter(['busca' => request('busca')])) }}"
                   class="filter-pill {{ !request('status') ? 'active' : '' }}">
                    Todos
                    <span class="pill-counter">{{ $totalGeral }}</span>
                </a>
                <a href="{{ route('ong.pontos.index', array_filter(['busca' => request('busca'), 'status' => 'ativos'])) }}"
                   class="filter-pill {{ request('status') === 'ativos' ? 'active' : '' }}">
                    Ativos
                    <span class="pill-counter">{{ $totalAtivos }}</span>
                </a>
                <a href="{{ route('ong.pontos.index', array_filter(['busca' => request('busca'), 'status' => 'inativos'])) }}"
                   class="filter-pill {{ request('status') === 'inativos' ? 'active' : '' }}">
                    Inativos
                    <span class="pill-counter">{{ $totalInativos }}</span>
                </a>
            </div>
        </form>
    </div>

    {{-- MENSAGEM FLASH DE SUCESSO --}}
    @if(session('success'))
        <div class="alert-success-banner" role="alert">
            <div style="display: flex; align-items: center; gap: 8px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.style.display='none'" class="alert-close-btn">✕</button>
        </div>
    @endif

    {{-- ============================================================
         TABELA DE PONTOS DE COLETA
         ============================================================ --}}
    <div class="pontos-table-card">
        <div class="table-responsive">
            <table class="pontos-table">
                <thead>
                    <tr>
                        <th class="col-ponto">Ponto de Coleta</th>
                        <th class="col-localizacao">Localização</th>
                        <th class="col-materiais">Materiais Aceitos</th>
                        <th class="col-status">Status</th>
                        <th class="th-actions">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pontos as $ponto)
                        <tr>
                            {{-- Ponto de Coleta --}}
                            <td>
                                <div class="ponto-nome-cell">{{ $ponto->nome }}</div>
                                @if ($ponto->horario_funcionamento)
                                    <div class="ponto-subtext">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        {{ $ponto->horario_funcionamento }}
                                    </div>
                                @endif
                                @if ($ponto->telefone_contato)
                                    <div class="ponto-subtext">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                                        {{ $ponto->telefone_contato }}
                                    </div>
                                @endif
                            </td>

                            {{-- Localização --}}
                            <td>
                                <div class="ponto-endereco-text">
                                    {{ $ponto->endereco }}{{ $ponto->numero ? ', ' . $ponto->numero : '' }}
                                    @if ($ponto->complemento)
                                        <span class="ponto-subtext">({{ $ponto->complemento }})</span>
                                    @endif
                                </div>
                                <div class="ponto-subtext">
                                    {{ $ponto->bairro ? $ponto->bairro . ' — ' : '' }}{{ $ponto->cidade }}/{{ $ponto->estado }}
                                    @if ($ponto->cep)
                                        <span class="cep-badge">CEP: {{ $ponto->cep }}</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Materiais Aceitos --}}
                            <td>
                                <div class="materiais-badges">
                                    @forelse ($ponto->materiaisAceitos as $material)
                                        <span class="badge-material">{{ $material->nome }}</span>
                                    @empty
                                        <span class="ponto-subtext" style="font-style: italic;">Nenhum material associado</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Status com Trigger para Modal --}}
                            <td>
                                <button
                                    type="button"
                                    class="status-pill {{ $ponto->ativo ? 'status-active' : 'status-inactive' }} btn-status-trigger"
                                    title="Clique para alterar status"
                                    onclick="abrirModalStatus(this)"
                                    data-id="{{ $ponto->id }}"
                                    data-nome="{{ $ponto->nome }}"
                                    data-ativo="{{ $ponto->ativo ? '1' : '0' }}"
                                    data-action="{{ route('ong.pontos.toggleStatus', $ponto) }}"
                                >
                                    <span class="status-dot"></span>
                                    {{ $ponto->ativo ? 'Ativo' : 'Inativo' }}
                                </button>
                            </td>

                            {{-- Ações --}}
                            <td>
                                <div class="actions-group">
                                    {{-- Botão Detalhes --}}
                                    <button
                                        type="button"
                                        class="btn-action btn-action-detalhes"
                                        title="Ver Detalhes do Ponto"
                                        onclick="abrirModalDetalhes(this)"
                                        data-nome="{{ $ponto->nome }}"
                                        data-status="{{ $ponto->ativo ? 'Ativo' : 'Inativo' }}"
                                        data-ativo="{{ $ponto->ativo ? '1' : '0' }}"
                                        data-telefone="{{ $ponto->telefone_contato ?? 'Não informado' }}"
                                        data-horario="{{ $ponto->horario_funcionamento ?? 'Não informado' }}"
                                        data-endereco="{{ $ponto->endereco }}"
                                        data-numero="{{ $ponto->numero }}"
                                        data-complemento="{{ $ponto->complemento }}"
                                        data-bairro="{{ $ponto->bairro }}"
                                        data-cidade="{{ $ponto->cidade }}"
                                        data-estado="{{ $ponto->estado }}"
                                        data-cep="{{ $ponto->cep }}"
                                        data-criado-em="{{ $ponto->created_at ? $ponto->created_at->format('d/m/Y \à\s H:i') : '—' }}"
                                        data-descricao="{{ $ponto->descricao }}"
                                        data-materiais="{{ $ponto->materiaisAceitos->pluck('nome')->implode(', ') }}"
                                    >
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                        Detalhes
                                    </button>

                                    {{-- Botão Editar (Abre Modal) --}}
                                    <button
                                        type="button"
                                        class="btn-action btn-action-edit"
                                        title="Editar Ponto de Coleta"
                                        onclick="abrirModalEditarPonto(this)"
                                        data-action="{{ route('ong.pontos.update', $ponto) }}"
                                        data-nome="{{ $ponto->nome }}"
                                        data-cep="{{ $ponto->cep }}"
                                        data-telefone="{{ $ponto->telefone_contato }}"
                                        data-endereco="{{ $ponto->endereco }}"
                                        data-numero="{{ $ponto->numero }}"
                                        data-complemento="{{ $ponto->complemento }}"
                                        data-bairro="{{ $ponto->bairro }}"
                                        data-cidade="{{ $ponto->cidade }}"
                                        data-estado="{{ $ponto->estado }}"
                                        data-horario="{{ $ponto->horario_funcionamento }}"
                                        data-descricao="{{ $ponto->descricao }}"
                                        data-ativo="{{ $ponto->ativo ? '1' : '0' }}"
                                        data-materiais-ids="{{ $ponto->materiaisAceitos->pluck('id')->implode(',') }}"
                                    >
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                        Editar
                                    </button>

                                    {{-- Botão Status --}}
                                    <button
                                        type="button"
                                        class="btn-action btn-action-status"
                                        title="{{ $ponto->ativo ? 'Desativar Ponto' : 'Ativar Ponto' }}"
                                        onclick="abrirModalStatus(this)"
                                        data-id="{{ $ponto->id }}"
                                        data-nome="{{ $ponto->nome }}"
                                        data-ativo="{{ $ponto->ativo ? '1' : '0' }}"
                                        data-action="{{ route('ong.pontos.toggleStatus', $ponto) }}"
                                    >
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                            <rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect>
                                            <circle cx="{{ $ponto->ativo ? '16' : '8' }}" cy="12" r="3"></circle>
                                        </svg>
                                        Status
                                    </button>

                                    {{-- Botão Excluir --}}
                                    <button
                                        type="button"
                                        class="btn-action btn-action-delete"
                                        title="Excluir Ponto"
                                        onclick="abrirModalExclusao(this)"
                                        data-id="{{ $ponto->id }}"
                                        data-nome="{{ $ponto->nome }}"
                                        data-action="{{ route('ong.pontos.destroy', $ponto) }}"
                                    >
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon" style="color: #B08968;">
                                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                    </div>
                                    <p class="empty-title">Nenhum ponto de coleta encontrado</p>
                                    <p class="empty-subtitle">
                                        @if(request('busca') || request('status'))
                                            Nenhum ponto corresponde aos filtros selecionados.
                                        @else
                                            Sua organização ainda não cadastrou nenhum local de arrecadação.
                                        @endif
                                    </p>
                                    <div style="margin-top: 1rem;">
                                        @if(request('busca') || request('status'))
                                            <a href="{{ route('ong.pontos.index') }}" class="btn-clear-filters">Limpar Filtros</a>
                                        @else
                                            <a href="{{ route('ong.pontos.create') }}" class="btn-new-ponto">+ Cadastrar Primeiro Ponto</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINAÇÃO ELEGANTE --}}
        @if ($pontos->hasPages())
            <div class="vibe-pagination-wrapper">
                {{ $pontos->links() }}
            </div>
        @endif
    </div>
</div>

@include('ong.pontos._modal_editar')

{{-- ============================================================
     MODAL DE DETALHES DO PONTO DE COLETA
     ============================================================ --}}
<div id="modalDetalhesPonto" class="vibe-modal-overlay" style="display: none;">
    <div class="vibe-modal-dialog vibe-modal-dialog-large" role="dialog" aria-modal="true" aria-labelledby="modalDetalhesPontoTitulo">
        <button type="button" class="vibe-modal-close-btn" onclick="fecharModalDetalhes()" title="Fechar">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="vibe-modal-header">
            <div class="vibe-modal-icon" style="margin-bottom: 8px;">
                <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#6F4E37" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                    <circle cx="12" cy="10" r="3"></circle>
                </svg>
            </div>
            <h3 id="modalDetalhesPontoTitulo" class="vibe-modal-title">Detalhes do Ponto de Coleta</h3>
            <p class="vibe-modal-subtitle">Consulta completa de endereço, horário de atendimento e materiais aceitos</p>
        </div>

        <div class="vibe-modal-body">
            <div class="detalhes-grid">
                {{-- Bloco 1: Identificação & Status --}}
                <div class="detalhes-block">
                    <div class="detalhes-block-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Identificação do Ponto
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">Nome do Ponto:</span>
                        <span id="pontoDetalheNome" class="detalhes-val-strong"></span>
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">Status Operacional:</span>
                        <span id="pontoDetalheStatus" class="status-pill status-active"></span>
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">Data de Cadastro:</span>
                        <span id="pontoDetalheCriadoEm" class="detalhes-val"></span>
                    </div>
                </div>

                {{-- Bloco 2: Atendimento e Contato --}}
                <div class="detalhes-block">
                    <div class="detalhes-block-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        Atendimento & Contato
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">Horário de Atendimento:</span>
                        <span id="pontoDetalheHorario" class="detalhes-val"></span>
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">Telefone de Contato:</span>
                        <span id="pontoDetalheTelefone" class="detalhes-val"></span>
                    </div>
                </div>

                {{-- Bloco 3: Endereço Completo --}}
                <div class="detalhes-block full-width">
                    <div class="detalhes-block-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Endereço & Localização
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">Logradouro Completo:</span>
                        <span id="pontoDetalheEndereco" class="detalhes-val"></span>
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">CEP:</span>
                        <span id="pontoDetalheCep" class="detalhes-val-cnpj"></span>
                    </div>
                </div>

                {{-- Bloco 4: Materiais Aceitos --}}
                <div class="detalhes-block full-width">
                    <div class="detalhes-block-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                        Materiais Acadêmicos Aceitos
                    </div>
                    <div id="pontoDetalheMateriais" class="materiais-badges" style="margin-top: 0.35rem;"></div>
                </div>

                {{-- Bloco 5: Descrição Adicional --}}
                <div class="detalhes-block full-width">
                    <div class="detalhes-block-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                        Instruções e Observações
                    </div>
                    <div id="pontoDetalheDescricao" class="detalhes-desc-box"></div>
                </div>
            </div>
        </div>

        <div class="vibe-modal-footer">
            <button type="button" class="vibe-btn-cancel" onclick="fecharModalDetalhes()">
                Fechar
            </button>
        </div>
    </div>
</div>

{{-- ============================================================
     MODAL DE ALTERAR STATUS (ATIVAR / DESATIVAR)
     ============================================================ --}}
<div id="modalStatusPonto" class="vibe-modal-overlay" style="display: none;">
    <div class="vibe-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalStatusTitulo">
        <div class="vibe-modal-icon">
            <div id="vibeSwitchIndicator" class="vibe-status-switch is-active" aria-hidden="true">
                <span class="vibe-switch-knob"></span>
            </div>
        </div>

        <h3 id="modalStatusTitulo" class="vibe-modal-title">Alterar Status</h3>
        <p class="vibe-modal-desc">
            Tem certeza que deseja <strong id="modalStatusAcaoTexto">desativar</strong> o ponto de coleta
            <span id="modalStatusNomePonto" class="vibe-modal-entity"></span>?
        </p>

        <form id="formStatusPonto" method="POST" action="" style="width: 100%;">
            @csrf
            @method('PATCH')
            <div class="vibe-modal-actions">
                <button type="button" class="vibe-btn-cancel" onclick="fecharModalStatus()">
                    Cancelar
                </button>
                <button type="submit" id="modalStatusSubmitBtn" class="vibe-btn-confirm">
                    Sim, alterar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ============================================================
     MODAL DE CONFIRMAÇÃO DE EXCLUSÃO (COM ÍCONE OFICIAL)
     ============================================================ --}}
<div id="modalExcluirPonto" class="vibe-modal-overlay" style="display: none;">
    <div class="vibe-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalExcluirTitulo">
        <div class="vibe-modal-icon">
            <img src="{{ asset('img/icon-modal-excluir.png') }}" alt="Confirmar exclusão" class="vibe-icon-img" width="56" height="56">
        </div>

        <h3 id="modalExcluirTitulo" class="vibe-modal-title">Confirmar Exclusão</h3>
        <p class="vibe-modal-desc">
            Tem certeza que deseja excluir o ponto de coleta
            <span id="modalExcluirNomePonto" class="vibe-modal-entity"></span>?
            <br>
            <small style="color: #6F4E37; font-size: 0.85rem; margin-top: 4px; display: block;">
                Esta ação removerá o ponto do mapa público e não poderá ser desfeita.
            </small>
        </p>

        <form id="formExcluirPonto" method="POST" action="" style="width: 100%;">
            @csrf
            @method('DELETE')
            <div class="vibe-modal-actions">
                <button type="button" class="vibe-btn-cancel" onclick="fecharModalExclusao()">
                    Cancelar
                </button>
                <button type="submit" class="vibe-btn-delete">
                    Sim, excluir
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // MODAL DE DETALHES
    function abrirModalDetalhes(btn) {
        const modal = document.getElementById('modalDetalhesPonto');
        if (!modal) return;

        document.getElementById('pontoDetalheNome').textContent = btn.dataset.nome || '—';

        const statusEl = document.getElementById('pontoDetalheStatus');
        const isAtivo = btn.dataset.ativo === '1';
        statusEl.textContent = btn.dataset.status || '—';
        statusEl.className = 'status-pill ' + (isAtivo ? 'status-active' : 'status-inactive');

        document.getElementById('pontoDetalheCriadoEm').textContent = btn.dataset.criadoEm || '—';
        document.getElementById('pontoDetalheHorario').textContent = btn.dataset.horario || 'Não informado';
        document.getElementById('pontoDetalheTelefone').textContent = btn.dataset.telefone || 'Não informado';

        let enderecoCompleto = btn.dataset.endereco || '';
        if (btn.dataset.numero) enderecoCompleto += ', ' + btn.dataset.numero;
        if (btn.dataset.complemento) enderecoCompleto += ' (' + btn.dataset.complemento + ')';
        if (btn.dataset.bairro) enderecoCompleto += ' — ' + btn.dataset.bairro;
        if (btn.dataset.cidade || btn.dataset.estado) enderecoCompleto += ', ' + (btn.dataset.cidade || '') + '/' + (btn.dataset.estado || '');
        document.getElementById('pontoDetalheEndereco').textContent = enderecoCompleto || '—';
        document.getElementById('pontoDetalheCep').textContent = btn.dataset.cep ? 'CEP: ' + btn.dataset.cep : '—';

        const materiaisContainer = document.getElementById('pontoDetalheMateriais');
        materiaisContainer.innerHTML = '';
        const materiaisStr = btn.dataset.materiais;
        if (materiaisStr && materiaisStr.trim().length > 0) {
            const list = materiaisStr.split(', ');
            list.forEach(item => {
                const badge = document.createElement('span');
                badge.className = 'badge-material';
                badge.textContent = item;
                materiaisContainer.appendChild(badge);
            });
        } else {
            materiaisContainer.innerHTML = '<span style="color: #6F4E37; font-style: italic;">Nenhum material associado.</span>';
        }

        document.getElementById('pontoDetalheDescricao').textContent = btn.dataset.descricao || 'Nenhuma instrução adicional informada.';

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function fecharModalDetalhes() {
        const modal = document.getElementById('modalDetalhesPonto');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // MODAL DE ALTERAR STATUS
    function abrirModalStatus(btn) {
        const modal = document.getElementById('modalStatusPonto');
        const form = document.getElementById('formStatusPonto');
        const acaoTexto = document.getElementById('modalStatusAcaoTexto');
        const nomePonto = document.getElementById('modalStatusNomePonto');
        const submitBtn = document.getElementById('modalStatusSubmitBtn');
        const switchIndicator = document.getElementById('vibeSwitchIndicator');

        const isAtivo = btn.dataset.ativo === '1';
        const acao = isAtivo ? 'desativar' : 'ativar';

        form.action = btn.dataset.action;
        acaoTexto.textContent = acao;
        nomePonto.textContent = btn.dataset.nome;
        submitBtn.textContent = 'Sim, ' + acao;

        if (isAtivo) {
            switchIndicator.classList.remove('is-inactive');
            switchIndicator.classList.add('is-active');
        } else {
            switchIndicator.classList.remove('is-active');
            switchIndicator.classList.add('is-inactive');
        }

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function fecharModalStatus() {
        const modal = document.getElementById('modalStatusPonto');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // MODAL DE CONFIRMAÇÃO DE EXCLUSÃO
    function abrirModalExclusao(btn) {
        const modal = document.getElementById('modalExcluirPonto');
        const form = document.getElementById('formExcluirPonto');
        const nomePonto = document.getElementById('modalExcluirNomePonto');

        form.action = btn.dataset.action;
        nomePonto.textContent = btn.dataset.nome;

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function fecharModalExclusao() {
        const modal = document.getElementById('modalExcluirPonto');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // Fechar ao clicar fora (backdrop)
    document.addEventListener('click', function(e) {
        const modalDetalhes = document.getElementById('modalDetalhesPonto');
        const modalStatus = document.getElementById('modalStatusPonto');
        const modalExcluir = document.getElementById('modalExcluirPonto');

        if (modalDetalhes && e.target === modalDetalhes) fecharModalDetalhes();
        if (modalStatus && e.target === modalStatus) fecharModalStatus();
        if (modalExcluir && e.target === modalExcluir) fecharModalExclusao();
    });

    // Fechar ao teclar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModalDetalhes();
            fecharModalStatus();
            fecharModalExclusao();
        }
    });
</script>
@endpush
@endsection
