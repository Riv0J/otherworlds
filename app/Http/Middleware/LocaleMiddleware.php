<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $locale = $request->cookie('locale', 'en'); // Obtén el valor de la cookie 'locale' o usa 'es' como valor predeterminado
        app()->setLocale($locale); // Establece el locale para la aplicación

        return $next($request);
    }

}
