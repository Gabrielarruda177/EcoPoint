@extends('layouts.app')

@section('titulo', 'Editar Ponto de Coleta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/pontos.css') }}?v=1.0">
@endsection

@section('conteudo')
    <div class="card">
        <span class="badge badge-ong">Perfil: ONG</span>
        <h2 class="pontos-title">Editar Ponto de Coleta</h2>
        <p>Atualize as informações de endereço, funcionamento ou materiais aceitos deste ponto.</p>
        <hr class="pontos-divider">
        <p class="pontos-placeholder">(Estrutura inicial pronta para o formulário de edição do ponto de coleta)</p>
    </div>
@endsection
