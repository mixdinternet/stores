<?php
Route::group(['middleware' => ['web'], 'prefix' => config('admin.url'), 'as' => 'admin.stores'], function () {
    Route::group(['middleware' => ['auth.admin', 'auth.rules']], function () {
        Route::get('stores/trash', ['uses' => 'StoresAdminController@index', 'as' => '.trash']);
        Route::post('stores/restore/{id}', ['uses' => 'StoresAdminController@restore', 'as' => '.restore']);
        Route::resource('stores', 'StoresAdminController', [
            'names' => [
                'index' => '.index',
                'create' => '.create',
                'store' => '.store',
                'edit' => '.edit',
                'update' => '.update',
                'show' => '.show',
            ], 'except' => ['destroy']
        ]);
        Route::delete('stores/destroy', ['uses' => 'StoresAdminController@destroy', 'as' => '.destroy']);
    });
});