@extends('layouts.app')

@section('titulo', 'Sobre Nós')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/sobre-nos.css') }}?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
@endsection

@section('conteudo')
    <section id="master">
        <div id="content">
            <p id="p-back">EDUCAÇÃO E SUSTENTABILIDADE</p>

            <p id="title">Uma nova história começa quando um livro circula.</h1>
                
            <p class="paragrafo">
                O <span class="destaque">EcoPoints</span> é uma plataforma acadêmica desenvolvida para aproximar cidadãos que desejam 
                doar livros didáticos, acadêmicos e apostilas de instituições e ONGs comprometidas com a democratização do conhecimento.            
            </p>

            <p class="paragrafo">
                Alinhado aos princípios <span class="destaque">ESG</span> e aos <span class="destaque">Objetivos de Desenvolvimento Sustentável</span>
                (ODS 4 - Educação de Qualidade e ODS 12 - Consumo e Produção Responsáveis), nosso propósito é combater o descarte inadequado de papel e garantir
                que materiais de estudo continuem impulsionando sonhos.
            </p>

            <a href="{{ route('publico.home') }}" class="btn-ecopoint">
                Encontre um ponto próximo &rarr;
            </a>
        </div>

        <div id="img">
            <img src="{{ asset('img/bibliotecas.png') }}" alt="Biblioteca com estantes de livros">
        </div>
    </section>

@endsection