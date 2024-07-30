<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Return the landing page view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function landing(): \Illuminate\Contracts\View\View
    {
        return view('home.landing');
    }

    /**
     * Return the app home view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $last_users = User::orderBy('created_at', 'DESC')->take(10)->get();

        $coming_trips = Trip::where('start_at', '>=', date('Y-m-d'))->orderBy('start_at', 'ASC')->take(6)->get();

        return view('home.home')->with(['last_users' => $last_users, 'coming_trips' => $coming_trips]);
    }
    
}
