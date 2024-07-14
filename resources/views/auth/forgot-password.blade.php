@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4 offset-4 ">
            @include('layout.alerts')
            <form method="POST" action="{{ route('password.forgot') }}">
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
                <div class="text-center ">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
    
@endsection