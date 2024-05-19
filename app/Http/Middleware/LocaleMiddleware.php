<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\Message;
class LocaleMiddleware{
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
            Session::flash('message', new Message(Message::TYPE_ERROR, trans('otherworlds.language_not_supported',['lang'=>$locale])));
            $locale = 'en';
            return redirect(url($locale.'/'.trans('otherworlds.places_slug',[],$locale)));
        }

        app()->setLocale($locale);

        return $next($request);
    }

}
