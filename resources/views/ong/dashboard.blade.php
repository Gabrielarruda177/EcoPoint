@extends('layouts.app')

@section('titulo', 'Painel da ONG')

@section('conteudo')
    <div class="card">
        <span class="badge badge-ong">Perfil: ONG</span>
        <h2 style="margin-top: 0.5rem;">Painel da Instituição</h2>
        <p>Área reservada para gestão institucional da ONG e de seus pontos de coleta de livros/apostilas.</p>
        <hr style="margin: 1rem 0; border: 0; border-top: 1px solid #e2e8f0;">
        <ul style="margin-left: 1.5rem;">
            <li><a href="{{ route('ong.perfil.edit') }}">Editar Perfil da Instituição</a></li>
            <li><a href="{{ route('ong.pontos.index') }}">Gerenciar Meus Pontos de Coleta</a></li>
            <li><a href="{{ route('ong.pontos.create') }}">Cadastrar Novo Ponto de Coleta</a></li>
        </ul>
    </div>
@endsection

