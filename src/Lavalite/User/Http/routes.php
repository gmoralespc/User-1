<?php

Route::group(array('prefix' => 'admin'), function () {

    Route::get('user/user/list/{type?}', 'Lavalite\User\Http\Controllers\UserAdminController@lists');
    Route::get('/user/role/list', 'Lavalite\User\Http\Controllers\RoleAdminController@lists');
    Route::get('/user/permission/list', 'Lavalite\User\Http\Controllers\PermissionAdminController@lists');

    Route::post('/user/update-profile', 'Lavalite\User\Http\Controllers\UserAdminController@updateProfile');
    Route::post('/user/change-password', 'Lavalite\User\Http\Controllers\UserAdminController@changePassword');

    Route::resource('/user/permission', 'Lavalite\User\Http\Controllers\PermissionAdminController');
    Route::resource('/user/role', 'Lavalite\User\Http\Controllers\RoleAdminController');
    Route::resource('user/user', 'Lavalite\User\Http\Controllers\UserAdminController');
});
