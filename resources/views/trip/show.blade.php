@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <img class="img-fluid " src="https://placehold.co/1920x500" alt="{{ $trip->name }}">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <h1>{{ $trip->name }} - Démarre le Le {{ date_format($trip->start_at, 'd-m-Y')  }} à {{ date_format($trip->start_at, 'H:i')  }}</h1>
            <div>
                By <a href="{{ route('profile.show', $trip->user->id) }}">{{ $trip->user->username }}</a>
            </div>
            <hr>
            <p>
                {{ $trip->description }}
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center ">
            {{ $trip->distance }} km
        </div>
        <div class="col-md-3 text-center ">
            {{ $trip->duration }} h
        </div>
        <div class="col-md-3 text-center ">
            {{ $trip->getLevelLabel() }}
        </div>
        <div class="col-md-3 text-center ">
            1 / {{ $trip->max_participants }}
        </div>
    </div>
</div>
    
@endsection