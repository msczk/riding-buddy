<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Return the profile index of the authed user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('profile.index');
    }

    /**
     * Return the public profile of a given user
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user): \Illuminate\Contracts\View\View
    {
        $trips = $user->tripsByStartDate;
        return view('profile.show')->with(['user' => $user, 'trips' => $trips]);
    }

    /**
     * Return the profile edition view of the authed user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(): \Illuminate\Contracts\View\View
    {
        $user = Auth::user();
        return view('profile.edit')->with('user', $user);
    }

    /**
     * Do the profile update action
     *
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request): \Illuminate\Http\RedirectResponse
    {
        $user_data = $request->validated();

        $user_data['optin_newsletter'] = $request->input('optin_newsletter') ? 1 : 0;

        $user = User::findOrfail(Auth::user()->id);

        $user->fill($user_data);

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    /**
     * Return the trips of the authed user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function trips(): \Illuminate\Contracts\View\View
    {
        $user = User::findOrfail(Auth::user()->id);

        $trips = $user->tripsByStartDate;

        return view('profile.trips')->with('trips', $trips);
    }
}
