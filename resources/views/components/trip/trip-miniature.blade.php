<a class="col-3" href="{{ route('trip.show', $trip) }}">
    <div>
        <img class="img-fluid " src="https://placehold.co/300x180" alt="{{ $trip->name }}">
    </div>
    <div class="text-center ">{{ $trip->name }}</div>
    <div class="text-center ">Le {{ date_format($trip->start_at, 'd-m-Y')  }} à {{ date_format($trip->start_at, 'H:i')  }}</div>
    <div class="text-center">
        <span>{{ $trip->distance }} km</span> - <span>{{ $trip->duration }} h</span> - <span>1/{{ $trip->max_participants }}</span>
    </div>
    <div class="text-center">
        <span>Créé par {{ $trip->user->username }}</span>
    </div>
</a>