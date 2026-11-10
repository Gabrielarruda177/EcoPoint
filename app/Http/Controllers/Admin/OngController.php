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
 
    public function index(): View
    {
        $ongs = Ong::with('user')
            ->latest()
            ->paginate(10);

        return view('admin.ongs.index', compact('ongs'));
    }

   
    public function create(): View
    {
        return view('admin.ongs.create');
    }

   
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
                'ativo' => true,
            ]);
        });

        return redirect()
            ->route('admin.ongs.index')
            ->with('success', 'ONG cadastrada com sucesso!');
    }

  
    public function edit(Ong $ong): View
    {
        $ong->load('user');

        return view('admin.ongs.edit', compact('ong'));
    }

    
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
            ]);
        });

        return redirect()
            ->route('admin.ongs.index')
            ->with('success', 'ONG atualizada com sucesso!');
    }

 
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