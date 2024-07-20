@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <a href="{{ route('profile.edit') }}" class="col-3 text-center">
            {{ __('My account') }}
        </a>
        <a href="{{ route('profile.trips') }}" class="col-3 text-center">
            {{ __('My trips') }}
        </a>
        <a href="{{ route('profile.invoices') }}" class="col-3 text-center">
            {{ __('My invoices') }}
        </a>
    </div>
</div>
    
@endsection