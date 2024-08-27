<a href="{{ route('profile.show', $user) }}" class="col-6 col-md-2">
    <div>
        <img class="w-100" src="https://placehold.co/300x300" alt="{{ $user->username }}">
    </div>
    <div class="text-center ">{{ $user->username }}</div>
  </a>