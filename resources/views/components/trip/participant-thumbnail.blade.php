<div class="col-12 participant-thumbnail">
    <div class="row">
        <div class="col-2 d-flex align-items-center">
            <a href="{{ route('profile.show', $user) }}">
                <img width="50px" height="50px" class="rounded-circle" src="{{ Vite::asset('resources/images/avatar/user-avatar.jpg') }}" alt="{{ $user->username }}">
            </a>
        </div>
        <div class="col-10 d-flex align-items-center">
            <div>
                <div class="small fw-semibold ">
                    <a class="text-decoration-none text-black" href="{{ route('profile.show', $user) }}">{{ $user->username }}</a>
                
                    @if($user->isApprovedForTrip($trip))
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_255_13612)">
                            <path d="M6.72669 11.1467L4.19336 8.60668L5.18003 7.62001L6.72669 9.17334L10.6267 5.26001L11.6134 6.24668L6.72669 11.1467Z" fill="#161616"/>
                            <path d="M15.3332 8L13.7065 6.14L13.9332 3.68L11.5265 3.13333L10.2665 1L7.99984 1.97333L5.73317 1L4.47317 3.12667L2.0665 3.66667L2.29317 6.13333L0.666504 8L2.29317 9.86L2.0665 12.3267L4.47317 12.8733L5.73317 15L7.99984 14.02L10.2665 14.9933L11.5265 12.8667L13.9332 12.32L13.7065 9.86L15.3332 8ZM6.72651 11.1467L4.19317 8.60667L5.17984 7.62L6.72651 9.17333L10.6265 5.26L11.6132 6.24667L6.72651 11.1467Z" fill="#D3FD51"/>
                            </g>
                        </svg>
                    @else
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_255_13606)">
                            <path d="M13.2086 6.09412L13.1889 6.3077L13.3301 6.46916L14.6689 8L13.3301 9.53084L13.1889 9.6923L13.2086 9.90588L13.3951 11.9295L11.4158 12.3791L11.206 12.4267L11.0963 12.6118L10.0602 14.3606L8.19712 13.5606L7.99916 13.4756L7.80141 13.5611L5.9389 14.3663L4.90334 12.6185L4.79369 12.4334L4.58392 12.3858L2.6045 11.9361L2.79107 9.90575L2.81069 9.69224L2.66954 9.53084L1.33023 7.99941L2.67013 6.46182L2.81065 6.30057L2.79107 6.08758L2.6046 4.05836L4.58264 3.61454L4.79329 3.56727L4.90334 3.38153L5.93946 1.63273L7.80255 2.43277L7.99984 2.51748L8.19712 2.43277L10.0597 1.63297L11.096 3.38761L11.2056 3.57317L11.4158 3.62091L13.3951 4.07051L13.2086 6.09412Z" fill="#ECECEC" stroke="#85858B"/>
                            <path d="M6.72669 11.1464L4.19336 8.60643L5.18003 7.61977L6.72669 9.1731L10.6267 5.25977L11.6134 6.24643L6.72669 11.1464Z" fill="#85858B"/>
                            </g>
                        </svg>                        
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>