<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificarPerfil
{
    /**
     * Manipula a requisição para garantir que o usuário logado possui o perfil adequado.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  Perfil exigido ('admin' ou 'ong')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Se o usuário não estiver autenticado ou não tiver o papel necessário, barra o acesso
        if (! $request->user() || $request->user()->role !== $role) {
            abort(403, 'Acesso não autorizado para o seu perfil de usuário.');
        }

        return $next($request);
    }
}
