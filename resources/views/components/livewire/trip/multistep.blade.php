<div class="row">
    <div class="col-12 text-center">
        @if ($currentStep == 1)
            <svg width="75" height="14" viewBox="0 0 75 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="6" y="6" width="60" height="2" fill="#C4C4C6"/>
                <circle cx="7" cy="7" r="7" fill="#D3FD51"/>
                <g clip-path="url(#clip0_28_3074)">
                    <path d="M6.00003 8.4L4.60003 7L4.13336 7.46667L6.00003 9.33333L10 5.33334L9.53336 4.86667L6.00003 8.4Z" fill="#161616"/>
                </g>
                <circle cx="37" cy="7" r="6.5" fill="white" stroke="#C4C4C6"/>
                <circle cx="67" cy="7" r="6.5" fill="white" stroke="#C4C4C6"/>
            </svg>
        @endif

        @if ($currentStep == 2)
            <svg width="75" height="14" viewBox="0 0 75 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="6" y="6" width="60" height="2" fill="#C4C4C6"/>
                <rect x="6" y="6" width="35" height="2" fill="#D3FD51"/>
                <circle cx="7" cy="7" r="7" fill="#D3FD51"/>
                <g clip-path="url(#clip0_28_3074)">
                    <path d="M6.00003 8.4L4.60003 7L4.13336 7.46667L6.00003 9.33333L10 5.33334L9.53336 4.86667L6.00003 8.4Z" fill="#161616"/>
                </g>
                <circle cx="37" cy="7" r="7" fill="#D3FD51"/>
                <g clip-path="url(#clip1_28_3074)">
                    <path d="M36 8.4L34.6 7L34.1334 7.46667L36 9.33333L40 5.33334L39.5334 4.86667L36 8.4Z" fill="#161616"/>
                </g>
                <circle cx="67" cy="7" r="6.5" fill="white" stroke="#C4C4C6"/>
            </svg>
        @endif

        @if ($currentStep == 3)
            <svg width="75" height="14" viewBox="0 0 75 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="6" y="6" width="65" height="2" fill="#D3FD51"/>
                <circle cx="7" cy="7" r="7" fill="#D3FD51"/>
                <g clip-path="url(#clip0_28_3074)">
                    <path d="M6.00003 8.4L4.60003 7L4.13336 7.46667L6.00003 9.33333L10 5.33334L9.53336 4.86667L6.00003 8.4Z" fill="#161616"/>
                </g>
                <circle cx="37" cy="7" r="7" fill="#D3FD51"/>
                <g clip-path="url(#clip1_28_3074)">
                    <path d="M36 8.4L34.6 7L34.1334 7.46667L36 9.33333L40 5.33334L39.5334 4.86667L36 8.4Z" fill="#161616"/>
                </g>
                <circle cx="67" cy="7" r="7" fill="#D3FD51"/>
                <g clip-path="url(#clip2_28_3801)">
                    <path d="M66 8.4L64.6 7L64.1333 7.46667L66 9.33333L70 5.33334L69.5333 4.86667L66 8.4Z" fill="#161616"/>
                </g>
            </svg>
        @endif
    </div>

    <form class="col-12" wire:submit.prevent="{{$edit ? 'update' : 'store'}}">
        @csrf
        
        {{-- STEP 1 --}}

        @if ($currentStep == 1)
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input required wire:model="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name">
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <textarea rows="5" required wire:model="description" class="form-control @error('description') is-invalid @enderror" id="description"></textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif

        {{-- STEP 2 --}}
        
        @if ($currentStep == 2)
            <div class="mb-3">
                <label for="start_at" class="form-label">{{ __('Start at') }}</label>
                <input min="{{ date('Y-m-d\T00:00', strtotime("+2 day")) }}" {{ ($edit ? 'disabled' : '')}} wire:model="start_at" type="datetime-local" class="form-control @error('start_at') is-invalid @enderror" id="start_at">
                @error('start_at')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="distance" class="form-label">{{ __('Distance') }}</label>
                <div class="input-group">
                    <input required wire:model="distance" type="number" min="1" class="form-control @error('distance') is-invalid @enderror" id="distance">
                    <span class="input-group-text">{{ __('Kms') }}</span>
                    @error('distance')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div id="distanceHelp" class="form-text">{{ __('The approximate distance you will cover during the ride') }}.</div>
            </div>
            <div class="mb-3">
                <label for="duration" class="form-label">{{ __('Duration') }}</label>
                <div class="input-group">
                    <input required wire:model="duration" min="1" type="number" class="form-control @error('duration') is-invalid @enderror" id="duration">
                    <span class="input-group-text">{{ __('Hours') }}</span>
                    @error('duration')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div id="durationHelp" class="form-text">{{ __('The approximate duration of the trip') }}.</div>
            </div>
            <div class="mb-3">
                <label for="level" class="form-label">{{ __('Level') }}</label>
                <select required wire:model="level" class="form-select @error('level') is-invalid @enderror" id="level">
                    @foreach (Config::get('app.riding_levels') as $label => $value)
                        <option value="{{ $value }}">{{ __($label) }}</option>
                    @endforeach
                </select>
                @error('level')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="max_participants" class="form-label">{{ __('Max participants') }}</label>
                <input required wire:model="max_participants" type="number" min="2" class="form-control @error('max_participants') is-invalid @enderror" id="max_participants">
                @error('max_participants')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif

        {{-- STEP 3 --}}
        
        @if ($currentStep == 3)
            <div class="mb-3">
                <label class="form-label">{{ __('Meeting location') }}</label>
                <div x-data="{
                    init_configuration()
                    {
                        maptilerSdk.config.apiKey = maptilerApiKey;
                        maptilerSdk.config.primaryLanguage = maptilerSdk.Language.FRENCH;
                    },
                    init(){
                        this.init_configuration();

                        let marker = null;

                        if($wire.coordinates_start_lat && $wire.coordinates_start_long)
                        {
                            var map = new maptilerSdk.Map({
                                container: 'new-trip-map', 
                                style: maptilerSdk.MapStyle.STREETS,
                                center: [$wire.coordinates_start_long, $wire.coordinates_start_lat], 
                                zoom: 4, 
                            });

                            marker = new maptilerSdk.Marker()
                                .setLngLat([$wire.coordinates_start_long, $wire.coordinates_start_lat])
                                .addTo(map);
                        }else{
                            var map = new maptilerSdk.Map({
                                container: 'new-trip-map', 
                                style: maptilerSdk.MapStyle.STREETS,
                                center: [2.656416789147727, 46.50767680637884], 
                                zoom: 4, 
                            });
                        }

                        map.on('click', function(e) {
    
                            if(marker !== null)
                            {
                                marker.remove();
                            }
                    
                            marker = new maptilerSdk.Marker()
                                .setLngLat(e.lngLat)
                                .addTo(map);
                    
                            var lngLat = marker.getLngLat();

                            $wire.coordinates_start_lat = lngLat.lat;
                            $wire.coordinates_start_long = lngLat.lng;
                        })
                    }
                }" id="new-trip-map"></div>
                
                @error('coordinates_start_lat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                @error('coordinates_start_long')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        @endif
        <div class="row">
            @if ($currentStep == 2 || $currentStep == 3)
                <div class="text-center col">
                    <button type="button" class="btn btn-primary w-100" wire:click="decreaseStep()">{{ __('Previous') }}</button>
                </div>
            @endif

            @if ($currentStep == 1 || $currentStep == 2)
                <div class="text-center col">
                    <button type="button" class="btn btn-primary w-100" wire:click="increaseStep()">{{ __('Next') }}</button>
                </div>

            @endif

            @if ($currentStep == 3)
                <div class="text-center col">
                    <button type="submit" class="btn btn-primary w-100">{{$edit ? __('Edit') : __('Create')}}</button>
                </div>
            @endif
        </div>
    </form>
</div>