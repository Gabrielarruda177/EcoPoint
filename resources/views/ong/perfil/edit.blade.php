@extends('layouts.app')

@section('titulo', 'Editar Perfil Institucional')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/ong/perfil-edit.css') }}?v=1.0">
@endsection

@section('conteudo')
    <div class="card">
        <span class="badge badge-ong">Perfil: ONG</span>
        <h2 class="perfil-edit-title">Editar Perfil Institucional</h2>
        <p>Atualize os dados institucionais da sua organização (nome, CNPJ, telefone, e-mail de contato e descrição).</p>
        <hr class="perfil-edit-divider">
        <p class="perfil-edit-placeholder">(Estrutura inicial pronta para receber o formulário de edição do perfil da ONG)</p>
    </div>
@endsection
