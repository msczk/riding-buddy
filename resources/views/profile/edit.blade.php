@extends('layout.layout')

@section('body_id', 'profile_edit')

@section('content')
<div class="container">
    <div class="row mt-2">
        <div class="col">
            <a class="text-decoration-none text-primary" href="{{ route('profile.index') }}">
                <i class="fa fa-chevron-left"></i>
            </a>
        </div>
    </div>
    <div class="row">
        @include('layout.alerts')
        <div class="col offset-lg-4 col-lg-4">
            <form id="profile_edit_form" method="POST" action="{{ route('profile.edit') }}">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">{{ __('Username') }}</label>
                    <input name="username" value="{{ $user->username }}" type="text" class="form-control disabled" disabled id="username">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email address') }}</label>
                    <input name="email" value="{{ $user->email }}" type="text" class="form-control disabled" disabled id="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="firstname" class="form-label">{{ __('Firstname') }}</label>
                    <input name="firstname" value="{{ $user->firstname }}" type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname">
                    @error('firstname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">{{ __('Lastname') }}</label>
                    <input name="lastname" value="{{ $user->lastname }}" type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname">
                    @error('lastname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="riding_level" class="form-label">{{ __('Experience') }}</label>
                    <select name="riding_level" class="form-select @error('riding_level') is-invalid @enderror" id="riding_level">
                        @foreach (Config::get('app.riding_levels') as $label => $value)
                            <option @if($user->riding_level == $value) selected @endif value="{{ $value }}">{{ __($label) }}</option>
                        @endforeach
                    </select>
                    @error('riding_level')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="bike" class="form-label">{{ __('My bike type') }}</label>
                    <select name="bike" class="form-select @error('bike') is-invalid @enderror" id="bike">
                        @foreach (Config::get('app.bikes') as $label => $value)
                            <option @if($user->bike == $value) selected @endif value="{{ $value }}">{{ __($label) }}</option>
                        @endforeach
                    </select>
                    @error('riding_level')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Description') }}</label>
                    <textarea rows="5" name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ $user->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">{{ __('Birthday') }}</label>
                    <input name="birthday" @if(isset($user->birthday) && !empty($user->birthday)) value="{{ $user->birthday->format('Y-m-d') }}" @endif type="date" class="form-control @error('birthday') is-invalid @enderror" id="birthday">
                    @error('birthday')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-check">
                    <input @if($user->optin_newsletter) checked @endif type="checkbox" class="form-check-input @error('optin_newsletter') is-invalid @enderror" name="optin_newsletter" id="optin_newsletter">
                    <label class="form-check-label" for="optin_newsletter">Recevoir la newsletter</label>
                    @error('optin_newsletter')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="text-center ">
                    <button type="submit" class="btn btn-primary w-100">{{ __('Save') }}</button>
                </div>
            </form>
            @if (auth()->user()->subscribed())
                @if (auth()->user()->subscription('default')->onGracePeriod())
                    <p class="text-center mt-2">{{ __('Your subscription will end on :end',['end' => auth()->user()->subscription('default')->ends_at->format('d/m/Y')]) }}</p>
                @else
                    <form action="{{ route('subscription.cancel') }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger">{{ __('Cancel my subscription') }}</button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</div>
    
@endsection