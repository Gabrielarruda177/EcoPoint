@extends('layouts.app')

@section('titulo', 'Detalhes do Ponto de Coleta')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/pontos-show.css') }}?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"> <!--Font Awesome 6 free-->
@endsection

@section('conteudo')
    <!--<div class="card">
        <h2>Detalhes do Ponto de Coleta</h2>
        <p>Informações de endereço, horários de funcionamento e materiais aceitos.</p>
        <hr class="ponto-show-divider">
        <p class="ponto-show-placeholder">(Estrutura inicial pronta para exibição detalhada do ponto)</p>
    </div>-->
    <main>

    <!--============================================================
        1. DIRETÓRIO DAS PÁGINAS
        ============================================================-->
        <div class="diretorio-section">

            <a href="{{ asset('css/publico/home.css') }}?v=1.0">Início</a>
            <a href="#">
                <i class="fa-solid fa-chevron-right"></i>
                Localize Aqui
            </a>
            <a>
                <i class="fa-solid fa-chevron-right"></i>
                Ponto Central - Biblioteca Comunitária  <!--BACK END-->
            </a>

        </div>

        
    <!--============================================================
        2. CONTEÚDO DA PÁGINA
        ============================================================-->
        <section id="content-section">

        <!--============================================================
            2.1 LEFT CONTENT
            ============================================================-->
            <div class="left-content-container">

            <!--============================================================
                2.1.2 INFOS PRINCIPAIS
                ============================================================-->
                <h2>Ponto Central - Biblioteca Comunitária</h2>
                
                <div class="resumo-infos-box">

                    <p>Aberto</p> <!--BACK END-->

                    <p>Bela Vista, SP</p> <!--BACK END-->

                </div>

                <div class="itens-infos-box">   

                    <p>
                        <i class="fa-solid fa-location-dot" style="font-size: 0.9rem;"></i>
                        Avenida Paulista, 1000 - sala 102 - Bela Vista, São Paulo - SP <!--BACK END-->
                    </p>

                    <p> <i class="fa-regular fa-clock" style="visibility: hidden;"></i>
                        Próximo a... </p> <!--BACK END-->

                    <p> <i class="fa-regular fa-clock" style="-webkit-text-stroke: 0.2px currentColor;"></i>
                        Segunda a Sexta, das 09h às 17h</p> <!--BACK END-->

                </div>

            <!--============================================================
                2.1.3 MATERIAIS ACEITOS
                ============================================================-->
                <div class="materiais-box">

                    <h3>Materiais aceitos</h3>

                    <div class="materiais-lista"> <!--BACK END-->
                        <p> Apostilas Pré-Vestibular / ENEM <i class="fa-solid fa-check"></i> </p>
                        <p> Livros Didáticos (Ensino Fundamental / Médio) <i class="fa-solid fa-check"></i> </p>
                        <p> Livros Literários / Paradidáticos <i class="fa-solid fa-check"></i> </p>
                        <p> Livros Universitários / Acadêmicos <i class="fa-solid fa-check"></i> </p>
                        <p> Dicionários e Enciclopédias <i class="fa-solid fa-xmark"></i> </p>
                    </div>
        
                </div>
            
            <!--============================================================
                2.1.4 REQUISITOS
                ============================================================-->
                <div class="requisitos-box">

                    <h3>Requisitos</h3>

<!--BACK END--> <p>tteeeeeeeeeeeextotteeeeeeeeeeeeextotteeeeeeeeeeeeextotteeeeeeeeeeeeextotteeeeeeeeeeeeextotteeeeeeeeeeeeextotteeeeeeeeeeeeextotteeeeeeeeeeeeextotteeeeeeeeeeeeexto</p>

                </div>

            <!--============================================================
                2.1.5 DESCRIÇÃO
                ============================================================-->
                <div class="descricao-box">

                    <h3>Descrição</h3>

                    <p>teeeeeeeeexto</p> <!--BACK END-->

                </div>

            </div>


        <!--============================================================
            2.2 RIGHT CONTENT - ONG + IMG
            ============================================================-->
            <div class="right-content-container">

                <div class="ong-img-box">

                    <img src="{{ asset('img/imgBiblioteca.jpeg') }}" alt="Img frontal do ecoponto"></img>
                    
                    <div class="ong-card"> <!--link visualizar perfil ong-->

                        <div class="ong-main-infos">

                            <img src="#"></img> <!--<!--BACK END inserir logo ong-->
                            
                            <p>ONG Viva Esperança</p> <!--BACK END-->

                        </div>

                        <a href="#"> Ver perfil da ONG <i class="fa-solid fa-chevron-right"></i> </a>
                    
                    </div>

                </div>
            
            </div>

        </section>
    
    </main>

@endsection
