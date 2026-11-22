@extends('layouts.app')

@section('titulo', 'Perfil da ONG')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/ongs-show.css') }}?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"> <!--Font Awesome 6 free-->
@endsection

@section('conteudo')
    <!--<div class="card">
        <h2>Perfil Institucional da ONG</h2>
        <p>Histórico, informações de contato e relação dos pontos de coleta mantidos pela instituição.</p>
        <hr class="ong-show-divider">
        <p class="ong-show-placeholder">(Estrutura inicial pronta para exibição do perfil da ONG)</p>
    </div>-->

    <main>

    <!--============================================================
        1. DIRETÓRIO DAS PÁGINAS
        ============================================================-->
        <section class="diretorio-section">

            <a href="{{ asset('css/publico/home.css') }}?v=1.0">Início</a>
            <a href="#">
                <i class="fa-solid fa-chevron-right"></i>
                as ongs
            </a>
            <a>
                <i class="fa-solid fa-chevron-right"></i>
                nome ong  <!--BACK END-->
            </a>

        </section>

    <!--============================================================
        2. CONTEÚDO DA PÁGINA
        ============================================================-->
        <section id="content-section">

        <!--============================================================
            2.1 LEFT CONTENT
            ============================================================-->
            <div class="left-content-container">

                <h2>Nome ong</h2> <!--BACK END-->

            <!--============================================================
                2.1.1 SOBRE A ONG
                ============================================================-->
                <div class="sobre-container">

                    <h3>Sobre a ONG</h3>

                    <p>
                        grgrrrrrsgssfsdiiiiiiiiiiiiiiiiiiiiiiiiii
                        iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii
                    iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii
                    iiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii
                    </p> <!--BACK END-->

                </div>       
                
            <!--============================================================
                2.1.2 ECOPONTOS DA ONG
                ============================================================-->
                <div class="ecopontos-container">

                    <h3>Ecopontos da ONG</h3>

                    <div class="ecopontos-cards">

                        <a class="ecoponto-card">

                            <div class="card-infos-box">

                                <img src=""></img>

                                <p> ecoponto1 </p> <!--BACK END-->

                            </div>

                                <span> Ver mais detalhes <i class="fa-solid fa-chevron-right"></i> </span>

                        </a>

                        <a class="ecoponto-card">

                            <div class="card-infos-box">

                                <img src=""></img>

                                <p> ecoponto2 </p> <!--BACK END-->

                            </div>

                            <span> Ver mais detalhes <i class="fa-solid fa-chevron-right"></i> </span>
                        
                        </a>

                        <a class="ecoponto-card">

                            <div class="card-infos-box">

                                <img src=""></img>

                                <p> ecopont3 </p> <!--BACK END-->

                            </div>
                            
                            <span> Ver mais detalhes <i class="fa-solid fa-chevron-right"></i> </span>

                        </a>

                    </div>

                </div>

            </div>

        <!--============================================================
            2.2 RIGHT CONTENT
            ============================================================-->
            <div class="right-content-container">

                <div class="main-ong-box">

                    <img src="#"></img>

                    <h3>nome ong</h3> <!--BACK END-->

                </div>

                <div class="itens-ong-box">

                    <p> <i class="fa-solid fa-phone"></i> telefone <!--BACK END--> <p>

                    <p> <i class="fa-solid fa-envelope"></i> e-mail comercial<p> <!--BACK END-->

                    <p>
                        <i class="fa-regular fa-clock" style="-webkit-text-stroke: 0.2px currentColor;"></i>
                        horário de funcionamento <!--BACK END-->
                    <p> 

                </div>

            </div>

        </section>

    </main>

@endsection
