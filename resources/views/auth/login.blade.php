@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4 offset-4 ">
            @include('layout.alerts')
            <form method="POST" action="{{ route('auth.login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email address') }}</label>
                    <input name="email" value="{{ old('email') }}" type="email" class="form-control @error('email') is-invalid @enderror" id="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input name="password" type="password" class="form-control" id="password">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label class="form-check-label" for="remember">{{ __('Stay logged in') }}</label>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
                </div>
                <div class="text-center">
                    <a class="text-muted" href="{{ route('password.forgot') }}">{{ __('Forgot password ?') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
    
@endsection