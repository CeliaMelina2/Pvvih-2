<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('connexion');
        }

        // Vérifie si l'utilisateur a bien le rôle demandé
        if (Auth::user()->role !== $role) {
            return redirect()->route('connexion')->withErrors([
                'auth' => 'Accès refusé. Vous devez être ' . $role,
            ]);
        }

        return $next($request);
    }
}
