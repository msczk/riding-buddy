<?php

namespace App\Livewire\Search;

use Livewire\Component;

class Search extends Component
{
    public string $query = '';
    public int $radius = 10;
    public int $max_participants = 2;
    public float $lat = 0;
    public float $long = 0;
    public array $results = [];

    public function render()
    {
        return view('components.livewire.search.search');
    }

    public function search()
    {
        return to_route('trip.search', ['query' => $this->query]);
    }

    public function toggleQueryModal()
    {
        $this->dispatch('toggleQueryModal');
    }
}
