<?php

namespace App\View\Components\Trip;

use App\Models\Trip;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TripThumbnail extends Component
{
    public $trip;
    /**
     * Create a new component instance.
     */
    public function __construct(Trip $trip)
    {
        $this->trip = $trip;
    }

    /**
     * Get the view / contents that represent the trip thumbnail.
     */
    public function render(): View
    {
        return view('components.trip.trip-miniature')->with('trip', $this->trip);
    }
}
