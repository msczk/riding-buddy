<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\Trip\TripDeleted;
use App\Notifications\Trip\TripApproved;
use App\Http\Requests\Trip\StoreTripRequest;
use App\Http\Requests\Trip\UpdateTripRequest;
use App\Notifications\Trip\TripNewParticipation;
use App\Notifications\Trip\TripWaitingForApproval;

class TripController extends Controller
{
    /**
     * Return the trip creation view
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        if (!Gate::allows('create-trip')) {
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
        if (!Gate::allows('create-trip')) {
            abort(403, __('You reached your subscription plan limits. Consider upgrading it'));
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        $trip_data = $request->validated();

        $trip_data['user_id'] = $user->id;

        $trip_data['slug'] = Str::slug($request->input('name'), '-', App::currentLocale()) . '-' . time();

        $trip = Trip::create($trip_data);

        $trip->findCountry();
        $trip->findCity();

        $trip->save();

        $trip->users()->attach($user);

        $trip->users()->updateExistingPivot($user, ['approved' => true]);

        return to_route('trip.show', $trip)->with('success', __('Trip created successfully!'));
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
        if ($trip->isOver()) {
            if (!$trip->public_after_over) {
                abort(403, __('This past trip is not public'));
            }
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        $is_approved = false;

        $fake_coordinates = $trip->generateCloseCoordinates(2);

        $coordinates_start_lat = $fake_coordinates[0];
        $coordinates_start_long = $fake_coordinates[1];

        if ($user) {
            if ($user->participate($trip)) {
                if ($user->isApprovedForTrip($trip)) {
                    $is_approved = true;

                    $coordinates_start_lat = $trip->coordinates_start_lat;
                    $coordinates_start_long = $trip->coordinates_start_long;
                }
            }
        }

        return view('trip.show')->with(['trip' => $trip, 'is_approved' => $is_approved, 'coordinates_start_lat' => $coordinates_start_lat, 'coordinates_start_long' => $coordinates_start_long]);
    }

    /**
     * Return the trip edition view
     *
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function edit(Trip $trip): \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
    {
        if (Auth::user() && $trip->user_id != Auth::user()->id) {
            return back()->with('error', __('This trip does not belong to you'));
        }

        if ($trip->isOver()) {
            return back()->with('error', __('This trip is already over and cannot be modified'));
        }

        if ($trip->isOneDayAway()) {
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
        if (Auth::user() && $trip->user_id != Auth::user()->id) {
            return back()->with('error', __('This trip does not belong to you'));
        }

        if ($trip->isOver()) {
            return back()->with('error', __('This trip is already over and cannot be modified'));
        }

        if ($trip->isOneDayAway()) {
            return back()->with('error', __('This trip will start soon and cannot be modified'));
        }

        $trip_data = $request->validated();

        $trip->update($trip_data);

        $trip->findCountry();
        $trip->findCity();

        $trip->update();

        return back()->with('success', __('Trip updated successfully!'));
    }

    /**
     * Do the trip soft delete action
     *
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Trip $trip): \Illuminate\Http\RedirectResponse
    {
        if (Auth::user() && $trip->user_id != Auth::user()->id) {
            return back()->with('error', __('This trip does not belong to you'));
        }

        if ($trip->trashed()) {
            return back()->with('error', __('This trip is already trashed'));
        }

        if (!empty($trip->users)) {
            foreach ($trip->users as $user) {
                if ($trip->user->id != $user->id) {
                    $user->notify(new TripDeleted($trip));
                }
            }
        }

        $trip->delete();

        return to_route('profile.trips')->with('success', __('Trip deleted successfully!'));
    }

    /**
     * Do the toggle trip visibility action
     *
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function visibility(Trip $trip): \Illuminate\Http\RedirectResponse
    {
        if (Auth::user() && $trip->user_id != Auth::user()->id) {
            return back()->with('error', __('This trip does not belong to you'));
        }

        $trip->public_after_over = !$trip->public_after_over;
        $trip->save();

        return back()->with('success', __('Trip visibility after over updated successfully!'));
    }

    /**
     * Do the toggle trip participation action
     *
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function participate(Trip $trip): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if (!$user) {
            return back()->with('error', __('You must bee logged in'));
        }

        if ($trip->user_id == $user->id) {
            return back()->with('error', __('You already participate to this trip'));
        }

        if ($trip->isOver()) {
            return back()->with('error', __('You cannot participate to this trip beecause it is already over'));
        }

        if ($trip->isOneDayAway()) {
            return back()->with('error', __('You cannot participate to this trip beecause it will start soon'));
        }

        if ($trip->users->contains($user)) {
            $trip->users()->detach($user);
            return back()->with('success', __('You unregistered for this trip'));
        } else {

            if ($trip->isFull()) {
                return back()->with('error', __('You cannot participate to this trip beecause it is already full'));
            }

            if (!Gate::allows('participate-trip')) {
                abort(403, __('You reached your subscription plan limits. Consider upgrading it'));
            }

            $trip->users()->attach($user);

            $user->notify(new TripWaitingForApproval($trip));

            $trip->user->notify(new TripNewParticipation($trip, $user));

            return back()->with('success', __('You participation has been submited to the initiator of this trip'));
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

        if (!$user) {
            return back()->with('error', __('You must bee logged in'));
        }

        if ($trip->user_id == $user->id) {
            return back()->with('error', __('You cannot rate your own trip'));
        }

        if (!$trip->isOver()) {
            return back()->with('error', __('You cannot rate a trip that is not over'));
        }

        if ($user->hasRated($trip)) {
            return back()->with('error', __('You have already rated this trip'));
        }

        if ($trip->users->contains($user)) {
            return view('trip.rate')->with('trip', $trip);
        } else {
            return back()->with('error', __('You did not participate to this trip'));
        }
    }

    /**
     * Do the trip rating action
     *
     * @param Request $request
     * @param Trip $trip
     * @return \Illuminate\Http\RedirectResponse
     */
    public function doRating(Request $request, Trip $trip): \Illuminate\Http\RedirectResponse
    {
        $rating = $request->input('rating');

        if (!is_numeric($rating) || empty($rating)) {
            return back()->with('error', __('Please send a correct rating value'));
        }

        $trip->users()->updateExistingPivot(Auth::user(), ['rate' => $rating]);

        return to_route('trip.show', $trip)->with('success', __('Thank you for rating this trip'));
    }

    /**
     * Do the approbation of a user who wants to join de trip
     *
     * @param Trip $trip
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Trip $trip, User $user): \Illuminate\Http\RedirectResponse
    {
        if (!Auth::user()) {
            return back()->with('error', __('You must bee logged in'));
        }

        if ($trip->user_id != Auth::user()->id) {
            return to_route('trip.show', $trip)->with('error', __('You are not the initiator of this trip'));
        }

        if ($trip->user_id == $user->id) {
            return to_route('trip.show', $trip)->with('error', __('You cannot approve yourself'));
        }

        if ($trip->isOver()) {
            return to_route('trip.show', $trip)->with('error', __('You cannot approve someone for a trip that is over'));
        }

        if (!$trip->users->contains($user)) {
            return to_route('trip.show', $trip)->with('error', __('You cannot approve someone for a trip he does not participate'));
        }

        $trip->users()->updateExistingPivot($user, ['approved' => true]);

        $user->notify(new TripApproved($trip));

        return to_route('trip.show', $trip)->with('success', __('User :username has been approved', ['username' => $user->username]));
    }
}
