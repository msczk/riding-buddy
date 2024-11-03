import $ from 'jquery';

import * as maptilersdk from '@maptiler/sdk';

import {maptiler_apikey} from './app.js';



$(document).ready(function() {

    window.maptilerSdk = maptilersdk;
    window.maptilerApiKey = maptiler_apikey;

    // If page is trip add or edit form
    // if($('#new-trip-map').length > 0)
    // {
    //     init_configuration();
        
    //     // We get the coordinates input value
    //     const coordinates_start_lat_element = $('#coordinates_start_lat')
    //     const coordinates_start_long_element = $('#coordinates_start_long')

    //     const coordinates_start_lat = coordinates_start_lat_element.val();
    //     const coordinates_start_long = coordinates_start_long_element.val();

    //     // if has coordinates = edit form so we zoom on the marker
    //     if(coordinates_start_lat !== '' && coordinates_start_long !== '')
    //     {
    //         var map = new maptilersdk.Map({
    //             container: 'new-trip-map', // container's id or the HTML element to render the map
    //             style: maptilersdk.MapStyle.STREETS,
    //             center: [coordinates_start_long, coordinates_start_lat], // starting position [lng, lat]
    //             zoom: 4, // starting zoom
                
    //           });
    //     }else{
    //         var map = new maptilersdk.Map({
    //             container: 'new-trip-map', // container's id or the HTML element to render the map
    //             style: maptilersdk.MapStyle.STREETS,
    //             center: [2.656416789147727, 46.50767680637884], // starting position [lng, lat]
    //             zoom: 4, // starting zoom
    //           });
    //     }

    //      // if has coordinates = edit form so we place the marker on the map
    //     if(coordinates_start_lat !== '' && coordinates_start_long !== '')
    //     {
    //         var marker = new maptilersdk.Marker()
    //         .setLngLat([coordinates_start_long, coordinates_start_lat])
    //         .addTo(map);
    //     }else{
    //         var marker = null;
    //     }
        
    //     // On map click we remove marker and place a new one + we set the coordinates in the input
    //     map.on('click', function(e) {
    
    //         if(marker !== null)
    //         {
    //             marker.remove();
    //         }
    
    //         marker = new maptilersdk.Marker()
    //             .setLngLat(e.lngLat)
    //             .addTo(map);
    
    //         var lngLat = marker.getLngLat();

    //         coordinates_start_lat_element.val(lngLat.lat);
    //         coordinates_start_long_element.val(lngLat.lng);
    //     });
    // }

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