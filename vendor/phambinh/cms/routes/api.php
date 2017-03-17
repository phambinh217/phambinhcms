<?php

Route::group(['module' => 'cms', 'namespace' => 'Phambinh\Cms\Http\Controllers\Api', 'prefix' => 'api/cms'], function () {
    Route::get('user', 'UserController@index')->name('api.user.index');
    Route::get('gen-api-token', 'UserController@genApiToken')->name('api.user.gen-api-token');
});
