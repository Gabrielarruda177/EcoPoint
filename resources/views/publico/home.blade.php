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
                <a href="#local" id="a-back-blue">
                    <p>Localize um Ecoponto agora ↓</p>
                </a>

                <a href="#as-ongs" id="a-noback">
                    <p>Cadastrar minha ONG</p>
                </a>
            </div>

            <div id="add-info">
                <div class="block">
                    <p class="title">+14.800</p>
                    <p class="subtitle">Livros em circulação</p>
                </div>
                <div class="block">
                    <p class="title">+5.9 Ton.</p>
                    <p class="subtitle">Papel reciclado / reutilizado</p>
                </div>
                <div class="block">
                    <p class="title">100%</p>
                    <p class="subtitle">Acesso comunitário livre</p>
                </div>
            </div>
        </div>

        <div id="simple-map">
            <p id="pin">📍 Rede Ativa em -Local</p>

            <p id="destaque">Ponto em Destaque:</p>

            <p id="name-ecopoint">Ecoponto em - Arrecadação aberta para apostilas e manuais técnicos de tecnologia e gestão.<?php /*-Materiais-Aceitos*/ ?></p>

            <div id="resumed-map">
                <div id="map-simple"></div>
                <p>📍</p>
            </div>
            
            <a id="link" href="#">
                <p>Ver informações completas →</p>
            </a>
        </div>
    </section>

    <section id="local">
        <div id="title-group">
            <p id="min-title">MAPEAMENTO EM TEMPO REAL</p>
            <p id="title">Localize aqui o ponto mais perto de você</p>
            <p id="subtitle">Busque pelo nome da rua, bairro ou selecione a ONG de sua preferência</p>
        </div>
        <div id="inputs">
            <div id="pesquisa">
                <img src="{{ asset('img/lupa-icon.png') }}" alt="Lupa" onclick="document.getElementById('input-local').focus()">
                <input type="text" name="local" id="input-local" placeholder="Digite o seu endereço, bairro ou cidade">
                <button type="button" id="localizar">
                    <p>Localizar</p>
                </button>
            </div>

            <select id="filter-distance">
                <option value="all">Distância: Todos os Raios</option>
                <option value="2">Distância: Até 2km</option>
                <option value="5">Distância: Até 5km</option>
                <option value="10">Distância: Até 10km</option>
                <option value="25">Distância: Até 25km</option>
            </select>

            <select id="filter-ongs">
                <option value="all">Todas as ONGs</option>
                @foreach($ongs as $ong)
                    <option value="{{ $ong->id }}">{{ $ong->nome }}</option>
                @endforeach
            </select>



            <button id="btn-centralizar">
                <p>Recentralizar</p>
            </button>
        </div>
        <div id="map-area">
            <div id="map-local"></div>
            <div id="simple-desc">
                <p id="estado"> ● Aberto / Fechado agora</p>

                <p id="nome-ecoponto">Ecoponto XXXXXX</p>

                <div id="endereco" class="detalhes">
                    <p id="emoji">📍</p>
                    <p id="endereco-ponto" class="p-detalhes">XXXXXXXXXXXXXXXXXXXXXXXXXXXX XXXXXXXXXXXXXXXXXX</p>
                </div>
                
                <div id="referencia" class="detalhes">
                    <p id="emoji">🧭</p>
                    <p id="referencia-ponto" class="p-detalhes">XXXXXXXXXXXXXXXXXXXXXXXXXXXX XXXXXXXXXXXXXXXXXX</p>
                </div>

                <div id="hr-funcionamento" class="detalhes">
                    <p id="emoji">🕑</p>
                    <p id="hr-funcionamento-ponto" class="p-detalhes">XXXXXXXXXXXXXXXXXXXXXXXXX XXXXXXXXXXXXXXXXXXXXX</p>
                </div>

                <div id="telefone" class="detalhes">
                    <p id="emoji">📞</p>
                    <p id="telefone-ponto" class="p-detalhes"><span class="principal">Telefone: </span>XXXXXXXXXXXXXXXXXXXXXX XXXXXXXXXXXXXXXX</p>
                </div>

                <div id="ong-responsavel">
                    <p id="emoji">🏛️</p>
                    <p id="ong-ponto">ONG Responsável: XXXXXXXXXXXXXXX </p>
                </div>

                <button id="see-details">
                    <p>Ver Detalhes Completos ></p>
                </button>
            </div>
        </div>
    </section>

    <script>
        window.DADOS_BANCO = {
            pontos: @json($pontos),
            ongs: @json($ongs)
        };
    </script>
    <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>
    <script src="{{ asset('js/publico/home/home.js') }}"></script>


@endsection
