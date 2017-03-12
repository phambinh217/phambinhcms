<?php 
/**
 * ModuleAlias: document-theme
 * ModuleName: document-theme
 * Description: Route of module document-theme.This bellow have 3 type route: normal rotue, admin route, api route
 * to use, you have to uncommnet it
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */

Route::group(['module' => 'document-theme', 'namespace' => 'Packages\DocumentTheme\Http\Controllers', 'middleware' => ['web']], function() {
    Route::get('/', 'HomeController@index')->name('index');
});
