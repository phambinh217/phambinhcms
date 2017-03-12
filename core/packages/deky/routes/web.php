<?php

Route::group(['namespace' => 'Packages\Deky\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin'], function () {
    Route::get('course', 'CourseController@index')->name('admin.course.index');
    Route::get('course/create', 'CourseController@create')->name('admin.course.create');
    Route::post('course', 'CourseController@store')->name('admin.course.store');
    Route::get('course/{course}', 'CourseController@show')->name('admin.course.show');
    Route::get('course/{course}/edit', 'CourseController@edit')->name('admin.course.edit');
    Route::put('course/{course}', 'CourseController@update')->name('admin.course.update');
    Route::get('course/intro', 'CourseController@intro')->name('admin.course.intro');
    Route::get('course/{course}/popup-show', 'CourseController@popupShow')->name('admin.course.popup-show');
    Route::put('course/{course}/disable', 'CourseController@disable')->name('admin.course.disable');
    Route::put('course/{course}/enable', 'CourseController@enable')->name('admin.course.enable');
    Route::delete('course/{course}', 'CourseController@destroy')->name('admin.course.destroy');
    Route::get('course/{course}/class', 'Class1Controller@index')->name('admin.course.class.show');
    Route::get('course/{course}/class/create', 'Class1Controller@create')->name('admin.course.class.create');
    Route::post('course/{course}/class', 'Class1Controller@store')->name('admin.course.class.store');

    Route::get('course/category', 'CategoryController@index')->name('admin.course.category.index');
    Route::get('course/category/create', 'CategoryController@create')->name('admin.course.category.create');
    Route::post('course/category', 'CategoryController@store')->name('admin.course.category.store');
    Route::get('course/category/{category}', 'CategoryController@show')->name('admin.course.category.show');
    Route::get('course/category/{category}/edit', 'CategoryController@edit')->name('admin.course.category.edit');
    Route::put('course/category/{category}', 'CategoryController@update')->name('admin.course.category.update');
    Route::put('course/category/{category}/disable', 'CategoryController@disable');
    Route::put('course/category/{category}/enable', 'CategoryController@disable');
    Route::delete('course/category/{category}', 'CategoryController@destroy')->name('admin.course.category.destroy');

    Route::get('class/{class}/edit', 'Class1Controller@edit')->name('admin.class.edit');
    Route::get('class/{class}/popup-payment', 'Class1Controller@popupPayment')->name('admin.class.popup-payment');
    Route::post('class/{class}/payment', 'Class1Controller@paymentStore')->name('admin.class.payment-store');
    Route::put('class/{class}/change-group', 'Class1Controller@changeGroup')->name('admin.class.change-group');
    Route::put('class/{class}', 'Class1Controller@update')->name('admin.class.update');
    Route::delete('class/{class}/destroy', 'Class1Controller@destroy')->name('admin.class.destroy');

    Route::get('student/', 'StudentController@index')->name('admin.student.index');
    Route::get('student/create', 'StudentController@create')->name('admin.student.create');
    Route::post('student/', 'StudentController@store')->name('admin.student.store');
    Route::get('student/{student}', 'StudentController@show')->name('admin.student.show');
    Route::get('student/{student}/edit', 'StudentController@edit')->name('admin.student.edit');
    Route::put('student/{student}', 'StudentController@update')->name('admin.student.update');
    Route::put('student/{student}/disable', 'StudentController@disable')->name('admin.student.disable');
    Route::put('student/{student}/enable', 'StudentController@enable')->name('admin.student.enable');
    Route::delete('student/{student}', 'StudentController@destroy')->name('admin.student.destroy');

    Route::get('student/group', 'StudentGroupController@index')->name('admin.student.group.index');
    Route::get('student/group/create', 'StudentGroupController@create')->name('admin.student.group.create');
    Route::post('student/group', 'StudentGroupController@store')->name('admin.student.group.store');
    Route::get('student/group/{student_group}', 'StudentGroupController@show')->name('admin.student.group.show');
    Route::get('student/group/{student_group}/edit', 'StudentGroupController@edit')->name('admin.student.group.edit');
    Route::put('student/group/{student_group}', 'StudentGroupController@update')->name('admin.student.group.update');
    Route::put('student/group/{group}/disable', 'StudentGroupController@disable');
    Route::put('student/group/{group}/enable', 'StudentGroupController@disable');
    Route::delete('student/group/{student_group}', 'StudentGroupController@destroy')->name('admin.student.group.destroy');

    Route::get('trainer/', 'TrainerController@index')->name('admin.trainer.index');
    Route::get('trainer/create', 'TrainerController@create')->name('admin.trainer.create');
    Route::post('trainer/', 'TrainerController@store')->name('admin.trainer.store');
    Route::get('trainer/{trainer}', 'TrainerController@show')->name('admin.trainer.show');
    Route::get('trainer/{trainer}/edit', 'TrainerController@edit')->name('admin.trainer.edit');
    Route::put('trainer/{trainer}', 'TrainerController@update')->name('admin.trainer.update');
    Route::put('trainer{trainer}/disable', 'TrainerController@disable')->name('admin.trainer.disable');
    Route::put('trainer{trainer}/enable', 'TrainerController@enable')->name('admin.trainer.enable');
    Route::delete('trainer/{trainer}', 'TrainerController@destroy')->name('admin.trainer.destroy');

    Route::get('partner/', 'PartnerController@index')->name('admin.partner.index');
    Route::get('partner/create', 'PartnerController@create')->name('admin.partner.create');
    Route::post('partner/', 'PartnerController@store')->name('admin.partner.store');
    Route::get('partner/{partner}', 'PartnerController@show')->name('admin.partner.show');
    Route::get('partner/{partner}/edit', 'PartnerController@edit')->name('admin.partner.edit');
    Route::put('partner/{partner}', 'PartnerController@update')->name('admin.partner.update');
    Route::put('partner/{partner}/disable', 'PartnerController@disable')->name('admin.partner.disable');
    Route::put('partner/{partner}/enable', 'PartnerController@enable')->name('admin.partner.enable');
    Route::delete('partner/{partner}', 'PartnerController@destroy')->name('admin.partner.destroy');

    Route::get('my-class', 'MyClassController@index')->name('admin.my-class.index');
    Route::get('my-class/{course}', 'MyClassController@show')->name('admin.my-class.show');
    Route::get('my-student', 'MyStudentController@index')->name('admin.my-student.index');
    Route::get('my-student/student', 'MyStudentController@student')->name('admin.my-student.student');
    Route::get('my-student/student/{class}/edit', 'MyStudentController@studentEdit')->name('admin.my-student.edit');
    Route::get('my-student/course', 'MyStudentController@course')->name('admin')->name('admin.my-student.course');
    Route::get('my-student/registry', 'MyStudentController@registry')->name('admin.my-student.registry.index');
    Route::get('my-student/registry/create', 'MyStudentController@registryCreate')->name('admin.my-student.registry.create');
    Route::get('my-student/registry/{class}/edit', 'MyStudentController@registryEdit')->name('admin.my-student.registry.edit');
    Route::post('my-student/registry', 'MyStudentController@registryStore')->name('admin.my-student.registry.store');
    Route::put('my-student/registry/{class}', 'MyStudentController@registryUpdate')->name('admin.my-student.registry.update');
    Route::put('my-student/student/{class}', 'MyStudentController@studentUpdate')->name('admin');
    Route::put('my-student/student/{class}/disable', 'MyStudentController@disable')->name('admin');
    Route::put('my-student/student/{class}/enable', 'MyStudentController@enable')->name('admin');
    Route::delete('my-student/student/{class}', 'MyStudentController@destroy')->name('admin');

    Route::get('setting/partner', 'SettingController@partner')->name('admin.setting.partner');
    Route::put('setting/partner', 'SettingController@partnerUpdate')->name('admin.setting.partner.update');
    Route::get('setting/trainer', 'SettingController@trainer')->name('admin.setting.trainer');
    Route::put('setting/trainer', 'SettingController@trainerUpdate')->name('admin.setting.trainer.update');
    Route::get('setting/student', 'SettingController@student')->name('admin.setting.student');
    Route::put('setting/student', 'SettingController@studentUpdate')->name('admin.setting.student.update');
});

Route::group(['module' => 'trainer', 'namespace' => 'Packages\Deky\Trainer\Http\Controllers\Api', 'middleware' => ['web'], 'prefix' => 'api/v1/trainer'], function () {
    Route::get('/', 'TrainerController@index')->name('api.v1.trainer.index');
});

Route::group(['module' => 'course', 'namespace' => 'Packages\Deky\Http\Controllers\Api', 'middleware' => ['web'], 'prefix' => 'api/v1/course'], function () {
    Route::get('/', 'CourseController@index')->name('api.v1.course.index');
});

Route::group(['module' => 'student', 'namespace' => 'Packages\Deky\Http\Controllers\Api', 'middleware' => ['web'], 'prefix' => 'api/v1/student'], function () {
    Route::get('/', 'StudentController@index')->name('api.v1.student.index');
});

Route::group(['module' => 'student', 'namespace' => 'Packages\Deky\Http\Controllers\Api', 'middleware' => ['web'], 'prefix' => 'api/v1/student'], function () {
    Route::get('/', 'StudentController@index')->name('api.v1.student.index');
});
