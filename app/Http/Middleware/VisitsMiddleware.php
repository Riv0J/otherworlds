<?php

namespace App\Http\Middleware;

use App\Models\CountryTranslation;
use Closure;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Visit;
use Stevebauman\Location\Facades\Location;

class VisitsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        $ip = $request->ip();

        if ($this->is_loopback($ip)) {
            return $next($request);
        }

        $country = $this->get_country($ip);
        Visit::create([
            'ip' => $ip,
            'user_agent' => $request->userAgent(),
            'route' => $request->path(),
            'country_id' => $country->id,
        ]);
        return $next($request);
    }

    /**
     * Get a country, given an IP
     */
    public function get_country($ip){
        $location = Location::get($ip);
        $country_name = $location ? $location->countryName : 'Unknown';

        dd($ip." ".$country_name);
        return CountryTranslation::join('countries', 'countries.id', 'countries_translations.country_id')
        ->where('countries_translations.name',$country_name)->get('countries.*');
    }

    private function is_loopback($ip) {
        // Verificar tanto direcciones IPv4 como IPv6 de loopback
        return $ip === '127.0.0.1' || $ip === '::1';
    }
}
