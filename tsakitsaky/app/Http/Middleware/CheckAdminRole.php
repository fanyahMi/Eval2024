<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminRole
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
        if (!$request->session()->has('id_utilisateurAdmin')) {
            return redirect('/Login-Administrateur');
        }

        if ($request->session()->has('roles')  && $request->session()->has('id_utilisateurAdmin')) {
            $roles = session('roles');
            $check = false;
            foreach ($roles as $key => $value) {
                if($value->role_id == 1){
                    $check = true;
                }
            }
            if($check == false) {
                abort(403, "Vous n'avez pas accès a cette page . Cette page est pour l' administrateur seulement ");
            }
            return $next($request);
        }
        abort(403, "Vous n'avez pas accès a cette page . Cette page est pour l' administrateur seulement ");
    }
}
