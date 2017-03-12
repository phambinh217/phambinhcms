<?php
/**
 * ModuleAlias: install
 * ModuleName: install
 * Description: Route of module install.This bellow have 3 type route: normal rotue, admin route, api route
 * to use, you have to uncommnet it
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */

Route::group(['module' => 'install', 'namespace' => 'Packages\CmsInstall\Http\Controllers', 'middleware' => ['web.not-install'], 'prefix' => 'install'], function () {
    Route::get('/', 'InstallController@index')->name('install.index');
    Route::get('site-info', 'InstallController@siteInfo')->name('install.site-info');
    Route::get('run-install', 'InstallController@runInstall')->name('install.run-install');

    Route::post('check-connect', 'InstallController@checkConnect')->name('install.check-connect');
    Route::post('check-site-info', 'InstallController@checkSiteInfo')->name('install.check-site-info');
    Route::post('run-install', 'InstallController@installing')->name('install.installing');
});
