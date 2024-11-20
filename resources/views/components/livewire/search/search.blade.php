<div class="container" id="searchbar">
    <form class="row" method="GET" wire:submit.prevent="search">
        @csrf
        <input wire:model="lat" type="hidden">
        <input wire:model="long" type="hidden">
        <div class="col-12 d-flex flex-row justify-content-end">
            <button wire:click="showModal" class="btn btn-link" type="button" id="search-place" data-bs-toggle="modal" data-bs-target="#searchQueryModal">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_46_1540)">
                    <path d="M14.2083 12.8333H13.4842L13.2275 12.5858C14.1258 11.5408 14.6667 10.1842 14.6667 8.70833C14.6667 5.4175 11.9992 2.75 8.70833 2.75C5.4175 2.75 2.75 5.4175 2.75 8.70833C2.75 11.9992 5.4175 14.6667 8.70833 14.6667C10.1842 14.6667 11.5408 14.1258 12.5858 13.2275L12.8333 13.4842V14.2083L17.4167 18.7825L18.7825 17.4167L14.2083 12.8333ZM8.70833 12.8333C6.42583 12.8333 4.58333 10.9908 4.58333 8.70833C4.58333 6.42583 6.42583 4.58333 8.70833 4.58333C10.9908 4.58333 12.8333 6.42583 12.8333 8.70833C12.8333 10.9908 10.9908 12.8333 8.70833 12.8333Z" fill="#161616"/>
                    </g>
                </svg>                    
            </button>
        </div>
        <div class="modal fade @if($show_modal) show @endif " id="searchQueryModal" tabindex="-1" aria-labelledby="searchQueryModalLabel" @if(!$show_modal) style="display: none;" @else style="display: block;"  @endif aria-hidden="{{ $show_modal ? 'false' : 'true' }}">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-4" id="searchQueryModalLabel">Full screen modal</h1>
                        <button wire:click="hideModal" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <input class="form-control" type="text" wire:model.live="query">
                            </div>
                        </div>
                        @if (!empty($results))
                        <div class="row">
                            @foreach ($results as $result)
                                <div class="col-12">
                                    {{ $result }}
                                </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>