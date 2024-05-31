import $ from 'jquery';

import * as maptilersdk from '@maptiler/sdk';

import {maptiler_apikey} from './app.js';


$(document).ready(function() {

    maptilersdk.config.apiKey = maptiler_apikey;

    if($('#new-trip-map').length > 0)
    {
        const map = new maptilersdk.Map({
            container: 'new-trip-map', // container's id or the HTML element to render the map
            style: maptilersdk.MapStyle.STREETS,
            center: [2.656416789147727, 46.50767680637884], // starting position [lng, lat]
            zoom: 4, // starting zoom
          });
    
        const coordinates_start = $('#coordinates_start');
        
        if(coordinates_start.val() !== '')
        {
            var marker = new maptilersdk.Marker()
            .setLngLat(coordinates_start.val().split(','))
            .addTo(map);
        }else{
            var marker = null;
        }
        
        map.on('click', function(e) {
    
            if(marker !== null)
            {
                marker.remove();
            }
    
            marker = new maptilersdk.Marker()
                .setLngLat(e.lngLat)
                .addTo(map);
    
            var lngLat = marker.getLngLat();
            coordinates_start.val(lngLat.lng + ',' + lngLat.lat);
        });
    }
});