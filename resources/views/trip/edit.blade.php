@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4 offset-4 ">
            
            @include('layout.alerts')

            <form method="POST" action="{{ route('trip.edit', $trip) }}">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input name="name" value="{{ old('name') ?? $trip->name }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ old('description') ?? $trip->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="start_at" class="form-label">Start at</label>
                    <input name="start_at" value="{{ old('start_at') ?? date_format($trip->start_at, 'Y-m-d') }}" type="date" class="form-control @error('start_at') is-invalid @enderror" id="start_at">
                    @error('start_at')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="distance" class="form-label">Distance</label>
                    <input name="distance" value="{{ old('distance') ?? $trip->distance }}" type="number" class="form-control @error('distance') is-invalid @enderror" id="distance">
                    @error('distance')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <input name="duration" value="{{ old('duration') ?? $trip->duration }}" type="number" class="form-control @error('duration') is-invalid @enderror" id="duration">
                    @error('duration')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select name="level" class="form-select @error('level') is-invalid @enderror" id="level">
                        @foreach (Config::get('app.riding_levels') as $label => $value)
                            <option @if($trip->level == $value) selected @endif  value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('level')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="max_participants" class="form-label">Max participants</label>
                    <input name="max_participants" value="{{ old('max_participants') ?? $trip->max_participants }}" type="number" class="form-control @error('max_participants') is-invalid @enderror" id="max_participants">
                    @error('max_participants')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div style="width: 100%; height: 300px;" id="new-trip-map"></div>
                    
                    <input name="coordinates_start" value="{{ old('coordinates_start') ?? $trip->coordinates_start }}" type="hidden" class="form-control @error('coordinates_start') is-invalid @enderror" id="coordinates_start">
                    @error('coordinates_start')
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