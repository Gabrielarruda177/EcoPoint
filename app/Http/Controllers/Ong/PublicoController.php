<?php

namespace App\Http\Controllers;

use App\Models\Ong;
use App\Models\PontoDeColeta;
use Illuminate\Http\Request;

class PublicoController extends Controller
{
    public function home()
    {
        $ongs = Ong::where('ativo', true)
            ->orderBy('nome')
            ->get();

        $pontos = PontoDeColeta::with('ong')
            ->whereHas('ong', function ($query) {
                $query->where('ativo', true);
            })
            ->get();

        return view('publico.home', compact('ongs', 'pontos'));
    }
}
