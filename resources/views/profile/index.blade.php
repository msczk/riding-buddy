@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <a href="{{ route('profile.edit') }}" class="col-3 text-center">
            {{ __('Mon profile') }}
        </a>
        <a href="{{ route('profile.trips') }}" class="col-3 text-center">
            {{ __('Mes voyages') }}
        </a>
        <a href="{{ route('profile.invoices') }}" class="col-3 text-center">
            {{ __('Mes factures') }}
        </a>
    </div>
</div>
    
@endsection