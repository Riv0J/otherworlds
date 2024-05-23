<?php



namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use App\Models\Visit;
use App\Models\CountryTranslation;

class VisitsMiddleware{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next){
        $ip = $request->ip();
        $country_id = $this->get_country_id($ip);

        $agent = new Agent();
        $browser = $agent->browser();
        $platform = $agent->platform();

        Visit::create([
            'ip' => $ip,
            'browser' => $browser." ".$agent->version($browser),
            'os' => $platform." ".$agent->version($platform),
            'route' => $request->path(),
            'country_id' => $country_id,
        ]);

        return $next($request);
    }

    /**
     * Get a country, given an IP
     */
    public function get_country_id($ip){
        $location = Location::get($ip);
        $country_name = $location ? $location->countryName : 'Unknown';
        return CountryTranslation::where('name', $country_name)->value('country_id');
    }

}
