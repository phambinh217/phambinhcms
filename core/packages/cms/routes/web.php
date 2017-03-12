<?php

Route::group(['namespace' => 'Packages\Cms\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    })->name('admin');
    Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard')->middleware('can:admin');

    Route::get('user/', 'UserController@index')->name('admin.user.index')->middleware('can:admin.user.index');
    Route::get('user/create', 'UserController@create')->name('admin.user.create')->middleware('can:admin.user.create');
    Route::post('user', 'UserController@store')->name('admin.user.store')->middleware('can:admin.user.create');
    Route::get('user/{user}', 'UserController@show')->name('admin.user.show')->middleware('can:admin.user.show,user');
    Route::get('user/{user}/edit', 'UserController@edit')->name('admin.user.edit')->middleware('can:admin.user.edit,user');
    Route::put('user/{user}', 'UserController@update')->name('admin.user.update')->middleware('can:admin.user.edit,user');
    Route::put('user/{user}/enable', 'UserController@enable')->name('admin.user.enable')->middleware('can:admin.user.enable,user');
    Route::put('user/{user}/disable', 'UserController@disable')->name('admin.user.disable')->middleware('can:admin.user.disable,user');
    Route::get('user/{user}/popup-show', 'UserController@popupShow')->name('admin.user.popup-show')->middleware('can:admin.user.show,user');
    Route::delete('user/{user}', 'UserController@destroy')->name('admin.user.destroy')->middleware('can:admin.user.destroy,user');
    Route::get('user/{user}/login-as', 'UserController@loginAs')->name('admin.user.login-as')->middleware('can:admin.user.login-as');
        
    Route::get('role', 'RoleController@index')->name('admin.role.index')->middleware('can:admin.role.index');
    Route::get('role/create', 'RoleController@create')->name('admin.role.create')->middleware('can:admin.role.create');
    Route::post('role', 'RoleController@store')->name('admin.role.store')->middleware('can:admin.role.create');
    Route::get('role/{role}', 'RoleController@show')->name('admin.role.show')->middleware('can:admin.role.show,role');
    Route::get('role/{role}/edit', 'RoleController@edit')->name('admin.role.edit')->middleware('can:admin.role.edit,role');
    Route::put('role/{role}', 'RoleController@update')->name('admin.role.update')->middleware('can:admin.role.edit,role');
    Route::delete('role/{role}', 'RoleController@destroy')->name('admin.role.destroy')->middleware('can:admin.role.destroy,role');

    Route::get('module-control/module/', 'ModuleController@index')->name('admin.module-control.module.index')->middleware('can:admin.module-control.module.index');
    Route::get('module-control/theme/', 'ThemeController@index')->name('admin.module-control.theme.index')->middleware('can:admin.module-control.theme.index');

    Route::get('file', 'ElfinderController@index')->name('admin.file.index')->middleware('can:admin');
    Route::get('file/elfinder/stand-alone', 'ElfinderController@standAlone')->name('admin.file.stand-alone')->middleware('can:admin');
    Route::any('file/elfinder/connector', 'ElfinderController@connector')->name('admin.file.connector');

    Route::get('mail/', 'MailController@index')->name('admin.mail.index')->middleware('can:admin')->middleware('can:admin');
    Route::get('mail/create', 'MailController@create')->name('admin.mail.create')->middleware('can:admin');
    Route::get('mail/inbox', 'MailController@inbox')->name('admin.mail.inbox')->middleware('can:admin');
    Route::get('mail/outbox', 'MailController@outbox')->name('admin.mail.outbox')->middleware('can:admin');
    Route::get('mail/inbox/{id}', 'MailController@inboxShow')->name('admin.mail.inbox.show')->middleware('can:admin');
    Route::get('mail/outbox/{id}', 'MailController@outboxShow')->name('admin.mail.outbox.show')->middleware('can:admin');
    Route::get('mail/popup-forward/{id}', 'MailController@popupForward')->name('admin.mail.popup-forward')->middleware('can:admin');
    Route::post('mail/', 'MailController@store')->name('admin.mail.store')->middleware('can:admin');

    Route::get('profile', 'ProfileController@show')->name('admin.profile.show')->middleware('can:admin');
    Route::get('profile/change-password', 'ProfileController@changePassword')->name('admin.profile.change-password')->middleware('can:admin');
    Route::put('profile/', 'ProfileController@update')->name('admin.profile.update')->middleware('can:admin');
    Route::put('profile/change-password', 'ProfileController@updatePassword')->name('admin.profile.update-passowrd')->middleware('can:admin');

    Route::get('setting/general', 'SettingController@general')->name('admin.setting.general')->middleware('can:admin.setting.general');
    Route::put('setting/general', 'SettingController@generalUpdate')->name('admin.setting.general.update')->middleware('can:admin.setting.general');
});

Route::group(['namespace' => 'Packages\Cms\Http\Controllers\Api', 'middleware' => ['web'], 'prefix' => 'api/v1'], function () {
    Route::resource('user', 'UserController');
    Route::get('gen-api-token', 'UserController@genApiToken')->name('api.v1.user.gen-api-token');
});


Route::get('test/user', function () {
    $filter = \Packages\Cms\User::getRequestFilter();
    $users = \Packages\Cms\User::applyFilter($filter)->toSql();
    dd($users);
    return view('welcome');
});
