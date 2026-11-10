<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OngController extends Controller
{
    /**
     * Lista todas as ONGs cadastradas no sistema.
     */
    public function index(): View
    {
        // Base para carregar as ONGs (ex: Ong::with('user')->get())
        return view('admin.ongs.index');
    }

    /**
     * Exibe o formulário de cadastro de nova ONG.
     */
    public function create(): View
    {
        return view('admin.ongs.create');
    }

    /**
     * Salva o cadastro da nova ONG e seu usuário de acesso.
     */
    public function store(Request $request): RedirectResponse
    {
        // Espaço para validação e criação dos registros no banco
        return redirect()->route('admin.ongs.index');
    }

    /**
     * Exibe o formulário de edição de uma ONG.
     */
    public function edit(Ong $ong): View
    {
        return view('admin.ongs.edit', compact('ong'));
    }

    /**
     * Atualiza os dados de uma ONG cadastrada.
     */
    public function update(Request $request, Ong $ong): RedirectResponse
    {
        // Espaço para validação e atualização dos dados
        return redirect()->route('admin.ongs.index');
    }

    /**
     * Ativa ou desativa uma ONG no sistema.
     */
    public function toggleStatus(Ong $ong): RedirectResponse
    {
        // Alterna o status ativo (true/false)
        $ong->update(['ativo' => !$ong->ativo]);

        return redirect()->route('admin.ongs.index');
    }
}

