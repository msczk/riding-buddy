@extends('layout.layout')

@section('body_id', 'trip_add')

@section('content')
<div class="container">
    <div class="row">
        <div class="col col-md-4 offset-md-4 my-3">
            <form method="POST" action="{{ route('trip.create') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input required name="name" value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea rows="5" required name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="start_at" class="form-label">{{ __('Start at') }}</label>
                    <input min="{{ date('Y-m-d\T00:00', strtotime("+2 day")) }}" required name="start_at" value="{{ old('start_at') }}" type="datetime-local" class="form-control @error('start_at') is-invalid @enderror" id="start_at">
                    @error('start_at')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="distance" class="form-label">{{ __('Distance') }}</label>
                    <div class="input-group">
                        <input required name="distance" value="{{ old('distance') ?? 1 }}" type="number" min="1" class="form-control @error('distance') is-invalid @enderror" id="distance">
                        <span class="input-group-text" id="basic-addon2">{{ __('Kms') }}</span>
                        @error('distance')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">{{ __('Duration') }}</label>
                    <div class="input-group">
                        <input required name="duration" value="{{ old('duration') ?? 1 }}" min="1" type="number" class="form-control @error('duration') is-invalid @enderror" id="duration">
                        <span class="input-group-text" id="basic-addon2">{{ __('Hours') }}</span>
                        @error('duration')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">{{ __('Level') }}</label>
                    <select required name="level" class="form-select @error('level') is-invalid @enderror" id="level">
                        @foreach (Config::get('app.riding_levels') as $label => $value)
                            <option @if(old('level') == $value) selected @endif value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('level')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="max_participants" class="form-label">{{ __('Max participants') }}</label>
                    <input required name="max_participants" value="{{ old('max_participants') ?? 2 }}" type="number" min="2" class="form-control @error('max_participants') is-invalid @enderror" id="max_participants">
                    @error('max_participants')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div id="new-trip-map"></div>
                    
                    <input required name="coordinates_start" value="{{ old('coordinates_start') }}" type="hidden" class="form-control @error('coordinates_start') is-invalid @enderror" id="coordinates_start">
                    @error('coordinates_start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Submit') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
    
@endsection