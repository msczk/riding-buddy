<?php

namespace App\View\Components\Bike;

use Closure;
use App\Models\Bike;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class BikeThumbnail extends Component
{
    private Bike $bike;
    private Bool $showEdit;
    private Bool $showTrash;

    /**
     * Create a new component instance.
     */
    public function __construct(Bike $bike, Bool $showEdit = false, Bool $showTrash = false)
    {
        $this->bike = $bike;

        $this->showEdit = false;
        $this->showTrash = false;

        if ($showEdit == true) {
            if (Auth::user() && Auth::user()->id == $this->bike->user_id) {
                $this->showEdit = $showEdit;
            }
        }

        if ($showTrash == true) {
            if (Auth::user() && Auth::user()->id == $this->bike->user_id) {
                $this->showTrash = $showTrash;
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.bike.bike-thumbnail')->with(['bike' => $this->bike, 'showEdit' => $this->showEdit, 'showTrash' => $this->showTrash]);
    }
}
