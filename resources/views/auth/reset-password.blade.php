@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="h5">{{ __('Reset password') }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col col-lg-4 offset-lg-4">
            @include('layout.alerts')
            <form class="my-2" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3 form-floating">
                    <label for="email">{{ __('Email address') }}</label>
                    <input placeholder="{{ __('Email address') }}" name="email" value="{{ old('email') }}" type="email" class="form-control @error('email') is-invalid @enderror" id="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Password') }}" name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password">
                    
                    <label for="password">{{ __('Password') }}</label>
                    
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Password confirmation') }}" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation">
                    
                    <label for="password_confirmation" class="form-label">{{ __('Password confirmation') }}</label>
                    
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="text-center ">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Reset') }}</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
    
@endsection