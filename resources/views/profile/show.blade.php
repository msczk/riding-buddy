@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1>{{ $user->username }}</h1>
            <p>{!! nl2br($user->description) !!}</p>
        </div>
    </div>
    <div class="row">
      @forelse ($trips as $trip)
            <x-Trip.TripThumbnail :trip=$trip />
          @empty
            <div class="col">
              <p class="text-center">No trips for the moment</p>
            </div>
          @endforelse
   </div>
</div>
    
@endsection