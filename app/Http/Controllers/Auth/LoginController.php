<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Exibe o formulário de login do sistema.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Processa a autenticação do usuário.
     */
    public function login(Request $request): RedirectResponse
    {
        $dados = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'perfil' => ['nullable', 'string', 'in:admin,ong'],
        ], [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'Informe um endereço de e-mail válido.',
            'password.required' => 'O campo senha é obrigatório.',
        ]);

        $credentials = [
            'email' => $dados['email'],
            'password' => $dados['password'],
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!empty($dados['perfil']) && $user->role !== $dados['perfil']) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $perfilConta = $user->isAdmin() ? 'Administrador' : 'ONG';
                $perfilSelecionado = $dados['perfil'] === 'admin' ? 'Administrador' : 'ONG';

                return back()
                    ->withErrors([
                        'perfil' => "Esta conta pertence ao perfil '{$perfilConta}', mas a opção '{$perfilSelecionado}' estava selecionada. Alterne a opção acima para prosseguir.",
                    ])
                    ->onlyInput('email', 'perfil');
            }

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            if ($user->isOng()) {
                return redirect()->intended(route('ong.dashboard'));
            }

            return redirect()->intended(route('publico.home'));
        }

        return back()
            ->withErrors([
                'email' => 'As credenciais fornecidas não conferem com nossos registros.',
            ])
            ->onlyInput('email', 'perfil');
    }

    /**
     * Finaliza a sessão do usuário autenticado.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Você saiu da sua conta com sucesso.');
    }
}
