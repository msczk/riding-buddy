<?php

namespace App\Livewire\Search;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;

class Search extends Component
{
    public string $query = '';
    public int $radius = 10;
    public int $max_participants = 2;
    public float $lat = 0;
    public float $long = 0;
    public array $results = [];
    public bool $show_modal = false;

    public function mount(Request $request)
    {
        if (!empty($request->get('lat'))) {
            $this->lat = $request->get('lat');
        }

        if (!empty($request->get('long'))) {
            $this->long = $request->get('long');
        }

        if (!empty($request->get('radius'))) {
            $this->radius = $request->get('radius');
        }

        if (!empty($request->get('place'))) {
            $this->query = $request->get('place');
        }
    }

    public function boot()
    {
        $this->results = [];

        if ($this->query != '') {
            $this->findPlace();
        }
    }

    public function findPlace()
    {
        if (App::environment('local')) {
            $client = new Client(['verify' => base_path('cacert.pem')]);
        } else {
            $client = new Client();
        }

        try {
            $res = $client->request('GET', 'https://api.maptiler.com/geocoding/' . $this->query . '.json', [
                'query' => [
                    'key' => env('MAPTILER_API_KEY'),
                    'types' => 'locality,municipality',
                    'language' => 'fr'
                ]
            ]);
        } catch (ClientException $e) {
            Log::alert(Psr7\Message::toString($e->getRequest()));
            Log::alert(Psr7\Message::toString($e->getResponse()));

            return $this;
        }

        $response = json_decode($res->getBody()->getContents(), true);

        if (isset($response['features'])) {
            foreach ($response['features'] as $feature) {
                $this->results[] = [
                    'name' => $feature['place_name'],
                    'lat' => $feature['geometry']['coordinates'][1],
                    'long' => $feature['geometry']['coordinates'][0]
                ];
            }
        }

        return $this;
    }

    public function render()
    {
        return view('components.livewire.search.search');
    }

    public function search(float $lat, float $long)
    {
        $this->lat = $lat;
        $this->long = $long;
        return to_route('trip.search', ['place' => $this->query, 'lat' => $this->lat, 'long' => $this->long, 'radius' => $this->radius]);
    }

    public function showModal()
    {
        $this->show_modal = true;
    }

    public function hideModal()
    {
        $this->query = '';
        $this->results = [];
        $this->show_modal = false;
    }
}
