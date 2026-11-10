@extends('layouts.app')

@section('titulo', 'Detalhes do Ponto de Coleta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/pontos-show.css') }}?v=1.0">
@endsection

@section('conteudo')
    <div class="card">
        <h2>Detalhes do Ponto de Coleta</h2>
        <p>Informações de endereço, horários de funcionamento e materiais aceitos.</p>
        <hr class="ponto-show-divider">
        <p class="ponto-show-placeholder">(Estrutura inicial pronta para exibição detalhada do ponto)</p>
    </div>
@endsection
