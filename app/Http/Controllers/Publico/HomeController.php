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
    public function index(){
        $pontos = PontoDeColeta::with(['ong', 'materiaisAceitos'])
            ->where('ativo', true);

        $pontos = PontoDeColeta::with(['ong', 'materiaisAceitos'])->get();
        $ongs = Ong::all();

        return view('publico.home', compact('pontos', 'ongs'));
    }
}
