@extends('layouts.app')

@section('titulo', 'ONGs')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/ongs-index.css') }}?v=1.0">
@endsection

@section('conteudo')
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
            </div>


           
            <div class="box-ongs">
                @forelse($ongs as $ong)
                    <div class="ong1 card-ong" data-nome="{{ mb_strtolower($ong->nome, 'UTF-8') }}">
                        <h2>{{ $ong->nome }}</h2>
                        <p>{{ Str::limit($ong->descricao, 110) }}</p>
                        <a href="{{ route('publico.ongs.show', $ong) }}">
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>
                @empty
                    <p class="sem-ongs">Nenhuma ONG cadastrada no momento.</p>
                @endforelse

                <div id="nenhuma-ong">
                    <p>Nenhuma ONG encontrada com esse nome.</p>
                </div>
        </div>

        </div>    


    </section>

    <script>
        window.DADOS_BANCO = {
            ongs: @json($ongs)
        }
    </script>
    <script src="{{ asset('js/publico/ongs/index.js') }}"></script>

@endsection
