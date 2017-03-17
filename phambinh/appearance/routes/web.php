<?php
/**
 * ModuleAlias: appearance
 * ModuleName: appearance
 * Description: Route of module appearance.This bellow have 3 type route: normal rotue, admin route, api route
 * to use, you have to uncommnet it
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */

Route::group(['module' => 'appearance', 'namespace' => 'Phambinh\Appearance\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/appearance'], function () {
    Route::get('menu', 'MenuController@index')->name('admin.appearance.menu.index')->middleware('can:admin.appearance.menu.index');
    Route::get('menu/{menu}', 'MenuController@menuEdit')->name('admin.appearance.menu.edit')->middleware('can:admin.appearance.menu.edit,menu');
    Route::put('menu/{menu}', 'MenuController@menuUpdate')->name('admin.appearance.menu.update')->middleware('can:admin.appearance.menu.edit,menu');
    Route::put('menu/{menu}/struct', 'MenuController@menuUpdateStruct')->name('admin.appearance.menu.update.struct')->middleware('can:admin.appearance.menu.edit,menu');
    Route::post('menu', 'MenuController@menuStore')->name('admin.appearance.menu.store');
    Route::post('menu/{menu}', 'MenuController@menuAdd')->name('admin.appearance.menu.add')->middleware('can:admin.appearance.menu.edit,menu');
    Route::post('menu/{menu}/default', 'MenuController@menuAddByDefault')->name('admin.appearance.menu.add-default')->middleware('can:admin.appearance.menu.edit,menu');
    Route::delete('menu/{menu}', 'MenuController@menuDestroy')->name('admin.appearance.menu.destroy')->middleware('can:admin.appearance.menu.destroy,menu');

    Route::put('menu-item/{menu_item}', 'MenuController@menuItemUpdate')->name('admin.appearance.menu-item.update')->middleware('can:admin.appearance.menu.edit');
    Route::delete('menu-item/{menu_item}', 'MenuController@menuItemDestroy')->name('admin.appearance.menu-item.destroy')->middleware('can:admin.appearance.menu.edit');

    Route::get('style-guide', 'StyleGuideController@index')->name('admin.appearance.style-guide.index')->middleware('can:admin');
});
