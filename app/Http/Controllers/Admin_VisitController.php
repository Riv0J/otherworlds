<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visit;
class Admin_VisitController extends Controller{
    /**
     * Show the list of visits to an admin
     */
    public function index($locale){
        $variables = [
            'locale' => $locale,
            'visits' => Visit::all()
        ];
        return view('admin.visits.index',$variables);
    }
}
