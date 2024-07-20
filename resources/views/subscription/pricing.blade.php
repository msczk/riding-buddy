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
                        <div class="text-center">{{ __('Free') }}</div>
                        <div class="text-center fw-bold">0 €</div>
                    </div>
                @endif
                <form class="col-3" method="POST" action="{{ route('subscription.pricing') }}">
                    @csrf
                    <input type="hidden" name="stripe_id" value="{{ $price->id }}">
                    <div class="text-center">{{ $price->nickname }}</div>
                    <div class="text-center fw-bold">{{ $price->unit_amount / 100 }} €</div>
                    <div class="text-center">
                        @if(!empty($price->metadata->create_trips))
                            - {{ __(':amount trip creation per month', ['amount' => $price->metadata->create_trips]) }}
                        @endif
                    </div>
                    <div class="text-center">
                        @if(!empty($price->metadata->create_trips))
                            - {{ __(':amount trip participation per month', ['amount' => $price->metadata->create_trips]) }}
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary w-100">{{ __('Continue') }}</button>
                </form>
            @empty
            <div class="col">
                <p class="text-center">{{ __('No plan to display for the moment') }}</p>
              </div>
            @endforelse
    </div>
    
</div>
    
@endsection