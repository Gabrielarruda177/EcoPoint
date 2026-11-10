@extends('layouts.app')

@section('titulo', 'Meus Pontos de Coleta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/pontos.css') }}?v=1.0">
@endsection

@section('conteudo')
    <div class="card">
        <span class="badge badge-ong">Perfil: ONG</span>
        <h2 class="pontos-title">Meus Pontos de Coleta</h2>
        <p>Gerencie os locais cadastrados pela sua instituição para recebimento de livros e apostilas.</p>
        <p class="pontos-action-row">
            <a href="{{ route('ong.pontos.create') }}" class="btn-new-ponto">
                + Novo Ponto de Coleta
            </a>
        </p>
        <hr class="pontos-divider">
        <p class="pontos-placeholder">(Estrutura inicial pronta para a tabela de pontos da ONG)</p>
    </div>
@endsection
