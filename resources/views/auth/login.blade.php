@extends('layout.layout')

@section('body_id', 'login')

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-md-4 offset-md-4">
            @include('layout.alerts')
            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-sem">{{ __('Email address') }}</label>
                    <input name="email" value="{{ old('email') }}" type="email" class="form-control @error('email') is-invalid @enderror" id="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-sem">{{ __('Password') }}</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label fw-sem" for="remember">{{ __('Stay logged in') }}</label>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Sign-in') }}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <a class="text-muted small" href="{{ route('password.forgot') }}">{{ __('Forgot password') }}</a>
        </div>
        <div class="col d-flex justify-content-end">
            <a class="text-muted small" href="{{ route('auth.register') }}">{{ __('Sign-up') }}</a>
        </div>
    </div>
</div>
    
@endsection