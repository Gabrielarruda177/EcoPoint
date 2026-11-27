<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\PontoDeColeta;
use App\Models\MaterialAceito;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PontoDeColetaController extends Controller
{
    /**
     * Exibe os detalhes e informações de um ponto de coleta específico.
     */
    public function show(PontoDeColeta $ponto): View
    {
        $ponto->load(['ong', 'materiaisAceitos']);

        $todosMateriais = MaterialAceito::all();

        return view('publico.pontos.show', compact('ponto', 'todosMateriais'));
    }
}

