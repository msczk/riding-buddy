<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Http\Requests\Trip\StoreTripRequest;
use App\Http\Requests\Trip\UpdateTripRequest;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    /**
     * Return the trip creation view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('trip.create');
    }

    /**
     * Do the trip creation action
     *
     * @param StoreTripRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTripRequest $request): \Illuminate\Http\RedirectResponse
    {
        $trip_data = $request->validated();

        $trip_data['user_id'] = Auth::user()->id;

        $trip = Trip::create($trip_data);

        return to_route('trip.edit', $trip)->with('success', 'Trip created successfully!');
    }

    /**
     * Return the trip public view
     *
     * @param Trip $trip
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Trip $trip): \Illuminate\Contracts\View\View
    {
        return view('trip.show')->with('trip', $trip);
    }

    /**
     * Return the trip edition view
     *
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function edit(Trip $trip): \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
    {
        if($trip->user_id != Auth::user()->id)
        {
            return back()->with('error', __('This trip does not belong to you'));
        }

        if($trip->isOver())
        {
            return back()->with('error', __('This trip is already over and cannot be modified'));
        }

        if($trip->isOneDayAway())
        {
            return back()->with('error', __('This trip will start soon and cannot be modified'));
        }

        return view('trip.edit')->with('trip', $trip);
    }

    /**
     * Do the Trip update action
     *
     * @param UpdateTripRequest $request
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTripRequest $request, Trip $trip): \Illuminate\Http\RedirectResponse
    {
        if($trip->user_id != Auth::user()->id)
        {
            return back()->with('error', __('This trip does not belong to you'));
        }

        if($trip->isOver())
        {
            return back()->with('error', __('This trip is already over and cannot be modified'));
        }

        if($trip->isOneDayAway())
        {
            return back()->with('error', __('This trip will start soon and cannot be modified'));
        }
        
        $trip_data = $request->validated();

        $trip->update($trip_data);

        return back()->with('success', 'Trip updated successfully!');
    }

    public function destroy(Trip $trip)
    {
        if($trip->user_id != Auth::user()->id)
        {
            return back()->with('error', __('This trip does not belong to you'));
        }

        if ($trip->trashed())
        {
            return back()->with('error', __('This trip is already trashed'));
        }

        $trip->delete();

        return to_route('profile.trips')->with('success', 'Trip deleted successfully!');
    }
}
