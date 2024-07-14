@extends('layout.layout')

@section('body_id', 'subscription_pricing')

@section('content')

<div class="container">
    
    @include('layout.alerts')

    <div class="row">
        <div class="col">
            <p class="text-success">{{ __('Confirmation de votre abonnement') }}</p>
        </div>
    </div>
    
</div>
    
@endsection