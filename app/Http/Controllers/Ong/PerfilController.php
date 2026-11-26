<?php

namespace App\Http\Controllers\Ong;

use App\Http\Controllers\Controller;
use App\Models\SolicitacaoAlteracaoOng;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PerfilController extends Controller
{
    public function edit(): View
    {
        /** @var \App\Models\User $usuario */
        $usuario = auth()->user();
        $ong = $usuario->ong;

        if (! $ong) {
            abort(404, 'Instituição/ONG não encontrada para este usuário.');
        }

        $ong->load('user');

        $solicitacoes = $ong->solicitacoesAlteracao()
            ->latest()
            ->paginate(5);

        $solicitacaoNomePendente = $ong->solicitacoesAlteracao()
            ->where('tipo', 'nome')
            ->where('status', 'pendente')
            ->first();

        $solicitacaoEnderecoPendente = $ong->solicitacoesAlteracao()
            ->where('tipo', 'endereco')
            ->where('status', 'pendente')
            ->first();

        return view('ong.perfil.edit', compact(
            'ong',
            'solicitacoes',
            'solicitacaoNomePendente',
            'solicitacaoEnderecoPendente'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $usuario */
        $usuario = auth()->user();
        $ong = $usuario->ong;

        if (! $ong) {
            abort(404, 'Instituição/ONG não encontrada para este usuário.');
        }

        $dados = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($usuario->id)],
            'telefone' => ['nullable', 'string', 'max:20'],
            'email_contato' => ['nullable', 'email', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'senha_atual' => ['nullable', 'required_with:nova_senha', 'string'],
            'nova_senha' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'O e-mail de acesso é obrigatório.',
            'email.email' => 'Informe um e-mail de acesso válido.',
            'email.unique' => 'Este e-mail de acesso já está em uso por outra conta.',
            'email_contato.email' => 'Informe um e-mail de contato válido.',
            'senha_atual.required_with' => 'Informe sua senha atual para definir uma nova senha.',
            'nova_senha.min' => 'A nova senha deve ter no mínimo 8 caracteres.',
            'nova_senha.confirmed' => 'A confirmação da nova senha não confere.',
        ]);

        if (! empty($dados['nova_senha'])) {
            if (! Hash::check($dados['senha_atual'], $usuario->password)) {
                return back()
                    ->withErrors(['senha_atual' => 'A senha atual informada está incorreta.'])
                    ->withInput();
            }
        }

        DB::transaction(function () use ($dados, $ong, $usuario) {
            $ong->update([
                'telefone' => $dados['telefone'] ?? null,
                'email_contato' => $dados['email_contato'] ?? null,
                'descricao' => $dados['descricao'] ?? null,
            ]);

            $usuarioAtualizacao = [
                'email' => $dados['email'],
            ];

            if (! empty($dados['nova_senha'])) {
                $usuarioAtualizacao['password'] = Hash::make($dados['nova_senha']);
            }

            $usuario->update($usuarioAtualizacao);
        });

        return redirect()
            ->route('ong.perfil.edit')
            ->with('success', 'Perfil da instituição atualizado com sucesso!')
            ->with('sucesso', 'Perfil da instituição atualizado com sucesso!');
    }

    public function solicitarAlteracao(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $usuario */
        $usuario = auth()->user();
        $ong = $usuario->ong;

        if (! $ong) {
            abort(404, 'Instituição/ONG não encontrada para este usuário.');
        }

        $request->validate([
            'tipo' => ['required', 'in:nome,endereco'],
            'justificativa' => ['nullable', 'string', 'max:500'],
        ]);

        $tipo = $request->input('tipo');

        $jaPendente = $ong->solicitacoesAlteracao()
            ->where('tipo', $tipo)
            ->where('status', 'pendente')
            ->exists();

        if ($jaPendente) {
            $tipoTexto = $tipo === 'nome' ? 'nome da instituição' : 'endereço/localização';
            return redirect()
                ->route('ong.perfil.edit')
                ->with('error', "Já existe uma solicitação pendente de alteração para {$tipoTexto}. Aguarde a análise do administrador.");
        }

        if ($tipo === 'nome') {
            $request->validate([
                'novo_nome' => ['required', 'string', 'max:255'],
            ], [
                'novo_nome.required' => 'Informe o novo nome pretendido para a instituição.',
                'novo_nome.max' => 'O nome não pode ultrapassar 255 caracteres.',
            ]);

            SolicitacaoAlteracaoOng::create([
                'ong_id' => $ong->id,
                'tipo' => 'nome',
                'dados_atuais' => [
                    'nome' => $ong->nome,
                ],
                'dados_propostos' => [
                    'nome' => $request->input('novo_nome'),
                ],
                'justificativa' => $request->input('justificativa'),
                'status' => 'pendente',
            ]);

            return redirect()
                ->route('ong.perfil.edit')
                ->with('sucesso', 'Solicitação de alteração de nome enviada com sucesso! Aguarde a aprovação do administrador.');
        }

        if ($tipo === 'endereco') {
            $dadosEndereco = $request->validate([
                'cep' => ['required', 'string', 'max:9'],
                'endereco' => ['required', 'string', 'max:255'],
                'numero' => ['nullable', 'string', 'max:20'],
                'complemento' => ['nullable', 'string', 'max:100'],
                'bairro' => ['required', 'string', 'max:100'],
                'cidade' => ['required', 'string', 'max:100'],
                'estado' => ['required', 'string', 'size:2'],
            ], [
                'cep.required' => 'O CEP é obrigatório.',
                'endereco.required' => 'O logradouro/rua é obrigatório.',
                'bairro.required' => 'O bairro é obrigatório.',
                'cidade.required' => 'A cidade é obrigatória.',
                'estado.required' => 'O estado (UF) é obrigatório.',
                'estado.size' => 'O estado deve conter exatamente 2 letras (ex: SP).',
            ]);

            SolicitacaoAlteracaoOng::create([
                'ong_id' => $ong->id,
                'tipo' => 'endereco',
                'dados_atuais' => [
                    'cep' => $ong->cep,
                    'endereco' => $ong->endereco,
                    'numero' => $ong->numero,
                    'complemento' => $ong->complemento,
                    'bairro' => $ong->bairro,
                    'cidade' => $ong->cidade,
                    'estado' => $ong->estado,
                ],
                'dados_propostos' => [
                    'cep' => $dadosEndereco['cep'],
                    'endereco' => $dadosEndereco['endereco'],
                    'numero' => $dadosEndereco['numero'] ?? null,
                    'complemento' => $dadosEndereco['complemento'] ?? null,
                    'bairro' => $dadosEndereco['bairro'],
                    'cidade' => $dadosEndereco['cidade'],
                    'estado' => strtoupper($dadosEndereco['estado']),
                ],
                'justificativa' => $request->input('justificativa'),
                'status' => 'pendente',
            ]);

            return redirect()
                ->route('ong.perfil.edit')
                ->with('sucesso', 'Solicitação de alteração de endereço enviada com sucesso! Aguarde a aprovação do administrador.');
        }

        return redirect()->route('ong.perfil.edit');
    }
}
