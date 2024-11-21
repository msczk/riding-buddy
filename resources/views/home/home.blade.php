@extends('layout.layout')

@section('body_id', 'home')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1>{{ __('Home') }}</h1>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                @livewire('search.search')
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1>{{ __('Coming trips') }}</h1>
            </div>
        </div>
        <div class="row">
            @forelse ($coming_trips as $coming_trip)
              <x-Trip.TripThumbnail :trip=$coming_trip />
            @empty
              <div class="col">
                <p class="text-center">{{ __('No coming trips for the moment') }}</p>
              </div>
            @endforelse
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{ __('New community members') }}</h1>
            </div>
        </div>
        <div class="row">
            @forelse ($last_users as $last_user)
            <x-Profile.ProfileThumbnail :user=$last_user />
            @empty
            <div class="col">
                <p class="text-center">{{ __('No new users for the moment') }}</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection