<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use App\Models\PontoDeColeta;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Exibe a página inicial pública do sistema.
     */
    public function index(): View
    {
        $ongs = Ong::where('ativo', true)
            ->orderBy('nome')
            ->get();

        $pontos = PontoDeColeta::with('ong')
            ->where('ativo', true)
            ->whereHas('ong', function ($query) {
                $query->where('ativo', true);
            })
            ->get();

        return view('publico.home', compact('ongs', 'pontos'));
    }
}
