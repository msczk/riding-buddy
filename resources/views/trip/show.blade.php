@extends('layout.layout')

@section('body_id', 'trip_show')

@section('javascript')
<script>
    @if($is_approved)
    
        var is_approved = {{$is_approved}};
    @else
        var is_approved = false;
    @endif

    var coordinates_start_lat = "{{$coordinates_start_lat}}";
    var coordinates_start_long = "{{$coordinates_start_long}}";
</script>
@endsection

@section('content')

<div class="container">
    @include('layout.alerts')
</div>


<div class="container">
    <div class="row">
        <div class="col-3 d-flex align-items-center">
            <x-Common.GoBack />
        </div>
        <div class="col-6 d-flex align-items-center justify-content-center">
            <h1 class="heading-title">{{ __('Trip details') }}</h1>
        </div>
    </div>
</div>

<div id="show-trip-map"></div>

<div class="container">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ route('profile.show', $trip->user) }}">
                <img width="50px" height="50px" class="rounded-circle" src="https://placehold.co/50x50" alt="{{ $trip->user->username }}">
            </a>
        </div>
        <div class="col-10 d-flex align-items-center">
            <div>
                <div class="small fw-semibold ">
                    <a class="text-decoration-none text-black" href="{{ route('profile.show', $trip->user) }}">{{ $trip->user->username }}</a>
                </div>
                <div class="extra-small mid-neutral-n70">
                    {{ __('Organizer') }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <ul class="nav nav-tabs custom-nav-tabs justify-content-evenly" id="trip-tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="btn active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail-tab-pane" type="button" role="tab" aria-controls="detail-tab-pane" aria-selected="true">{{ __('Details') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn" id="discussion-tab" data-bs-toggle="tab" data-bs-target="#discussion-tab-pane" type="button" role="tab" aria-controls="discussion-tab-pane" aria-selected="false">{{ __('Discussion') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="btn" id="participants-tab" data-bs-toggle="tab" data-bs-target="#participants-tab-pane" type="button" role="tab" aria-controls="participants-tab-pane" aria-selected="false">{{ __('Participants') }}</button>
                </li>
            </ul>

            <div class="tab-content" id="trip-tabs-content">
                <div class="tab-pane fade show active" id="detail-tab-pane" role="tabpanel" aria-labelledby="detail-tab" tabindex="0">
                    <div class="row">
                        <div class="col">
                            <div id="trip-name">
                                {{ $trip->name }}
                            </div>
                            <div id="trip-description">
                                {!! nl2br(e($trip->description)) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row trip-details-lines mt-0">
                        <div class="col-12 d-flex">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="40" height="40" rx="8" fill="#EFEFEF"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.75 24.4642V17.4856H28.25V24.5201C28.25 27.3975 26.4388 29.1667 23.5409 29.1667H16.4501C13.5793 29.1667 11.75 27.3608 11.75 24.4642ZM16.2961 22.2092C15.8795 22.2284 15.5354 21.8975 15.5173 21.4768C15.5173 21.0551 15.8433 20.7068 16.2599 20.6875C16.6674 20.6875 17.0025 21.0093 17.0115 21.4208C17.0296 21.8434 16.7036 22.1918 16.2961 22.2092ZM20.0181 22.2092C19.6015 22.2284 19.2574 21.8975 19.2393 21.4768C19.2393 21.0551 19.5653 20.7068 19.9819 20.6875C20.3894 20.6875 20.7245 21.0093 20.7335 21.4208C20.7516 21.8434 20.4256 22.1918 20.0181 22.2092ZM23.713 25.5825C23.2964 25.5733 22.9613 25.225 22.9613 24.8033C22.9522 24.3817 23.2873 24.0343 23.7039 24.0251H23.713C24.1386 24.0251 24.4827 24.3734 24.4827 24.8033C24.4827 25.2342 24.1386 25.5825 23.713 25.5825ZM19.2393 24.8033C19.2574 25.225 19.6015 25.5559 20.0181 25.5367C20.4256 25.5193 20.7516 25.1709 20.7335 24.7493C20.7245 24.3368 20.3894 24.015 19.9819 24.015C19.5653 24.0343 19.2393 24.3817 19.2393 24.8033ZM15.5082 24.8033C15.5263 25.225 15.8705 25.5559 16.287 25.5367C16.6946 25.5193 17.0206 25.1709 17.0025 24.7493C16.9934 24.3368 16.6583 24.015 16.2508 24.015C15.8342 24.0343 15.5082 24.3817 15.5082 24.8033ZM22.9704 21.4676C22.9704 21.0459 23.2964 20.7068 23.713 20.6976C24.1205 20.6976 24.4465 21.0267 24.4646 21.4309C24.4737 21.8526 24.1476 22.2009 23.7401 22.2092C23.3235 22.2183 22.9794 21.8975 22.9704 21.4768V21.4676Z" fill="black"/>
                                <path opacity="0.4" d="M11.7532 17.4854C11.7649 16.9473 11.8102 15.8794 11.8954 15.5356C12.33 13.6024 13.8062 12.3741 15.9162 12.199H24.0847C26.1766 12.3832 27.6709 13.6198 28.1056 15.5356C28.1898 15.8702 28.2351 16.9464 28.2468 17.4854H11.7532Z" fill="black"/>
                                <path d="M16.6128 15.0408C17.0113 15.0408 17.3101 14.7392 17.3101 14.3349V11.54C17.3101 11.1358 17.0113 10.8333 16.6128 10.8333C16.2144 10.8333 15.9155 11.1358 15.9155 11.54V14.3349C15.9155 14.7392 16.2144 15.0408 16.6128 15.0408Z" fill="black"/>
                                <path d="M23.387 15.0408C23.7764 15.0408 24.0843 14.7392 24.0843 14.3349V11.54C24.0843 11.1358 23.7764 10.8333 23.387 10.8333C22.9885 10.8333 22.6897 11.1358 22.6897 11.54V14.3349C22.6897 14.7392 22.9885 15.0408 23.387 15.0408Z" fill="black"/>
                            </svg>
                            <div class="trip-details-text">
                                <div class="trip-details-title">
                                    {{ \Carbon\Carbon::createFromDate($trip->start_at)->translatedFormat(__('jS F Y - (h:i)')) }}
                                </div>
                                <div class="trip-details-subtitle">
                                    {{ __('Start date and time') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row trip-details-lines">
                        <div class="col-12 d-flex">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="40" height="40" rx="8" fill="#EFEFEF"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.8206 11.692C18.8234 10.5283 21.2851 10.5486 23.2691 11.7452C25.2336 12.9663 26.4276 15.1454 26.4164 17.4896C26.3707 19.8184 25.0904 22.0074 23.4901 23.6997C22.5664 24.6808 21.5331 25.5483 20.4114 26.2846C20.2958 26.3514 20.1693 26.3961 20.0379 26.4166C19.9116 26.4112 19.7885 26.3739 19.6798 26.3079C17.9671 25.2016 16.4646 23.7895 15.2446 22.1394C14.2236 20.762 13.6436 19.0979 13.5833 17.3731C13.5819 15.0245 14.8178 12.8557 16.8206 11.692ZM17.9779 18.3451C18.3148 19.1757 19.11 19.7174 19.9922 19.7174C20.5702 19.7216 21.1258 19.4901 21.5352 19.0745C21.9446 18.6589 22.1738 18.0938 22.1717 17.5051C22.1748 16.6065 21.6458 15.7945 20.8316 15.4485C20.0174 15.1024 19.0787 15.2904 18.4538 15.9247C17.8289 16.5591 17.641 17.5146 17.9779 18.3451Z" fill="black"/>
                                <ellipse opacity="0.4" cx="19.9998" cy="28.2499" rx="4.58333" ry="0.916666" fill="black"/>
                            </svg>
                                
                            <div class="trip-details-text">
                                <div class="trip-details-title">
                                    {{ $trip->city }}, {{ $trip->country }}
                                </div>
                                <div class="trip-details-subtitle">
                                    {{ __('Location') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row trip-details-lines">
                        <div class="col-12 d-flex">
                            <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="40" height="40" rx="8" fill="#EFEFEF"/>
                                <path d="M19.9534 22.3284C16.7909 22.3284 14.1226 22.8451 14.1226 24.8396C14.1226 26.8348 16.8082 27.3334 19.9534 27.3334C23.1159 27.3334 25.7843 26.8167 25.7843 24.8222C25.7843 22.827 23.0987 22.3284 19.9534 22.3284Z" fill="black"/>
                                <path opacity="0.4" d="M19.9532 20.4282C22.0947 20.4282 23.8118 18.7012 23.8118 16.5475C23.8118 14.3929 22.0947 12.6667 19.9532 12.6667C17.8118 12.6667 16.0947 14.3929 16.0947 16.5475C16.0947 18.7012 17.8118 20.4282 19.9532 20.4282Z" fill="black"/>
                                <path opacity="0.4" d="M28.3307 17.4511C28.8847 15.2717 27.2604 13.3145 25.192 13.3145C24.9671 13.3145 24.7521 13.3392 24.5419 13.3813C24.514 13.3879 24.4828 13.402 24.4664 13.4267C24.4475 13.4581 24.4615 13.5002 24.482 13.5274C25.1034 14.4041 25.4604 15.4715 25.4604 16.6173C25.4604 17.7152 25.1329 18.7389 24.5584 19.5883C24.4993 19.6758 24.5518 19.7939 24.656 19.812C24.8005 19.8376 24.9482 19.8508 25.0993 19.855C26.6054 19.8946 27.9572 18.9197 28.3307 17.4511Z" fill="black"/>
                                <path d="M29.9086 22.5822C29.6328 21.9911 28.9672 21.5858 27.9552 21.3868C27.4775 21.2696 26.1847 21.1045 24.9823 21.1268C24.9642 21.1293 24.9544 21.1417 24.9527 21.1499C24.9503 21.1615 24.9552 21.1813 24.979 21.1937C25.5347 21.4702 27.6827 22.673 27.4126 25.2098C27.4011 25.3196 27.4889 25.4145 27.5981 25.398C28.1267 25.322 29.4867 25.0282 29.9086 24.1127C30.1417 23.6289 30.1417 23.0667 29.9086 22.5822Z" fill="black"/>
                                <path opacity="0.4" d="M15.4578 13.3816C15.2485 13.3386 15.0327 13.3147 14.8078 13.3147C12.7394 13.3147 11.115 15.272 11.6699 17.4513C12.0425 18.9199 13.3944 19.8948 14.9005 19.8552C15.0515 19.8511 15.2001 19.8371 15.3437 19.8123C15.448 19.7941 15.5005 19.6761 15.4414 19.5886C14.8669 18.7383 14.5394 17.7155 14.5394 16.6176C14.5394 15.4709 14.8972 14.4035 15.5186 13.5277C15.5383 13.5004 15.553 13.4583 15.5333 13.427C15.5169 13.4014 15.4866 13.3882 15.4578 13.3816Z" fill="black"/>
                                <path d="M12.0448 21.3866C11.0328 21.5856 10.368 21.9909 10.0922 22.582C9.85827 23.0666 9.85827 23.6287 10.0922 24.1133C10.5141 25.028 11.8741 25.3227 12.4027 25.3978C12.5119 25.4143 12.5989 25.3202 12.5874 25.2096C12.3173 22.6736 14.4653 21.4708 15.0218 21.1943C15.0448 21.1811 15.0497 21.1621 15.0473 21.1497C15.0456 21.1415 15.0366 21.1291 15.0185 21.1274C13.8153 21.1043 12.5234 21.2694 12.0448 21.3866Z" fill="black"/>
                            </svg>
                                
                            <div class="trip-details-text">
                                <div class="trip-details-title">
                                   {{ $trip->approvedUsers()->count() }} / {{$trip->max_participants}}
                                </div>
                                <div class="trip-details-subtitle">
                                    {{ __('Number of participants') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!Auth::user() || (Auth::user() && $trip->user_id != Auth::user()->id))
                        @if(!$trip->isOver() && !$trip->isOneDayAway())
                            <div class="row">
                                <div class="col-12">
                                    <form id="trip-participation-form" method="POST" action="{{ route('trip.participate', $trip) }}">
                                        @csrf
                                        @method('put')

                                        @if(Auth::user() && Auth::user()->participate($trip))
                                            <button class="btn w-100 btn-no-participate">{{ __('Remove participation') }}</button>
                                        @else
                                            <button class="btn btn-primary w-100 btn-participate">{{ __('Ask for participaton') }}</button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <div class="tab-pane fade" id="discussion-tab-pane" role="tabpanel" aria-labelledby="discussion-tab" tabindex="0">
                    <div class="row">
                        <div id="no-message-yet" class="col-12 text-center">
                            <div>
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.4453 3.42316C21.0466 3.00849 20.3506 3.29383 20.3506 3.86849V7.38449C20.3506 8.85916 21.5653 10.0725 23.0399 10.0725C23.9693 10.0832 25.2599 10.0858 26.3559 10.0832C26.9173 10.0818 27.2026 9.41116 26.8133 9.00583C25.4066 7.54316 22.8879 4.92183 21.4453 3.42316Z" fill="#161616"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M24.1754 12.0227H24.1752H24.1752C23.7405 12.019 23.2442 12.0147 22.686 12.0147C20.2648 12.0147 18.2739 10.0107 18.2739 7.56675V3.27875C18.2739 2.94141 18.0046 2.66675 17.6706 2.66675H10.618C7.32673 2.66675 4.6665 5.36808 4.6665 8.67875V23.0454C4.6665 26.5187 7.45347 29.3334 10.8926 29.3334H21.3949C24.6743 29.3334 27.3332 26.6494 27.3332 23.3361V12.6281C27.3332 12.2894 27.0652 12.0161 26.7298 12.0174L26.2385 12.0212C25.8085 12.0246 25.3749 12.0281 25.0783 12.0281C24.8147 12.0281 24.5138 12.0255 24.1754 12.0227ZM19.2238 21.8425H11.9651C11.4171 21.8425 10.9731 21.3985 10.9731 20.8505C10.9731 20.3025 11.4171 19.8571 11.9651 19.8571H19.2238C19.7718 19.8571 20.2171 20.3025 20.2171 20.8505C20.2171 21.3985 19.7718 21.8425 19.2238 21.8425ZM11.9651 15.1835H16.4785C17.0265 15.1835 17.4718 14.7395 17.4718 14.1915C17.4718 13.6435 17.0265 13.1982 16.4785 13.1982H11.9651C11.4171 13.1982 10.9731 13.6435 10.9731 14.1915C10.9731 14.7395 11.4171 15.1835 11.9651 15.1835Z" fill="#161616"/>
                                </svg>
                                    
                            </div>
                            <h2 class="h5">
                                {{ __('No message') }}
                            </h2>
                            <div>
                                <span class="small mid-neutral-n70">{{ __('There is no discussion about this trip for the moment') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="participants-tab-pane" role="tabpanel" aria-labelledby="participants-tab" tabindex="0">
                    <div class="row">
                        @if(!$trip->users->isEmpty())
                            @foreach ($trip->users as $user)
                                <x-Trip.ParticipantThumbnail :user=$user :trip=$trip />
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection