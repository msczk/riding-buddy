@extends('layout.layout')

@section('content')
<div class="container">
  <div class="row mt-2">
      <div class="col">
          <a class="text-decoration-none text-primary" href="{{ route('profile.index') }}">
              <i class="fa fa-chevron-left"></i>
          </a>
      </div>
  </div>
   @include('layout.alerts')
    <div class="row mt-2">
      <h2>{{ __('My coming trips') }}</h2>
      @forelse ($coming_trips as $trip)
        <x-Trip.TripThumbnail :trip=$trip :showEdit=true :showTrash=true />
      @empty
        <div class="col">
          <p class="text-center">{{ __('No trips for the moment') }}</p>
        </div>
      @endforelse
   </div>
   <div class="row mt-2">
    <h2>{{ __('My past trips') }}</h2>
    @forelse ($past_trips as $trip)
      <x-Trip.TripThumbnail :trip=$trip :showEdit=true :showTrash=true />
    @empty
      <div class="col">
        <p class="text-center">{{ __('No trips for the moment') }}</p>
      </div>
    @endforelse
 </div>
</div>
    
@endsection