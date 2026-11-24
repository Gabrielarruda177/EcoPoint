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
                Consulte, edite, ative/desative ou exclua as organizações parceiras cadastradas.
            </p>
        </div>
        <div>
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
                                    {{-- Botão que abre o Modal de Edição na própria página --}}
                                    <button type="button" 
                                            class="btn-action btn-action-edit" 
                                            title="Editar dados da ONG"
                                            data-action="{{ route('admin.ongs.update', $ong) }}"
                                            data-nome="{{ $ong->nome }}"
                                            data-email="{{ $ong->user->email ?? '' }}"
                                            data-cnpj="{{ $ong->cnpj }}"
                                            data-telefone="{{ $ong->telefone }}"
                                            data-email-contato="{{ $ong->email_contato }}"
                                            data-cidade="{{ $ong->cidade }}"
                                            data-estado="{{ $ong->estado }}"
                                            data-endereco="{{ $ong->endereco }}"
                                            data-numero="{{ $ong->numero }}"
                                            data-bairro="{{ $ong->bairro }}"
                                            data-cep="{{ $ong->cep }}"
                                            onclick="abrirModalEditar(this)">
                                        Editar
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

        if (modalStatus && e.target === modalStatus) fecharModalStatus();
        if (modalExcluir && e.target === modalExcluir) fecharModalExclusao();
        if (modalEditar && e.target === modalEditar) fecharModalEditar();
    });

    // Fechar ao teclar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModalStatus();
            fecharModalExclusao();
            fecharModalEditar();
        }
    });
</script>
@endpush
