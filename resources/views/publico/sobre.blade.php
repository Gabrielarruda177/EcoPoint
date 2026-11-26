@extends('layouts.app')

@section('titulo', 'Sobre Nós')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/sobre-nos.css') }}?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
@endsection

@section('conteudo')
    <main>
        <section id="master">
            <div id="content">
                <p id="p-back">EDUCAÇÃO E SUSTENTABILIDADE</p>

                <p id="title">Uma nova história começa quando um livro circula</p>
                <p class="paragrafo">
                    <span class="destaque">EcoPoints</span> é uma plataforma acadêmica desenvolvida para aproximar cidadão que desejam 
                    doar livros didáticos, acadêmicos e apostilas para instituições e ONGs comprometidas com a democratização do conhecimento.            
                </p>

                <p class="paragrafo">
                    alinhado aos princípios <span class="destaque">ESG</span> e aos <span class="destaque">Objetivos de Desenvolvimento Sustentável</span>
                    (ODS 4 - Educação de Qualidade e ODS 12 - Consumo e Produção Responsáveis), nosso propósito é combater o descarte inadequado de papel e garantir
                    que materiais de estudo continuem impulsionando sonhos.
                </p>

                <a href="{{ route('publico.home') }}">
                    <p>Encontre um ponto próximo → </p>
                </a>
            </div>
            <div id="img">
                <img src="{{ asset('img/bibliotecas.png') }}" alt="foto-geral">
            </div>
        </section>
    </main>
@endsection