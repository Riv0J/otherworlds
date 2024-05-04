<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
class AdminController extends Controller{
    function users_index($locale){
        $variables = [
            'locale' => $locale,
            'users' => User::all(),
        ];
        return view('admin.users', $variables);
    }
}
