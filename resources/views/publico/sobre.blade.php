@extends('layouts.app')

@section('titulo', 'Sobre Nós')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/publico/sobre.css') }}?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
@endsection

@section('conteudo')
    <main>
        <section class="diretorio-section">
            <a href="{{ route('publico.home') }}">Início</a>
            <a>
                <i class="fa-solid fa-chevron-right"></i>
                Sobre Nós
            </a>
        </section>

        
    </main>
@endsection