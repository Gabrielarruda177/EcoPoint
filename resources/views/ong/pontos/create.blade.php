@extends('layouts.app')

@section('titulo', 'Cadastrar Ponto de Coleta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/pontos.css') }}?v=1.0">
@endsection

@section('conteudo')
    <div class="card">
        <span class="badge badge-ong">Perfil: ONG</span>
        <h2 class="pontos-title">Cadastrar Novo Ponto de Coleta</h2>
        <p>Informe o endereço, os horários e selecione os tipos de materiais acadêmicos aceitos no local.</p>
        <hr class="pontos-divider">
        <p class="pontos-placeholder">(Estrutura inicial pronta para o formulário de cadastro de pontos de coleta)</p>
    </div>
@endsection
