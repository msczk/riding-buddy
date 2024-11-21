<?php

namespace App\Livewire\Trip;

use App\Models\Trip;
use Livewire\Component;

class Thumbnail extends Component
{
    public Trip $trip;

    public function mount(Trip $trip)
    {
        $this->trip = $trip;
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
