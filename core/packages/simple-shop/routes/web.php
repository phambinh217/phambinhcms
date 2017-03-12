<?php 
/**
 * ModuleAlias: baseshop
 * ModuleName: baseshop
 * Description: Route of module baseshop.This bellow have 3 type route: normal rotue, admin route, api route
 * to use, you have to uncommnet it
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */

Route::group(['module' => 'baseshop', 'namespace' => 'Packages\SimpleShop\Http\Controllers', 'middleware' => ['web']], function () {
    Route::get('/', 'HomeController@index')->name('index');
    Route::any('search', 'HomeController@search')->name('search');
    
    Route::get('{id}/quickview', 'ProductController@quickview')->name('product.quickview');
    Route::get('{slug}.{id}-prd', 'ProductController@show')->name('product.show');
    Route::get('{slug}.{id}-brd', 'ProductController@listByBrand')->name('product.brand');
    Route::get('{slug}.{id}-ctgr', 'ProductController@listByCategory')->name('product.category');
    Route::get('{slug}.{id}-flt', 'ProductController@listByFilter')->name('product.filter');
    Route::get('{slug}.{id}-tg', 'ProductController@listByTag')->name('product.tag');
    Route::get('sale', 'ProductController@listBySale')->name('product.sale');

    Route::get('cart', 'CartController@index')->name('cart.index');
    Route::post('cart', 'CartController@store')->name('cart.store');
    Route::post('cart/update', 'CartController@updateMany')->name('cart.update-many');
    Route::delete('cart/{rowId}', 'CartController@destroy')->name('cart.destroy');
    Route::match(['get', 'post'], 'cart/quickview', 'CartController@quickview')->name('cart.quickview');

    Route::get('compare', 'CompareController@index')->name('compare.index');
    Route::post('compare', 'CompareController@store')->name('compare.store');
    Route::delete('compare/{rowId}', 'CompareController@destroy')->name('compare.destroy');
    Route::match(['get', 'post'], 'compare/quickview', 'CompareController@quickview')->name('compare.quickview');

    Route::get('checkout', 'CheckoutController@index')->name('checkout.index');
    Route::post('checkout', 'CheckoutController@store')->name('checkout.store');
    Route::get('checkout/success', 'CheckoutController@success')->name('checkout.success');
    Route::get('checkout/{id}/confirm-order', 'CheckoutController@confirm')->name('checkout.confirm-order');

    Route::get('profile', 'ProfileController@index')->name('profile.index');
    Route::get('profile/change-password', 'ProfileController@changePassword')->name('profile.change-password');
    Route::get('profile/request-return', 'ProfileController@requestReturn')->name('profile.request-return');
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::get('profile/history-order', 'ProfileController@historyOrder')->name('profile.history-order');
    Route::put('profile/update', 'ProfileController@update')->name('profile.update');

    Route::get('mail', 'MailController@index')->name('mail.index');
    Route::get('contact', 'PagestaticController@contact')->name('pagestatic.contact');
    Route::get('contact/success', 'PagestaticController@contactSuccess')->name('pagestatic.contact-success');
    Route::get('about', 'PagestaticController@about')->name('pagestatic.about');

    Route::get('customer/login', 'AuthController@login')->name('customer.login');
    Route::get('customer/register', 'AuthController@register')->name('customer.register');
    Route::get('customer/password/reset', 'AuthController@resetPassword')->name('customer.reset-password');
});
