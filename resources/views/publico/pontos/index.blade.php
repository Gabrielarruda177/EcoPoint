@extends('layouts.app')

@section('titulo', 'Pontos de Coleta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/pontos-index.css') }}?v=1.0">
@endsection

@section('conteudo')
    <div class="card">
        <h2>Pontos de Coleta de Livros e Apostilas</h2>
        <p>Consulte os locais cadastrados pelas ONGs parceiras para entrega e doação de materiais.</p>
        <hr class="pontos-index-divider">
        <p class="pontos-index-placeholder">(Estrutura inicial pronta para a listagem dos pontos via controller)</p>
    </div>
@endsection
