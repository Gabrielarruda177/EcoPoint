@extends('layouts.app')

@section('titulo', $ong->nome ?? 'Perfil da ONG')

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
            <a href="#">
                As ONGS
            </a>
            <a>
                <i class="fa-solid fa-chevron-right"></i>
                {{$ong->nome}}
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

                <h2>{{$ong->nome}}</h2>

            <!--============================================================
                2.1.1 SOBRE A ONG
                ============================================================-->
                <div class="sobre-container">

                    <h3>Sobre a ONG</h3>

                    <p>
                        {{$ong->descricao}}
                    </p>

                </div>       
                
            <!--============================================================
                2.1.2 ECOPONTOS DA ONG
                ============================================================-->
                <div class="ecopontos-container">

                    <h3>Ecopontos da ONG</h3>

                    <div class="ecopontos-cards">
                        @forelse($ong->pontosDeColeta as $ecoponto)
                        <a href="{{ url('/pontos/' . $ecoponto->id) }}" class="ecoponto-card">

                            <div class="card-infos-box">

                                <img src="{{ $ecoponto->imagem ? asset('storage/' . $ecoponto->imagem) : asset('img/bibliotecas.png') }}" alt="Foto {{ $ecoponto->nome }}">

                                <p> {{ $ecoponto->nome }} </p> <!--BACK END-->

                            </div>

                                <span href> Ver mais detalhes <i class="fa-solid fa-chevron-right"></i> </span>

                        </a>

                        @empty
                            <p>Esta ONG ainda não possui ecopontos cadastrados.</p>
                        @endforelse
                    </div>

                </div>

            </div>

        <!--============================================================
            2.2 RIGHT CONTENT
            ============================================================-->
            <div class="right-content-container">

                <div class="main-ong-box">

                    <img src="{{ $ong->logo ? asset('storage/' . $ong->logo) : asset('img/icon-ecopoints.webp') }}" alt="Logo {{ $ong->nome }}">

                    <h3>{{$ong->nome}}</h3>

                </div>

                <div class="itens-ong-box">

                    <p> <i class="fa-solid fa-phone"></i> {{$ong->telefone}} <p>

                    <p> <i class="fa-solid fa-envelope"></i> {{$ong->email_contato}}<p> <!--BACK END-->

                    <p>
                        <i class="fa-regular fa-clock" style="-webkit-text-stroke: 0.2px currentColor;"></i>
                        {{$ong->cep}} <!--BACK END-->
                    <p> 

                </div>

            </div>

        </section>

    </main>

    <script src="{{ asset('js/publico/ongs/show.js') }}"></script>

@endsection
