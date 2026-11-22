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

            <a id="resumed-map" href="#as-ongs">
                <div id="map-simple"></div>
                <p>📍 -<?php /* Cidade */?> FATEC Itaquera · -Aberto/Fechado</p>
            </a>
            
            <a id="link" href="#" target="_blank">
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
                <?php //Colocar todas as ONGs cadastradas ?>
            </select>

            <button id="btn-centralizar">
                <p>Recentralizar</p>
            </button>
        </div>
        <div id="map-area">
            <div id="map-local"></div>
            <div id="simple-desc">
                <div id="foto">
                    <p id="estado"> ● Aberto / Fechado agora</p>
                    <img src="{{ asset('img/logo-ecopoints.webp') }}"id="foto-ong">
                </div>

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

                <div id="capacidade" class="detalhes">
                    <p id="emoji">📦</p>
                    <p id="capacidade-ponto" class="p-detalhes"><span class="principal">Capacidade: </span>XXXXXXXXXXXXXXXXXXXXXX XXXXXXXXXXXXXXXX</p>
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

    <section id="as-ongs">


        <div class="container-asOngs">
           
            <h1>As ONGs</h1>


            <p> </p>


            <div class="barraPesquisa-asOngs">


                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


                <button type="submit" class="pesquisar-ong" onclick="document.getElementById('search-ong').focus()">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>


                <input type="search" placeholder="Ex: Instituto Saber e Leitura" id="search-ong">


                <button type="submit" class="limpar-ong">
                    <i class="fa-solid fa-xmark"></i>
                </button>


                <button type="submit" class="microfone-ong">
                    <i class="fa-solid fa-microphone"></i>
                </button>
           
            </div>


           
            <div class="box-ongs">


                <div class="ong1">
                   
                    <h2>ONG</h2>
                    <p>txtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxt</p>
                    <a href="">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>


                </div>


                <div class="ong2">
                   
                    <h2>ONG</h2>
                    <p>txtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxt</p>
                    <a href="">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>


                </div>


                <div class="ong3">
                   
                    <h2>ONG</h2>
                    <p>txtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxttxtxtxtxt</p>
                    <a href="">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>


                </div>


            </div>


            <button>Ver mais</button>


        </div>    


    </section>

    <script src="https://unpkg.com/maplibre-gl@4.7.1/dist/maplibre-gl.js"></script>
    <script src="{{ asset('js/publico/home/home.js') }}"></script>

@endsection
