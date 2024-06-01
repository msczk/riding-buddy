<a href="{{ route('profile.show', $user->id) }}" class="col-2">
    <div>
        <img class="img-fluid " src="https://placehold.co/300x300" alt="{{ $user->username }}">
    </div>
    <div class="text-center ">{{ $user->username }}</div>
  </a>