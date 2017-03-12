<?php
/**
 * ModuleAlias: shop
 * ModuleName: shop
 * Description: Route of module  ecommerce.This bellow have 3 type route: normal rotue, admin route, api route
 * to use, you have to uncommnet it
 * @author: noname
 * @version: 1.0
 * @package: PackagesCMS
 */
Route::group(['namespace' => 'Packages\Ecommerce\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/ecommerce'], function () {
    Route::get('product', 'ProductController@index')->name('admin.ecommerce.product.index')->middleware('can:admin.ecommerce.product.index');
    Route::get('product/create', 'ProductController@create')->name('admin.ecommerce.product.create')->middleware('can:admin.ecommerce.product.create');
    Route::get('product/browser', 'ProductController@browser')->name('admin.ecommerce.product.browser')->middleware('can:admin.ecommerce.product.browser');
    Route::post('product', 'ProductController@store')->name('admin.ecommerce.product.store')->middleware('can:admin.ecommerce.product.create');
    Route::get('product/{product}/edit', 'ProductController@edit')->name('admin.ecommerce.product.edit')->middleware('can:admin.ecommerce.product.edit,product');
    Route::put('product/{product}', 'ProductController@update')->name('admin.ecommerce.product.update')->middleware('can:admin.ecommerce.product.edit,product');
    Route::get('product/{product}/popup-edit-quantity', 'ProductController@popupEditQuantity')->name('admin.ecommerce.product.popup-edit-quantity')->middleware('can:admin.ecommerce.product.edit,product');
    Route::get('product/{product}/update-quantity', 'ProductController@updateQuantity')->name('admin.ecommerce.product.update-quantity')->middleware('can:admin.ecommerce.product.edit,product');
    Route::put('product/{product}/enable', 'ProductController@enable')->name('admin.ecommerce.product.enable')->middleware('can:admin.ecommerce.product.enable,product');
    Route::put('product/{product}/disable', 'ProductController@disable')->name('admin.ecommerce.product.disable')->middleware('can:admin.ecommerce.product.disable,product');
    Route::delete('product/{product}', 'ProductController@destroy')->name('admin.ecommerce.product.destroy')->middleware('can:admin.ecommerce.product.destroy,product');

    Route::put('product/multiple-enable', 'ProductController@multipleEnable')->name('admin.ecommerce.product.multiple-enable')->middleware('can:admin.ecommerce.product.enable');
    Route::put('product/multiple-disable', 'ProductController@multipleDisable')->name('admin.ecommerce.product.multiple-disable')->middleware('can:admin.ecommerce.product.disable');
    Route::delete('product/multiple-destroy', 'ProductController@multipleDestroy')->name('admin.ecommerce.product.multiple-destroy')->middleware('can:admin.ecommerce.product.destroy');

    Route::get('option', 'OptionController@index')->name('admin.ecommerce.option.index')->middleware('can:admin.ecommerce.product.edit');
    Route::get('option/create', 'OptionController@create')->name('admin.ecommerce.option.create')->middleware('can:admin.ecommerce.product.edit');
    Route::post('option', 'OptionController@store')->name('admin.ecommerce.option.store')->middleware('can:admin.ecommerce.product.edit');
    Route::get('option/{option}/edit', 'OptionController@edit')->name('admin.ecommerce.option.edit')->middleware('can:admin.ecommerce.product.edit');
    Route::put('option/{option}', 'OptionController@update')->name('admin.ecommerce.option.update')->middleware('can:admin.ecommerce.product.edit');
    Route::delete('option/{option}', 'OptionController@destroy')->name('admin.ecommerce.option.destroy')->middleware('can:admin.ecommerce.product.edit');
    Route::delete('option/multiple-destroy', 'OptionController@multipleDestroy')->name('admin.ecommerce.option.multiple-destroy')->middleware('can:admin.ecommerce.product.edit');
    Route::delete('option/value/{option}', 'OptionValueController@destroy')->name('admin.ecommerce.option.value.destroy')->middleware('can:admin.ecommerce.product.edit');

    Route::get('category', 'CategoryController@index')->name('admin.ecommerce.category.index')->middleware('can:admin.ecommerce.category.index');
    Route::get('category/create', 'CategoryController@create')->name('admin.ecommerce.category.create')->middleware('can:admin.ecommerce.category.create');
    Route::post('category', 'CategoryController@store')->name('admin.ecommerce.category.store')->middleware('can:admin.ecommerce.category.create');
    Route::get('category/{category}/edit', 'CategoryController@edit')->name('admin.ecommerce.category.edit')->middleware('can:admin.ecommerce.category.edit,category');
    Route::put('category/{category}', 'CategoryController@update')->name('admin.ecommerce.category.update')->middleware('can:admin.ecommerce.category.category,edit');
    Route::delete('category/{category}', 'CategoryController@destroy')->name('admin.ecommerce.category.destroy')->middleware('can:admin.ecommerce.category.destroy,category');
    Route::delete('category/multiple-destroy', 'CategoryController@multipleDestroy')->name('admin.ecommerce.category.multiple-destroy')->middleware('can:admin.ecommerce.category.destroy');

    Route::get('filter', 'FilterController@index')->name('admin.ecommerce.filter.index')->middleware('can:admin.ecommerce.filter.index');
    Route::get('filter/create', 'FilterController@create')->name('admin.ecommerce.filter.create')->middleware('can:admin.ecommerce.filter.create');
    Route::post('filter', 'FilterController@store')->name('admin.ecommerce.filter.store')->middleware('can:admin.ecommerce.filter.create');
    Route::get('filter/{filter}/edit', 'FilterController@edit')->name('admin.ecommerce.filter.edit')->middleware('can:admin.ecommerce.filter.edit,filter');
    Route::put('filter/{filter}', 'FilterController@update')->name('admin.ecommerce.filter.update')->middleware('can:admin.ecommerce.filter.edit,filter');
    Route::delete('filter/{filter}', 'FilterController@destroy')->name('admin.ecommerce.filter.destroy')->middleware('can:admin.ecommerce.filter.destroy,filter');
    Route::delete('filter/multiple-destroy', 'FilterController@multipleDestroy')->name('admin.ecommerce.filter.multiple-destroy')->middleware('can:admin.ecommerce.filter.destroy');

    Route::get('brand', 'BrandController@index')->name('admin.ecommerce.brand.index')->middleware('can:admin.ecommerce.brand.index');
    Route::get('brand/create', 'BrandController@create')->name('admin.ecommerce.brand.create')->middleware('can:admin.ecommerce.brand.create');
    Route::post('brand', 'BrandController@store')->name('admin.ecommerce.brand.store')->middleware('can:admin.ecommerce.brand.create');
    Route::get('brand/{brand}/edit', 'BrandController@edit')->name('admin.ecommerce.brand.edit')->middleware('can:admin.ecommerce.brand.edit,brand');
    Route::put('brand/{brand}', 'BrandController@update')->name('admin.ecommerce.brand.update')->middleware('can:admin.ecommerce.brand.edit,brand');
    Route::delete('brand/{brand}', 'BrandController@destroy')->name('admin.ecommerce.brand.destroy')->middleware('can:admin.ecommerce.brand.destroy,brand');
    Route::delete('brand/multiple-destroy', 'BrandController@multipleDestroy')->name('admin.ecommerce.brand.multiple-destroy')->middleware('can:admin.ecommerce.brand.destroy');
    
    Route::get('attribute', 'AttributeController@index')->name('admin.ecommerce.attribute.index')->middleware('can:admin.ecommerce.product.edit');
    Route::get('attribute/create', 'AttributeController@create')->name('admin.ecommerce.attribute.create')->middleware('can:admin.ecommerce.product.edit');
    Route::post('attribute', 'AttributeController@store')->name('admin.ecommerce.attribute.store')->middleware('can:admin.ecommerce.product.edit');
    Route::get('attribute/{attribute}/edit', 'AttributeController@edit')->name('admin.ecommerce.attribute.edit')->middleware('can:admin.ecommerce.product.edit');
    Route::put('attribute/{attribute}', 'AttributeController@update')->name('admin.ecommerce.attribute.update')->middleware('can:admin.ecommerce.product.edit');
    Route::delete('attribute/{attribute}', 'AttributeController@destroy')->name('admin.ecommerce.attribute.destroy')->middleware('can:admin.ecommerce.product.edit');
    Route::delete('attribute/multiple-destroy', 'AttributeController@multipleDestroy')->name('admin.ecommerce.attribute.multiple-destroy')->middleware('can:admin.ecommerce.product.edit');

    Route::get('tag', 'TagController@index')->name('admin.ecommerce.tag.index')->middleware('can:admin.ecommerce.product.edit');
    Route::get('tag/create', 'TagController@create')->name('admin.ecommerce.tag.create')->middleware('can:admin.ecommerce.product.edit');
    Route::post('tag', 'TagController@store')->name('admin.ecommerce.tag.store')->middleware('can:admin.ecommerce.product.edit');
    Route::get('tag/{tag}/edit', 'TagController@edit')->name('admin.ecommerce.tag.edit')->middleware('can:admin.ecommerce.product.edit');
    Route::put('tag/{tag}', 'TagController@update')->name('admin.ecommerce.tag.update')->middleware('can:admin.ecommerce.product.edit');
    Route::delete('tag/{tag}', 'TagController@destroy')->name('admin.ecommerce.tag.destroy')->middleware('can:admin.ecommerce.product.edit');
    Route::delete('tag/multiple-destroy', 'TagController@multipleDestroy')->name('admin.ecommerce.tag.multiple-destroy')->middleware('can:admin.ecommerce.product.edit');

    Route::get('setting/currency', 'SettingController@currency')->name('admin.ecommerce.setting.currency')->middleware('can:admin.ecommerce.setting');
    Route::put('setting/currency', 'SettingController@currencySettingUpdate')->name('admin.ecommerce.setting.currency.update')->middleware('can:admin.ecommerce.setting');
    Route::post('setting/currency', 'SettingController@currencyStore')->name('admin.ecommerce.setting.currency.store-currency')->middleware('can:admin.ecommerce.setting');
    Route::put('setting/currency/{currency}', 'SettingController@currencyUpdate')->name('admin.ecommerce.setting.currency.update-currency')->middleware('can:admin.ecommerce.setting');
    Route::delete('setting/currency/{currency}', 'SettingController@currencyDestroy')->name('admin.ecommerce.setting.currency.destroy-currency')->middleware('can:admin.ecommerce.setting');
    
    Route::get('setting/customer', 'SettingController@customer')->name('admin.ecommerce.setting.customer')->middleware('can:admin.ecommerce.setting');
    Route::put('setting/customer', 'SettingController@customerUpdate')->name('admin.ecommerce.setting.customer.update')->middleware('can:admin.ecommerce.setting');

    Route::get('customer', 'CustomerController@index')->name('admin.ecommerce.customer.index')->middleware('can:admin.ecommerce.customer.index');
    Route::get('customer/create', 'CustomerController@create')->name('admin.ecommerce.customer.create')->middleware('can:admin.ecommerce.customer.create');
    Route::post('customer/', 'CustomerController@store')->name('admin.ecommerce.customer.store')->middleware('can:admin.ecommerce.customer.create');
    Route::get('customer/{customer}', 'CustomerController@show')->name('admin.ecommerce.customer.show')->middleware('can:admin.ecommerce.customer.show,customer');
    Route::get('customer/{customer}/edit', 'CustomerController@edit')->name('admin.ecommerce.customer.edit')->middleware('can:admin.ecommerce.customer.edit,customer');
    Route::put('customer/{customer}', 'CustomerController@update')->name('admin.ecommerce.customer.update')->middleware('can:admin.ecommerce.customer.edit,customer');
    Route::put('customer/{customer}/disable', 'CustomerController@enable')->name('admin.ecommerce.customer.enable')->middleware('can:admin.ecommerce.customer.enable,customer');
    Route::put('customer/{customer}/enable', 'CustomerController@disable')->name('admin.ecommerce.customer.disable')->middleware('can:admin.ecommerce.customer.disable,customer');
    Route::get('customer/{customer}/popup-show', 'CustomerController@popupShow')->name('admin.ecommerce.customer.popup-show')->middleware('can:admin.ecommerce.customer.show,customer');
    Route::delete('customer/{customer}', 'CustomerController@destroy')->name('admin.ecommerce.customer.destroy')->middleware('can:admin.ecommerce.customer.destroy,customer');

    Route::get('order', 'OrderController@index')->name('admin.ecommerce.order.index')->middleware('can:admin.ecommerce.order.index');
    Route::get('order/{order}', 'OrderController@show')->name('admin.ecommerce.order.show')->middleware('can:admin.ecommerce.order.show,order');
    Route::get('order/create', 'OrderController@create')->name('admin.ecommerce.order.create')->middleware('can:admin.ecommerce.order.create');
    Route::get('order/{order}/edit', 'OrderController@edit')->name('admin.ecommerce.order.edit')->middleware('can:admin.ecommerce.order.edit,order');
    Route::put('order/{order}/change-status', 'OrderController@changeStatus')->name('admin.ecommerce.order.change-status')->middleware('can:admin.ecommerce.order.change-status,order');

    Route::get('setting/order', 'SettingController@order')->name('admin.ecommerce.setting.order')->middleware('can:admin.ecommerce.setting.order');
    Route::post('setting/order-status', 'SettingController@orderStatusStore')->name('admin.ecommerce.setting.order-status.store')->middleware('can:admin.ecommerce.setting.order');
    Route::put('setting/order-status/{id}', 'SettingController@orderStatusUpdate')->name('admin.ecommerce.setting.order-status.update')->middleware('can:admin.ecommerce.setting.order');
    Route::delete('setting/order-status/{id}', 'SettingController@orderStatusDestroy')->name('admin.ecommerce.setting.order-status.update')->middleware('can:admin.ecommerce.setting.order');
    Route::put('setting/order', 'SettingController@orderSettingUpdate')->name('admin.ecommerce.setting.order.update')->middleware('can:admin.ecommerce.setting.order');
});

Route::group(['namespace' => 'Packages\Ecommerce\Http\Controllers\Api', 'middleware' => ['web'], 'prefix' => 'api/v1/ecommerce'], function () {
    Route::get('order/{id}/products', 'OrderController@products');
    Route::get('category', 'CategoryController@index');
    Route::get('tag', 'TagController@index');
    Route::post('tag/first-or-create', 'TagController@firstOrCreate');
    Route::get('attribute', 'AttributeController@index');
    Route::post('attribute/first-or-create', 'AttributeController@firstOrCreate');
    Route::get('option', 'OptionController@index');
    Route::post('option/first-or-create', 'OptionController@firstOrCreate');
    Route::get('option-value', 'OptionValueController@index');
    Route::post('option-value/first-or-create', 'OptionValueController@firstOrCreate');
    Route::get('product', 'ProductController@index');
    Route::get('product/{id}', 'ProductController@show');
    Route::get('product/{id}/images', 'ProductController@images');
    Route::get('product/{id}/options', 'ProductController@options');
});
