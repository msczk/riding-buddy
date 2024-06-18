@extends('layout.layout')

@section('content')
<div class="container">
   @include('layout.alerts')
    <div class="row mt-2">
      <h2>{{ __('My coming trips') }}</h2>
      @forelse ($coming_trips as $trip)
            <x-Trip.TripThumbnail :trip=$trip :showEdit=true :showTrash=true />
          @empty
            <div class="col">
              <p class="text-center">No trips for the moment</p>
            </div>
          @endforelse
   </div>
   <div class="row mt-2">
    <h2>{{ __('My past trips') }}</h2>
    @forelse ($past_trips as $trip)
          <x-Trip.TripThumbnail :trip=$trip :showEdit=true :showTrash=true />
        @empty
          <div class="col">
            <p class="text-center">No trips for the moment</p>
          </div>
        @endforelse
 </div>
</div>
    
@endsection