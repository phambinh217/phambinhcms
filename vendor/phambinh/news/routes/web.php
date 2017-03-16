<?php

Route::group(['module' => 'news', 'namespace' => 'Phambinh\News\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/news'], function () {
    Route::get('/', 'NewsController@index')->name('admin.news.index')->middleware('can:admin.news.index');
    Route::get('create', 'NewsController@create')->name('admin.news.create')->middleware('can:admin.news.create');
    Route::post('/', 'NewsController@store')->name('admin.news.store')->middleware('can:admin.news.create');
    Route::get('{news}/edit', 'NewsController@edit')->name('admin.news.edit')->middleware('can:admin.news.edit,news');
    Route::put('{news}', 'NewsController@update')->name('admin.news.update')->middleware('can:admin.news.edit,news');
    Route::put('{news}/disable', 'NewsController@disable')->name('admin.news.disable')->middleware('can:admin.news.disable,news');
    Route::put('{news}/enable', 'NewsController@enable')->name('admin.news.enable')->middleware('can:admin.news.enable,news');
    Route::delete('{news}', 'NewsController@destroy')->name('admin.news.destroy')->middleware('can:admin.news.destroy,news');

    Route::get('category/', 'CategoryController@index')->name('admin.news.category.index')->middleware('can:admin.news.category.index');
    Route::get('category/create', 'CategoryController@create')->name('admin.news.category.create')->middleware('can:admin.news.category.create');
    Route::post('category/', 'CategoryController@store')->name('admin.news.category.store')->middleware('can:admin.news.category.create');
    Route::get('category/{category}', 'CategoryController@show')->name('admin.news.category.show')->middleware('can:admin.news.category.show,category');
    Route::get('category/{category}/edit', 'CategoryController@edit')->name('admin.news.category.edit')->middleware('can:admin.news.category.edit,category');
    Route::put('category/{category}', 'CategoryController@update')->name('admin.news.category.update')->middleware('can:admin.news.category.edit,category');
    Route::put('category/{category}/disable', 'CategoryController@disable')->middleware('can:admin.news.category.disable,category');
    Route::put('category/{category}/enable', 'CategoryController@enable')->middleware('can:admin.news.category.enable,category');
    Route::delete('category/{category}', 'CategoryController@destroy')->name('admin.news.category.destroy')->middleware('can:admin.news.category.destroy,category');
});
