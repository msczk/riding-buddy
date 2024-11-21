<a href="{{ route('profile.show', $user) }}" class="col-6 col-md-2 user-thumbnail">
    <div class="avatar-thumbnail">
        <img class="w-100" src="{{ Vite::asset('resources/images/avatar/user-avatar.jpg') }}" alt="{{ $user->username }}">
    </div>
    <div class="text-center ">{{ $user->username }}</div>
  </a>