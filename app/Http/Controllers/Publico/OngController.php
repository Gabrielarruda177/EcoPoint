<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OngController extends Controller
{
    /**
     * Exibe o perfil institucional público de uma ONG e seus pontos ativos.
     */
    public function show(Ong $ong): View
    {
        return view('publico.ongs.show', compact('ong'));
    }
}

