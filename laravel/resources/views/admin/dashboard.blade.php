@extends('layouts.app')

@section('titulo', 'Painel do Administrador')

@section('conteudo')
    <div class="card">
        <span class="badge badge-admin">Perfil: Administrador</span>
        <h2 style="margin-top: 0.5rem;">Painel de Controle do Administrador</h2>
        <p>Visão geral e gerenciamento central de ONGs cadastradas e seus acessos.</p>
        <hr style="margin: 1rem 0; border: 0; border-top: 1px solid #e2e8f0;">
        <ul style="margin-left: 1.5rem;">
            <li><a href="{{ route('admin.ongs.index') }}">Gerenciar ONGs Cadastradas</a></li>
            <li><a href="{{ route('admin.ongs.create') }}">Cadastrar Nova ONG</a></li>
        </ul>
    </div>
@endsection

