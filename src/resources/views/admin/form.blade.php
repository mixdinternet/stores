@extends('mixdinternet/admix::form')

@section('title')
    Gerenciar {{ strtolower(config('mstores.name', 'Lojas')) }}
@endsection

@section('form')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
            <li class="active"><a href="#tab_geral" data-toggle="tab">Geral</a></li>
        </ul>
        {!! BootForm::horizontal(['model' => $store, 'store' => 'admin.stores.store', 'update' => 'admin.stores.update'
            , 'id' => 'form-model', 'class' => 'form-horizontal form-rocket jq-form-validate jq-form-save'
            , 'files' => true ]) !!}
        <div class="tab-content">
            <div class="tab-pane active" id="tab_geral">
                <div class="tab-content">
                    @if ($store['id'])
                        {!! BootForm::text('id', 'Código', null, ['disabled' => true]) !!}
                    @endif

                    {!! BootForm::select('status', 'Status', ['active' => 'Ativo', 'inactive' => 'Inativo'], null
                        , ['class' => 'jq-select2', 'data-rule-required' => true]) !!}

                    @if(count(config('mstores.types')) > 1)
                        {!! BootForm::select('type', 'Tipo', ['' => '-'] + config('mstores.types'), null
                            , ['class' => 'jq-select2']) !!}
                    @else
                        {!! Form::hidden('type', key(config('mstores.types'))) !!}
                    @endif

                    {!! BootForm::text('name', 'Nome', null, ['data-rule-required' => true, 'maxlength' => '150']) !!}

                    {!! BootForm::text('zipcode', 'CEP', null, ['data-rule-required' => true, 'maxlength' => '50', 'id' => 'zipcode', 'class' => '-mask-zipcode']) !!}

                    {!! BootForm::text('address', 'Endereço', null, ['data-rule-required' => true, 'maxlength' => '150', 'id' => 'address']) !!}

                    {!! BootForm::text('state', 'Estado', null, ['data-rule-required' => true, 'maxlength' => '50', 'id' => 'state']) !!}

                    {!! BootForm::text('city', 'Cidade', null, ['data-rule-required' => true, 'maxlength' => '150', 'id' => 'city']) !!}

                    {!! BootForm::text('phone', 'Telefone', null, ['maxlength' => '150', 'class' => '-mask-phone']) !!}

                    {!! BootForm::textarea('description', 'Descrição', null, ['maxlength' => '1000']) !!}

                    <div class="form-group ">
                        <label for="name" class="control-label col-sm-3 col-md-3">Localização da Unidade</label>
                        <div class="col-sm-9 col-md-9">
                            {!! BootForm::hidden('latitude', null, ['id' => 'latitude']) !!}
                            {!! BootForm::hidden('longitude', null, ['id' => 'longitude'])!!}
                            <div id="map" style="width: 100%; height: 300px;"></div>
                            <div>
                                <p class="help-block"><a href="#" class="jq-busca-endereco">Clique aqui</a> para
                                    encontrar seu endereço e arraste o marcador para o local exato.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! BootForm::close() !!}
    </div>
@endsection

@section('footer-scripts')
    <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{ config('maps.key') }}"></script>

    <script>
        function showAddress(address) {
            var map;
            var geocoder;
            var addressMarker;

            geocoder = new google.maps.Geocoder();
            var myOptions = {
                zoom: 15,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map"), myOptions);

            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        draggable: true,
                        position: results[0].geometry.location
                    });
                    var mlat = marker.getPosition().lat();
                    var mlng = marker.getPosition().lng();

                    $('#latitude').val(mlat);
                    $('#longitude').val(mlng);

                    google.maps.event.addListener(marker, 'dragend', function () {
                        var mlat = marker.getPosition().lat();
                        var mlng = marker.getPosition().lng();
                        $('#latitude').val(mlat);
                        $('#longitude').val(mlng);
                    });
                } else {
                    alert("Falha no carregamento do mapa: " + status);
                }
            });

        }

        $(function () {

            if ($('#longitude').length > 0) {
                if ($('#longitude').val() === '') {
                    showAddress('São José do Rio Preto');
                }
                else {
                    showAddress($('#latitude').val() + ', ' + $('#longitude').val());
                }
            }

            $('.jq-busca-endereco').on('click', function (e) {
                e.preventDefault();
                var endereco = $('#address').val() + ', ' + $('#city').val() + ' / ' + $('#state').val();
                showAddress(endereco);
            });
        });
    </script>
@endsection