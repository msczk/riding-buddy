@extends('layout.layout')

@section('body_id', 'trip_add')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="heading-title">{{ __('Create a new trip') }}</h1>
        </div>
    </div>
    @livewire('trip.multistep-form-trip-add')
</div>
    
@endsection