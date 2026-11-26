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
use App\Mail\OngCredenciaisMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

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
            'descricao' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'cep' => ['nullable', 'string', 'max:9'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:100'],
            'bairro' => ['nullable', 'string', 'max:100'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:2'],
        ]);

        $caminhoLogo = null;
        if ($request->hasFile('logo')) {
            $caminhoLogo = $request->file('logo')->store('ongs', 'public');
        }

        $senhaTemporaria = Str::random(14);

        try {
            DB::transaction(function () use ($dados, $senhaTemporaria, $caminhoLogo) {
                $usuario = User::create([
                    'name' => $dados['nome'],
                    'email' => $dados['email'],
                    'password' => Hash::make($senhaTemporaria),
                    'role' => 'ong',
                ]);

                return Ong::create([
                    'user_id' => $usuario->id,
                    'nome' => $dados['nome'],
                    'cnpj' => $dados['cnpj'] ?? null,
                    'telefone' => $dados['telefone'] ?? null,
                    'email_contato' => $dados['email_contato'] ?? null,
                    'descricao' => $dados['descricao'] ?? null,
                    'logo' => $caminhoLogo,
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
        } catch (Throwable $e) {
            if ($caminhoLogo && Storage::disk('public')->exists($caminhoLogo)) {
                Storage::disk('public')->delete($caminhoLogo);
            }

            Log::error('Erro ao cadastrar ONG no banco: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Não foi possível cadastrar a ONG. Tente novamente.');
        }

        // Envio do e-mail com as credenciais de acesso
        try {
            Mail::to($dados['email'])
                ->bcc('ong.ecopoint@gmail.com')
                ->send(new OngCredenciaisMail(
                    $dados['nome'],
                    $dados['email'],
                    $senhaTemporaria
                ));

            return redirect()
                ->route('admin.ongs.index')
                ->with('success', 'ONG cadastrada e credenciais enviadas por e-mail com sucesso!');
        } catch (Throwable $e) {
            Log::error('Erro no envio de e-mail de credenciais da ONG: ' . $e->getMessage());

            $detalheErro = str_contains($e->getMessage(), '535') || str_contains($e->getMessage(), 'authenticate')
                ? 'Falha de autenticação no servidor de e-mail (verifique a senha de app no .env).'
                : 'O servidor de e-mail não respondeu.';

            return redirect()
                ->route('admin.ongs.index')
                ->with(
                    'warning',
                    "ONG cadastrada com sucesso! Porém, o envio do e-mail falhou ({$detalheErro}). Senha temporária gerada: {$senhaTemporaria}"
                );
        }
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
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'remover_logo' => ['nullable', 'boolean'],
            'cep' => ['nullable', 'string', 'max:9'],
            'endereco' => ['nullable', 'string', 'max:255'],
            'numero' => ['nullable', 'string', 'max:20'],
            'complemento' => ['nullable', 'string', 'max:100'],
            'bairro' => ['nullable', 'string', 'max:100'],
            'cidade' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:2'],
        ]);

        $caminhoLogo = $ong->logo;

        if ($request->hasFile('logo')) {
            if ($ong->logo && Storage::disk('public')->exists($ong->logo)) {
                Storage::disk('public')->delete($ong->logo);
            }
            $caminhoLogo = $request->file('logo')->store('ongs', 'public');
        } elseif ($request->boolean('remover_logo')) {
            if ($ong->logo && Storage::disk('public')->exists($ong->logo)) {
                Storage::disk('public')->delete($ong->logo);
            }
            $caminhoLogo = null;
        }

        DB::transaction(function () use ($dados, $ong, $caminhoLogo) {
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
                'logo' => $caminhoLogo,
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

            if ($ong->logo && Storage::disk('public')->exists($ong->logo)) {
                Storage::disk('public')->delete($ong->logo);
            }

            foreach ($ong->pontosDeColeta as $ponto) {
                if ($ponto->imagem && Storage::disk('public')->exists($ponto->imagem)) {
                    Storage::disk('public')->delete($ponto->imagem);
                }
            }

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
