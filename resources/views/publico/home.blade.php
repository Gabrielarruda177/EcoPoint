@extends('layouts.app')

@section('titulo', 'Início')

@section('conteudo')
    <div class="card">
        <h1>Bem-vindo ao EcoPoint</h1>
        <p>Sistema de Mapeamento de Pontos de Coleta de Livros e Apostilas Acadêmicas.</p>
        <hr style="margin: 1rem 0; border: 0; border-top: 1px solid #e2e8f0;">
        <p>Encontre instituições e pontos próximos para doar ou recolher materiais acadêmicos.</p>
        <p style="margin-top: 1rem;">
            <a href="{{ route('publico.pontos.index') }}" style="color: #2f855a; font-weight: bold;">
                &rarr; Ver pontos de coleta disponíveis
            </a>
        </p>
    </div>
@endsection

