@extends('layouts.admin')

@section('titulo', 'Gerenciamento de ONGs')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/ongs-index.css') }}?v=1.1">
@endsection

@section('conteudo')
<div class="ongs-index-container">
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

    <div class="ongs-table-card">
        <div class="table-responsive">
            <table class="ongs-table">
                <thead>
                    <tr>
                        <th>Instituição</th>
                        <th>CNPJ / Telefone</th>
                        <th>Usuário de Acesso</th>
                        <th>Status</th>
                        <th class="th-actions">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ongs as $ong)
                        <tr>
                            <td>
                                <div class="ong-nome-cell">{{ $ong->nome }}</div>
                                @if ($ong->email_contato)
                                    <div class="ong-subtext">{{ $ong->email_contato }}</div>
                                @endif
                            </td>
                            <td>
                                <div>{{ $ong->cnpj ?: 'Não informado' }}</div>
                                @if ($ong->telefone)
                                    <div class="ong-subtext">{{ $ong->telefone }}</div>
                                @endif
                            </td>
                            <td>
                                <div>{{ $ong->user->email ?? 'Sem usuário' }}</div>
                            </td>
                            <td>
                                @if ($ong->ativo)
                                    <span class="status-pill status-active">Ativo</span>
                                @else
                                    <span class="status-pill status-inactive">Inativo</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-group actions-group--end">
                                    <a href="{{ route('admin.ongs.edit', $ong) }}" class="btn-action btn-action-edit">
                                        Editar
                                    </a>

                                    <form action="{{ route('admin.ongs.toggleStatus', $ong) }}" method="POST" class="form-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-action btn-action-toggle">
                                            {{ $ong->ativo ? 'Desativar' : 'Ativar' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.ongs.destroy', $ong) }}" method="POST" class="form-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta ONG e seus pontos de coleta associados?');">
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

        @if ($ongs->hasPages())
            <div class="table-pagination">
                {{ $ongs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
