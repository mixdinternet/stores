@extends('client/frontend::master')

@section('content')
    <article>
        <section class="localizacao">
            <div class="container size-1600">
                <div class="row box-qualidade">
                    <div class="column large-6 medium-7 small-12">
                        <div class="row">
                            <div class="column large-12">
                                <h1>Encontre sua loja</h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="column large-12">
                                <input type="text" name="city" id="map-autocomplete"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="mapa">
            <div id="map"></div>
        </section>
    </article>
@endsection

@section('footer-scripts')
    <script src="{{ route('api.stores.index') }}"></script>
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{ config('maps.key') }}"></script>
    <script>
        function nl2br(str, is_xhtml) {
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        }

        function loadMarkers(map) {
            var total = stores.length;
            var markers = [];
            var infowindow = [];
            for (var i = 0; i < total; i++) {

                var item = stores[i];
                var latLng = new google.maps.LatLng(item.latitude, item.longitude);

                infowindow[i] = new google.maps.InfoWindow({
                    content: '<div class="content">' +
                    '<p class="nome">' + item.name + '</p>' +
                    '<p class="endereco">' +
                    item.city + ', ' + item.state + '<br />' +
                    item.address + '<br />' +
                    nl2br(item.description) + '<br />' +
                    item.phone +
                    '</p>' +
                    '<a href="http://maps.google.com/maps?q=' + item.latitude + ',' + item.longitude + '" class="btn-como-chegar" target="_blank">Como chegar</a>' +
                    '</div>'
                });

                markers[i] = new google.maps.Marker({
                    position: latLng,
                    map: map,
                    icon: '/assets/img/icon-mapa.png'
                });

                google.maps.event.addListener(markers[i], 'click', (function (marker, i) {
                    return function () {
                        infowindow.map(function (k) {
                            k.close();
                        });
                        infowindow[i].open(map, markers[i]);
                    }
                })(markers[i], i));
            }

            var mcOptions = {
                styles: [
                    {
                        height: 53,
                        url: "https://raw.githubusercontent.com/googlemaps/v3-utility-library/master/markerclustererplus/images/m1.png",
                        width: 53
                    },
                    {
                        height: 56,
                        url: "https://raw.githubusercontent.com/googlemaps/v3-utility-library/master/markerclustererplus/images/m2.png",
                        width: 56
                    },
                    {
                        height: 66,
                        url: "https://raw.githubusercontent.com/googlemaps/v3-utility-library/master/markerclustererplus/images/m3.png",
                        width: 66
                    },
                    {
                        height: 78,
                        url: "https://raw.githubusercontent.com/googlemaps/v3-utility-library/master/markerclustererplus/images/m4.png",
                        width: 78
                    },
                    {
                        height: 90,
                        url: "https://raw.githubusercontent.com/googlemaps/v3-utility-library/master/markerclustererplus/images/m5.png",
                        width: 90
                    }
                ]
            }

            var markerCluster = new MarkerClusterer(map, markers, mcOptions);
        }
    </script>
@endsection