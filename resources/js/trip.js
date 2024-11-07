import $ from 'jquery';

import * as maptilersdk from '@maptiler/sdk';

import {maptiler_apikey} from './app.js';

$(document).ready(function() {

    window.maptilerSdk = maptilersdk;
    window.maptilerApiKey = maptiler_apikey;

    // If page is trip show
    if($('#show-trip-map').length > 0)
    {
        init_configuration();
        
        if(coordinates_start_lat !== '' && coordinates_start_long !== '')
        {
            var map = new maptilersdk.Map({
                container: 'show-trip-map', // container's id or the HTML element to render the map
                style: maptilersdk.MapStyle.STREETS,
                center: [coordinates_start_long, coordinates_start_lat], // starting position [lng, lat]
                zoom: 10, // starting zoom
                
                });

            if(is_approved) 
            {
                var marker = new maptilersdk.Marker()
                .setLngLat([coordinates_start_long, coordinates_start_lat])
                .addTo(map);
            }else{
                map.on('load', function () {
                    map.addSource('start_area', {
                        type: 'geojson',
                        data: {
                        "type": "FeatureCollection",
                        "features": [{
                            "type": "Feature",
                            "geometry": {
                                "type": "Point",
                                "coordinates": [coordinates_start_long, coordinates_start_lat]
                            }
                        }]
                        }
                    });
                    
                    map.addLayer({
                        'id': 'point',
                        'source': 'start_area',
                        'type': 'circle',
                        'paint': {
                            'circle-radius' : 50,
                            'circle-color' : '#007cbf',
                            'circle-opacity' : 0.5,
                        }
                    });
                });
            }
        }        
    }
});

function init_configuration()
{
    maptilersdk.config.apiKey = maptiler_apikey;
    maptilersdk.config.primaryLanguage = maptilersdk.Language.FRENCH;
}