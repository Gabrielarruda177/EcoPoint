@extends('layouts.app')

@section('titulo', 'Painel da ONG')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/dashboard.css') }}?v=1.0">
@endsection

@section('conteudo')
    <div class="card">
        <span class="badge badge-ong">Perfil: ONG</span>
        <h2 class="ong-dashboard-title">Painel da Instituição</h2>
        <p class="ong-dashboard-welcome">
            Bem-vindo(a), <strong>{{ auth()->user()->name }}</strong>!
        </p>
        <p class="ong-dashboard-desc">
            Área reservada para gestão institucional da ONG e de seus pontos de coleta de livros/apostilas.
        </p>
        <hr class="ong-dashboard-divider">
        <ul class="ong-dashboard-links">
            <li><a href="{{ route('ong.perfil.edit') }}">Editar Perfil da Instituição</a></li>
            <li><a href="{{ route('ong.pontos.index') }}">Gerenciar Meus Pontos de Coleta</a></li>
            <li><a href="{{ route('ong.pontos.create') }}">Cadastrar Novo Ponto de Coleta</a></li>
        </ul>
    </div>
@endsection
