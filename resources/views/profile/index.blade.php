@extends('layout.layout')

@section('body_id', 'account')

@section('content')
<div class="container">
    <div class="row mt-2">
        <div class="col">
            <h1>{{ __('Profile') }}</h1>
        </div>
    </div>

    <div class="row mt-2 border-bottom pb-3">
        <a class="col text-decoration-none " href="{{ route('profile.show', Auth::user()) }}">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <div class="me-3">
                        <img width="50px" height="50px" class="rounded-circle" src="https://placehold.co/300x300">
                    </div>
                    <div>
                        <div class="fw-bold text-black">
                            {{ Auth::user()->username }}
                        </div>
                        <div class="text-muted">
                            {{ __('Show profile') }}
                        </div>
                    </div>
                </div>
                
                <div class="d-flex flex-column justify-content-center text-black">
                    <i class="fa fa-chevron-right"></i>
                </div>
            </div>
        </a>
    </div>
    <div class="row flex-column mt-2 border-bottom pb-3">
        <a href="{{ route('profile.edit') }}" class="col d-flex text-black text-decoration-none justify-content-between py-2">
            <div>
                <i class="fa-regular fa-circle-user"></i> {{ __('Account') }}
            </div>
            <div class="">
                <i class="fa fa-chevron-right"></i>
            </div>
        </a>
        <a href="{{ route('profile.trips') }}" class="col d-flex text-black text-decoration-none justify-content-between py-2">
            <div>
                <i class="fa-solid fa-route"></i> {{ __('My trips') }}
            </div>
            <div class="">
                <i class="fa fa-chevron-right"></i>
            </div>
        </a>
        <a href="{{ route('profile.bikes') }}" class="col d-flex text-black text-decoration-none justify-content-between py-2">
            <div>
                <i class="fa-solid fa-biking"></i> {{ __('Garage') }}
            </div>
            <div class="">
                <i class="fa fa-chevron-right"></i>
            </div>
        </a>
        {{-- <a href="{{ route('profile.invoices') }}" class="col d-flex text-black text-decoration-none justify-content-between py-2">
            <div>
                <i class="fa-regular fa-file-lines"></i> {{ __('Invoices') }}
            </div>
            <div class="">
                <i class="fa fa-chevron-right"></i>
            </div>
        </a> --}}
    </div>
    @auth
        <form class="my-3" action="{{ route('auth.logout') }}" method="POST">
        @method('delete')
        @csrf
        <button class="btn btn-outline-dark w-100">{{ __('Logout') }}</button>
        </form>
    @endauth
</div>
    
@endsection