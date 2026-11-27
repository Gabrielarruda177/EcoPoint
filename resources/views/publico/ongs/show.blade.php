@extends('layouts.app')

@section('titulo', $ong->nome ?? 'Perfil da ONG')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/ongs-show.css') }}?v=2.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
@endsection

@section('conteudo')
<div class="ong-show-wrapper">

    {{-- BREADCRUMB --}}
    <nav class="ong-breadcrumb">
        <a href="{{ route('publico.ongs.index') }}">ONGs</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span>{{ $ong->nome }}</span>
    </nav>

    {{-- HERO --}}
    <div class="ong-hero">
        <div class="ong-hero-logo">
            <img 
                src="{{ ($ong->logo && file_exists(public_path('storage/' . $ong->logo))) ? asset('storage/' . $ong->logo) : asset('img/icon-ecopoints.webp') }}" 
                alt="Logo {{ $ong->nome }}"
                onerror="this.onerror=null; this.src='{{ asset('img/icon-ecopoints.webp') }}';"
            >
        </div>
        <div class="ong-hero-info">
            <span class="ong-hero-label">Instituição Parceira</span>
            <h1 class="ong-hero-name">{{ $ong->nome }}</h1>
            @if($ong->descricao)
                <p class="ong-hero-desc">{{ $ong->descricao }}</p>
            @endif
        </div>
    </div>

    {{-- GRID PRINCIPAL --}}
    <div class="ong-main-grid">

        {{-- COLUNA ESQUERDA --}}
        <div class="ong-col-left">
            <section class="ong-section">
                <div class="ong-section-header">
                    <div class="ong-section-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <div>
                        <h2 class="ong-section-title">Ecopontos de Coleta</h2>
                        <p class="ong-section-subtitle">Locais onde você pode entregar seus livros e apostilas</p>
                    </div>
                </div>

                <div class="ecopontos-grid">
                    @forelse($ong->pontosDeColeta as $ecoponto)
                        <a href="{{ url('/pontos/' . $ecoponto->id) }}" class="ecoponto-card">
                            <div class="ecoponto-thumb">
                                <img 
                                    src="{{ ($ecoponto->imagem && file_exists(public_path('storage/' . $ecoponto->imagem))) ? asset('storage/' . $ecoponto->imagem) : asset('img/bibliotecas.png') }}" 
                                    alt="Foto {{ $ecoponto->nome }}"
                                    onerror="this.onerror=null; this.src='{{ asset('img/bibliotecas.png') }}';"
                                >
                                @if($ecoponto->ativo)
                                    <span class="ecoponto-badge-ativo">Ativo</span>
                                @else
                                    <span class="ecoponto-badge-inativo">Inativo</span>
                                @endif
                            </div>
                            <div class="ecoponto-body">
                                <h3 class="ecoponto-name">{{ $ecoponto->nome }}</h3>
                                @if($ecoponto->endereco)
                                    <p class="ecoponto-addr">
                                        <i class="fa-solid fa-map-pin"></i>
                                        {{ $ecoponto->endereco }}{{ $ecoponto->cidade ? ', ' . $ecoponto->cidade : '' }}
                                    </p>
                                @endif
                                @if($ecoponto->horario_funcionamento)
                                    <p class="ecoponto-horario">
                                        <i class="fa-regular fa-clock"></i>
                                        {{ $ecoponto->horario_funcionamento }}
                                    </p>
                                @endif
                            </div>
                            <div class="ecoponto-footer">
                                <span class="ecoponto-link">Ver detalhes <i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </a>
                    @empty
                        <div class="ecopontos-empty">
                            <i class="fa-solid fa-box-open"></i>
                            <p>Esta ONG ainda não possui ecopontos cadastrados.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- COLUNA DIREITA --}}
        <aside class="ong-col-right">
            <div class="ong-contact-card">
                <div class="ong-contact-logo">
                    <img 
                        src="{{ ($ong->logo && file_exists(public_path('storage/' . $ong->logo))) ? asset('storage/' . $ong->logo) : asset('img/icon-ecopoints.webp') }}" 
                        alt="Logo {{ $ong->nome }}"
                        onerror="this.onerror=null; this.src='{{ asset('img/icon-ecopoints.webp') }}';"
                    >
                </div>
                <h3 class="ong-contact-name">{{ $ong->nome }}</h3>

                <div class="ong-contact-divider"></div>

                <ul class="ong-contact-list">
                    @if($ong->telefone)
                        <li>
                            <span class="ong-contact-icon"><i class="fa-solid fa-phone"></i></span>
                            <div>
                                <span class="ong-contact-label">Telefone</span>
                                <span class="ong-contact-val">{{ $ong->telefone }}</span>
                            </div>
                        </li>
                    @endif
                    @if($ong->email_contato)
                        <li>
                            <span class="ong-contact-icon"><i class="fa-solid fa-envelope"></i></span>
                            <div>
                                <span class="ong-contact-label">E-mail</span>
                                <a href="mailto:{{ $ong->email_contato }}" class="ong-contact-val ong-contact-link">{{ $ong->email_contato }}</a>
                            </div>
                        </li>
                    @endif
                    @if($ong->endereco)
                        <li>
                            <span class="ong-contact-icon"><i class="fa-solid fa-location-dot"></i></span>
                            <div>
                                <span class="ong-contact-label">Endereço</span>
                                <span class="ong-contact-val">{{ $ong->endereco }}</span>
                            </div>
                        </li>
                    @endif
                    @if($ong->cep)
                        <li>
                            <span class="ong-contact-icon"><i class="fa-solid fa-map"></i></span>
                            <div>
                                <span class="ong-contact-label">CEP</span>
                                <span class="ong-contact-val">{{ $ong->cep }}</span>
                            </div>
                        </li>
                    @endif
                </ul>

                <div class="ong-contact-stats">
                    <div class="ong-stat">
                        <span class="ong-stat-num">{{ $ong->pontosDeColeta->count() }}</span>
                        <span class="ong-stat-label">Ecopontos</span>
                    </div>
                    <div class="ong-stat">
                        <span class="ong-stat-num">{{ $ong->pontosDeColeta->where('ativo', true)->count() }}</span>
                        <span class="ong-stat-label">Ativos</span>
                    </div>
                </div>
            </div>
        </aside>

    </div>
</div>

<script src="{{ asset('js/publico/ongs/show.js') }}"></script>
@endsection
