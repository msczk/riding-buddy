import $ from 'jquery';

import * as maptilersdk from '@maptiler/sdk';

import {maptiler_apikey} from './app.js';


$(document).ready(function() {

    // If page is trip add or edit form
    if($('#new-trip-map').length > 0)
    {
        init_map_configuration();
        
        // We get the coordinates input value
        const coordinates_start = $('#coordinates_start');

        // if has coordinates = edit form so we zoom on the marker
        if(coordinates_start.val() !== '')
        {
            var map = new maptilersdk.Map({
                container: 'new-trip-map', // container's id or the HTML element to render the map
                style: maptilersdk.MapStyle.STREETS,
                center: coordinates_start.val().split(','), // starting position [lng, lat]
                zoom: 4, // starting zoom
                
              });
        }else{
            var map = new maptilersdk.Map({
                container: 'new-trip-map', // container's id or the HTML element to render the map
                style: maptilersdk.MapStyle.STREETS,
                center: [2.656416789147727, 46.50767680637884], // starting position [lng, lat]
                zoom: 4, // starting zoom
              });
        }

         // if has coordinates = edit form so we place the marker on the map
        if(coordinates_start.val() !== '')
        {
            var marker = new maptilersdk.Marker()
            .setLngLat(coordinates_start.val().split(','))
            .addTo(map);
        }else{
            var marker = null;
        }
        
        // On map click we remove marker and place a new one + we set the coordinates in the input
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

    // If page is trip show
    if($('#show-trip-map').length > 0)
    {
        init_map_configuration();
        
        // if has coordinates = edit form so we zoom on the marker
        if(coordinates_start !== '')
        {
            var map = new maptilersdk.Map({
                container: 'show-trip-map', // container's id or the HTML element to render the map
                style: maptilersdk.MapStyle.STREETS,
                center: coordinates_start.split(','), // starting position [lng, lat]
                zoom: 7, // starting zoom
                
                });
        
            var marker = new maptilersdk.Marker()
            .setLngLat(coordinates_start.split(','))
            .addTo(map);
        }
    }
});

function init_map_configuration()
{
    maptilersdk.config.apiKey = maptiler_apikey;
    maptilersdk.config.primaryLanguage = maptilersdk.Language.FRENCH;
}