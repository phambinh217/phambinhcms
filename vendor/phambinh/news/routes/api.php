<?php

Route::group(['module' => 'news', 'namespace' => 'Phambinh\News\Http\Controllers\Api', 'middleware' => ['auth:api'], 'prefix' => 'api/news'], function () {
    Route::post('category/store', 'CategoryController@store')->name('api.news.category.store')->middleware('can:admin.news.category.create');
});
