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
            'countries' => Country::whereExists(function ($query) {
                $query->select('country_id')
                ->from('places')
                ->whereRaw('places.country_id = countries.id');
            })->get(),
            'logged' => auth()->user(),
            'places' => self::get_places(1,'',$locale,0,0)
        ];
        return view('admin.places.index',$variables);
    }

    /**
     * Show the create place form to an admin
     */
    public function create($locale){
        $variables = [
            'locale' => $locale,
            'categories' => Category::all(),
            'countries' => Country::all()
        ];
        return view('admin.places.create', $variables);
    }

    /**
     * Get Users based on page and search term
     */
    public static function get_places($page, $search, $locale, $category_id, $country_id){
        // calculate the start index based on the page, and per page
        $per_page = 30;
        $start_index = ($page - 1) * $per_page;
        $query = Place::with('medias')
        ->join('places_translations', 'places_translations.place_id', 'places.id')
        ->where('places_translations.locale', $locale)
        ->where('places_translations.name', 'like', '%' . $search . '%')
        ->orderBy('places.views_count', 'desc');

        if($category_id != null && $category_id != 0){
            $query->where('category_id',$category_id);
        }
        if($country_id != null && $country_id != 0){
            $query->where('country_id',$country_id);
        }

        return $query->select('places.*', 'places_translations.name')
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
        $places = self::get_places($next_page, $search, $data['locale'], $data['category_id'], $data['country_id']);

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
