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

    <div class="row">
        <div class="col">
            <div id="show-trip-map"></div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <h1>{{ $trip->name }} - {{ __('Starts at :date :time', ['date' => date_format($trip->start_at, 'd-m-Y'), 'time' => date_format($trip->start_at, 'H:i')]) }}</h1>
            <div>
                {{ __('By') }} <a href="{{ route('profile.show', $trip->user->id) }}">{{ $trip->user->username }}</a>
            </div>
            <p>
                {{ $trip->description }}
            </p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3 text-center">
            {{ $trip->distance }} {{ __('km') }}
        </div>
        <div class="col-md-3 text-center">
            {{ $trip->duration }} {{ __('h') }}
        </div>
        <div class="col-md-3 text-center">
            {{ $trip->getLevelLabel() }}
        </div>
        <div class="col-md-3 text-center ">
            {{ $trip->users->count() }} / {{ $trip->max_participants }}
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            @if(Auth::user() && $trip->user_id != Auth::user()->id)
                @if(!$trip->isOver() && !$trip->isOneDayAway())
                    <form method="POST" action="{{ route('trip.participate', $trip) }}">
                        @csrf
                        @method('put')

                        @if($trip->users->contains(Auth::user()))
                            <button class="btn btn-outline-primary">{{ __('Remove participation') }}</button>
                        @else
                            <button class="btn btn-outline-primary">{{ __('Participate') }}</button>
                        @endif
                    </form>
                @endif
            @endif
        </div>
    </div>
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
    
@endsection