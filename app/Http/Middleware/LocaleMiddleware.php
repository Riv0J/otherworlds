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
        $locale = $request->route('locale');

        // check if locale is valid, return to places index if not
        if ($locale == null || in_array($locale, config('translatable.locales')) == false) {
            return redirect()->route('places', ['locale' => 'en']);
        }
        \App::setLocale($locale);
        // dd("changing locale to, ".$locale);
        return $next($request);
    }

}
