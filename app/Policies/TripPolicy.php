<?php

namespace App\Policies;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TripPolicy
{
    /**
     * Determine if the user can create a trip based on his permissions
     *
     * @return boolean
     */
    public function create(): bool
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $trips_creation_allowed_amount = $user->allowedAmountOfTripsCreation();

        $count_created_trips_of_month = $user->createdTrips()
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        return $count_created_trips_of_month < $trips_creation_allowed_amount;
    }

    /**
     * Determine if the user can participate to a trip based on his permissions
     *
     * @return boolean
     */
    public function participate(): bool
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        $trips_participation_allowed_amount = $user->allowedAmountOfTripsParticipation();

        $count_participated_trips_of_month = $user->trips()
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        return $count_participated_trips_of_month < $trips_participation_allowed_amount;
    }
}
