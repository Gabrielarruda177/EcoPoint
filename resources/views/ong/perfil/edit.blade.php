@extends('layouts.ong')

@section('titulo', 'Meu Perfil Institucional')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/perfil-edit.css') }}?v=3.0">
@endsection

@section('conteudo')
<div class="perfil-container">

    {{-- Header da Página --}}
    <div class="perfil-header-card">
        <div class="perfil-header-content">
            <div>
                <span class="badge-portal">Área da Organização</span>
                <h1 class="perfil-title">Perfil Institucional da Organização</h1>
                <p class="perfil-subtitle">
                    Mantenha os canais de contato atualizados e acompanhe solicitações de alteração de dados cadastrais.
                </p>
            </div>
            <div class="perfil-header-meta">
                <span class="meta-ong-status {{ $ong->ativo ? 'status-ativa' : 'status-inativa' }}">
                    <span class="status-dot"></span>
                    {{ $ong->ativo ? 'Instituição Ativa' : 'Instituição Inativa' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Notificações / Alertas --}}
    @if (session('sucesso') || session('success'))
        <div class="alert-box alert-success" role="alert">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
            <div>{{ session('sucesso') ?? session('success') }}</div>
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

    @if ($errors->any())
        <div class="alert-box alert-danger" role="alert">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <div>
                <strong>Por favor, verifique os erros encontrados:</strong>
                <ul class="alert-list">
                    @foreach ($errors->all() as $erro)
                        <li>{{ $erro }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    {{-- ============================================================
         SEÇÃO 1 — INFORMAÇÕES QUE EXIGEM APROVAÇÃO E DADOS FIXOS
         ============================================================ --}}
    <div class="perfil-card controlled-card">
        <div class="card-title-row">
            <div>
                <span class="section-tag approval-tag">Controle de Identificação</span>
                <h2 class="card-section-title">1. Informações que Exigem Aprovação do Administrador</h2>
                <p class="card-section-desc">
                    Por motivos de segurança e integridade cadastral, alterações de <strong>Nome</strong> e <strong>Localização Oficial</strong> passam por análise da equipe gestora antes de serem oficializadas.
                </p>
            </div>
        </div>

        <div class="controlled-grid">
            {{-- BLOCO NOME DA INSTITUIÇÃO --}}
            <div class="controlled-item">
                <div class="controlled-item-header">
                    <div>
                        <span class="item-label">Nome Oficial da ONG</span>
                        <div class="item-value-main">{{ $ong->nome }}</div>
                    </div>
                    <span class="badge-lock">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Requer Aprovação
                    </span>
                </div>

                @if ($solicitacaoNomePendente)
                    <div class="pending-notice">
                        <div class="pending-notice-icon">⏳</div>
                        <div class="pending-notice-body">
                            <strong>Solicitação em análise enviada em {{ $solicitacaoNomePendente->created_at->format('d/m/Y \à\s H:i') }}:</strong>
                            <div class="proposed-value">Novo nome solicitado: <span>"{{ $solicitacaoNomePendente->dados_propostos['nome'] ?? '' }}"</span></div>
                        </div>
                    </div>
                @else
                    <div class="controlled-action">
                        <button type="button" class="btn-action-request" onclick="abrirModalNome()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            Solicitar Alteração de Nome
                        </button>
                    </div>
                @endif
            </div>

            {{-- BLOCO CNPJ (DADO FIXO) --}}
            <div class="controlled-item">
                <div class="controlled-item-header">
                    <div>
                        <span class="item-label">CNPJ (Registro Cadastral Fixo)</span>
                        <div class="item-value-main cnpj-badge-display">
                            {{ $ong->cnpj ?: 'Não informado' }}
                        </div>
                    </div>
                    <span class="badge-immutable">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>
                        Dado Imutável
                    </span>
                </div>
                <p class="item-helper-text">
                    O CNPJ é o identificador único da entidade na plataforma. Conforme as regras do sistema, não é passível de alteração após o cadastro.
                </p>
            </div>

            {{-- BLOCO ENDEREÇO / LOCALIZAÇÃO OFICIAL --}}
            <div class="controlled-item full-width">
                <div class="controlled-item-header">
                    <div>
                        <span class="item-label">Endereço e Localização Oficial</span>
                        <div class="item-value-address">
                            @if ($ong->endereco || $ong->cidade)
                                <strong>{{ $ong->endereco ?: 'Logradouro não informado' }}, {{ $ong->numero ?: 'S/N' }}</strong>
                                @if($ong->complemento) <span>({{ $ong->complemento }})</span> @endif
                                <span>— {{ $ong->bairro ?: 'Bairro não informado' }}, {{ $ong->cidade ?: '-' }} / {{ $ong->estado ?: '-' }}</span>
                                <span class="cep-tag">CEP: {{ $ong->cep ?: 'Não informado' }}</span>
                            @else
                                <span class="text-muted">Nenhum endereço cadastrado no momento.</span>
                            @endif
                        </div>
                    </div>
                    <span class="badge-lock">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Requer Aprovação
                    </span>
                </div>

                @if ($solicitacaoEnderecoPendente)
                    <div class="pending-notice">
                        <div class="pending-notice-icon">⏳</div>
                        <div class="pending-notice-body">
                            <strong>Solicitação de novo endereço enviada em {{ $solicitacaoEnderecoPendente->created_at->format('d/m/Y \à\s H:i') }}:</strong>
                            <div class="proposed-value">
                                Proposta: {{ $solicitacaoEnderecoPendente->dados_propostos['endereco'] ?? '' }}, {{ $solicitacaoEnderecoPendente->dados_propostos['numero'] ?? 'S/N' }} — {{ $solicitacaoEnderecoPendente->dados_propostos['bairro'] ?? '' }}, {{ $solicitacaoEnderecoPendente->dados_propostos['cidade'] ?? '' }}/{{ $solicitacaoEnderecoPendente->dados_propostos['estado'] ?? '' }} (CEP: {{ $solicitacaoEnderecoPendente->dados_propostos['cep'] ?? '' }})
                            </div>
                        </div>
                    </div>
                @else
                    <div class="controlled-action">
                        <button type="button" class="btn-action-request" onclick="abrirModalEndereco()">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            Solicitar Alteração de Endereço
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ============================================================
         SEÇÃO 2 — INFORMAÇÕES EDITÁVEIS DIRETAMENTE PELA ONG
         ============================================================ --}}
    <form action="{{ route('ong.perfil.update') }}" method="POST" class="perfil-direct-form">
        @csrf
        @method('PUT')

        <div class="perfil-card">
            <div class="card-title-row">
                <div>
                    <span class="section-tag direct-tag">Edição Direta</span>
                    <h2 class="card-section-title">2. Informações de Contato e Apresentação</h2>
                    <p class="card-section-desc">
                        Você tem autonomia total para atualizar seus canais de contato e apresentação institucional a qualquer momento.
                    </p>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="telefone" class="form-label">Telefone de Contato</label>
                    <input 
                        type="text" 
                        name="telefone" 
                        id="telefone" 
                        class="form-control" 
                        value="{{ old('telefone', $ong->telefone) }}" 
                        placeholder="(11) 98765-4321"
                    >
                    <span class="form-hint">Telefone comercial ou WhatsApp da entidade.</span>
                </div>

                <div class="form-group">
                    <label for="email_contato" class="form-label">E-mail Institucional Público</label>
                    <input 
                        type="email" 
                        name="email_contato" 
                        id="email_contato" 
                        class="form-control" 
                        value="{{ old('email_contato', $ong->email_contato) }}" 
                        placeholder="contato@instituicao.org"
                    >
                    <span class="form-hint">Exibido na página pública para voluntários e doadores.</span>
                </div>
            </div>

            <div class="form-group">
                <label for="descricao" class="form-label">Descrição Institucional</label>
                <textarea 
                    name="descricao" 
                    id="descricao" 
                    class="form-control" 
                    rows="3" 
                    placeholder="Conte sobre a missão da organização, projetos de incentivo à leitura e reciclagem, áreas de atuação..."
                >{{ old('descricao', $ong->descricao) }}</textarea>
                <span class="form-hint">Apresentação visível no portal público do EcoPoints.</span>
            </div>

            <div class="divider-line"></div>

            <div class="card-title-row">
                <div>
                    <span class="section-tag direct-tag">Acesso à Plataforma</span>
                    <h2 class="card-section-title">3. Credenciais de Acesso e Senha</h2>
                    <p class="card-section-desc">
                        Gerencie seu e-mail de login e renove sua senha quando necessário. Deixe a senha em branco para mantê-la inalterada.
                    </p>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    E-mail de Login / Acesso <span class="required-mark">*</span>
                </label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    class="form-control" 
                    value="{{ old('email', $ong->user->email ?? auth()->user()->email) }}" 
                    required
                >
                <span class="form-hint">E-mail utilizado para entrar no painel da ONG. A alteração tem efeito imediato.</span>
            </div>

            <div class="form-group">
                <label for="senha_atual" class="form-label">Senha Atual (obrigatória apenas se for trocar de senha)</label>
                <input 
                    type="password" 
                    name="senha_atual" 
                    id="senha_atual" 
                    class="form-control" 
                    placeholder="Digite sua senha atual para autorizar nova senha"
                    autocomplete="current-password"
                >
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label for="nova_senha" class="form-label">Nova Senha</label>
                    <input 
                        type="password" 
                        name="nova_senha" 
                        id="nova_senha" 
                        class="form-control" 
                        placeholder="Mínimo de 8 caracteres"
                        autocomplete="new-password"
                    >
                </div>

                <div class="form-group">
                    <label for="nova_senha_confirmation" class="form-label">Confirmar Nova Senha</label>
                    <input 
                        type="password" 
                        name="nova_senha_confirmation" 
                        id="nova_senha_confirmation" 
                        class="form-control" 
                        placeholder="Repita a nova senha"
                        autocomplete="new-password"
                    >
                </div>
            </div>

            <div class="form-actions-footer">
                <a href="{{ route('ong.dashboard') }}" class="btn-secondary">
                    Voltar ao Painel
                </a>
                <button type="submit" class="btn-primary-green">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path><polyline points="17 21 17 13 7 13 7 21"></polyline><polyline points="7 3 7 8 15 8"></polyline></svg>
                    Salvar Informações Diretas
                </button>
            </div>
        </div>
    </form>

    {{-- ============================================================
         SEÇÃO 3 — HISTÓRICO E ACOMPANHAMENTO DE SOLICITAÇÕES
         ============================================================ --}}
    <div class="perfil-card">
        <div class="card-title-row">
            <div>
                <span class="section-tag history-tag">Transparência</span>
                <h2 class="card-section-title">4. Histórico e Acompanhamento de Solicitações</h2>
                <p class="card-section-desc">
                    Consulte o andamento de todos os seus pedidos de alteração de nome e endereço analisados pelo administrador.
                </p>
            </div>
        </div>

        @if ($solicitacoes->isEmpty())
            <div class="empty-solicitacoes">
                <div class="empty-icon">📋</div>
                <p class="empty-title">Nenhuma solicitação enviada até o momento</p>
                <p class="empty-desc">Quando você solicitar alteração de nome ou endereço, o status e o histórico completo aparecerão aqui.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="solicitacoes-table">
                    <thead>
                        <tr>
                            <th>Data de Envio</th>
                            <th>Tipo</th>
                            <th>Informação Solicitada</th>
                            <th>Status</th>
                            <th>Parecer / Decisão</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($solicitacoes as $item)
                            <tr>
                                <td class="table-date">
                                    {{ $item->created_at->format('d/m/Y') }}
                                    <span class="time-sub">{{ $item->created_at->format('H:i') }}</span>
                                </td>
                                <td>
                                    @if ($item->tipo === 'nome')
                                        <span class="badge-type type-nome">Nome</span>
                                    @else
                                        <span class="badge-type type-endereco">Endereço</span>
                                    @endif
                                </td>
                                <td class="table-details">
                                    @if ($item->tipo === 'nome')
                                        <div class="detail-comparison">
                                            <div class="val-proposed"><strong>Novo:</strong> {{ $item->dados_propostos['nome'] ?? '-' }}</div>
                                            <div class="val-current"><strong>Anterior:</strong> {{ $item->dados_atuais['nome'] ?? '-' }}</div>
                                        </div>
                                    @else
                                        <div class="detail-comparison">
                                            <div class="val-proposed">
                                                <strong>Novo:</strong> 
                                                {{ $item->dados_propostos['endereco'] ?? '' }}, {{ $item->dados_propostos['numero'] ?? 'S/N' }} — {{ $item->dados_propostos['bairro'] ?? '' }}, {{ $item->dados_propostos['cidade'] ?? '' }}/{{ $item->dados_propostos['estado'] ?? '' }} (CEP: {{ $item->dados_propostos['cep'] ?? '' }})
                                            </div>
                                        </div>
                                    @endif

                                    @if ($item->justificativa)
                                        <div class="item-justificativa">
                                            <em>"{{ $item->justificativa }}"</em>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status === 'pendente')
                                        <span class="badge-status status-pending">
                                            <span class="status-indicator"></span> Pendente
                                        </span>
                                    @elseif ($item->status === 'aprovada')
                                        <span class="badge-status status-approved">
                                            <span class="status-indicator"></span> Aprovada
                                        </span>
                                    @elseif ($item->status === 'recusada')
                                        <span class="badge-status status-rejected">
                                            <span class="status-indicator"></span> Recusada
                                        </span>
                                    @endif
                                </td>
                                <td class="table-parecer">
                                    @if ($item->status === 'pendente')
                                        <span class="text-muted">Aguardando análise da administração</span>
                                    @elseif ($item->status === 'aprovada')
                                        <span class="text-success-green">
                                            Aprovada em {{ $item->analisado_em ? $item->analisado_em->format('d/m/Y H:i') : '-' }}
                                        </span>
                                    @elseif ($item->status === 'recusada')
                                        <div class="refusal-box">
                                            <strong>Motivo da recusa:</strong>
                                            <p>{{ $item->motivo_recusa ?: 'Motivo não especificado.' }}</p>
                                            <span class="refusal-date">Analisada em {{ $item->analisado_em ? $item->analisado_em->format('d/m/Y H:i') : '-' }}</span>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($solicitacoes->hasPages())
                <div class="pagination-wrapper">
                    {{ $solicitacoes->links() }}
                </div>
            @endif
        @endif
    </div>

</div>

{{-- ============================================================
     MODAL — SOLICITAR ALTERAÇÃO DE NOME
     ============================================================ --}}
<div class="custom-modal-backdrop" id="modalNomeBackdrop" style="display: none;">
    <div class="custom-modal-dialog">
        <div class="custom-modal-header">
            <div class="modal-header-icon green-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
            </div>
            <div>
                <h3 class="custom-modal-title">Solicitar Alteração de Nome</h3>
                <p class="custom-modal-subtitle">Envie o novo nome oficial da instituição para análise administrativa.</p>
            </div>
            <button type="button" class="modal-close-btn" onclick="fecharModalNome()">✕</button>
        </div>

        <form action="{{ route('ong.perfil.solicitar') }}" method="POST">
            @csrf
            <input type="hidden" name="tipo" value="nome">

            <div class="custom-modal-body">
                <div class="modal-alert-info">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    <span>O nome atual continuará ativo no sistema até que um administrador aprove sua solicitação.</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Nome Atual Registrado</label>
                    <input type="text" class="form-control" value="{{ $ong->nome }}" readonly disabled>
                </div>

                <div class="form-group">
                    <label for="novo_nome" class="form-label">
                        Novo Nome Pretendido <span class="required-mark">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="novo_nome" 
                        id="novo_nome" 
                        class="form-control" 
                        placeholder="Ex.: Novo Instituto Cultural Esperança" 
                        required
                        maxlength="255"
                    >
                </div>

                <div class="form-group">
                    <label for="justificativa_nome" class="form-label">Justificativa da Mudança (Opcional)</label>
                    <textarea 
                        name="justificativa" 
                        id="justificativa_nome" 
                        class="form-control" 
                        rows="2" 
                        placeholder="Ex.: Alteração estatutária recente ou atualização de razão social..."
                    ></textarea>
                </div>
            </div>

            <div class="custom-modal-footer">
                <button type="button" class="btn-secondary" onclick="fecharModalNome()">Cancelar</button>
                <button type="submit" class="btn-primary-green">Enviar Solicitação</button>
            </div>
        </form>
    </div>
</div>

{{-- ============================================================
     MODAL — SOLICITAR ALTERAÇÃO DE ENDEREÇO
     ============================================================ --}}
<div class="custom-modal-backdrop" id="modalEnderecoBackdrop" style="display: none;">
    <div class="custom-modal-dialog custom-modal-lg">
        <div class="custom-modal-header">
            <div class="modal-header-icon green-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            </div>
            <div>
                <h3 class="custom-modal-title">Solicitar Alteração de Endereço</h3>
                <p class="custom-modal-subtitle">Informe a nova sede ou endereço oficial da instituição para validação.</p>
            </div>
            <button type="button" class="modal-close-btn" onclick="fecharModalEndereco()">✕</button>
        </div>

        <form action="{{ route('ong.perfil.solicitar') }}" method="POST">
            @csrf
            <input type="hidden" name="tipo" value="endereco">

            <div class="custom-modal-body">
                <div class="modal-alert-info">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    <span>O endereço anterior continuará ativo nos pontos de coleta até a aprovação pelo administrador.</span>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="cep_modal" class="form-label">CEP <span class="required-mark">*</span></label>
                        <input 
                            type="text" 
                            name="cep" 
                            id="cep_modal" 
                            class="form-control" 
                            placeholder="00000-000" 
                            maxlength="9"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="estado_modal" class="form-label">Estado (UF) <span class="required-mark">*</span></label>
                        <input 
                            type="text" 
                            name="estado" 
                            id="estado_modal" 
                            class="form-control" 
                            placeholder="SP" 
                            maxlength="2"
                            style="text-transform: uppercase;"
                            required
                        >
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="cidade_modal" class="form-label">Cidade <span class="required-mark">*</span></label>
                        <input 
                            type="text" 
                            name="cidade" 
                            id="cidade_modal" 
                            class="form-control" 
                            placeholder="São Paulo" 
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="bairro_modal" class="form-label">Bairro <span class="required-mark">*</span></label>
                        <input 
                            type="text" 
                            name="bairro" 
                            id="bairro_modal" 
                            class="form-control" 
                            placeholder="Bairro" 
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="endereco_modal" class="form-label">Logradouro / Rua <span class="required-mark">*</span></label>
                    <input 
                        type="text" 
                        name="endereco" 
                        id="endereco_modal" 
                        class="form-control" 
                        placeholder="Av. Principal, Rua das Flores..." 
                        required
                    >
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label for="numero_modal" class="form-label">Número</label>
                        <input 
                            type="text" 
                            name="numero" 
                            id="numero_modal" 
                            class="form-control" 
                            placeholder="123 ou S/N"
                        >
                    </div>

                    <div class="form-group">
                        <label for="complemento_modal" class="form-label">Complemento</label>
                        <input 
                            type="text" 
                            name="complemento" 
                            id="complemento_modal" 
                            class="form-control" 
                            placeholder="Sala 10, Bloco B"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="justificativa_endereco" class="form-label">Justificativa da Mudança (Opcional)</label>
                    <textarea 
                        name="justificativa" 
                        id="justificativa_endereco" 
                        class="form-control" 
                        rows="2" 
                        placeholder="Ex.: Mudança para sede própria ou ampliação de instalações..."
                    ></textarea>
                </div>
            </div>

            <div class="custom-modal-footer">
                <button type="button" class="btn-secondary" onclick="fecharModalEndereco()">Cancelar</button>
                <button type="submit" class="btn-primary-green">Enviar Solicitação</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModalNome() {
        document.getElementById('modalNomeBackdrop').style.display = 'flex';
        setTimeout(() => document.getElementById('novo_nome')?.focus(), 100);
    }

    function fecharModalNome() {
        document.getElementById('modalNomeBackdrop').style.display = 'none';
    }

    function abrirModalEndereco() {
        document.getElementById('modalEnderecoBackdrop').style.display = 'flex';
        setTimeout(() => document.getElementById('cep_modal')?.focus(), 100);
    }

    function fecharModalEndereco() {
        document.getElementById('modalEnderecoBackdrop').style.display = 'none';
    }

    window.addEventListener('click', function(e) {
        const modalNome = document.getElementById('modalNomeBackdrop');
        const modalEndereco = document.getElementById('modalEnderecoBackdrop');
        if (e.target === modalNome) fecharModalNome();
        if (e.target === modalEndereco) fecharModalEndereco();
    });

    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            fecharModalNome();
            fecharModalEndereco();
        }
    });

    const cepInput = document.getElementById('cep_modal');
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 8);
            if (v.length > 5) {
                v = v.replace(/^(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = v;

            const rawCep = v.replace(/\D/g, '');
            if (rawCep.length === 8) {
                fetch(`https://viacep.com.br/ws/${rawCep}/json/`)
                    .then(r => r.json())
                    .then(data => {
                        if (!data.erro) {
                            if (data.logradouro) document.getElementById('endereco_modal').value = data.logradouro;
                            if (data.bairro) document.getElementById('bairro_modal').value = data.bairro;
                            if (data.localidade) document.getElementById('cidade_modal').value = data.localidade;
                            if (data.uf) document.getElementById('estado_modal').value = data.uf;
                            document.getElementById('numero_modal')?.focus();
                        }
                    })
                    .catch(() => {});
            }
        });
    }

    const telInput = document.getElementById('telefone');
    if (telInput) {
        telInput.addEventListener('input', function(e) {
            let v = e.target.value.replace(/\D/g, '').substring(0, 11);
            if (v.length > 10) {
                v = v.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
            } else if (v.length > 5) {
                v = v.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
            } else if (v.length > 2) {
                v = v.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
            }
            e.target.value = v;
        });
    }
</script>
@endsection

@section('scripts')
    <script src="{{ asset('js/utils/form-helpers.js') }}?v=1.0"></script>
@endsection
