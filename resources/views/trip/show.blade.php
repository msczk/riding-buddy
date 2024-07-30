@extends('layout.layout')

@section('body_id', 'trip_show')

@section('javascript')
<script>
    var coordinates_start = "{{$trip->coordinates_start}}";
</script>
@endsection

@section('content')

<div class="container">
    @include('layout.alerts')
</div>
        
<div class="container">
    <div class="row mt-2">
        <div class="col-8">
            <a class="text-decoration-none text-primary" href="{{ route('home') }}">
                <i class="fa fa-chevron-left"></i>
            </a>
        </div>
        <div class="col d-flex justify-content-between">
            <a data-copy="{{ route('trip.show', $trip->id) }}" class="text-decoration-none text-primary copyClipBoard" href="javascript:void(0)">
                <i class="text-primary fa fa-link"></i>
            </a>
            <a class="text-decoration-none text-primary" href="#">
                <i class="fa fa-download"></i>
            </a>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <h1>{{ $trip->name }}</h1>
            <h2>{{ date_format($trip->start_at, 'l jS F Y h:i') }}</h2>
            <p>
                <span class="fw-bold">{{ __('About this trip :') }}</span><br>
                {!! nl2br(e($trip->description)) !!}
            </p>
            <div class="py-2">
                <img width="50px" height="50px" class="rounded-circle" src="https://placehold.co/300x300" alt="{{ $trip->user->username }}"> <a href="{{ route('profile.show', $trip->user->id) }}">{{ $trip->user->username }}</a>
            </div>
        </div>
    </div>

    <div class="row bg-dark text-light">
        <div class="col-6 text-center">
            {{ $trip->distance }} {{ __('km') }}
        </div>
        <div class="col-6 text-center">
            {{ $trip->duration }} {{ __('h') }}
        </div>
        <div class="col-6 text-center">
            {{ $trip->getLevelLabel() }}
        </div>
        <div class="col-6 text-center ">
            {{ $trip->users->count() }} / {{ $trip->max_participants }}
        </div>
    </div>
</div>

<div id="show-trip-map"></div>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>{{ __('Participants') }}</h1>
        </div>
    </div>
    <div class="row">
        @forelse ($trip->users as $user)
            <x-Profile.ProfileThumbnail :user=$user />
        @empty
            <div class="col">
                <p class="text-center">{{ __('No new users for the moment') }}</p>
            </div>
        @endforelse
    </div>
</div>    

@if(!Auth::user() || (Auth::user() && $trip->user_id != Auth::user()->id))
    @if(!$trip->isOver() && !$trip->isOneDayAway())
        <div class="participation-bar-fixed d-flex flex-column">
            <form class="text-center my-auto px-2" method="POST" action="{{ route('trip.participate', $trip) }}">
                @csrf
                @method('put')

                @if($trip->users->contains(Auth::user()))
                    <button class="btn btn-primary w-100">{{ __('Remove participation') }}</button>
                @else
                    <button class="btn btn-primary w-100">{{ __('Participate') }}</button>
                @endif
            </form>
        </div>
    @endif
@endif


    
@endsection