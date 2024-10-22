@extends('layout.layout')

@section('body_id', 'profile_edit')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="h5">{{ __('Edit my profile') }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @include('layout.alerts')
        </div>
        
        <div class="col offset-lg-4 col-lg-4">
            <form id="profile_edit_form" method="POST" action="{{ route('profile.edit') }}">
                @method('put')
                @csrf
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Username') }}" name="username" value="{{ $user->username }}" type="text" class="form-control disabled" disabled id="username">
                    
                    <label for="username">{{ __('Username') }}</label>

                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Email address') }}" name="email" value="{{ $user->email }}" type="text" class="form-control disabled" disabled id="email">
                    
                    <label for="email">{{ __('Email address') }}</label>

                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Firstname') }}" name="firstname" value="{{ $user->firstname }}" type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname">
                    
                    <label for="firstname">{{ __('Firstname') }}</label>
                    
                    @error('firstname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3 form-floating">
                    <input placeholder="{{ __('Lastname') }}" name="lastname" value="{{ $user->lastname }}" type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname">
                    
                    <label for="lastname">{{ __('Lastname') }}</label>
                    
                    @error('lastname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="riding_level" class="form-label fw-semibold">{{ __('Experience') }}</label>
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
                    <label for="bike" class="form-label fw-semibold">{{ __('My bike type') }}</label>
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
                <div class="mb-3 form-floating">
                    <textarea placeholder="{{ __('Description') }}" rows="5" name="description" class="form-control @error('description') is-invalid @enderror" id="description">{{ $user->description }}</textarea>
                    
                    <label for="description">{{ __('Description') }}</label>
                    
                    @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label fw-semibold">{{ __('Birthday') }}</label>
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