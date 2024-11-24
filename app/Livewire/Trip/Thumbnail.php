<?php

namespace App\Livewire\Trip;

use App\Models\Trip;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Thumbnail extends Component
{
    public Trip $trip;
    public bool $editable = false;
    public bool $deletable = false;

    public function mount(Trip $trip, bool $editable = false, bool $deletable = false)
    {
        $this->trip = $trip;

        $this->editable = $this->deletable = false;

        if ($editable === true) {
            if (Auth::user() && Auth::user()->id == $this->trip->user_id) {
                if (!$this->trip->isOver() && !$this->trip->isOneDayAway() && !$trip->trashed()) {
                    $this->editable = $editable;
                }
            }
        }

        if ($deletable == true) {
            if (Auth::user() && Auth::user()->id == $this->trip->user_id) {
                if (!$this->trip->trashed()) {
                    $this->deletable = $deletable;
                }
            }
        }
    }

    public function view()
    {
        return to_route('trip.show', $this->trip);
    }

    public function render()
    {
        return view('components.livewire.trip.trip-thumbnail');
    }
}
