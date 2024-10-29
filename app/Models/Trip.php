<?php

namespace App\Models;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

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
        'coordinates_start_lat',
        'coordinates_start_long',
        'distance',
        'duration',
        'level',
        'max_participants',
        'public_after_over',
        'slug',
        'country',
        'city'
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
     * Get the users associated to the trip
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('rate');
    }


    /**
     * Get the users that are approved for the trip
     *
     * @return BelongsToMany
     */
    public function approvedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->where('approved', 1)->withPivot('rate');
    }

    /**
     * Return the label that corresponds to the level based on the number stored
     *
     * @return string
     */
    public function getLevelLabel(): string
    {
        foreach (Config::get('app.riding_levels') as $label => $value) {
            if ($this->level == $value) {
                return __($label);
            }
        }

        return _('unknown');
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

    /**
     * Generate random coordinates close to the starting location of the trip
     *
     * @param integer $radius
     * @return array [lat, long]
     */
    public function generateCloseCoordinates(int $radius): array
    {
        $radius_earth = 6371; //kms

        //Pick random distance within $distance;
        $distance = lcg_value() * $radius;

        //Convert degrees to radians.
        $centre_rads = array_map('deg2rad', [$this->coordinates_start_lat, $this->coordinates_start_long]);

        //First suppose our point is the north pole.
        //Find a random point $distance miles away
        $lat_rads = (pi() / 2) -  $distance / $radius_earth;
        $lng_rads = lcg_value() * 2 * pi();


        //($lat_rads,$lng_rads) is a point on the circle which is
        //$distance miles from the north pole. Convert to Cartesian
        $x1 = cos($lat_rads) * sin($lng_rads);
        $y1 = cos($lat_rads) * cos($lng_rads);
        $z1 = sin($lat_rads);


        //Rotate that sphere so that the north pole is now at $centre.

        //Rotate in x axis by $rot = (pi()/2) - $centre_rads[0];
        $rot = (pi() / 2) - $centre_rads[0];
        $x2 = $x1;
        $y2 = $y1 * cos($rot) + $z1 * sin($rot);
        $z2 = -$y1 * sin($rot) + $z1 * cos($rot);

        //Rotate in z axis by $rot = $centre_rads[1]
        $rot = $centre_rads[1];
        $x3 = $x2 * cos($rot) + $y2 * sin($rot);
        $y3 = -$x2 * sin($rot) + $y2 * cos($rot);
        $z3 = $z2;


        //Finally convert this point to polar co-ords
        $lng_rads = atan2($x3, $y3);
        $lat_rads = asin($z3);

        return array_map('rad2deg', array($lat_rads, $lng_rads));
    }

    /**
     * Call Maptiler API and set the country
     *
     * @return self
     */
    public function findCountry(): self
    {
        $country = '';

        if (App::environment('local')) {
            $client = new Client(['verify' => base_path('cacert.pem')]);
        } else {
            $client = new Client();
        }

        try {
            $res = $client->request('GET', 'https://api.maptiler.com/geocoding/' . $this->coordinates_start_long . ',' . $this->coordinates_start_lat . '.json', [
                'query' => [
                    'key' => env('MAPTILER_API_KEY'),
                    'types' => 'country',
                    'language' => 'fr'
                ]
            ]);
        } catch (ClientException $e) {
            Log::alert(Psr7\Message::toString($e->getRequest()));
            Log::alert(Psr7\Message::toString($e->getResponse()));
        }

        $response = json_decode($res->getBody()->getContents(), true);

        if (isset($response['features'][0]['text_fr'])) {
            $country = $response['features'][0]['text_fr'];
        }

        $this->country = $country;

        return $this;
    }

    /**
     * Call Maptiler API and set the city
     *
     * @return self
     */
    public function findCity(): self
    {
        $city = '';

        if (App::environment('local')) {
            $client = new Client(['verify' => base_path('cacert.pem')]);
        } else {
            $client = new Client();
        }

        try {
            $res = $client->request('GET', 'https://api.maptiler.com/geocoding/' . $this->coordinates_start_long . ',' . $this->coordinates_start_lat . '.json', [
                'query' => [
                    'key' => env('MAPTILER_API_KEY'),
                    'types' => 'municipality',
                    'language' => 'fr'
                ]
            ]);
        } catch (ClientException $e) {
            Log::alert(Psr7\Message::toString($e->getRequest()));
            Log::alert(Psr7\Message::toString($e->getResponse()));
        }

        $response = json_decode($res->getBody()->getContents(), true);

        if (isset($response['features'][0]['text_fr'])) {
            $city = $response['features'][0]['text_fr'];
        }

        $this->city = $city;

        return $this;
    }
}
