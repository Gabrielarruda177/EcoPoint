<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\PontoDeColeta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PontoDeColetaController extends Controller
{
    /**
     * Lista todos os pontos de coleta ativos para consulta pública.
     */
    public function index(): View
    {
        return view('publico.pontos.index');
    }

    /**
     * Exibe os detalhes e informações de um ponto de coleta específico.
     */
    public function show(PontoDeColeta $ponto): View
    {
        return view('publico.pontos.show', compact('ponto'));
    }
}

