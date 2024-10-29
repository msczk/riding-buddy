@extends('layout.layout')

@section('body_id', 'forgot-password')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="heading-title">{{ __('Forgot password') }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-4 offset-lg-4">
            @include('layout.alerts')
            <form class="my-2" method="POST" action="{{ route('password.forgot') }}">
                @csrf
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Email address') }}" name="email" value="{{ old('email') }}" type="email" class="form-control @error('email') is-invalid @enderror" id="email">
                    
                    <label for="email">{{ __('Email address') }}</label>
                    
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="text-center ">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col text-center">
            <a class="mid-neutral-n80 small" href="{{ route('auth.login') }}">{{ __('Sign-in') }}</a>
        </div>
    </div>
</div>
    
@endsection