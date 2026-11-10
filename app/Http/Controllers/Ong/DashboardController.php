<?php

namespace App\Http\Controllers\Ong;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o painel inicial da ONG autenticada com métricas e atalhos rápidos.
     */
    public function index(): View
    {
        /** @var \App\Models\User $usuario */
        $usuario = auth()->user();
        $ong = $usuario->ong;

        // Se o usuário ainda não tiver ONG associada, inicializa coleções vazias
        $totalPontos = $ong ? $ong->pontosDeColeta()->count() : 0;
        $pontosAtivos = $ong ? $ong->pontosDeColeta()->where('ativo', true)->count() : 0;
        $ultimosPontos = $ong
            ? $ong->pontosDeColeta()->with('materiaisAceitos')->latest()->take(5)->get()
            : collect();

        return view('ong.dashboard', compact('ong', 'totalPontos', 'pontosAtivos', 'ultimosPontos'));
    }
}
