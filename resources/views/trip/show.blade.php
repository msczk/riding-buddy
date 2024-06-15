@extends('layout.layout')

@section('body_id', 'trip_show')

@section('javascript')
<script>
    var coordinates_start = "{{$trip->coordinates_start}}";
</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div id="show-trip-map"></div>
        </div>
    </div>
    <div class="row mt-2">
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