<div class="col-6 col-md-3 user-thumbnail">
    <a href="{{ route('profile.show', $user) }}">
        <div class="avatar-thumbnail">
            <img class="w-100" src="{{ Vite::asset('resources/images/avatar/user-avatar.jpg') }}" alt="{{ $user->username }}">
        </div>
    </a>
    <div class="text-center fw-semibold">{{ $user->username }}</div>
</div>