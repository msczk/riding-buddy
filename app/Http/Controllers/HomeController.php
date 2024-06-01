<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Return the home view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(): \Illuminate\Contracts\View\View
    {
        $last_users = User::orderBy('created_at', 'DESC')->take(6)->get();

        $coming_trips = Trip::where('start_at', '>=', date('Y-m-d'))->orderBy('start_at', 'ASC')->take(4)->get();

        return view('home.home')->with(['last_users' => $last_users, 'coming_trips' => $coming_trips]);
    }
    
}
