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

    public function sobre(): View
    {
        return view('publico.sobre');
    }

    public function contato(): View
    {
        return view('publico.contato');
    }

    public function enviarContato(Request $request)
    {
        $dados = $request->validate([
            'nome' => 'required|string|max:120',
            'email' => 'required|email|max:120',
            'assunto' => 'required|string|max:150',
            'mensagem' => 'required|string|max:2000',
        ]);

        return back()->with('sucesso', 'Mensagem enviada com sucesso! Em breve entraremos em contato.');
    }
}
