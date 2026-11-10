@extends('layouts.app')

@section('titulo', 'Meus Pontos de Coleta')

@section('conteudo')
    <div class="card">
        <span class="badge badge-ong">Perfil: ONG</span>
        <h2 style="margin-top: 0.5rem;">Meus Pontos de Coleta</h2>
        <p>Gerencie os locais cadastrados pela sua instituição para recebimento de livros e apostilas.</p>
        <p style="margin: 1rem 0;">
            <a href="{{ route('ong.pontos.create') }}" style="background: #2f855a; color: white; padding: 0.5rem 1rem; border-radius: 4px; text-decoration: none;">
                + Novo Ponto de Coleta
            </a>
        </p>
        <hr style="margin: 1rem 0; border: 0; border-top: 1px solid #e2e8f0;">
        <p style="color: #718096; font-style: italic;">(Estrutura inicial pronta para a tabela de pontos da ONG)</p>
    </div>
@endsection

