@extends('layouts.app')

@section('titulo', 'Início')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/home.css') }}?v=1.0">
@endsection

@section('conteudo')
    <section id="inicio">
        <div id="resume">
            <p id="p-back">🌱 SEU LIVRO, NO PRÓXIMO PONTO</p>

            <p id="principal">
                Conecte seus livros ao 
                <span class="blue">próximo leitor</span>
                 com 
                <span class="green">EcoPoints.</span>
            </p>

            <p id="subtitle">
                Encontre pontos de coleta próximos, apoie projetos comunitários de incentivo à leitura e dê vida nova a livros escolares, acadêmicos e apostilas.
            </p>

            <div id="click">
                <a href="#as-ongs" id="a-back-blue">
                    <p>Localize um Ecoponto agora ↓</p>
                </a>

                <a href="#as-ongs" id="a-noback">
                    <p>Cadastrar minha ONG</p>
                </a>
            </div>

            <div id="add-info">
                <div class="block">
                    <p class="title">asdasd</p>
                    <p class="subtitle">Livros em circulação</p>
                </div>
                <div class="block">
                    <p class="title">asdasd</p>
                    <p class="subtitle">Papel reciclado / reutilizado</p>
                </div>
                <div class="block">
                    <p class="title">asdasd</p>
                    <p class="subtitle">Acesso comunitário livre</p>
                </div>
            </div>
        </div>

        <div id="simple-map">

        </div>
    </section>

    <script src="../../../public/js/publico/home.js"></script>

@endsection
