<?php

namespace App\Livewire\Trip;

use Carbon\Carbon;
use App\Models\Trip;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class MultistepFormTripAdd extends Component
{
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


    public function mount()
    {
        $this->currentStep = 1;
    }

    public function render()
    {
        return view('components.livewire.trip.multistep')->with('edit', false);
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
            $today = Carbon::now()->startOfDay();

            $two_days_from_now = $today->addDays(2);

            $this->validate([
                'start_at' => 'required|date|date_format:Y-m-d\TH:i|after:' . $two_days_from_now,
                'distance' => 'required|numeric|min:1',
                'duration' => 'required|numeric|min:1',
                'level' => 'required',
                'max_participants' => 'required|numeric|min:2'
            ]);
        }
    }

    public function store()
    {
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
            'start_at' => $this->start_at,
            'coordinates_start_lat' => $this->coordinates_start_lat,
            'coordinates_start_long' => $this->coordinates_start_long,
            'distance' => $this->distance,
            'duration' => $this->duration,
            'level' => $this->level,
            'max_participants' => $this->max_participants,
            'user_id' => $user->id,
            'slug' => Str::slug($this->name, '-', App::currentLocale()) . '-' . time()
        );

        $trip = Trip::create($trip_data);

        $trip->findCountry();
        $trip->findCity();

        $trip->save();

        $trip->users()->attach($user);

        $trip->users()->updateExistingPivot($user, ['approved' => true]);

        return to_route('trip.show', $trip)->with('success', __('Trip created successfully!'));
    }
}
