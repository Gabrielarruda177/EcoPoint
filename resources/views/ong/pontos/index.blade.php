@extends('layouts.app')

@section('titulo', 'Meus Pontos de Coleta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/pontos.css') }}?v=1.1">
@endsection

@section('conteudo')
<div class="pontos-container">
    <div class="pontos-header-card">
        <div>
            <span class="badge badge-ong">Perfil: ONG</span>
            <h1 class="pontos-title">Meus Pontos de Coleta</h1>
            <p class="pontos-subtitle">
                Gerencie os locais cadastrados pela sua instituição para recebimento de livros e apostilas acadêmicas.
            </p>
        </div>
        <div>
            <a href="{{ route('ong.pontos.create') }}" class="btn-new-ponto">
                + Novo Ponto de Coleta
            </a>
        </div>
    </div>

    <div class="pontos-table-card">
        <div class="table-responsive">
            <table class="pontos-table">
                <thead>
                    <tr>
                        <th>Ponto de Coleta</th>
                        <th>Endereço Completo</th>
                        <th>Materiais Aceitos</th>
                        <th>Status</th>
                        <th style="text-align: right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pontos as $ponto)
                        <tr>
                            <td>
                                <div class="ponto-nome-cell">{{ $ponto->nome }}</div>
                                @if ($ponto->horario_funcionamento)
                                    <div class="ponto-subtext">🕒 {{ $ponto->horario_funcionamento }}</div>
                                @endif
                                @if ($ponto->telefone_contato)
                                    <div class="ponto-subtext">📞 {{ $ponto->telefone_contato }}</div>
                                @endif
                            </td>
                            <td>
                                <div>
                                    {{ $ponto->endereco }}{{ $ponto->numero ? ', ' . $ponto->numero : '' }}
                                    @if ($ponto->complemento)
                                        <span class="ponto-subtext">({{ $ponto->complemento }})</span>
                                    @endif
                                </div>
                                <div class="ponto-subtext">
                                    {{ $ponto->bairro ? $ponto->bairro . ' - ' : '' }}{{ $ponto->cidade }}/{{ $ponto->estado }}
                                    @if ($ponto->cep)
                                        | CEP: {{ $ponto->cep }}
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="materiais-badges">
                                    @forelse ($ponto->materiaisAceitos as $material)
                                        <span class="badge-material">{{ $material->nome }}</span>
                                    @empty
                                        <span class="ponto-subtext">Nenhum material associado</span>
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
                            <td>
                                <div class="actions-group actions-group--end">
                                    <a href="{{ route('ong.pontos.edit', $ponto) }}" class="btn-action btn-action-edit">
                                        Editar
                                    </a>

                                    <form action="{{ route('ong.pontos.destroy', $ponto) }}" method="POST" class="form-inline" onsubmit="return confirm('Tem certeza que deseja excluir este ponto de coleta?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-action-delete">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <p>Sua organização ainda não possui pontos de coleta cadastrados.</p>
                                    <a href="{{ route('ong.pontos.create') }}" class="btn-new-ponto">
                                        Cadastrar Primeiro Ponto
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($pontos->hasPages())
            <div class="pagination-wrapper">
                {{ $pontos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
