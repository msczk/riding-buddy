@extends('layout.layout')

@section('body_id', 'search')

@section('content')
    

    <div class="container">
        <div class="row">
            <div class="col-6">
                <h1>{{ __('Results') }}</h1>
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                @livewire('search.search')
            </div>
        </div>
        <div class="row">
            @forelse ($trips as $trip)
                @livewire('trip.thumbnail', ['trip' => $trip])
            @empty
                <div id="no-trip-yet" class="col-12 text-center">
                    <div>
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 28.1167V15.4283H35V28.2183C35 33.45 31.7069 36.6667 26.438 36.6667H13.5456C8.32602 36.6667 5 33.3833 5 28.1167ZM13.2656 24.0167C12.5082 24.0517 11.8825 23.45 11.8496 22.685C11.8496 21.9183 12.4424 21.285 13.1998 21.25C13.9407 21.25 14.5499 21.835 14.5664 22.5833C14.5993 23.3517 14.0066 23.985 13.2656 24.0167ZM20.0329 24.0167C19.2755 24.0517 18.6498 23.45 18.6169 22.685C18.6169 21.9183 19.2097 21.285 19.9671 21.25C20.708 21.25 21.3172 21.835 21.3337 22.5833C21.3666 23.3517 20.7739 23.985 20.0329 24.0167ZM26.7508 30.15C25.9934 30.1333 25.3842 29.5 25.3842 28.7333C25.3677 27.9667 25.9769 27.335 26.7344 27.3183H26.7508C27.5247 27.3183 28.1504 27.9517 28.1504 28.7333C28.1504 29.5167 27.5247 30.15 26.7508 30.15ZM18.6169 28.7333C18.6498 29.5 19.2755 30.1017 20.0329 30.0667C20.7739 30.035 21.3666 29.4017 21.3337 28.635C21.3172 27.885 20.708 27.3 19.9671 27.3C19.2097 27.335 18.6169 27.9667 18.6169 28.7333ZM11.8332 28.7333C11.8661 29.5 12.4918 30.1017 13.2492 30.0667C13.9901 30.035 14.5829 29.4017 14.5499 28.635C14.5335 27.885 13.9243 27.3 13.1833 27.3C12.4259 27.335 11.8332 27.9667 11.8332 28.7333ZM25.4007 22.6683C25.4007 21.9017 25.9934 21.285 26.7508 21.2683C27.4918 21.2683 28.0845 21.8667 28.1175 22.6017C28.1339 23.3683 27.5412 24.0017 26.8002 24.0167C26.0428 24.0333 25.4171 23.45 25.4007 22.685V22.6683Z" fill="black"/>
                            <path opacity="0.4" d="M5.0056 15.4282C5.02701 14.4499 5.10933 12.5082 5.26411 11.8832C6.05445 8.3682 8.73831 6.13486 12.5748 5.81653H27.4266C31.2301 6.15153 33.9469 8.39986 34.7372 11.8832C34.8903 12.4915 34.9727 14.4482 34.9941 15.4282H5.0056Z" fill="black"/>
                            <path d="M13.8414 10.9834C14.5659 10.9834 15.1093 10.435 15.1093 9.70004V4.61837C15.1093 3.88337 14.5659 3.33337 13.8414 3.33337C13.117 3.33337 12.5736 3.88337 12.5736 4.61837V9.70004C12.5736 10.435 13.117 10.9834 13.8414 10.9834Z" fill="black"/>
                            <path d="M26.1582 10.9834C26.8662 10.9834 27.4261 10.435 27.4261 9.70004V4.61837C27.4261 3.88337 26.8662 3.33337 26.1582 3.33337C25.4338 3.33337 24.8904 3.88337 24.8904 4.61837V9.70004C24.8904 10.435 25.4338 10.9834 26.1582 10.9834Z" fill="black"/>
                        </svg>
                    </div>
                    <h2 class="h5">
                        {{ __('Add a new trip') }}
                    </h2>
                    <div>
                        <span class="small mid-neutral-n70">{{ __('Hurry up to make new acquaintances and maybe find new friends.') }}</span>
                    </div>
                    <div>
                        <a class="btn btn-primary w-75" href="{{ route('trip.create') }}">{{ __('Add trip') }}</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

@endsection