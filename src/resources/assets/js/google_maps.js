$(function () {
    function initMap() {
        var MY_MAPTYPE_ID = 'personalizado';

        var featureOpts = [
            {
                stylers: [
                    {hue: '#c5c7c9'},
                    {visibility: 'simplified'},
                    {gamma: 1.5},
                    {saturation: -100},
                    {weight: 1}
                ]
            },
            {
                elementType: 'labels',
                stylers: [
                    {visibility: 'on'}
                ]
            },
            {
                featureType: 'water',
                stylers: [
                    {color: '#9ca1a6'}
                ]
            }
        ];

        var center = new google.maps.LatLng(-14.9422935, -56.5841279); // brasil
        var map = new google.maps.Map(document.getElementById('map'), {
            scrollwheel: false,
            zoom: 5,
            center: center,
            mapTypeControlOptions: {
                mapTypeIds: [google.maps.MapTypeId.ROADMAP, MY_MAPTYPE_ID]
            },
            mapTypeId: MY_MAPTYPE_ID
        });

        var styledMapOptions = {
            name: 'Personalizado'
        };

        var customMapType = new google.maps.StyledMapType(featureOpts, styledMapOptions);
        map.mapTypes.set(MY_MAPTYPE_ID, customMapType);

        var input = document.getElementById('map-autocomplete');
        if(input) {
            var options = {
                types: ['(cities)'],
                /*componentRestrictions: {country: 'br'}*/
            };

            var autocomplete = new google.maps.places.Autocomplete(input, options);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();

                if (!place.geometry) {
                    alert('Endereço não encontrado');
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
            });
        }

        loadMarkers(map);
        //google.maps.event.addDomListener(window, 'load', initialize);
    }

    if(document.getElementById('map')) {
        initMap();
    }
});