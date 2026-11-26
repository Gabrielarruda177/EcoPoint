{{-- ============================================================
     MODAL DE EDITAR PONTO DE COLETA (PALETA TERROSA)
     ============================================================ --}}
<div id="modalEditarPonto" class="vibe-modal-overlay" style="display: none;">
    <div class="vibe-modal-dialog vibe-modal-dialog-large" role="dialog" aria-modal="true" aria-labelledby="modalEditarPontoTitulo">
        <button type="button" class="vibe-modal-close-btn" onclick="fecharModalEditarPonto()" title="Fechar">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="vibe-modal-header">
            <div class="vibe-modal-icon" style="margin-bottom: 8px;">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#6F4E37" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
            </div>
            <h3 id="modalEditarPontoTitulo" class="vibe-modal-title">Editar Ponto de Coleta</h3>
            <p class="vibe-modal-subtitle">Atualize os dados operacionais, endereço e materiais aceitos neste local</p>
        </div>

        <form id="formEditarPonto" method="POST" action="">
            @csrf
            @method('PUT')

            <div class="vibe-modal-body">
                <div class="edit-ponto-grid">
                    {{-- Nome --}}
                    <div class="edit-field-group edit-field-full">
                        <label for="editPontoNome" class="edit-label">Nome do Ponto de Coleta <span class="edit-req">*</span></label>
                        <input type="text" id="editPontoNome" name="nome" class="edit-input" required placeholder="Ex: Biblioteca Central">
                    </div>

                    {{-- CEP --}}
                    <div class="edit-field-group">
                        <label for="editPontoCep" class="edit-label">CEP</label>
                        <input type="text" id="editPontoCep" name="cep" class="edit-input" maxlength="9" placeholder="00000-000">
                    </div>

                    {{-- Telefone --}}
                    <div class="edit-field-group">
                        <label for="editPontoTelefone" class="edit-label">Telefone de Contato</label>
                        <input type="text" id="editPontoTelefone" name="telefone_contato" class="edit-input" maxlength="20" placeholder="(00) 00000-0000">
                    </div>

                    {{-- Endereço --}}
                    <div class="edit-field-group edit-field-wide">
                        <label for="editPontoEndereco" class="edit-label">Endereço / Logradouro <span class="edit-req">*</span></label>
                        <input type="text" id="editPontoEndereco" name="endereco" class="edit-input" required placeholder="Rua, Avenida, etc.">
                    </div>

                    {{-- Número --}}
                    <div class="edit-field-group">
                        <label for="editPontoNumero" class="edit-label">Número</label>
                        <input type="text" id="editPontoNumero" name="numero" class="edit-input" maxlength="20" placeholder="Ex: 120">
                    </div>

                    {{-- Complemento --}}
                    <div class="edit-field-group">
                        <label for="editPontoComplemento" class="edit-label">Complemento</label>
                        <input type="text" id="editPontoComplemento" name="complemento" class="edit-input" placeholder="Sala, Bloco, etc.">
                    </div>

                    {{-- Bairro --}}
                    <div class="edit-field-group">
                        <label for="editPontoBairro" class="edit-label">Bairro</label>
                        <input type="text" id="editPontoBairro" name="bairro" class="edit-input" placeholder="Bairro">
                    </div>

                    {{-- Cidade --}}
                    <div class="edit-field-group">
                        <label for="editPontoCidade" class="edit-label">Cidade <span class="edit-req">*</span></label>
                        <input type="text" id="editPontoCidade" name="cidade" class="edit-input" required placeholder="Cidade">
                    </div>

                    {{-- Estado --}}
                    <div class="edit-field-group">
                        <label for="editPontoEstado" class="edit-label">Estado (UF) <span class="edit-req">*</span></label>
                        <input type="text" id="editPontoEstado" name="estado" class="edit-input" required maxlength="2" style="text-transform: uppercase;" placeholder="SP">
                    </div>

                    {{-- Horário de Funcionamento --}}
                    <div class="edit-field-group edit-field-full">
                        <label for="editPontoHorario" class="edit-label">Horário de Funcionamento</label>
                        <input type="text" id="editPontoHorario" name="horario_funcionamento" class="edit-input" placeholder="Ex: Segunda a Sexta, 08h às 18h">
                    </div>

                    {{-- Materiais Aceitos --}}
                    <div class="edit-field-group edit-field-full">
                        <span class="edit-label">Materiais Acadêmicos Aceitos</span>
                        <div class="edit-materiais-grid">
                            @foreach ($materiais ?? [] as $material)
                                <label class="edit-material-check">
                                    <input type="checkbox" name="materiais[]" value="{{ $material->id }}" class="edit-ponto-material-cb">
                                    <span>{{ $material->nome }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Descrição --}}
                    <div class="edit-field-group edit-field-full">
                        <label for="editPontoDescricao" class="edit-label">Instruções e Observações</label>
                        <textarea id="editPontoDescricao" name="descricao" rows="3" class="edit-input edit-textarea" placeholder="Pontos de referência ou orientações aos doadores..."></textarea>
                    </div>

                    {{-- Status Ativo --}}
                    <div class="edit-field-group edit-field-full">
                        <label class="edit-status-check">
                            <input type="checkbox" id="editPontoAtivo" name="ativo" value="1">
                            <span>Ponto de coleta ativo e visível no mapa público</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="vibe-modal-footer" style="gap: 12px;">
                <button type="button" class="vibe-btn-cancel" style="flex: 0 0 auto; min-width: 120px;" onclick="fecharModalEditarPonto()">
                    Cancelar
                </button>
                <button type="submit" class="vibe-btn-confirm" style="flex: 0 0 auto; min-width: 170px;">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .edit-ponto-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.9rem 1rem;
        text-align: left;
    }

    .edit-field-group {
        display: flex;
        flex-direction: column;
    }

    .edit-field-full {
        grid-column: span 2;
    }

    .edit-field-wide {
        grid-column: span 1;
    }

    @media (max-width: 600px) {
        .edit-ponto-grid {
            grid-template-columns: 1fr;
        }
        .edit-field-full {
            grid-column: span 1;
        }
    }

    .edit-label {
        font-size: 0.78rem;
        font-weight: 700;
        color: #6F4E37;
        margin-bottom: 0.3rem;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .edit-req {
        color: #B91C1C;
    }

    .edit-input {
        width: 100%;
        padding: 0.6rem 0.8rem;
        border: 1px solid #D4B996;
        border-radius: 9px;
        background: #FFFDF9;
        color: #3B2A1F;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .edit-input:focus {
        border-color: #6F4E37;
        background: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(111, 78, 55, 0.12);
    }

    .edit-textarea {
        resize: vertical;
        min-height: 76px;
    }

    .edit-materiais-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 0.5rem;
        background: #FAF6F0;
        border: 1px solid #EDE3D4;
        border-radius: 10px;
        padding: 0.75rem;
    }

    .edit-material-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.84rem;
        color: #3B2A1F;
        cursor: pointer;
        font-weight: 500;
    }

    .edit-material-check input[type="checkbox"],
    .edit-status-check input[type="checkbox"] {
        accent-color: #6F4E37;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .edit-status-check {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        font-size: 0.88rem;
        font-weight: 600;
        color: #3B2A1F;
        background: #FAF6F0;
        border: 1px solid #EDE3D4;
        padding: 0.65rem 0.9rem;
        border-radius: 10px;
        cursor: pointer;
    }
</style>

<script>
    function abrirModalEditarPonto(btn) {
        const modal = document.getElementById('modalEditarPonto');
        const form = document.getElementById('formEditarPonto');
        if (!modal || !form) return;

        form.action = btn.dataset.action || '';

        document.getElementById('editPontoNome').value = btn.dataset.nome || '';
        document.getElementById('editPontoCep').value = btn.dataset.cep || '';
        document.getElementById('editPontoTelefone').value = btn.dataset.telefone || '';
        document.getElementById('editPontoEndereco').value = btn.dataset.endereco || '';
        document.getElementById('editPontoNumero').value = btn.dataset.numero || '';
        document.getElementById('editPontoComplemento').value = btn.dataset.complemento || '';
        document.getElementById('editPontoBairro').value = btn.dataset.bairro || '';
        document.getElementById('editPontoCidade').value = btn.dataset.cidade || '';
        document.getElementById('editPontoEstado').value = btn.dataset.estado || '';
        document.getElementById('editPontoHorario').value = btn.dataset.horario || '';
        document.getElementById('editPontoDescricao').value = btn.dataset.descricao || '';
        document.getElementById('editPontoAtivo').checked = btn.dataset.ativo === '1';

        const selectedIds = (btn.dataset.materiaisIds || '').split(',').filter(Boolean);
        document.querySelectorAll('.edit-ponto-material-cb').forEach(cb => {
            cb.checked = selectedIds.includes(cb.value);
        });

        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function fecharModalEditarPonto() {
        const modal = document.getElementById('modalEditarPonto');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('click', function(e) {
        const modalEditar = document.getElementById('modalEditarPonto');
        if (modalEditar && e.target === modalEditar) {
            fecharModalEditarPonto();
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModalEditarPonto();
        }
    });
</script>
