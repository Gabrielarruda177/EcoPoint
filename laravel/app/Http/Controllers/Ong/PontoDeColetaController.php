<?php

namespace App\Http\Controllers\Ong;

use App\Http\Controllers\Controller;
use App\Models\PontoDeColeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PontoDeColetaController extends Controller
{
    /**
     * Lista apenas os pontos de coleta pertencentes à ONG logada.
     */
    public function index(): View
    {
        return view('ong.pontos.index');
    }

    /**
     * Exibe o formulário de cadastro de um novo ponto de coleta.
     */
    public function create(): View
    {
        return view('ong.pontos.create');
    }

    /**
     * Salva o novo ponto de coleta e vincula os materiais aceitos.
     */
    public function store(Request $request): RedirectResponse
    {
        // Espaço para validação e gravação do ponto e sincronização dos materiais
        return redirect()->route('ong.pontos.index');
    }

    /**
     * Exibe o formulário de edição de um ponto de coleta da ONG.
     */
    public function edit(PontoDeColeta $ponto): View
    {
        return view('ong.pontos.edit', compact('ponto'));
    }

    /**
     * Atualiza os dados do ponto de coleta e seus materiais aceitos.
     */
    public function update(Request $request, PontoDeColeta $ponto): RedirectResponse
    {
        // Espaço para validação, atualização e sincronização dos materiais
        return redirect()->route('ong.pontos.index');
    }

    /**
     * Remove um ponto de coleta da ONG.
     */
    public function destroy(PontoDeColeta $ponto): RedirectResponse
    {
        // Espaço para exclusão do ponto de coleta
        return redirect()->route('ong.pontos.index');
    }
}

