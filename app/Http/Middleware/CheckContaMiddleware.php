<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckContaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica se o usuário está autenticado
        if (!auth()->check()) {
            // Se não estiver, redireciona para a página de login
            return redirect()->route('login');
        }

        // Se estiver autenticado, permite o acesso
        return $next($request);
    }
}
