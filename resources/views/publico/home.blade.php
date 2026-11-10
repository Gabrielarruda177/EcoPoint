@extends('layouts.app')

@section('titulo', 'Início')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/home.css') }}?v=1.0">
@endsection

@section('conteudo')
    <div class="card">
        <h1>Bem-vindo ao EcoPoint</h1>
        <p>Sistema de Mapeamento de Pontos de Coleta de Livros e Apostilas Acadêmicas.</p>
        <hr class="home-divider">
        <p>Encontre instituições e pontos próximos para doar ou recolher materiais acadêmicos.</p>
        <p class="home-cta-row">
            <a href="{{ route('publico.pontos.index') }}" class="home-cta-link">
                &rarr; Ver pontos de coleta disponíveis
            </a>
        </p>
    </div>
@endsection
