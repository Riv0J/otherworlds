<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Message;
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
        if ($user && $user->active == true && ($user->is_guest() || $user->is_admin() || $user->is_owner())) {
            return $next($request);
        }

        if ($request->ajax()) {
            return response()->json([
                'message' => new Message(Message::TYPE_ERROR, ucfirst($user->role->name).': '.trans('otherworlds.no_privileges'))
            ], Response::HTTP_FORBIDDEN);
        }

        $locale = $request->route('locale') ?? 'en';
        return redirect()->route('home',[ 'locale'=> $locale])->withErrors(trans('otherworlds.no_privileges'));
    }
}
