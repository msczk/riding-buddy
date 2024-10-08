@extends('layout.layout')

@section('content')
    <div class="container">
        <div class="row mt-2 d-md-none">
            <div class="col">
                <a class="text-decoration-none text-primary" href="{{ (Auth::user() && Auth::user()->id == $user->id) ? route('profile.index') : route('home') }}">
                    <i class="fa fa-chevron-left"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1>{{ $user->username }}@if(!empty($user->birthday)) ({{ $user->getAge() }})@endif</h1>
                <p>{!! nl2br(e($user->description)) !!}</p>
            </div>
        </div>
        <div class="row mt-2">
            <h2>{{ __('His coming trips') }}</h2>
            @forelse ($coming_trips as $trip)
                <x-Trip.TripThumbnail :trip=$trip />
            @empty
                <div class="col">
                <p class="text-center">{{ __('No trips for the moment') }}</p>
                </div>
            @endforelse
        </div>
        <div class="row mt-2">
            <h2>{{ __('His past trips') }}</h2>
            @forelse ($past_trips as $trip)
            <x-Trip.TripThumbnail :trip=$trip />
            @empty
            <div class="col">
                <p class="text-center">{{ __('No trips for the moment') }}</p>
            </div>
            @endforelse
        </div>
        @if (!$user->bikes->isEmpty())
            <div class="row">
                <h2>{{ __('His bikes') }}</h2>
                @foreach ($user->bikes as $bike)
                    <x-Bike.BikeThumbnail :bike=$bike />
                @endforeach
            </div>
        @endif
    </div>
@endsection