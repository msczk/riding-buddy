<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLevelLabel() : string
    {
        switch($this->level)
        {
            case 1:
                return 'easy';
                break;

            case 2:
                return 'medium';
                break;

            case 3:
                return 'hard';
                break;

            default:
                return 'unknown';
                break;
        }
    }
}
