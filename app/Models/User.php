<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'description',
        'password',
        'firstname',
        'lastname',
        'optin_newsletter',
        'riding_level',
        'birthday',
        'bike',
        'slug'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birthday' => 'date',
            'password' => 'hashed',
            'optin_newsletter' => 'boolean',
        ];
    }

    /**
     * Get the trips that the user created
     *
     * @return HasMany
     */
    public function createdTrips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    /**
     * Get the trips that the user created ordered by the start date of the trip (nearest to farthest)
     *
     * @return HasMany
     */
    public function tripsByStartDate(): HasMany
    {
        return $this->hasMany(Trip::class)->orderBy('start_at', 'ASC');
    }

    /**
     * Get the age of the user if birthday field is not empty
     *
     * @return String
     */
    public function getAge(): String
    {
        if (!empty($this->birthday)) {
            return Carbon::parse($this->birthday)->age . ' ' . __('ans');
        }

        return '';
    }

    /**
     * Get the trips that the user will participate to
     *
     * @return BelongsToMany
     */
    public function trips(): BelongsToMany
    {
        return $this->belongsToMany(Trip::class)->withPivot(['rate', 'approved']);
    }

    /**
     * Determine if a user already rated a trip
     *
     * @param Trip $trip
     * @return boolean
     */
    public function hasRated(Trip $trip): bool
    {
        return !(empty($this->trips->find($trip->id)->pivot->rate));
    }

    /**
     * Return the allowed amount of trips the user can create based on his subscription
     *
     * @return integer
     */
    public function allowedAmountOfTripsCreation(): int
    {
        if ($this->subscribed()) {
            $subscription = $this->subscription()->asStripeSubscription();

            if (isset($subscription->plan->metadata->create_trips) && !empty($subscription->plan->metadata->create_trips)) {
                return $subscription->plan->metadata->create_trips;
            }
        }

        return Config::get('app.permissions.default.create_trips');
    }

    /**
     * Return the allowed amount of trips the user can participate to based on his subscription
     *
     * @return integer
     */
    public function allowedAmountOfTripsParticipation(): int
    {
        if ($this->subscribed()) {
            $subscription = $this->subscription()->asStripeSubscription();

            if (isset($subscription->plan->metadata->participate_trips) && !empty($subscription->plan->metadata->participate_trips)) {
                return $subscription->plan->metadata->participate_trips;
            }
        }

        return Config::get('app.permissions.default.participate_trips');
    }

    /**
     * Return if a user participates to a trip
     *
     * @param Trip $trip
     * @return boolean
     */
    public function participate(Trip $trip): bool
    {
        return $trip->users->contains($this);
    }

    /**
     * Return if a user participates and is approved for a trip
     *
     * @param Trip $trip
     * @return boolean
     */
    public function isApprovedForTrip(Trip $trip): bool
    {
        return $this->trips->find($trip->id)->pivot->approved;
    }

    /**
     * Get the user's bike(s)
     *
     * @return HasMany
     */
    public function bikes(): HasMany
    {
        return $this->hasMany(Bike::class);
    }
}
