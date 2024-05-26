@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4 offset-4 ">
            
            @include('layout.alerts')

            <form method="POST" action="{{ route('profile.edit') }}">
                @method('put')
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input name="username" value="{{ $user->username }}" type="text" class="form-control disabled" disabled id="username">
                    @error('username')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" value="{{ $user->email }}" type="text" class="form-control disabled" disabled id="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="firstname" class="form-label">Firstname</label>
                    <input name="firstname" value="{{ $user->firstname }}" type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname">
                    @error('firstname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Lastname</label>
                    <input name="lastname" value="{{ $user->lastname }}" type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname">
                    @error('lastname')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="level" class="form-label">Level</label>
                    <select name="riding_level" class="form-select @error('riding_level') is-invalid @enderror" id="riding_level">
                        @foreach (Config::get('app.riding_levels') as $label => $value)
                            <option @if($user->riding_level == $value) selected @endif  value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('riding_level')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="birthday" class="form-label">Birthday</label>
                    <input name="birthday" value="{{ $user->birthday }}" type="date" class="form-control @error('birthday') is-invalid @enderror"  id="birthday">
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
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
    
@endsection