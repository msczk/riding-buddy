<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Trip extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'start_at',
        'coordinates_start',
        'distance',
        'duration',
        'level',
        'max_participants',
        'public_after_over'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'public_after_over' => 'boolean'
        ];
    }

    /**
     * Get the user that created the trip
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the users that will participate to the trip
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('rate');
    }

    /**
     * Return the label that corresponds to the level based on the number stored
     *
     * @return string
     */
    public function getLevelLabel() : string
    {
        foreach (Config::get('app.riding_levels') as $label => $value)
        {
            if($this->level == $value)
            {
                return $label;
            }
        }

        return 'unknown';
    }

    /**
     * Determine if a trip is over based on its start_at date
     *
     * @return boolean
     */
    public function isOver(): bool
    {
        return $this->start_at < now();
    }

    /**
     * Determine if a trip will start in 1 day or less
     *
     * @return float
     */
    public function isOneDayAway(): float
    {
        $date = Carbon::parse($this->start_at);
        $now = Carbon::now();
        $diff = $now->diffInDays($date);

        return $diff <= 1;
    }

    /**
     * Determine if trip has reach its participation limit
     *
     * @return boolean
     */
    public function isFull(): bool
    {
        return ($this->users()->count() >= $this->max_participants);
    }
}
