@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row mt-2">
        <div class="col">
            <a class="text-decoration-none text-primary" href="{{ route('profile.bikes') }}">
                <i class="fa fa-chevron-left"></i>
            </a>
        </div>
    </div>
    <div class="row">
        @include('layout.alerts')
        <div class="col offset-lg-4 col-lg-4">
            <form id="profile_edit_form" method="POST" action="{{ route('bike.edit', $bike) }}">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="brand" class="form-label">{{ __('Brand') }}</label>
                    <input name="brand" value="{{ old('brand') ?? $bike->brand }}" type="text" class="form-control @error('brand') is-invalid @enderror" id="brand">
                    @error('brand')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="model" class="form-label">{{ __('Model') }}</label>
                    <input name="model" value="{{ old('model') ?? $bike->model }}" type="text" class="form-control @error('model') is-invalid @enderror" id="model">
                    @error('model')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="cylinder" class="form-label">{{ __('Cylinder') }}</label>
                    <div class="input-group">
                        <input required name="cylinder" value="{{ old('cylinder') ?? $bike->cylinder }}" type="number" min="1" class="form-control @error('cylinder') is-invalid @enderror" id="cylinder">
                        <span class="input-group-text">{{ __('cc') }}</span>
                        @error('cylinder')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">{{ __('Year') }}</label>
                    <input name="year" value="{{ old('year') ?? $bike->year }}" type="number" class="form-control @error('year') is-invalid @enderror" id="year">
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