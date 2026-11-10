@extends('layouts.app')

@section('titulo', 'Perfil da ONG')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/ongs-show.css') }}?v=1.0">
@endsection

@section('conteudo')
    <div class="card">
        <h2>Perfil Institucional da ONG</h2>
        <p>Histórico, informações de contato e relação dos pontos de coleta mantidos pela instituição.</p>
        <hr class="ong-show-divider">
        <p class="ong-show-placeholder">(Estrutura inicial pronta para exibição do perfil da ONG)</p>
    </div>
@endsection
