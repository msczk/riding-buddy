@extends('layout.layout')

@section('body_id', 'search')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{ __('Search for a trip') }}</h1>
                {{-- <x-Trip.SearchBar :place=$place :radius=$radius :lat=$lat :long=$long :full=true /> --}}
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <h2>{{ __('Results') }}</h1>
            </div>
        </div>
        <div class="row">
            @forelse ($trips as $trip)
              <x-Trip.TripThumbnail :trip=$trip />
            @empty
              <div class="col">
                <p class="text-center">{{ __('No trips for the moment') }}</p>
              </div>
            @endforelse
        </div>
    </div>
@endsection