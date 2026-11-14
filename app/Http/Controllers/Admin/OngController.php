<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ong;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class OngController extends Controller
{
    /**
     * Lista todas as ONGs com paginação e status.
     */
    public function index(): View
    {
        $ongs = Ong::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.ongs.index', compact('ongs'));
    }

    /**
     * Exibe o formulário de cadastro de uma nova ONG.
     */
    public function create(): View
    {
        return view('admin.ongs.create');
    }

    /**
     * Armazena uma nova ONG no banco de dados e cria seu usuário de acesso.
     */
    public function store(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'cnpj' => ['nullable', 'string', 'max:18'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'email_contato' => ['nullable', 'email', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'senha' => ['required', 'string', 'min:8', 'confirmed'],
            'descricao' => ['nullable', 'string'],
            'cep' => ['nullable', 'string', 'max:9'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:100'],
            'bairro' => ['nullable', 'string', 'max:100'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:2'],
        ]);

        DB::transaction(function () use ($dados) {
            $usuario = User::create([
                'name' => $dados['nome'],
                'email' => $dados['email'],
                'password' => Hash::make($dados['senha']),
                'role' => 'ong',
            ]);

            Ong::create([
                'user_id' => $usuario->id,
                'nome' => $dados['nome'],
                'cnpj' => $dados['cnpj'] ?? null,
                'telefone' => $dados['telefone'] ?? null,
                'email_contato' => $dados['email_contato'] ?? null,
                'descricao' => $dados['descricao'] ?? null,
                'cep' => $dados['cep'] ?? null,
                'endereco' => $dados['endereco'] ?? null,
                'numero' => $dados['numero'] ?? null,
                'complemento' => $dados['complemento'] ?? null,
                'bairro' => $dados['bairro'] ?? null,
                'cidade' => $dados['cidade'] ?? null,
                'estado' => $dados['estado'] ?? null,
                'ativo' => true,
            ]);
        });

        return redirect()
            ->route('admin.ongs.index')
            ->with('success', 'ONG cadastrada com sucesso!');
    }

    /**
     * Exibe o formulário de edição de uma ONG.
     */
    public function edit(Ong $ong): View
    {
        $ong->load('user');

        return view('admin.ongs.edit', compact('ong'));
    }

    /**
     * Atualiza os dados de uma ONG e suas credenciais.
     */
    public function update(Request $request, Ong $ong): RedirectResponse
    {
        $dados = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'cnpj' => ['nullable', 'string', 'max:18'],
            'telefone' => ['nullable', 'string', 'max:20'],
            'email_contato' => ['nullable', 'email', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($ong->user_id),
            ],
            'senha' => ['nullable', 'string', 'min:8', 'confirmed'],
            'descricao' => ['nullable', 'string'],
            'cep' => ['nullable', 'string', 'max:9'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:100'],
            'bairro' => ['nullable', 'string', 'max:100'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:2'],
        ]);

        DB::transaction(function () use ($dados, $ong) {
            $usuario = $ong->user;

            if ($usuario) {
                $usuario->name = $dados['nome'];
                $usuario->email = $dados['email'];

                if (!empty($dados['senha'])) {
                    $usuario->password = Hash::make($dados['senha']);
                }

                $usuario->save();
            }

            $ong->update([
                'nome' => $dados['nome'],
                'cnpj' => $dados['cnpj'] ?? null,
                'telefone' => $dados['telefone'] ?? null,
                'email_contato' => $dados['email_contato'] ?? null,
                'descricao' => $dados['descricao'] ?? null,
                'cep' => $dados['cep'] ?? null,
                'endereco' => $dados['endereco'] ?? null,
                'numero' => $dados['numero'] ?? null,
                'complemento' => $dados['complemento'] ?? null,
                'bairro' => $dados['bairro'] ?? null,
                'cidade' => $dados['cidade'] ?? null,
                'estado' => $dados['estado'] ?? null,
            ]);
        });

        return redirect()
            ->route('admin.ongs.index')
            ->with('success', 'ONG atualizada com sucesso!');
    }

    /**
     * Remove uma ONG do sistema.
     */
    public function destroy(Ong $ong): RedirectResponse
    {
        DB::transaction(function () use ($ong) {
            $usuario = $ong->user;

            $ong->pontosDeColeta()->delete();

            $ong->delete();

            if ($usuario) {
                $usuario->delete();
            }
        });

        return redirect()
            ->route('admin.ongs.index')
            ->with('success', 'ONG excluída com sucesso!');
    }

    /**
     * Alterna o status de ativação da ONG.
     */
    public function toggleStatus(Ong $ong): RedirectResponse
    {
        $ong->update([
            'ativo' => !$ong->ativo,
        ]);

        return redirect()
            ->route('admin.ongs.index')
            ->with('success', 'Status da ONG atualizado!');
    }
}
