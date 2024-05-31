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
            <h1>{{ $trip->name }} - Démarre le {{ date_format($trip->start_at, 'd-m-Y') }}</h1>
            <div>
                By {{ $trip->user->username }}
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