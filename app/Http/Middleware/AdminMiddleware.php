<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){

        $user = $request->user();
        if ($user && $user->active == true && ($user->is_admin() || $user->is_owner())) {
            return $next($request);
        }

        $locale = $request->route('locale') ?? 'en';
        return redirect()->route('home',[ 'locale'=> $locale])->withErrors(trans('otherworlds.no_privileges'));
    }
}
