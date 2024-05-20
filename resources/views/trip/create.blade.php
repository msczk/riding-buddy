@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4 offset-4 ">
            <form method="POST" action="{{ route('trip.create') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input name="name" value="{{ old('name') }}" type="text" class="form-control @error('name') is-invalid @enderror" id="name">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="start_at" class="form-label">Start at</label>
                    <input name="start_at" value="{{ old('start_at') }}" type="date" class="form-control @error('start_at') is-invalid @enderror" id="start_at">
                    @error('start_at')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="x_start" class="form-label">Start X</label>
                    <input name="x_start" value="{{ old('x_start') }}" type="text" class="form-control @error('x_start') is-invalid @enderror" id="x_start">
                    @error('x_start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="y_start" class="form-label">Start Y</label>
                    <input name="y_start" value="{{ old('y_start') }}" type="text" class="form-control @error('y_start') is-invalid @enderror" id="y_start">
                    @error('y_start')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="distance" class="form-label">Distance</label>
                    <input name="distance" value="{{ old('distance') }}" type="number" class="form-control @error('distance') is-invalid @enderror" id="distance">
                    @error('distance')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <input name="duration" value="{{ old('duration') }}" type="number" class="form-control @error('duration') is-invalid @enderror" id="duration">
                    @error('duration')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select name="level" class="form-select @error('level') is-invalid @enderror" id="level">
                        <option {{ old('level') == 1 ?? 'selected' }} value="1">Easy</option>
                        <option {{ old('level') == 2 ?? 'selected' }} value="2">Medium</option>
                        <option {{ old('level') == 3 ?? 'selected' }} value="3">Hard</option>
                    </select>
                    @error('level')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="max_participants" class="form-label">Max participants</label>
                    <input name="max_participants" value="{{ old('max_participants') }}" type="number" class="form-control @error('max_participants') is-invalid @enderror" id="max_participants">
                    @error('max_participants')
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