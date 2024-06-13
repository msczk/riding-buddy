@extends('layout.layout')

@section('content')
<div class="container">
   @include('layout.alerts')
    <div class="row">
        @forelse ($trips as $trip)
              <x-Trip.TripThumbnail :trip=$trip :showEdit=true />
            @empty
              <div class="col">
                <p class="text-center">No trips for the moment</p>
              </div>
            @endforelse
    </div>
</div>
    
@endsection