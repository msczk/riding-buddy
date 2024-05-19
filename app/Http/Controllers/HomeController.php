<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show()
    {
        $last_users = User::orderBy('created_at', 'DESC')->take(6)->get();
        return view('home.home')->with(['last_users' => $last_users]);
    }
    
}
