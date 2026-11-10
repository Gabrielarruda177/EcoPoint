@extends('layouts.app')

@section('titulo', 'Gerenciar ONGs')

@section('conteudo')
    <div class="card">
        <span class="badge badge-admin">Perfil: Administrador</span>
        <h2 style="margin-top: 0.5rem;">Gerenciamento de ONGs</h2>
        <p>Consulte, edite ou desative o acesso de organizações cadastradas no sistema.</p>
        <p style="margin: 1rem 0;">
            <a href="{{ route('admin.ongs.create') }}" style="background: #2f855a; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
                + Nova ONG
            </a>
        </p>
        <hr style="margin: 1rem 0; border: 0; border-top: 1px solid #e2e8f0;">
        <p style="color: #718096; font-style: italic;">(Estrutura inicial pronta para a tabela de listagem de ONGs com ações de editar e desativar)</p>
    </div>
@endsection

