@if($full)
    <form action="{{ route('trip.search') }}" method="GET" id="search-wrapper" class="row">
        <input type="hidden" name="lat" id="lat" @isset($lat) value="{{ $lat }}" @endisset>
        <input type="hidden" name="long" id="long" @isset($long) value="{{ $long }}" @endisset>

        <div class="col-6 col-md-4 mb-2">
            <label for="place">{{ __('Trip start place') }}</label>
            <input @isset($place) value="{{ $place }}" @endisset class="form-control" autocomplete="off" type="search" name="place" id="place" placeholder="{{ __('I am looking for a trip at') }}">
            <div id="searchbar-result-wrapper">
                <div id="searchbar-result"></div>
            </div>
        </div>

        <div class="col-6 col-md-4 mb-2">
            <label for="radius" class="form-label">{{ __('Radius') }}</label>
            <input type="range" min="5" max="200" step="5" class="form-range" name="radius" id="radius" @isset($radius) value="{{ $radius }}" @endisset>
        </div>
        
        <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">{{ __('Search') }}</button>
        </div>
        
    </form>
@else
    <form action="{{ route('trip.search') }}" method="GET" id="search-wrapper">
        <input type="hidden" name="lat" id="lat" @isset($lat) value="{{ $lat }}" @endisset>
        <input type="hidden" name="long" id="long" @isset($long) value="{{ $long }}" @endisset>

        <input type="hidden" name="radius" id="radius" @isset($radius) value="{{ $radius }}" @endisset>

        <div class="input-group position-relative">
            <input @isset($place) value="{{ $place }}" @endisset class="form-control" autocomplete="off" type="search" name="place" id="place" placeholder="{{ __('I am looking for a trip at') }}">
            <button class="btn btn-primary" type="submit">{{ __('Search') }}</button>
        </div>
        <div id="searchbar-result-wrapper">
            <div id="searchbar-result"></div>
        </div>
    </form>
@endif