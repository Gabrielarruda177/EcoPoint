@extends('layouts.app')

@section('titulo', $ponto->nome ?? "Perfil do ponto")

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

            <a href="{{ route('publico.home') }}?v=1.0">Início</a>
            <a href="{{ route('publico.home') }}#local">
                <i class="fa-solid fa-chevron-right"></i>
                Localize Aqui
            </a>
            <a>
                <i class="fa-solid fa-chevron-right"></i>
                {{$ponto->nome}}
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
                <h2>{{$ponto->nome}}</h2>
                
                <div class="resumo-infos-box">

                    <p>{{$ponto->ativo ? 'Aberto' : 'Fechado'}}</p> <!--BACK END-->

                    <p>{{ $ponto->bairro }}{{ $ponto->estado ? ', ' . $ponto->estado : '' }}</p> <!--BACK END-->

                </div>

                <div class="itens-infos-box">   

                    <p>
                        <i class="fa-solid fa-location-dot" style="font-size: 0.9rem;"></i>
                        {{ $ponto->endereco }}{{ $ponto->numero ? ', ' . $ponto->numero : '' }}
                        {{ $ponto->complemento ? ' - ' . $ponto->complemento : '' }}
                        - {{ $ponto->bairro }}, {{ $ponto->cidade }} - {{ $ponto->estado }}
                    </p>

                    @if($ponto->complemento)
                        <p>
                            <i class="fa-regular fa-clock" style="visibility: hidden;"></i>
                            {{ $ponto->complemento }}
                        </p>
                    @endif

                    <p>
                        <i class="fa-regular fa-clock" style="-webkit-text-stroke: 0.2px currentColor;"></i>
                        {{ $ponto->horario_funcionamento ?? 'Consulte horários com a ONG' }}
                    </p>

                </div>

            <!--============================================================
                2.1.3 MATERIAIS ACEITOS
                ============================================================-->
                <div class="materiais-box">

                    <h3>Materiais aceitos</h3>

                    <div class="materiais-lista"> <!--BACK END-->
                        @php
                            $idsAceitos = $ponto->materiaisAceitos->pluck('id')->toArray();
                        @endphp

                        @forelse($todosMateriais as $material)
                            @php
                                $aceito = in_array($material->id, $idsAceitos);
                            @endphp
                            <p>
                                {{ $material->nome }} 
                                <i class="fa-solid {{ $aceito ? 'fa-check' : 'fa-xmark' }}"></i>
                            </p>
                        @empty
                            <p>Nenhum material cadastrado.</p>
                        @endforelse
                    </div>
        
                </div>
            
            <!--============================================================
                2.1.4 REQUISITOS
                ============================================================-->
                <div class="requisitos-box">
                    <h3>Requisitos</h3>
                    <p>{{ $ponto->requisitos ?? 'Livros e apostilas em bom estado de conservação.' }}</p>
                </div>

            <!--============================================================
                2.1.5 DESCRIÇÃO
                ============================================================-->
                <div class="descricao-box">
                    <h3>Descrição</h3>
                    <p>{{ $ponto->descricao ?? 'Nenhuma descrição informada para este ponto de coleta.' }}</p>
                </div>

            </div>


        <!--============================================================
            2.2 RIGHT CONTENT - ONG + IMG
            ============================================================-->
            <div class="right-content-container">

                <div class="ong-img-box">

                    <img src="{{ $ponto->imagem ? asset('storage/' . $ponto->imagem) : asset('img/bibliotecas.png') }}" alt="Img frontal do ecoponto {{ $ponto->nome }}">
                    
                    @if($ponto->ong)
                        <div class="ong-card">
                            <div class="ong-main-infos">
                                <img src="{{ $ponto->ong->logo ? asset('storage/' . $ponto->ong->logo) : asset('img/icon-ecopoints.webp') }}" alt="Logo {{ $ponto->ong->nome }}">
                                <p>{{ $ponto->ong->nome }}</p>
                            </div>

                            <a href="{{ route('publico.ongs.show', $ponto->ong) }}">
                                Ver perfil da ONG <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>
                    @endif

                </div>
            
            </div>

        </section>
    
    </main>

    <script src="{{ asset('js/publico/pontos/show.js') }}"></script>

@endsection
