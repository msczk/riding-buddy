<?php

namespace App\View\Components\Trip;

use App\Models\Trip;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ParticipantThumbnail extends Component
{
    public User $user;
    public Trip $trip;
    /**
     * Create a new component instance.
     */
    public function __construct(User $user, Trip $trip)
    {
        $this->user = $user;
        $this->trip = $trip;
    }

    /**
     * Get the view / contents that represent the profile thumbnail.
     */
    public function render(): View
    {
        return view('components.trip.participant-thumbnail')->with(['user' => $this->user, 'trip' => $this->trip]);
    }
}
