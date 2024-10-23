<div class="bike-miniature col-6 col-lg-3">
    <div>
        <img class="w-100" src="https://placehold.co/300x300" alt="{{ $bike->brand }} {{ $bike->model }} {{ $bike->year }}">
    </div>
    <div class="text-center">
        {{ $bike->brand }} {{ $bike->model }} ({{ $bike->cylinder }} cc) {{ $bike->year }}
    </div>
    @if($showEdit || $showTrash)
        <div class="d-flex justify-content-between">
            @if($showEdit)
                <a class="btn btn-primary" href="{{ route('bike.edit', $bike) }}">
                    <i class="fa fa-pen"></i>
                </a>
            @endif
            @if($showTrash)
                <form action="{{ route('bike.destroy', $bike) }}" method="POST">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger" type="submit">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            @endif
        </div>
    @endif
</div>