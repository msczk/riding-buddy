<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

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
    public function trips(): HasMany
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
        if(!empty($this->birthday))
        {
            return Carbon::parse($this->birthday)->age.' '.__('ans');
        }

        return '';
    }
}
