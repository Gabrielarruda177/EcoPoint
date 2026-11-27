@extends('layouts.admin')

@section('titulo', 'Gerenciamento de ONGs')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/ongs-index.css') }}?v=4.0">
@endsection

@section('conteudo')
<div class="ongs-index-container">
    {{-- ============================================================
         HEADER CARD
         ============================================================ --}}
    <div class="ongs-header-card">
        <div>
            <span class="badge badge-admin">Perfil: Administrador</span>
            <h1 class="ongs-title">Gerenciamento de ONGs</h1>
            <p class="ongs-subtitle">
                Consulte os dados completos, ative/desative ou exclua as organizações parceiras cadastradas.
            </p>
        </div>
        <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
            <a href="{{ route('admin.solicitacoes.index') }}" class="btn-new-ong" style="background: rgba(255, 255, 255, 0.18); border: 1px solid rgba(255, 255, 255, 0.35); box-shadow: none;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line></svg>
                Solicitações
                @if(isset($totalPendentes) && $totalPendentes > 0)
                    <span style="background: #f59e0b; color: #fff; padding: 0.15rem 0.5rem; border-radius: 10px; font-size: 0.75rem; margin-left: 4px;">{{ $totalPendentes }}</span>
                @endif
            </a>
            <a href="{{ route('admin.ongs.create') }}" class="btn-new-ong">
                + Nova ONG
            </a>
        </div>
    </div>

    {{-- ============================================================
         TABELA DE ONGS
         ============================================================ --}}
    <div class="ongs-table-card">
        <div class="table-responsive">
            <table class="ongs-table">
                <thead>
                    <tr>
                        <th class="col-instituicao">Instituição</th>
                        <th class="col-localizacao">Localização</th>
                        <th class="col-cnpj">CNPJ / Telefone</th>
                        <th class="col-usuario">Usuário de Acesso</th>
                        <th class="col-status">Status</th>
                        <th class="th-actions">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ongs as $ong)
                        <tr>
                            <td class="col-instituicao">
                                <div class="ong-nome-cell">{{ $ong->nome }}</div>
                                @if ($ong->email_contato)
                                    <div class="ong-subtext">{{ $ong->email_contato }}</div>
                                @endif
                            </td>
                            <td class="col-localizacao">
                                @if ($ong->cidade || $ong->estado)
                                    <div class="local-cidade">
                                        {{ $ong->cidade ?: '—' }}{{ $ong->estado ? ' / ' . $ong->estado : '' }}
                                    </div>
                                    @if ($ong->endereco)
                                        <div class="ong-subtext">{{ $ong->endereco }}{{ $ong->numero ? ', ' . $ong->numero : '' }}</div>
                                    @endif
                                @else
                                    <span class="ong-subtext">Não informada</span>
                                @endif
                            </td>
                            <td class="col-cnpj">
                                <div>{{ $ong->cnpj ?: 'Não informado' }}</div>
                                @if ($ong->telefone)
                                    <div class="ong-subtext">{{ $ong->telefone }}</div>
                                @endif
                            </td>
                            <td class="col-usuario">
                                <div>{{ $ong->user->email ?? 'Sem usuário' }}</div>
                            </td>
                            <td class="col-status">
                                @if ($ong->ativo)
                                    <span class="status-pill status-active">Ativo</span>
                                @else
                                    <span class="status-pill status-inactive">Inativo</span>
                                @endif
                            </td>
                            <td class="th-actions">
                                <div class="actions-group">
                                    {{-- Botão que abre o Modal de Detalhes da Instituição --}}
                                    <button type="button" 
                                            class="btn-action btn-action-detalhes" 
                                            title="Visualizar detalhes completos da ONG"
                                            data-nome="{{ $ong->nome }}"
                                            data-cnpj="{{ $ong->cnpj ?: 'Não informado' }}"
                                            data-telefone="{{ $ong->telefone ?: 'Não informado' }}"
                                            data-email-contato="{{ $ong->email_contato ?: 'Não informado' }}"
                                            data-email-login="{{ $ong->user->email ?? 'Não cadastrado' }}"
                                            data-endereco="{{ $ong->endereco ?: 'Não informado' }}"
                                            data-numero="{{ $ong->numero ?: 'S/N' }}"
                                            data-complemento="{{ $ong->complemento ?: '' }}"
                                            data-bairro="{{ $ong->bairro ?: 'Não informado' }}"
                                            data-cidade="{{ $ong->cidade ?: 'Não informada' }}"
                                            data-estado="{{ $ong->estado ?: '—' }}"
                                            data-cep="{{ $ong->cep ?: 'Não informado' }}"
                                            data-descricao="{{ $ong->descricao ?: 'Nenhuma descrição cadastrada.' }}"
                                            data-status="{{ $ong->ativo ? 'Ativo' : 'Inativo' }}"
                                            data-pontos-count="{{ $ong->pontosDeColeta->count() }}"
                                            data-criado-em="{{ $ong->created_at->format('d/m/Y \à\s H:i') }}"
                                            onclick="abrirModalDetalhes(this)">
                                        Detalhes
                                    </button>

                                    {{-- Botão que dispara o Modal de Alterar Status --}}
                                    <button type="button" 
                                            class="btn-action btn-action-toggle" 
                                            title="{{ $ong->ativo ? 'Desativar ONG' : 'Ativar ONG' }}"
                                            onclick="abrirModalStatus('{{ $ong->id }}', '{{ addslashes($ong->nome) }}', '{{ $ong->ativo ? 'desativar' : 'ativar' }}', '{{ route('admin.ongs.toggleStatus', $ong) }}')">
                                        {{ $ong->ativo ? 'Desativar' : 'Ativar' }}
                                    </button>

                                    {{-- Botão que dispara o Modal de Exclusão --}}
                                    <button type="button" 
                                            class="btn-action btn-action-delete" 
                                            title="Excluir Instituição"
                                            onclick="abrirModalExclusao('{{ $ong->id }}', '{{ addslashes($ong->nome) }}', '{{ route('admin.ongs.destroy', $ong) }}')">
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <p>Nenhuma ONG cadastrada até o momento.</p>
                                    <div class="empty-state-action">
                                        <a href="{{ route('admin.ongs.create') }}" class="btn-new-ong">
                                            Cadastrar a primeira ONG
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ============================================================
             PAGINAÇÃO ESTILIZADA
             ============================================================ --}}
        @if ($ongs->hasPages())
            <div class="pagination-wrapper">
                {{ $ongs->links() }}
            </div>
        @endif
    </div>
</div>

{{-- ============================================================
     MODAL DE ALTERAR STATUS (COR VERDE INSTITUCIONAL)
     ============================================================ --}}
<div id="modalStatusOng" class="vibe-modal-overlay" style="display: none;">
    <div class="vibe-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalStatusTitulo">
        <div class="vibe-modal-icon">
            <svg width="46" height="26" viewBox="0 0 46 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="46" height="26" rx="13" fill="#2E6930"/>
                <circle cx="33" cy="13" r="9" fill="white"/>
            </svg>
        </div>

        <h3 id="modalStatusTitulo" class="vibe-modal-title">Alterar Status</h3>

        <p class="vibe-modal-desc">
            Tem certeza que deseja <strong id="modalStatusAcaoText">desativar</strong> a instituição<br>
            <strong id="modalStatusNome" class="vibe-modal-entity"></strong>?
        </p>

        <div class="vibe-modal-actions">
            <button type="button" class="vibe-btn-cancel" onclick="fecharModalStatus()">
                Cancelar
            </button>
            <form id="formConfirmarStatus" method="POST" action="" class="vibe-form-confirm">
                @csrf
                @method('PATCH')
                <button type="submit" id="btnConfirmarStatus" class="vibe-btn-confirm vibe-btn-green">
                    Sim, desativar
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ============================================================
     MODAL DE EXCLUIR (ÍCONE CIRCULAR COM "X" CONFORME IMAGEM)
     ============================================================ --}}
<div id="modalExcluirOng" class="vibe-modal-overlay" style="display: none;">
    <div class="vibe-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="modalExcluirTitulo">
        <div class="vibe-modal-icon">
            <img src="{{ asset('img/icon-modal-excluir.png') }}" width="48" height="48" alt="Excluir" class="vibe-icon-img">
        </div>

        <h3 id="modalExcluirTitulo" class="vibe-modal-title">Excluir Instituição</h3>

        <p class="vibe-modal-desc">
            Tem certeza que deseja <strong>excluir</strong> a instituição<br>
            <strong id="modalNomeOng" class="vibe-modal-entity"></strong>?
        </p>

        <div class="vibe-modal-actions">
            <button type="button" class="vibe-btn-cancel" onclick="fecharModalExclusao()">
                Cancelar
            </button>
            <form id="formConfirmarExclusao" method="POST" action="" class="vibe-form-confirm">
                @csrf
                @method('DELETE')
                <button type="submit" class="vibe-btn-confirm vibe-btn-green">
                    Sim, excluir
                </button>
            </form>
        </div>
    </div>
</div>

{{-- ============================================================
     MODAL DE DETALHES COMPLETOS DA ONG
     ============================================================ --}}
<div id="modalDetalhesOng" class="vibe-modal-overlay" style="display: none;">
    <div class="vibe-modal-dialog vibe-modal-dialog-large" role="dialog" aria-modal="true" aria-labelledby="modalDetalhesTitulo">
        <button type="button" class="vibe-modal-close-btn" onclick="fecharModalDetalhes()" title="Fechar Modal">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="vibe-modal-header">
            <div class="vibe-modal-icon" style="margin-bottom: 8px;">
                <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="#2F6929" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </div>
            <h3 id="modalDetalhesTitulo" class="vibe-modal-title">Detalhes da Instituição</h3>
            <p class="vibe-modal-subtitle">Consulta completa de dados cadastrais, localização e operação</p>
        </div>

        <div class="vibe-modal-body">
            <div class="detalhes-grid">
                {{-- Bloco 1: Identificação --}}
                <div class="detalhes-block">
                    <div class="detalhes-block-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Identificação & Registro
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">Nome Oficial:</span>
                        <span id="detalheNome" class="detalhes-val-strong"></span>
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">CNPJ (Identificador Fixo):</span>
                        <span id="detalheCnpj" class="detalhes-val-cnpj"></span>
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">Status da Entidade:</span>
                        <span id="detalheStatus" class="status-pill status-active"></span>
                    </div>
                </div>

                {{-- Bloco 2: Contato e Acesso --}}
                <div class="detalhes-block">
                    <div class="detalhes-block-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        Contato & Acesso
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">E-mail de Login do Usuário:</span>
                        <span id="detalheEmailLogin" class="detalhes-val-email"></span>
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">E-mail de Contato Público:</span>
                        <span id="detalheEmailContato" class="detalhes-val"></span>
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">Telefone:</span>
                        <span id="detalheTelefone" class="detalhes-val"></span>
                    </div>
                </div>

                {{-- Bloco 3: Localização --}}
                <div class="detalhes-block full-width">
                    <div class="detalhes-block-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Endereço Oficial
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">Endereço / Logradouro:</span>
                        <span id="detalheEnderecoCompleto" class="detalhes-val"></span>
                    </div>
                    <div class="detalhes-item">
                        <span class="detalhes-label">CEP:</span>
                        <span id="detalheCep" class="detalhes-val"></span>
                    </div>
                </div>

                {{-- Bloco 4: Operação e Histórico --}}
                <div class="detalhes-block full-width">
                    <div class="detalhes-block-title">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        Operação no Sistema
                    </div>
                    <div style="display: flex; gap: 2.5rem; flex-wrap: wrap;">
                        <div class="detalhes-item">
                            <span class="detalhes-label">Pontos de Coleta Vinculados:</span>
                            <strong id="detalhePontosCount" style="color: #1D3D1A; font-size: 1.15rem;"></strong>
                        </div>
                        <div class="detalhes-item">
                            <span class="detalhes-label">Data de Cadastro no Sistema:</span>
                            <span id="detalheCriadoEm" class="detalhes-val"></span>
                        </div>
                    </div>
                    <div class="detalhes-item" style="margin-top: 0.65rem;">
                        <span class="detalhes-label">Descrição Institucional:</span>
                        <div id="detalheDescricao" class="detalhes-desc-box"></div>
                    </div>
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
     MODAL DE EDITAR ONG (NA PRÓPRIA PÁGINA COM CAMPOS ESSENCIAIS)
     ============================================================ --}}
<div id="modalEditarOng" class="vibe-modal-overlay" style="display: none;">
    <div class="vibe-modal-dialog vibe-modal-dialog-large" role="dialog" aria-modal="true" aria-labelledby="modalEditarTitulo">
        <div class="vibe-modal-icon">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#2E6930" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
        </div>

        <h3 id="modalEditarTitulo" class="vibe-modal-title">Editar Instituição</h3>
        <p class="vibe-modal-subtitle">Atualize os dados principais da organização parceira</p>

        <form id="formEditarOng" method="POST" action="" class="vibe-edit-form">
            @csrf
            @method('PUT')

            <div class="vibe-form-grid">
                {{-- Nome --}}
                <div class="vibe-field-group vibe-field-full">
                    <label for="editNome" class="vibe-label">Nome da Instituição <span class="required">*</span></label>
                    <input type="text" id="editNome" name="nome" class="vibe-input" required>
                </div>

                {{-- E-mail de Login --}}
                <div class="vibe-field-group">
                    <label for="editEmail" class="vibe-label">E-mail de Login <span class="required">*</span></label>
                    <input type="email" id="editEmail" name="email" class="vibe-input" required>
                </div>

                {{-- CNPJ --}}
                <div class="vibe-field-group">
                    <label for="editCnpj" class="vibe-label">CNPJ</label>
                    <input type="text" id="editCnpj" name="cnpj" class="vibe-input" placeholder="00.000.000/0000-00">
                </div>

                {{-- Telefone --}}
                <div class="vibe-field-group">
                    <label for="editTelefone" class="vibe-label">Telefone</label>
                    <input type="text" id="editTelefone" name="telefone" class="vibe-input" placeholder="(00) 00000-0000">
                </div>

                {{-- E-mail de Contato --}}
                <div class="vibe-field-group">
                    <label for="editEmailContato" class="vibe-label">E-mail de Contato</label>
                    <input type="email" id="editEmailContato" name="email_contato" class="vibe-input" placeholder="contato@ong.org">
                </div>

                {{-- Cidade --}}
                <div class="vibe-field-group">
                    <label for="editCidade" class="vibe-label">Cidade</label>
                    <input type="text" id="editCidade" name="cidade" class="vibe-input">
                </div>

                {{-- Estado --}}
                <div class="vibe-field-group">
                    <label for="editEstado" class="vibe-label">Estado (UF)</label>
                    <input type="text" id="editEstado" name="estado" maxlength="2" class="vibe-input" placeholder="SP">
                </div>

                {{-- Endereço --}}
                <div class="vibe-field-group vibe-field-full">
                    <label for="editEndereco" class="vibe-label">Endereço Completo</label>
                    <input type="text" id="editEndereco" name="endereco" class="vibe-input" placeholder="Rua, número, bairro">
                </div>

                {{-- Senha Opcional --}}
                <div class="vibe-field-group">
                    <label for="editSenha" class="vibe-label">Nova Senha</label>
                    <input type="password" id="editSenha" name="senha" class="vibe-input" placeholder="Deixe em branco p/ manter">
                </div>

                {{-- Confirmação de Senha --}}
                <div class="vibe-field-group">
                    <label for="editSenhaConfirmation" class="vibe-label">Confirmar Nova Senha</label>
                    <input type="password" id="editSenhaConfirmation" name="senha_confirmation" class="vibe-input" placeholder="Repita a nova senha">
                </div>
            </div>

            <div class="vibe-modal-actions" style="margin-top: 24px;">
                <button type="button" class="vibe-btn-cancel" onclick="fecharModalEditar()">
                    Cancelar
                </button>
                <button type="submit" class="vibe-btn-confirm vibe-btn-green">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // MODAL DE STATUS
    function abrirModalStatus(id, nome, acao, actionUrl) {
        const modal = document.getElementById('modalStatusOng');
        const nomeEl = document.getElementById('modalStatusNome');
        const acaoTextEl = document.getElementById('modalStatusAcaoText');
        const btnConfirm = document.getElementById('btnConfirmarStatus');
        const formEl = document.getElementById('formConfirmarStatus');

        if (nomeEl) nomeEl.textContent = nome;
        if (acaoTextEl) acaoTextEl.textContent = acao;
        if (btnConfirm) btnConfirm.textContent = 'Sim, ' + acao;
        if (formEl) formEl.action = actionUrl;

        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function fecharModalStatus() {
        const modal = document.getElementById('modalStatusOng');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // MODAL DE EXCLUSÃO
    function abrirModalExclusao(id, nome, actionUrl) {
        const modal = document.getElementById('modalExcluirOng');
        const nomeEl = document.getElementById('modalNomeOng');
        const formEl = document.getElementById('formConfirmarExclusao');

        if (nomeEl) nomeEl.textContent = nome;
        if (formEl) formEl.action = actionUrl;
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function fecharModalExclusao() {
        const modal = document.getElementById('modalExcluirOng');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // MODAL DE DETALHES COMPLETOS
    function abrirModalDetalhes(btn) {
        const modal = document.getElementById('modalDetalhesOng');
        if (!modal) return;

        document.getElementById('detalheNome').textContent = btn.dataset.nome || '—';
        document.getElementById('detalheCnpj').textContent = btn.dataset.cnpj || '—';

        const statusEl = document.getElementById('detalheStatus');
        const isAtivo = btn.dataset.status === 'Ativo';
        statusEl.textContent = btn.dataset.status || '—';
        statusEl.className = 'status-pill ' + (isAtivo ? 'status-active' : 'status-inactive');

        document.getElementById('detalheEmailLogin').textContent = btn.dataset.emailLogin || '—';
        document.getElementById('detalheEmailContato').textContent = btn.dataset.emailContato || '—';
        document.getElementById('detalheTelefone').textContent = btn.dataset.telefone || '—';

        let enderecoCompleto = btn.dataset.endereco;
        if (btn.dataset.numero) enderecoCompleto += ', ' + btn.dataset.numero;
        if (btn.dataset.complemento) enderecoCompleto += ' (' + btn.dataset.complemento + ')';
        if (btn.dataset.bairro) enderecoCompleto += ' — ' + btn.dataset.bairro;
        if (btn.dataset.cidade || btn.dataset.estado) enderecoCompleto += ', ' + (btn.dataset.cidade || '') + ' / ' + (btn.dataset.estado || '');
        document.getElementById('detalheEnderecoCompleto').textContent = enderecoCompleto || '—';
        document.getElementById('detalheCep').textContent = btn.dataset.cep || '—';

        document.getElementById('detalhePontosCount').textContent = btn.dataset.pontosCount + ' ponto(s)';
        document.getElementById('detalheCriadoEm').textContent = btn.dataset.criadoEm || '—';
        document.getElementById('detalheDescricao').textContent = btn.dataset.descricao || 'Nenhuma descrição informada.';

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function fecharModalDetalhes() {
        const modal = document.getElementById('modalDetalhesOng');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // MODAL DE EDITAR (NA PRÓPRIA PÁGINA)
    function abrirModalEditar(btn) {
        const modal = document.getElementById('modalEditarOng');
        const form = document.getElementById('formEditarOng');

        if (form && btn.dataset.action) {
            form.action = btn.dataset.action;
        }

        document.getElementById('editNome').value = btn.dataset.nome || '';
        document.getElementById('editEmail').value = btn.dataset.email || '';
        document.getElementById('editCnpj').value = btn.dataset.cnpj || '';
        document.getElementById('editTelefone').value = btn.dataset.telefone || '';
        document.getElementById('editEmailContato').value = btn.dataset.emailContato || '';
        document.getElementById('editCidade').value = btn.dataset.cidade || '';
        document.getElementById('editEstado').value = btn.dataset.estado || '';
        document.getElementById('editEndereco').value = btn.dataset.endereco || '';
        document.getElementById('editSenha').value = '';
        document.getElementById('editSenhaConfirmation').value = '';

        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function fecharModalEditar() {
        const modal = document.getElementById('modalEditarOng');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    // Fechar ao clicar no backdrop (fora da caixa branca)
    document.addEventListener('click', function(e) {
        const modalStatus = document.getElementById('modalStatusOng');
        const modalExcluir = document.getElementById('modalExcluirOng');
        const modalEditar = document.getElementById('modalEditarOng');
        const modalDetalhes = document.getElementById('modalDetalhesOng');

        if (modalStatus && e.target === modalStatus) fecharModalStatus();
        if (modalExcluir && e.target === modalExcluir) fecharModalExclusao();
        if (modalEditar && e.target === modalEditar) fecharModalEditar();
        if (modalDetalhes && e.target === modalDetalhes) fecharModalDetalhes();
    });

    // Fechar ao teclar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModalStatus();
            fecharModalExclusao();
            fecharModalEditar();
            fecharModalDetalhes();
        }
    });
</script>
@endpush
