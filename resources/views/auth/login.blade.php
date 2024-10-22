@extends('layout.layout')

@section('body_id', 'login')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="h5">{{ __('Login') }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-4 offset-lg-4">
            @include('layout.alerts')
            <form class="my-2" method="POST" action="{{ route('auth.login') }}">
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
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Password') }}" name="password" type="password" class="form-control" id="password">
                    <label for="password">{{ __('Password') }}</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label fw-semibold" for="remember">{{ __('Stay logged in') }}</label>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Sign-in') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-8 col-md-6">
            <a class="mid-neutral-n80 small" href="{{ route('password.forgot') }}">{{ __('Forgot password') }}</a>
        </div>
        <div class="col-4 col-md-6 d-flex justify-content-end">
            <a class="mid-neutral-n80 small" href="{{ route('auth.register') }}">{{ __('Sign-up') }}</a>
        </div>
    </div>
</div>
    
@endsection