@extends('layout.layout')

@section('body_id', 'registration')

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-lg-4 offset-lg-4">
            <h1 class="heading-title">{{ __('Let\'s get started') }}</h1>
            <p class="small mid-neutral-n80">{{ __('Before we start, we need a few information.') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-4 offset-lg-4">
            <form class="my-2" method="POST" action="{{ route('auth.register') }}">
                @csrf
                <div class="form-floating mb-3">
                    <input placeholder="{{ __('Username') }}" required name="username" value="{{ old('username') }}" type="text" class="form-control @error('username') is-invalid @enderror" id="username">
                    
                    <label for="username">{{ __('Username') }}</label>
                    
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input placeholder="{{ __('Email address') }}" required name="email" value="{{ old('email') }}" type="email" class="form-control @error('email') is-invalid @enderror" id="email">
                    
                    <label for="email">{{ __('Email address') }}</label>
                    
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input placeholder="{{ __('Password') }}" required name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password">
                    
                    <label for="password">{{ __('Password') }}</label>
                    
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input required placeholder="{{ __('Password confirmation') }}" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">
                    
                    <label for="password_confirmation">{{ __('Password confirmation') }}</label>
                    
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="optin_newsletter" id="optin_newsletter">
                    <label class="form-check-label fw-semibold" for="optin_newsletter">{{ __('Subscribe to newsletter') }}</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="cgu" id="cgu">
                    <label class="form-check-label fw-semibold  @error('cgu') is-invalid @enderror" for="cgu">{{ __('I accept the terms and conditions') }}</label>
                    @error('cgu')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="text-center ">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Sign-up') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col text-center">
            <span class="mid-neutral-n80 small">{{ __('Already have an acccount ?') }}</span> <a class="text-muted small" href="{{ route('auth.login') }}">{{ __('Sign-in') }}</a>
        </div>
    </div>
</div>
    
@endsection