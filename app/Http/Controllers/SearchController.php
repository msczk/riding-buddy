<?php

namespace App\Http\Controllers;

use App\Http\Requests\Trip\SearchTripRequest;
use App\Models\Trip;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Do the search action
     *
     * @param SearchTripRequest $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function doSearch(SearchTripRequest $request): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $search_lat = $request->get('lat');
        $search_long = $request->get('long');
        $radius = $request->get('radius');
        $place = $request->get('place');

        $trips = Trip::where('start_at', '>=', date('Y-m-d'))->havingRaw('(
            6371 * acos (
            cos ( radians(?) )
            * cos( radians( coordinates_start_lat ) )
            * cos( radians( coordinates_start_long ) - radians(?) )
            + sin ( radians(?) )
            * sin( radians( coordinates_start_lat ) )
            )
        ) <= ' . $radius, [$search_lat, $search_long, $search_lat])->orderBy('start_at', 'ASC')->get();

        return view('search.result')->with(['trips' => $trips, 'place' => $place, 'radius' => $radius, 'lat' => $search_lat, 'long' => $search_long]);
    }
}
