<?php

namespace App\Http\Controllers\Ong;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PerfilController extends Controller
{
    /**
     * Exibe o formulário de edição do perfil da ONG logada.
     */
    public function edit(): View
    {
        // Recupera a ONG associada ao usuário autenticado: auth()->user()->ong
        return view('ong.perfil.edit');
    }

    /**
     * Atualiza as informações do perfil institucional da ONG.
     */
    public function update(Request $request): RedirectResponse
    {
        // Espaço para validação e atualização dos dados da ONG logada
        return redirect()->route('ong.perfil.edit');
    }
}

