<?php

namespace App\Livewire\Trip;

use App\Models\Trip;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class MultistepFormTripEdit extends Component
{
    public Trip $trip;

    public string $name = '';
    public string $description = '';
    public string $start_at;
    public ?string $coordinates_start_lat = null;
    public ?string $coordinates_start_long = null;
    public int $distance = 0;
    public string $duration = '';
    public int $level = 1;
    public int $max_participants = 2;

    public $totalSteps = 3;
    public $currentStep = 1;

    public function mount(Trip $trip)
    {
        $this->trip = $trip;

        $this->name = $trip->name;
        $this->description = $trip->description;
        $this->start_at = $trip->start_at->format('Y-m-d H:i:s');
        $this->coordinates_start_lat = $trip->coordinates_start_lat;
        $this->coordinates_start_long = $trip->coordinates_start_long;
        $this->distance = $trip->distance;
        $this->duration = $trip->duration;
        $this->level = $trip->level;
        $this->max_participants = $trip->max_participants;

        $this->currentStep = 1;
    }

    public function render()
    {
        return view('components.livewire.trip.multistep')->with('edit', true);
    }

    public function increaseStep()
    {
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if ($this->currentStep > $this->totalSteps) {
            $this->currentStep = $this->totalSteps;
        }
    }

    public function decreaseStep()
    {
        $this->resetErrorBag();
        $this->currentStep--;
        if ($this->currentStep < 1) {
            $this->currentStep = 1;
        }
    }

    public function validateData()
    {
        if ($this->currentStep == 1) {
            $this->validate([
                'name' => 'required',
                'description' => 'required'
            ]);
        } elseif ($this->currentStep == 2) {
            $min = $this->trip->users()->count();

            if ($min < 2) {
                $min = 2;
            }

            $this->validate([
                'distance' => 'required|numeric|min:1',
                'duration' => 'required|numeric|min:1',
                'level' => 'required',
                'max_participants' => 'required|numeric|min:' . $min,
            ]);
        }
    }

    public function update()
    {
        if (Auth::user() && $this->trip->user_id != Auth::user()->id) {
            return back()->with('error', __('This trip does not belong to you'));
        }

        if ($this->trip->isOver()) {
            return back()->with('error', __('This trip is already over and cannot be modified'));
        }

        if ($this->trip->isOneDayAway()) {
            return back()->with('error', __('This trip will start soon and cannot be modified'));
        }

        $this->resetErrorBag();
        if ($this->currentStep == 3) {
            $this->validate([
                'coordinates_start_long' => 'required',
                'coordinates_start_lat' => 'required'
            ]);
        }

        /** @var \App\Models\User */
        $user = Auth::user();

        $trip_data = array(
            'name' => $this->name,
            'description' => $this->description,
            'coordinates_start_lat' => $this->coordinates_start_lat,
            'coordinates_start_long' => $this->coordinates_start_long,
            'distance' => $this->distance,
            'duration' => $this->duration,
            'level' => $this->level,
            'max_participants' => $this->max_participants,
            'user_id' => $user->id,
            'slug' => Str::slug($this->name, '-', App::currentLocale()) . '-' . time()
        );

        $this->trip->update($trip_data);

        $this->trip->findCountry();
        $this->trip->findCity();

        $this->trip->update();

        return to_route('trip.show', $this->trip)->with('success', __('Trip updated successfully!'));
    }
}
