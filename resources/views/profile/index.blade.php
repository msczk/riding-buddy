@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <a href="{{ route('profile.edit') }}" class="col-3 text-center">
            Mon compte
        </a>
        <a href="{{ route('profile.trips') }}" class="col-3 text-center">
            Mes voyages
        </a>
        <a href="#" class="col-3 text-center">
            Mes abonnements
        </a>
    </div>
</div>
    
@endsection