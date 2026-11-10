<?php

namespace App\Http\Controllers\Ong;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PerfilController extends Controller
{
    /**
     * Exibe o formulário de edição do perfil institucional da ONG logada.
     */
    public function edit(): View
    {
        $ong = auth()->user()->ong;

        if (! $ong) {
            abort(404, 'Instituição/ONG não encontrada para este usuário.');
        }

        $ong->load('user');

        return view('ong.perfil.edit', compact('ong'));
    }

    /**
     * Atualiza as informações institucionais da ONG logada e senha de acesso opcional.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $usuario */
        $usuario = auth()->user();
        $ong = $usuario->ong;

        if (! $ong) {
            abort(404, 'Instituição/ONG não encontrada para este usuário.');
        }

        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'cnpj' => ['nullable', 'string', 'max:18'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'email_contato' => ['nullable', 'email', 'max:255'],
            'descricao' => ['nullable', 'string'],
            'senha_atual' => ['nullable', 'required_with:nova_senha', 'string'],
            'nova_senha' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'nome.required' => 'O nome da instituição é obrigatório.',
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
                'nome' => $dados['nome'],
                'cnpj' => $dados['cnpj'] ?? null,
                'telefone' => $dados['telefone'] ?? null,
                'email_contato' => $dados['email_contato'] ?? null,
                'descricao' => $dados['descricao'] ?? null,
            ]);

            // Atualiza também o nome no registro do User
            $usuario->update([
                'name' => $dados['nome'],
            ]);

            if (! empty($dados['nova_senha'])) {
                $usuario->update([
                    'password' => Hash::make($dados['nova_senha']),
                ]);
            }
        });

        return redirect()
            ->route('ong.perfil.edit')
            ->with('success', 'Perfil da instituição atualizado com sucesso!');
    }
}
