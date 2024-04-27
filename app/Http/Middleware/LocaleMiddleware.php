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
            return redirect()->route('place_index', ['locale' => 'en', 'section_slug' => trans('otherworlds.places_slug')]);
        }

        app()->setLocale($locale);
        return $next($request);
    }

}
