<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Country;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class Api_Controller extends Controller
{
    public function get_countries(Request $request){
        $response = [];
        $status = 422;
        try {
            $validated = $request->validate([
                'lang' => ['required',Rule::in(config('translatable.locales'))],
            ]);

            app()->setLocale($validated['lang']);

            $response = [
                'success' => true,
                'countries' => Country::all()
            ];

        } catch (ValidationException $e) {
            $response = [
                'success' => false,
                'errors' => $e->errors()
            ];
        }
        return response()->json($response);
    }

    public function api_get_places(Request $request){
        $response = [];
        $status = 422;
        try {
            $validated = $request->validate([
                'lang' => ['required',Rule::in(config('translatable.locales'))],
                'country_id' => 'nullable|exists:countries,id',
                'category_id' => 'nullable|exists:categories,id'
            ]);

            app()->setLocale($validated['lang']);
            $places = DB::table('places')->join('places_countries','places.id','places_countries');
            $status = 200;

        } catch (ValidationException $e) {
            $response = [
                'success' => false,
                'errors' => $e->errors()
            ];
        }
        return response()->json($response, $status);

    }
}
