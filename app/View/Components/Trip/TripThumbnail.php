<?php

namespace App\View\Components\Trip;

use Closure;
use App\Models\Trip;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class TripThumbnail extends Component
{
    public $trip;
    public $showEdit;
    /**
     * Create a new component instance.
     */
    public function __construct(Trip $trip, $showEdit = false)
    {
        $this->trip = $trip;

        $this->showEdit = false;

        if($showEdit == true)
        {
            if(Auth::user() && Auth::user()->id == $this->trip->user_id)
            {
                if(!$this->trip->isOver() && !$this->trip->isOneDayAway())
                {
                    $this->showEdit = $showEdit;
                }
            }
        }
    }

    /**
     * Get the view / contents that represent the trip thumbnail.
     */
    public function render(): View
    {
        return view('components.trip.trip-miniature')->with(['trip' => $this->trip, 'showEdit' => $this->showEdit]);
    }
}
