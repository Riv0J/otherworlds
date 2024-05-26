<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Message;
class Admin_VisitController extends Controller{
    /**
     * Show the list of visits to an admin
     */
    public function index($locale){
        $variables = [
            'locale' => $locale,
            'total' => Visit::count(),
            'logged' => auth()->user(),
            'visits' => self::get_visits(1)
        ];
        return view('admin.visits.index',$variables);
    }

    /**
     * Get visits based on page
     */
    public static function get_visits($page){
        // calculate the start index based on the page, and per page
        $per_page = 30;
        $start_index = ($page - 1) * $per_page;

        // additionally get the country for each visit
        return Visit::orderBy('visits.created_at', 'desc')
        ->with('country')
        ->skip($start_index)
        ->take($per_page)
        ->get();
    }

    /**
     * Ajax, get visits based on page
     */
    public function ajax_visit_request(Request $request){
        $data = $request->all(); //get request data
        app()->setLocale($data['locale']); //set locale to request
        $next_page = $data['page'] + 1;

        //get visits for the page requested
        $visits = self::get_visits($next_page);

        if(count($visits) === 0){
            //if no places, means there is no next page
            $next_page = -1;
        }

        $variables = [
            'next_page' => $next_page,
            'visits' => $visits,
        ];

        return response()->json($variables); //convert vars to json
    }

    /**
     * Ajax, delete a visit
     */
    public function ajax_delete_visit(Request $request){
        $data = $request->all();
        $visit = Visit::find($data['visit_id']);
        $visit->delete();
        $response['message'] = new Message(Message::TYPE_SUCCESS, 'Visit deleted');
        return response()->json($response);
    }
}
