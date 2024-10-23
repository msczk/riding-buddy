@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="h5">{{ __('Edit a bike') }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @include('layout.alerts')
        </div>
        <div class="col offset-lg-4 col-lg-4">
            <form id="profile_edit_form" method="POST" action="{{ route('bike.edit', $bike) }}">
                @csrf
                @method('put')
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Brand') }}" name="brand" required value="{{ old('brand') ?? $bike->brand }}" type="text" class="form-control @error('brand') is-invalid @enderror" id="brand">
                    
                    <label for="brand">{{ __('Brand') }}</label>
                    
                    @error('brand')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Model') }}" name="model" required value="{{ old('model') ?? $bike->model }}" type="text" class="form-control @error('model') is-invalid @enderror" id="model">
                    
                    <label for="model">{{ __('Model') }}</label>
                    
                    @error('model')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-floating">
                        <input placeholder="{{ __('Cylinder') }}" required name="cylinder" value="{{ old('cylinder') ?? $bike->cylinder }}" type="text" class="form-control @error('cylinder') is-invalid @enderror" id="cylinder">
                        
                        <label for="cylinder">{{ __('Cylinder') }}</label>
                        @error('cylinder')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                </div>
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Year') }}" name="year" required value="{{ old('year') ?? $bike->year }}" type="number" class="form-control @error('year') is-invalid @enderror" id="year">
                    
                    <label for="year">{{ __('Year') }}</label>
                    
                    @error('year')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="text-center ">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
    
@endsection