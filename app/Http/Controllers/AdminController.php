<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
class AdminController extends Controller{
    function users_index($locale){
        $variables = [
            'locale' => $locale,
            'users' => User::orderBy('role_id', 'asc')->get()
        ];
        return view('admin.users', $variables);
    }
}
