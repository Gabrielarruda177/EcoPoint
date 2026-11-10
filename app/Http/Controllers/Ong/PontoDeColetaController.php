<?php

namespace App\Http\Controllers\Ong;

use App\Http\Controllers\Controller;
use App\Models\MaterialAceito;
use App\Models\PontoDeColeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PontoDeColetaController extends Controller
{
    /**
     * Lista apenas os pontos de coleta pertencentes à ONG autenticada.
     */
    public function index(): View
    {
        $ong = auth()->user()->ong;

        $pontos = $ong
            ? $ong->pontosDeColeta()->with('materiaisAceitos')->latest()->paginate(10)
            : PontoDeColeta::whereRaw('1 = 0')->paginate(10);

        return view('ong.pontos.index', compact('ong', 'pontos'));
    }

    /**
     * Exibe o formulário de cadastro de um novo ponto de coleta.
     */
    public function create(): View
    {
        $materiais = MaterialAceito::orderBy('nome')->get();

        return view('ong.pontos.create', compact('materiais'));
    }

    /**
     * Salva o novo ponto de coleta vinculado à ONG autenticada e sincroniza os materiais aceitos.
     */
    public function store(Request $request): RedirectResponse
    {
        $ong = auth()->user()->ong;

        if (! $ong) {
            abort(403, 'Você não possui uma instituição/ONG cadastrada para criar pontos de coleta.');
        }

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'cep' => ['nullable', 'string', 'max:9'],
            'endereco' => ['required', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'size:2'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'horario_funcionamento' => ['nullable', 'string', 'max:255'],
            'telefone_contato' => ['nullable', 'string', 'max:20'],
            'ativo' => ['nullable', 'boolean'],
            'materiais' => ['nullable', 'array'],
            'materiais.*' => ['integer', 'exists:materiais_aceitos,id'],
        ], [
            'nome.required' => 'O nome do ponto de coleta é obrigatório.',
            'endereco.required' => 'O endereço / logradouro é obrigatório.',
            'cidade.required' => 'A cidade é obrigatória.',
            'estado.required' => 'O estado (UF) é obrigatório.',
            'estado.size' => 'O estado deve conter exatamente 2 letras (ex.: SP, RJ).',
            'materiais.*.exists' => 'O material acadêmico selecionado é inválido.',
        ]);

        DB::transaction(function () use ($dados, $ong) {
            $ponto = $ong->pontosDeColeta()->create([
                'nome' => $dados['nome'],
                'descricao' => $dados['descricao'] ?? null,
                'cep' => $dados['cep'] ?? null,
                'endereco' => $dados['endereco'],
                'numero' => $dados['numero'] ?? null,
                'complemento' => $dados['complemento'] ?? null,
                'bairro' => $dados['bairro'] ?? null,
                'cidade' => $dados['cidade'],
                'estado' => strtoupper($dados['estado']),
                'latitude' => $dados['latitude'] ?? null,
                'longitude' => $dados['longitude'] ?? null,
                'horario_funcionamento' => $dados['horario_funcionamento'] ?? null,
                'telefone_contato' => $dados['telefone_contato'] ?? null,
                'ativo' => isset($dados['ativo']) ? (bool) $dados['ativo'] : true,
            ]);

            if (! empty($dados['materiais'])) {
                $ponto->materiaisAceitos()->sync($dados['materiais']);
            }
        });

        return redirect()
            ->route('ong.pontos.index')
            ->with('success', 'Ponto de coleta cadastrado com sucesso!');
    }

    /**
     * Exibe o formulário de edição de um ponto de coleta da ONG.
     */
    public function edit(PontoDeColeta $ponto): View
    {
        $this->autorizarAcessoAoPonto($ponto);

        $ponto->load('materiaisAceitos');
        $materiais = MaterialAceito::orderBy('nome')->get();

        return view('ong.pontos.edit', compact('ponto', 'materiais'));
    }

    /**
     * Atualiza os dados do ponto de coleta e seus materiais aceitos.
     */
    public function update(Request $request, PontoDeColeta $ponto): RedirectResponse
    {
        $this->autorizarAcessoAoPonto($ponto);

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'cep' => ['nullable', 'string', 'max:9'],
            'endereco' => ['required', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => ['required', 'string', 'max:255'],
            'estado' => ['required', 'string', 'size:2'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'horario_funcionamento' => ['nullable', 'string', 'max:255'],
            'telefone_contato' => ['nullable', 'string', 'max:20'],
            'ativo' => ['nullable', 'boolean'],
            'materiais' => ['nullable', 'array'],
            'materiais.*' => ['integer', 'exists:materiais_aceitos,id'],
        ], [
            'nome.required' => 'O nome do ponto de coleta é obrigatório.',
            'endereco.required' => 'O endereço / logradouro é obrigatório.',
            'cidade.required' => 'A cidade é obrigatória.',
            'estado.required' => 'O estado (UF) é obrigatório.',
            'estado.size' => 'O estado deve conter exatamente 2 letras (ex.: SP, RJ).',
            'materiais.*.exists' => 'O material acadêmico selecionado é inválido.',
        ]);

        DB::transaction(function () use ($dados, $ponto) {
            $ponto->update([
                'nome' => $dados['nome'],
                'descricao' => $dados['descricao'] ?? null,
                'cep' => $dados['cep'] ?? null,
                'endereco' => $dados['endereco'],
                'numero' => $dados['numero'] ?? null,
                'complemento' => $dados['complemento'] ?? null,
                'bairro' => $dados['bairro'] ?? null,
                'cidade' => $dados['cidade'],
                'estado' => strtoupper($dados['estado']),
                'latitude' => $dados['latitude'] ?? null,
                'longitude' => $dados['longitude'] ?? null,
                'horario_funcionamento' => $dados['horario_funcionamento'] ?? null,
                'telefone_contato' => $dados['telefone_contato'] ?? null,
                'ativo' => isset($dados['ativo']) ? (bool) $dados['ativo'] : false,
            ]);

            $ponto->materiaisAceitos()->sync($dados['materiais'] ?? []);
        });

        return redirect()
            ->route('ong.pontos.index')
            ->with('success', 'Ponto de coleta atualizado com sucesso!');
    }

    /**
     * Remove um ponto de coleta pertencente à ONG.
     */
    public function destroy(PontoDeColeta $ponto): RedirectResponse
    {
        $this->autorizarAcessoAoPonto($ponto);

        $ponto->delete();

        return redirect()
            ->route('ong.pontos.index')
            ->with('success', 'Ponto de coleta excluído com sucesso!');
    }

    /**
     * Garante que a ONG autenticada só gerencia pontos que pertençam a ela mesma.
     */
    protected function autorizarAcessoAoPonto(PontoDeColeta $ponto): void
    {
        $ong = auth()->user()->ong;

        if (! $ong || $ponto->ong_id !== $ong->id) {
            abort(403, 'Você não tem permissão para gerenciar este ponto de coleta.');
        }
    }
}
