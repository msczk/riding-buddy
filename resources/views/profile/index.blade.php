@extends('layout.layout')

@section('body_id', 'account')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4 d-flex align-items-center justify-content-center">
            <h1 class="h6 text-center m-0">{{ __('Profile') }}</h1>
        </div>
        <div class="col-4 d-flex align-items-center justify-content-end">
            <a href="{{ route('profile.edit') }}">
                <svg width="20" height="22" viewBox="0 0 20 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10.011 13.5942C8.54019 13.5942 7.35046 12.4484 7.35046 11.0092C7.35046 9.57004 8.54019 8.41504 10.011 8.41504C11.4817 8.41504 12.6434 9.57004 12.6434 11.0092C12.6434 12.4484 11.4817 13.5942 10.011 13.5942Z" fill="black"/>
                    <path d="M18.4609 13.1725C18.2829 12.8975 18.0299 12.6225 17.702 12.4484C17.4397 12.32 17.2711 12.1092 17.1212 11.8617C16.6435 11.0734 16.9245 10.0375 17.7208 9.57004C18.6576 9.04754 18.9574 7.88337 18.414 6.97587L17.7864 5.89421C17.2524 4.98671 16.0814 4.66587 15.154 5.19754C14.3296 5.63754 13.271 5.34421 12.7932 4.56504C12.6434 4.30837 12.559 4.03337 12.5778 3.75837C12.6059 3.40087 12.4935 3.06171 12.3248 2.78671C11.9782 2.21837 11.3506 1.83337 10.6574 1.83337H9.33648C8.65262 1.85171 8.02496 2.21837 7.67835 2.78671C7.50036 3.06171 7.39731 3.40087 7.41605 3.75837C7.43478 4.03337 7.35047 4.30837 7.20058 4.56504C6.72282 5.34421 5.66424 5.63754 4.84923 5.19754C3.91244 4.66587 2.75081 4.98671 2.20747 5.89421L1.57982 6.97587C1.04585 7.88337 1.34562 9.04754 2.27305 9.57004C3.06932 10.0375 3.35036 11.0734 2.88196 11.8617C2.72271 12.1092 2.55408 12.32 2.29178 12.4484C1.97327 12.6225 1.69223 12.8975 1.54235 13.1725C1.19573 13.7409 1.21447 14.4559 1.56108 15.0517L2.20747 16.1517C2.55408 16.7384 3.20047 17.105 3.87496 17.105C4.19347 17.105 4.56819 17.0134 4.86797 16.83C5.10217 16.6742 5.3832 16.6192 5.69235 16.6192C6.61977 16.6192 7.39731 17.38 7.41605 18.2875C7.41605 19.3417 8.2779 20.1667 9.36458 20.1667H10.6386C11.7159 20.1667 12.5778 19.3417 12.5778 18.2875C12.6059 17.38 13.3834 16.6192 14.3109 16.6192C14.6106 16.6192 14.8917 16.6742 15.1352 16.83C15.435 17.0134 15.8004 17.105 16.1282 17.105C16.7934 17.105 17.4397 16.7384 17.7864 16.1517L18.4421 15.0517C18.7794 14.4375 18.8075 13.7409 18.4609 13.1725" stroke="black" stroke-width="2"/>
                </svg>                                                       
            </a>
        </div>
    </div>

    <div id="block-avatar" class="row text-center">
        <div id="avatar" class="col-12">
            <a href="{{ route('profile.show', Auth::user()) }}">
                <img width="75px" height="75px" class="avatar-img" src="https://placehold.co/300x300">
            </a>
        </div>
        <div id="username" class="col-12">
            <span class="fw-semibold">
                {{ Auth::user()->username }}
            </span>
        </div>
    </div>

    <ul class="nav nav-tabs justify-content-evenly" id="profile-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="btn @if($tab == 'trip') active @endif" id="trip-tab" data-bs-toggle="tab" data-bs-target="#trip-tab-pane" type="button" role="tab" aria-controls="trip-tab-pane" aria-selected="true">{{ __('Trips') }}</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="btn @if($tab == 'participation') active @endif" id="participation-tab" data-bs-toggle="tab" data-bs-target="#participation-tab-pane" type="button" role="tab" aria-controls="participation-tab-pane" aria-selected="false">{{ __('Participations') }}</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="btn @if($tab == 'garage') active @endif"" id="garage-tab" data-bs-toggle="tab" data-bs-target="#garage-tab-pane" type="button" role="tab" aria-controls="garage-tab-pane" aria-selected="false">{{ __('Garage') }}</button>
        </li>
    </ul>

    @include('layout.alerts')

    <div class="tab-content">
        <div class="tab-pane fade @if($tab == 'trip') show active @endif" id="trip-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <div class="row">
                @if(!$trips->isEmpty())
                    @foreach ($trips as $trip)
                        <x-Trip.TripThumbnail :trip=$trip :showEdit=true :showTrash=true />
                    @endforeach
                @else
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
                @endif
            </div>
        </div>
        <div class="tab-pane fade @if($tab == 'participation') show active @endif" id="participation-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
            <div class="row">
                @if(!$participations->isEmpty())
                    @foreach ($participations as $participation)
                        <x-Trip.TripThumbnail :trip=$participation :showEdit=true :showTrash=true />
                    @endforeach
                @else
                    <div id="no-trip-yet" class="col-12 text-center">
                        <div>
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_9_7282)">
                                    <path d="M12.0006 11.39C12.0006 10.74 11.6106 10.16 11.0206 9.91L5.44062 7.55C3.96062 9.23 3.12062 11.25 2.64062 13H10.3906C11.2806 13 12.0006 12.28 12.0006 11.39Z" fill="#05132B"/>
                                    <path d="M21.96 11.22C21.55 6.81 17.4 3.73 12.98 4.02C10.47 4.18 8.54 4.96 7.05 6.06L11.79 8.07C13.12 8.64 13.99 9.94 13.99 11.39C13.99 13.38 12.37 15 10.38 15H2.21C2 16.31 2 17.2 2 17.2V18C2 19.1 2.9 20 4 20H14C18.67 20 22.41 15.99 21.96 11.22Z" fill="#05132B"/>
                                </g>
                            </svg>
                        </div>
                        <h2 class="h5">
                            {{ __('No participation') }}
                        </h2>
                        <div>
                            <span class="small mid-neutral-n70">{{ __('You do not participate to any trips.') }}</span>
                        </div>
                        <div>
                            <a class="btn btn-primary w-75" href="{{ route('trip.create') }}">{{ __('Search for a trip') }}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="tab-pane fade @if($tab == 'garage') show active @endif" id="garage-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
            <div class="row">
                @if(!$bikes->isEmpty())
                    <div class="col-12">
                        <a class="btn btn-primary w-100 mb-2" href="{{ route('bike.create') }}">{{ __('Add bike') }}</a>
                    </div>
                    @foreach ($bikes as $bike)
                        <x-Bike.BikeThumbnail :bike=$bike :showEdit=true :showTrash=true />
                    @endforeach
                @else
                    <div id="no-trip-yet" class="col-12 text-center">
                        <div>
                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_9_6065)">
                                    <path d="M20 11C19.82 11 19.64 11.03 19.47 11.05L17.41 9H20V6L16.28 7.86L13.41 5H9V7H12.59L14.59 9H11L7 11L5 9H0V11H4C1.79 11 0 12.79 0 15C0 17.21 1.79 19 4 19C6.21 19 8 17.21 8 15L10 17H13L16.49 10.9L17.5 11.91C16.59 12.64 16 13.75 16 15C16 17.21 17.79 19 20 19C22.21 19 24 17.21 24 15C24 12.79 22.21 11 20 11ZM4 17C2.9 17 2 16.1 2 15C2 13.9 2.9 13 4 13C5.1 13 6 13.9 6 15C6 16.1 5.1 17 4 17ZM20 17C18.9 17 18 16.1 18 15C18 13.9 18.9 13 20 13C21.1 13 22 13.9 22 15C22 16.1 21.1 17 20 17Z" fill="#05132B"/>
                                </g>
                            </svg>
                        </div>
                        <h2 class="h5">
                            {{ __('Add a new bike') }}
                        </h2>
                        <div>
                            <span class="small mid-neutral-n70">{{ __('Show your ride to other members.') }}</span>
                        </div>
                        <div>
                            <a class="btn btn-primary w-75" href="{{ route('bike.create') }}">{{ __('Add bike') }}</a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
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