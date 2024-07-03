<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheControlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Ajouter les en-têtes de cache pour les fichiers statiques
        $response->header('Cache-Control', 'public, max-age=604800'); // Cache pendant 7 jours (604800 secondes)

        return $response;
    }
}
