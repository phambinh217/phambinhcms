<?php 
/**
 * ModuleAlias: document
 * ModuleName: document
 * Description: Route of module document.This bellow have 3 type route: normal rotue, admin route, api route
 * to use, you have to uncommnet it
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */

// Route::group(['module' => 'document', 'namespace' => 'Packages\Document\Http\Controllers', 'middleware' => ['web'], 'prefix' => 'document'], function() {

// });

Route::group(['module' => 'document', 'namespace' => 'Packages\Document\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/document'], function () {
    Route::get('/', 'DocumentController@index')->name('admin.document.index')->middleware('can:admin.document.index');
    Route::get('create', 'DocumentController@create')->name('admin.document.create')->middleware('can:admin.document.create');
    Route::post('/', 'DocumentController@store')->name('admin.document.store')->middleware('can:admin.document.create');
    Route::get('/{document}/edit', 'DocumentController@edit')->name('admin.document.edit')->middleware('can:admin.document.edit');
    Route::put('/{document}', 'DocumentController@update')->name('admin.document.update')->middleware('can:admin.document.edit');
    Route::put('/{document}/enable', 'DocumentController@enable')->name('admin.document.enable')->middleware('can:admin.document.enable');
    Route::put('/{document}/disable', 'DocumentController@disable')->name('admin.document.disable')->middleware('can:admin.document.disable');
    Route::delete('/{document}', 'DocumentController@destroy')->name('admin.document.destroy')->middleware('can:admin.document.destroy');

    Route::get('/version', 'VersionController@index')->name('admin.document.version.index')->middleware('can:admin.document.index');
    Route::get('/version/create', 'VersionController@create')->name('admin.document.version.create')->middleware('can:admin.document.create');
    Route::post('/version', 'VersionController@store')->name('admin.document.version.store')->middleware('can:admin.document.create');
    Route::get('/version/{version}/edit', 'VersionController@edit')->name('admin.document.version.edit')->middleware('can:admin.document.edit');
    Route::put('/version/{version}', 'VersionController@update')->name('admin.document.version.update')->middleware('can:admin.document.edit');
    Route::delete('/version/{version}', 'VersionController@destroy')->name('admin.document.version.destroy')->middleware('can:admin.document.destroy');
});
