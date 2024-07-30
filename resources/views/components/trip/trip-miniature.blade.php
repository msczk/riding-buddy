<div class="trip-miniature col-12 col-md-3">
    @if (!$trip->trashed() && $trip->public_after_over)
        <a class="d-block" href="{{ route('trip.show', $trip) }}">
    @else
        <div>
    @endif
        <div>
            <img class="w-100" src="https://placehold.co/300x180" alt="{{ $trip->name }}">
        </div>

        <div>{{ $trip->name }}</div>

        <div>
            <span>{{ $trip->distance }} km</span> - <span>{{ $trip->duration }} h</span> - <span>1/{{ $trip->max_participants }}</span>
        </div>

        <div>Le {{ date_format($trip->start_at, 'd-m-Y')  }} à {{ date_format($trip->start_at, 'H:i')  }} par {{ $trip->user->username }}</div>
        @if (!$trip->trashed() && $trip->public_after_over)
            </a>
        @else
            </div>
        @endif
    @if($showEdit)
        <a class="btn btn-success" href="{{ route('trip.edit', $trip) }}">{{ __('Edit') }}</a>
    @endif
    @if($showTrash && !$trip->isOver())
        <form method="POST" action="{{ route('trip.destroy', $trip) }}">
            @csrf
            @method('delete')
            <button class="btn btn-danger" type="submit">{{ __('Delete') }}</button>
        </form>
    @endif
    @if ($trip->isOver() && !$trip->trashed())
    <form method="POST" action="{{ route('trip.visibility', $trip) }}">
        @csrf
        @method('put')
        @if($trip->public_after_over)
            <button class="btn btn-success" type="submit">{{ __('Visible') }}</button>
        @else
            <button class="btn btn-danger" type="submit">{{ __('Not visible') }}</button>
        @endif
    </form>
    @endif
</div>

