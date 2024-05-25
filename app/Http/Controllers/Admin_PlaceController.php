<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use App\Models\Category;
use App\Models\Country;

class Admin_PlaceController extends Controller{
    /**
     * Show a list of places to an admin
     */
    public function index($locale){
        $variables = [
            'locale' => $locale,
            'total' => Place::count(),
            'categories' => Category::all(),
            'countries' => Country::all(),
            'logged' => auth()->user(),
            'places' => self::get_places(1,'',$locale)
        ];
        return view('admin.places.index',$variables);
    }

    /**
     * Get Users based on page and search term
     */
    public static function get_places($page, $search, $locale){
        // calculate the start index based on the page, and per page
        $per_page = 30;
        $start_index = ($page - 1) * $per_page;
        return Place::with('category')->with('country')->with('medias')
        ->join('places_translations','places_translations.place_id','places.id')
        ->where('places_translations.locale', $locale)
        ->where('places_translations.name', 'like','%'.$search.'%')
        ->orderBy('places.views_count', 'desc')
        ->select('places.*', 'places_translations.name')
        ->skip($start_index)
        ->take($per_page)
        ->get();
    }

    /**
     * Ajax, request more places by page and search
     */
    public function ajax_place_request(Request $request){
        $data = $request->all(); //get request data
        app()->setLocale($data['locale']); //set locale to request
        $next_page = $data['page'] + 1;
        $search = $data['search'];

        //get places for the page requested
        $places = self::get_places($next_page, $search, $data['locale']);

        if(count($places) === 0){
            //if no places, means there is no next page
            $next_page = -1;
        }

        $variables = [
            'next_page' => $next_page,
            'places' => $places,
        ];

        return response()->json($variables); //convert vars to json
    }
}
