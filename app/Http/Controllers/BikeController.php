<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreBikeRequest;
use App\Http\Requests\UpdateBikeRequest;

class BikeController extends Controller
{
    /**
     * Return the bike creation view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('bike.create');
    }

    /**
     * Do the bike creation action
     *
     * @param StoreBikeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBikeRequest $request): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $bike_data = $request->validated();

        $bike_data['user_id'] = $user->id;

        Bike::create($bike_data);

        return to_route('profile.bikes')->with('success', __('Bike created successfully!'));
    }

    /**
     * Return the bike edition view
     *
     * @param Bike $bike
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function edit(Bike $bike): \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
    {
        if (Auth::user() && $bike->user_id != Auth::user()->id) {
            return back()->with('error', __('This bike does not belong to you'));
        }

        return view('bike.edit')->with(['bike' => $bike]);
    }

    /**
     * Do the Bike update action
     *
     * @param UpdateBikeRequest $request
     * @param Bike $bike
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBikeRequest $request, Bike $bike): \Illuminate\Http\RedirectResponse
    {
        if (Auth::user() && $bike->user_id != Auth::user()->id) {
            return back()->with('error', __('This bike does not belong to you'));
        }

        $bike_data = $request->validated();

        $bike->update($bike_data);

        return back()->with('success', __('Bike updated successfully!'));
    }

    /**
     * Do the bike delete action
     *
     * @param Bike $bike
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Bike $bike): \Illuminate\Http\RedirectResponse
    {
        if (Auth::user() && $bike->user_id != Auth::user()->id) {
            return back()->with('error', __('This bike does not belong to you'));
        }

        $bike->delete();

        return to_route('profile.bikes')->with('success', __('Bike deleted successfully!'));
    }
}
