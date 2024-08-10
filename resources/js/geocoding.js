import $ from 'jquery';

import * as maptilersdk from '@maptiler/sdk';

import {maptiler_apikey} from './app.js';


$(document).ready(function() {

    // If page contains trip searchbar
    if($('#search-wrapper').length > 0)
    {
        init_configuration();

        $('#place').on('keyup', delay(function () {

            let search = $(this).val();
            const result = maptilersdk.geocoding.forward(search, {autocomplete : true, types : ['municipality']});
            result
            .catch((reason) => {
                console.log(reason);
            })
            .then((value) => {
                if(value.features.length > 0)
                {
                    console.log(value.features)
                    var html = '<ul>';
                    value.features.forEach((element) => {
                        html += '<li data-long="'+element.geometry.coordinates[0]+'" data-lat="'+element.geometry.coordinates[1]+'">'+element.place_name+'</li>';
                    });
                    html += '</ul>';

                    $('#searchbar-result').addClass('open');
                    $('#searchbar-result').html(html);
                }
            })
            
        }, 500));
        
        $('#place').on('focusout', () => {
            $('#searchbar-result').removeClass('open');
        });

        $(document).on('mousedown', '#searchbar-result ul li', function(){
            
            var text = $(this).text();
            var lat = $(this).data('lat');
            var long = $(this).data('long');
            $('#place').val(text);
            $('#lat').val(lat);
            $('#long').val(long);
            $('#searchbar-result').removeClass('open');
        });
    }
});

function init_configuration()
{
    maptilersdk.config.apiKey = maptiler_apikey;
    maptilersdk.config.primaryLanguage = maptilersdk.Language.FRENCH;
}

function delay(callback, ms) {
    var timer = 0;
    return function() {
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = setTimeout(function () {
        callback.apply(context, args);
        }, ms || 0);
    };
}