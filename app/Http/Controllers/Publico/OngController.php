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
    public function index(Ong $ong) : View {
         $ongs = Ong::where('ativo', true)
            ->orderBy('nome')
            ->get();


        return view('publico.ongs.index', compact('ongs'));
    }

    public function show($id)
    {
        $ong = Ong::with('pontosDeColeta')->findOrFail($id);

        return view('publico.ongs.show', compact('ong'));
    }
}

