<?php

namespace App\Http\Controllers\Ong;

use App\Http\Controllers\Controller;
use App\Models\MaterialAceito;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Exibe o painel inicial da ONG autenticada com métricas completas e 5 gráficos interativos.
     */
    public function index(): View
    {
        /** @var \App\Models\User $usuario */
        $usuario = auth()->user();
        $ong = $usuario->ong;

        if (! $ong) {
            return view('ong.dashboard', [
                'ong' => null,
                'totalPontos' => 0,
                'pontosAtivos' => 0,
                'pontosInativos' => 0,
                'totalCidades' => 0,
                'totalMateriais' => 0,
                'totalSolicitacoes' => 0,
                'solicitacoesPendentes' => 0,
                'ultimosPontos' => collect(),
                'graficoStatus' => ['ativos' => 0, 'inativos' => 0],
                'graficoCidades' => [],
                'graficoMateriais' => [],
                'graficoSolicitacoes' => ['pendentes' => 0, 'aprovadas' => 0, 'recusadas' => 0],
                'graficoPontosMes' => [],
                'materiais' => MaterialAceito::orderBy('nome')->get(),
            ]);
        }

        // 1. Cards de Métricas Principais (estilo Admin)
        $totalPontos = $ong->pontosDeColeta()->count();
        $pontosAtivos = $ong->pontosDeColeta()->where('ativo', true)->count();
        $pontosInativos = $ong->pontosDeColeta()->where('ativo', false)->count();

        $totalCidades = $ong->pontosDeColeta()
            ->whereNotNull('cidade')
            ->where('cidade', '<>', '')
            ->distinct('cidade')
            ->count('cidade');

        $pontosIds = $ong->pontosDeColeta()->pluck('id');
        $totalMateriais = DB::table('material_ponto_coleta')
            ->whereIn('ponto_de_coleta_id', $pontosIds)
            ->distinct('material_aceito_id')
            ->count('material_aceito_id');

        $totalSolicitacoes = $ong->solicitacoesAlteracao()->count();
        $solicitacoesPendentes = $ong->solicitacoesAlteracao()->where('status', 'pendente')->count();
        $solicitacoesAprovadas = $ong->solicitacoesAlteracao()->where('status', 'aprovada')->count();
        $solicitacoesRecusadas = $ong->solicitacoesAlteracao()->where('status', 'recusada')->count();

        // 2. Gráfico 1: Status Operacional dos Pontos (Doughnut)
        $graficoStatus = [
            'ativos' => $pontosAtivos,
            'inativos' => $pontosInativos,
        ];

        // 3. Gráfico 2: Pontos de Coleta por Cidade (Bar)
        $graficoCidades = $ong->pontosDeColeta()
            ->selectRaw('cidade, COUNT(*) as total')
            ->whereNotNull('cidade')
            ->where('cidade', '<>', '')
            ->groupBy('cidade')
            ->orderByDesc('total')
            ->take(6)
            ->get()
            ->map(fn ($p) => [
                'cidade' => $p->cidade,
                'total' => (int) $p->total,
            ])
            ->toArray();

        // 4. Gráfico 3: Materiais Acadêmicos Aceitos nos Pontos da ONG (Horizontal Bar)
        $graficoMateriais = MaterialAceito::withCount(['pontosDeColeta' => function ($q) use ($ong) {
                $q->where('ong_id', $ong->id);
            }])
            ->get()
            ->map(fn ($m) => [
                'nome' => $m->nome,
                'total' => (int) $m->pontos_de_coleta_count,
            ])
            ->sortByDesc('total')
            ->values()
            ->toArray();

        // 5. Gráfico 4: Status das Solicitações Cadastrais da ONG (Doughnut)
        $graficoSolicitacoes = [
            'pendentes' => $solicitacoesPendentes,
            'aprovadas' => $solicitacoesAprovadas,
            'recusadas' => $solicitacoesRecusadas,
        ];

        // 6. Gráfico 5: Evolução Temporal de Cadastro de Pontos da ONG (Line / Area)
        $driver = DB::connection()->getDriverName();
        $dateFormat = match ($driver) {
            'pgsql'  => "TO_CHAR(created_at, 'YYYY-MM')",
            'sqlite' => "strftime('%Y-%m', created_at)",
            default  => "DATE_FORMAT(created_at, '%Y-%m')",
        };

        $graficoPontosMes = $ong->pontosDeColeta()
            ->selectRaw("{$dateFormat} as mes, COUNT(*) as total")
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->map(fn ($p) => [
                'mes' => $p->mes,
                'total' => (int) $p->total,
            ])
            ->toArray();

        // 7. Pontos recentes para listagem rápida
        $ultimosPontos = $ong->pontosDeColeta()
            ->with('materiaisAceitos')
            ->latest()
            ->take(5)
            ->get();

        $materiais = MaterialAceito::orderBy('nome')->get();

        return view('ong.dashboard', compact(
            'ong',
            'totalPontos',
            'pontosAtivos',
            'pontosInativos',
            'totalCidades',
            'totalMateriais',
            'totalSolicitacoes',
            'solicitacoesPendentes',
            'ultimosPontos',
            'graficoStatus',
            'graficoCidades',
            'graficoMateriais',
            'graficoSolicitacoes',
            'graficoPontosMes',
            'materiais'
        ));
    }
}
