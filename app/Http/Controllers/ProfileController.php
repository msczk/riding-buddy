<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('profile.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $trips = $user->tripsByStartDate;
        return view('profile.show')->with(['user' => $user, 'trips' => $trips]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfileRequest $request)
    {
        $user_data = $request->validated();

        $user_data['optin_newsletter'] = $request->input('optin_newsletter') ? 1 : 0;

        $user = User::findOrfail(Auth::user()->id);

        $user->fill($user_data);

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function trips()
    {
        $user = User::findOrfail(Auth::user()->id);

        $trips = $user->tripsByStartDate;

        return view('profile.trips')->with('trips', $trips);
    }
}
