<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialAceito;
use App\Models\Ong;
use App\Models\PontoDeColeta;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o painel inicial do administrador.
     */
    public function index(): View
    {
        /* Metricas */
        $totalOngs = Ong::count();
        $ongAtivas = Ong::where('ativo', true)->count();
        $ongInativas = Ong::where('ativo', false)->count();
        $totalPontos = PontoDeColeta::count();

        $mediaPontosPorOng = $totalOngs > 0 ? round($totalPontos / $totalOngs, 1) : 0;

        /* Grafico 1 */
        // Reutiliza $ongAtivas e $ongInativas

        /* Grafico 2 */
        $pontosPorOng = Ong::withCount('pontosDeColeta')
            ->orderByDesc('pontos_de_coleta_count')
            ->get()
            ->map(fn (Ong $o) => [
                'nome'  => $o->nome,
                'total' => $o->pontos_de_coleta_count,
            ]);

        /* Grafico 3 */
        $driver = DB::connection()->getDriverName();

        $dateFormat = match ($driver) {
            'pgsql'  => "TO_CHAR(created_at, 'YYYY-MM')",
            'sqlite' => "strftime('%Y-%m', created_at)",
            default  => "DATE_FORMAT(created_at, '%Y-%m')",
        };

        $ongsPorMes = Ong::selectRaw("{$dateFormat} as mes, COUNT(*) as total")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        /* Grafico 4 */
        /*
        $materiaisMaisAceitos = MaterialAceito::withCount('pontosDeColeta')
            ->orderByDesc('pontos_de_coleta_count')
            ->get()
            ->map(fn (MaterialAceito $m) => [
                'nome'  => $m->nome,
                'total' => $m->pontos_de_coleta_count,
            ]);
        */

        /* Grafico 5 */
        /*
        $pontosPorCidade = PontoDeColeta::selectRaw('cidade, COUNT(*) as total')
            ->whereNotNull('cidade')
            ->where('cidade', '<>', '')
            ->groupBy('cidade')
            ->orderByDesc('total')
            ->get()
            ->map(fn ($p) => [
                'cidade' => $p->cidade,
                'total'  => (int) $p->total,
            ]);
        */

        /* Grafico 6 - Mapa */
        $regioesBrasil = [
            'Norte'        => ['AC', 'AP', 'AM', 'PA', 'RO', 'RR', 'TO'],
            'Nordeste'     => ['AL', 'BA', 'CE', 'MA', 'PB', 'PE', 'PI', 'RN', 'SE'],
            'Centro-Oeste' => ['DF', 'GO', 'MT', 'MS'],
            'Sudeste'      => ['ES', 'MG', 'RJ', 'SP'],
            'Sul'          => ['PR', 'RS', 'SC'],
        ];

        $pontosPorRegiao = [];
        $ongsPorRegiao   = [];

        foreach ($regioesBrasil as $regiao => $ufs) {
            $pontosPorRegiao[$regiao] = PontoDeColeta::whereIn('estado', $ufs)->count();
            $ongsPorRegiao[$regiao]   = Ong::whereIn('estado', $ufs)->count();
        }

        $regioesAtendidasCount = collect($pontosPorRegiao)->filter(fn ($qtd) => $qtd > 0)->count();

        $estadosAtendidosCount = PontoDeColeta::whereNotNull('estado')
            ->where('estado', '<>', '')
            ->distinct('estado')
            ->count('estado');

        $cidadesAtendidasCount = PontoDeColeta::whereNotNull('cidade')
            ->where('cidade', '<>', '')
            ->distinct('cidade')
            ->count('cidade');

        return view('admin.dashboard', compact(
            'totalOngs',
            'ongAtivas',
            'ongInativas',
            'totalPontos',
            'mediaPontosPorOng',
            'pontosPorOng',
            'ongsPorMes',
            // 'materiaisMaisAceitos',
            // 'pontosPorCidade',
            'pontosPorRegiao',
            'ongsPorRegiao',
            'regioesAtendidasCount',
            'estadosAtendidosCount',
            'cidadesAtendidasCount'
        ));
    }
}
