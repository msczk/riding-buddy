@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>{{ $user->username }}@if(!empty($user->birthday)) ({{ $user->getAge() }})@endif</h1>
            <p>{{ nl2br($user->description) }}</p>
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
</div>
    
@endsection