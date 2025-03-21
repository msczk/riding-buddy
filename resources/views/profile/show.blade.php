@extends('layout.layout')

@section('body_id', 'biker_profile')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3 d-flex align-items-center">
                <x-Common.GoBack />
            </div>
            <div class="col-6 d-flex align-items-center justify-content-center">
                <h1 class="heading-title">{{ __('Biker profile') }}</h1>
            </div>
        </div>
    </div>
    <div id="block-avatar-public">
        <img width="500px" height="500px" class="img-fluid" src="{{ Vite::asset('resources/images/avatar/user-avatar.jpg') }}">
    </div>
    <div id="block-user-info" class="container">
        <div class="row">
            <div class="col">
                <h2 class="text-dark">{{ $user->username }}</h1>
                <div class="small mid-neutral-n80">{{ __('Member since :date', ['date' => date_format($user->created_at, __('d/m/Y'))]) }}</div>
            </div>
        </div>
    </div>
    <div class="container" id="block-user-rate-riding">
        <div class="row">
            <div class="col-4 text-center">{{ $user->riding_level }}</div>
            <div class="col-4 text-center">{{ $user->riding_level }}</div>
            <div class="col-4 text-center">{{ $user->getRating() }}</div>
        </div>
    </div>
    <div id="block-user-more-info" class="container">
        <div class="row description">
            <div class="col">
                <div class="more-info-title">
                    {{ _('Description') }}
                </div>
                <div class="more-info-content">
                    {!! nl2br(e($user->description)) !!}
                </div>
            </div>
        </div>
        <div class="row location">
            <div class="col">
                <div class="more-info-title">
                    {{ __('Location') }}
                </div>
                <div class="more-info-content">
                   {{ ($user->location ? : __('Unknown')) }}
                </div>
            </div>
        </div>
        @if(!$coming_trips->isEmpty())
            <div class="row trips">
                <div class="col">
                    <div class="more-info-title">
                        {{ __('His coming trips') }}
                    </div>
                    <div id="coming-trips" class="row">
                        @foreach ($coming_trips as $trip)
                            @livewire('trip.thumbnail', ['trip' => $trip])
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        @if (!$user->bikes->isEmpty())
            <div class="row bikes">
                <div class="col">
                    <div class="more-info-title">
                        {{ __('His bikes') }}
                    </div>
                    <div id="bikes-profil" class="row">
                        @foreach ($user->bikes as $bike)
                            <x-Bike.BikeThumbnail :bike=$bike />
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection