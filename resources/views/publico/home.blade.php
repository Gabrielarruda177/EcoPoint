@extends('layouts.app')

@section('titulo', 'Início')

@section('styles')
    <link href="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.css" rel="stylesheet" />
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
            <p id="pin">📍 Rede Ativa em -Local</p>

            <p id="destaque">Ponto em Destaque</p>

            <p id="name-ecopoint">Ecoponto FATEC Itaquera<?php /* -Local */ ?> - Arrecadação aberta para apostilas e manuais técnicos de tecnologia e gestão.<?php /*-Materiais-Aceitos*/ ?></p>

            <a id="resumed-map" href="#" target="_blank">
                <div id="map-simple"></div>
                <p>📍 -<?php /*Cidade */?> FATEC Itaquera · -Aberto/Fechado</p>
            </a>
            
            <a id="link" href="#" target="_blank">
                <p>Ver informações completas →</p>
            </a>
        </div>
    </section>

    <section id="local">
        <div id="title"></div>
        <div id="inputs">
            <div id="pesquisa">
                <input type="text" name="local" id="input-local">
                <button type="button" id="btn">Localizar</button>
                
            </div>
        </div>
        <div id="map-area">
            <div id="map-local"></div>
            <div id="simple-desc"></div>
        </div>
    </section>

    <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>
    <script src="{{ asset('js/publico/home/home.js') }}"></script>

@endsection
