<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;
use App\Notifications\TripDeleted;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Trip\StoreTripRequest;
use App\Http\Requests\Trip\UpdateTripRequest;

class TripController extends Controller
{
    /**
     * Return the trip creation view
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if(!Gate::allows('create-trip'))
        {
            abort(403, __('You reached your subscription plan limits. Consider upgrading it'));
        }
        
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
        if(!Gate::allows('create-trip')) 
        {
            abort(403, __('You reached your subscription plan limits. Consider upgrading it'));
        }

        $trip_data = $request->validated();

        $trip_data['user_id'] = Auth::user()->id;

        $trip = Trip::create($trip_data);

        $trip->users()->attach(Auth::user());

        return to_route('trip.show', $trip)->with('success', 'Trip created successfully!');
    }

    /**
     * Return the trip public view
     *
     * @param Trip $trip
     * @return \Illuminate\Contracts\View\View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function show(Trip $trip): \Illuminate\Contracts\View\View
    {
        if($trip->isOver())
        {
            if(!$trip->public_after_over)
            {
                abort(403, __('This past trip is not public'));
            }
        }
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
        if(Auth::user() && $trip->user_id != Auth::user()->id)
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
        if(Auth::user() && $trip->user_id != Auth::user()->id)
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

    /**
     * Do the trip soft delete action
     *
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Trip $trip): \Illuminate\Http\RedirectResponse
    {
        if(Auth::user() && $trip->user_id != Auth::user()->id)
        {
            return back()->with('error', __('This trip does not belong to you'));
        }

        if ($trip->trashed())
        {
            return back()->with('error', __('This trip is already trashed'));
        }

        if(!empty($trip->users))
        {
            foreach($trip->users as $user)
            {
                if($trip->user->id != $user->id)
                {
                    $user->notify(new TripDeleted($trip));
                }
            }
        }

        $trip->delete();

        return to_route('profile.trips')->with('success', 'Trip deleted successfully!');
    }

    /**
     * Do the toggle trip visibility action
     *
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function visibility(Trip $trip): \Illuminate\Http\RedirectResponse
    {
        if(Auth::user() && $trip->user_id != Auth::user()->id)
        {
            return back()->with('error', __('This trip does not belong to you'));
        }

        $trip->public_after_over = !$trip->public_after_over;
        $trip->save();

        return back()->with('success', 'Trip visibility after over updated successfully!');
    }

    /**
     * Do the toggle trip participation action
     *
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function participate(Trip $trip): \Illuminate\Http\RedirectResponse
    {
        if(!Auth::user())
        {
            return back()->with('error', __('You must bee logged in'));
        }
        
        if($trip->user_id == Auth::user()->id)
        {
            return back()->with('error', __('You already participate to this trip'));
        }

        if($trip->isOver())
        {
            return back()->with('error', __('You cannot participate to this trip beecause it is already over'));
        }

        if($trip->isOneDayAway())
        {
            return back()->with('error', __('You cannot participate to this trip beecause it will start soon'));
        }

        if($trip->users->contains(Auth::user()))
        {
            $trip->users()->detach(Auth::user());
            return back()->with('success', 'You unregistered for this trip');
        }else{

            if($trip->isFull())
            {
                return back()->with('error', __('You cannot participate to this trip beecause it is already full'));
            }

            if(!Gate::allows('participate-trip')) 
            {
                abort(403, __('You reached your subscription plan limits. Consider upgrading it'));
            }

            $trip->users()->attach(Auth::user());
            return back()->with('success', 'You registered for this trip');
        }
    }

    /**
     * Return the trip rating view
     *
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function rate(Trip $trip): \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if($trip->user_id == $user->id)
        {
            return back()->with('error', __('You cannot rate your own trip'));
        }

        if(!$trip->isOver())
        {
            return back()->with('error', __('You cannot rate a trip that is not over'));
        }

        if($user->hasRated($trip))
        {
            return back()->with('error', __('You have already rated this trip'));   
        }

        if($trip->users->contains($user))
        {
            return view('trip.rate')->with('trip', $trip);
        }else{
            return back()->with('error', __('You did not participate to this trip'));
        }
    }

    public function doRating(Request $request, Trip $trip)
    {
        $rating = $request->input('rating');

        if(!is_numeric($rating) || empty($rating))
        {
            return back()->with('error', __('Please send a correct rating value'));
        }

        $trip->users()->updateExistingPivot(Auth::user(), ['rate' => $rating]);

        return to_route('trip.show', $trip)->with('success', 'Thank you for rating this trip');
    }
}
