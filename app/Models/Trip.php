<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Config;

class Trip extends Model
{
    use HasFactory;

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
}
