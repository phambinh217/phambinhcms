<?php 
/**
 * ModuleAlias: fb-comment
 * ModuleName: fb-comment
 * Description: Route of module fb-comment.This bellow have 3 type route: normal rotue, admin route, api route
 * to use, you have to uncommnet it
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */

Route::group(['module' => 'fb-comment', 'namespace' => 'Packages\FbComment\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/fb-comment'], function () {
    Route::get('setting', 'SettingController@index')->name('admin.fb-comment.setting.index')->middleware('can:admin.fb-comment.setting');
    Route::put('setting/update', 'SettingController@update')->name('admin.fb-comment.setting.update')->middleware('can:admin.fb-comment.setting');
});
