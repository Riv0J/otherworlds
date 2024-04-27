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
    public function handle($request, Closure $next){
        $route = $request->route(); // Obtiene la información de la ruta
    $controllerAction = $route->getActionName(); // Obtiene el nombre de la acción del controlador

    list($controller, $method) = explode('@', $controllerAction); // Divide el nombre de la acción para obtener el controlador y el método

    // Ahora puedes acceder al controlador y al método
    // $controller contiene el nombre de la clase del controlador
    // $method contiene el nombre del método del controlador

    // Por ejemplo, puedes hacer algo como esto para imprimir el controlador y el método
    // echo "Controlador: $controller, Método: $method";

        $locale = $request->route('locale');

        // check if locale is valid, return to places index if not
        if ($locale == null || in_array($locale, config('translatable.locales')) == false) {
            return redirect()->route('place_index', ['locale' => 'en', 'section_slug' => trans('otherworlds.places_slug')]);
        }

        app()->setLocale($locale);

        return $next($request);
    }

}
