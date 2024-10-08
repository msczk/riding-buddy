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
      <h2>{{ __('My garage') }}</h2>
      @if(!$bikes->isEmpty())
        <div class="row">
          @foreach ($bikes as $bike)
            @if ($loop->first)
            <a class="col-6 col-lg-3 text-decoration-none" href="{{ route('bike.create') }}">
              <div class="w-100 h-100 justify-content-center align-items-center d-flex bg-secondary-subtle">
                <i class="fa fa-plus fa-2x"></i>
              </div>
            </a>
            @endif
            <x-Bike.BikeThumbnail :bike=$bike :showEdit=true :showTrash=true />
          @endforeach
        </div>
      @else
        <div class="col text-center">
          <p>{{ __('No bikes for the moment') }}</p>
          <a class="btn btn-primary" href="{{ route('bike.create') }}">{{ __('Add a bike') }}</a>
        </div>
      @endif
   </div>
</div>
    
@endsection