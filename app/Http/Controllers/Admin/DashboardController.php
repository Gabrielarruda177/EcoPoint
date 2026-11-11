<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use App\Models\PontoDeColeta;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    
    public function index(): View
    {
        $totalOngs = Ong::count();

        $ongAtivas = Ong::where('ativo', true)->count();

        $ongInativas = Ong::where('ativo', false)->count();

        $totalPontos = PontoDeColeta::count();

        /** Gráfico 2 */
        $pontosPorOng = Ong::withCount('pontosDeColeta')
            ->orderByDesc('pontos_de_coleta_count')
            ->get()
            ->map(fn (Ong $o) => [
                'nome' => $o->nome,
                'total' => $o->pontos_de_coleta_count,
            ]);

        /** Gráfico 3 */
        $ongsPorMes = Ong::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mes, COUNT(*) as total")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return view('admin.dashboard', compact(
            'totalOngs',
            'ongAtivas',
            'ongInativas',
            'totalPontos',
            'pontosPorOng',
            'ongsPorMes'
        ));
    }
}

