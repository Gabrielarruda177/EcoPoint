@extends('layouts.app')

@section('titulo', 'ONGs')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/publico/ongs-index.css') }}?v=1.0">
@endsection

@section('conteudo')
    <section id="as-ongs">
        <div class="container-asOngs">
            <h1>As ONGs</h1>

            <div class="barraPesquisa-asOngs">
                <button type="button" class="pesquisar-ong" onclick="document.getElementById('search-ong').focus()">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>

                <input type="search" placeholder="Ex: Instituto Saber e Leitura" id="search-ong">

                <button type="button" class="limpar-ong">
                    <i class="fa-solid fa-xmark"></i>
                </button>           
            </div>

            <div class="box-ongs">
                @forelse($ongs as $ong)
                    <a href="{{ route('publico.ongs.show', $ong) }}" class="card-ong" data-nome="{{ mb_strtolower($ong->nome, 'UTF-8') }}">
                        <div class="ong-logo">
                            @if(!empty($ong->logo))
                                <img src="{{ asset('storage/' . $ong->logo) }}" alt="Logo {{ $ong->nome }}">
                            @else
                                <span>ONG</span>
                            @endif
                        </div>

                        <div class="ong-info">
                            <h2>{{ $ong->nome }}</h2>
                            <p>{{ Str::limit($ong->descricao, 85) }}</p>
                        </div>

                        <div class="ong-seta">
                            <i class="fa-solid fa-chevron-right"></i>
                        </div>
                    </a>
                @empty
                    <p class="sem-ongs">Nenhuma ONG cadastrada no momento.</p>
                @endforelse

                <div id="nenhuma-ong">
                    <p>Nenhuma ONG encontrada com esse nome.</p>
                </div>
            </div>
        </div>    
    </section>

    <script src="{{ asset('js/publico/ongs/index.js') }}"></script>
@endsection