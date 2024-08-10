<?php

namespace App\View\Components\Trip;

use Closure;
use App\Models\Trip;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class SearchBar extends Component
{
    private $place;
    private $radius;
    private $lat;
    private $long;
    private $full;

    /**
     * Create a new component instance.
     */
    public function __construct($place = '', $lat = '', $long = '', $radius = 30, $full = false)
    {
        $this->place = $place;
        $this->radius = $radius;
        $this->lat = $lat;
        $this->long = $long;
        $this->full = $full;
    }

    /**
     * Get the view / contents that represent the trip thumbnail.
     */
    public function render(): View
    {
        return view('components.trip.searchbar')->with(['place' => $this->place, 'radius' => $this->radius, 'lat' => $this->lat, 'long' => $this->long, 'full' => $this->full]);
    }
}
