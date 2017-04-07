<?php

Route::group(['middleware' => ['api'], 'prefix' => 'api/stores', 'as' => 'api.stores'], function () {
    Route::get('/{type?}', ['uses' => 'ApiController@index',  'as' => '.index']);
});
