@extends('layout.layout')

@section('body_id', 'subscription_pricing')

@section('content')

<div class="container">
    
    @include('layout.alerts')

    @if(session('limit_reached'))
        <p class="text-success text-center">{{ session('limit_reached') }}</p>
    @endif

    <div class="row">
            @forelse ($prices as $price)
                @if($loop->first)
                    <div class="col-3">
                        <div class="text-center">{{ __('Gratuit') }}</div>
                        <div class="text-center fw-bold">0 €</div>
                    </div>
                @endif
                <form class="col-3" method="POST" action="{{ route('subscription.pricing') }}">
                    @csrf
                    <input type="hidden" name="stripe_id" value="{{ $price->id }}">
                    <div class="text-center">{{ $price->nickname }}</div>
                    <div class="text-center fw-bold">{{ $price->unit_amount / 100 }} €</div>
                    <button type="submit" class="btn btn-primary w-100">{{ __('Continue') }}</button>
                </form>
            @empty
            <div class="col">
                <p class="text-center">No new users for the moment</p>
              </div>
            @endforelse
    </div>
    
</div>
    
@endsection