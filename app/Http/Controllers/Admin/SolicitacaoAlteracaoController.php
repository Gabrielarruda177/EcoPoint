<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SolicitacaoAlteracaoOng;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class SolicitacaoAlteracaoController extends Controller
{
    public function index(Request $request): View
    {
        $statusFiltro = $request->query('status', 'todas');

        $query = SolicitacaoAlteracaoOng::with(['ong.user', 'analisadoPor'])
            ->latest();

        if (in_array($statusFiltro, ['pendente', 'aprovada', 'recusada'])) {
            $query->where('status', $statusFiltro);
        }

        $solicitacoes = $query->paginate(10)->withQueryString();

        $totalPendentes = SolicitacaoAlteracaoOng::where('status', 'pendente')->count();
        $totalAprovadas = SolicitacaoAlteracaoOng::where('status', 'aprovada')->count();
        $totalRecusadas = SolicitacaoAlteracaoOng::where('status', 'recusada')->count();

        return view('admin.solicitacoes.index', compact(
            'solicitacoes',
            'statusFiltro',
            'totalPendentes',
            'totalAprovadas',
            'totalRecusadas'
        ));
    }

    public function aprovar(SolicitacaoAlteracaoOng $solicitacao): RedirectResponse
    {
        if ($solicitacao->status !== 'pendente') {
            return redirect()
                ->back()
                ->with('error', 'Esta solicitação já foi analisada anteriormente.');
        }

        try {
            DB::transaction(function () use ($solicitacao) {
                $ong = $solicitacao->ong;
                $propostos = $solicitacao->dados_propostos;

                if ($solicitacao->tipo === 'nome') {
                    $novoNome = $propostos['nome'] ?? null;
                    if ($novoNome) {
                        $ong->update(['nome' => $novoNome]);
                        if ($ong->user) {
                            $ong->user->update(['name' => $novoNome]);
                        }
                    }
                } elseif ($solicitacao->tipo === 'endereco') {
                    $ong->update([
                        'cep' => $propostos['cep'] ?? null,
                        'endereco' => $propostos['endereco'] ?? null,
                        'numero' => $propostos['numero'] ?? null,
                        'complemento' => $propostos['complemento'] ?? null,
                        'bairro' => $propostos['bairro'] ?? null,
                        'cidade' => $propostos['cidade'] ?? null,
                        'estado' => $propostos['estado'] ?? null,
                    ]);
                }

                $solicitacao->update([
                    'status' => 'aprovada',
                    'user_id' => auth()->id(),
                    'analisado_em' => now(),
                    'motivo_recusa' => null,
                ]);
            });

            return redirect()
                ->back()
                ->with('sucesso', "Solicitação #{$solicitacao->id} aprovada! Os dados da instituição foram atualizados.");
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Ocorreu um erro ao aprovar a solicitação: ' . $e->getMessage());
        }
    }

    public function recusar(Request $request, SolicitacaoAlteracaoOng $solicitacao): RedirectResponse
    {
        if ($solicitacao->status !== 'pendente') {
            return redirect()
                ->back()
                ->with('error', 'Esta solicitação já foi analisada anteriormente.');
        }

        $request->validate([
            'motivo_recusa' => ['nullable', 'string', 'max:1000'],
        ]);

        $solicitacao->update([
            'status' => 'recusada',
            'motivo_recusa' => $request->input('motivo_recusa') ?: 'A alteração solicitada não pôde ser aprovada no momento.',
            'user_id' => auth()->id(),
            'analisado_em' => now(),
        ]);

        return redirect()
            ->back()
            ->with('sucesso', "Solicitação #{$solicitacao->id} recusada com sucesso. Os dados da ONG permaneceram inalterados.");
    }
}
