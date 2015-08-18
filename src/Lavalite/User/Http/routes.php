<?php

Route::group(array('prefix' => 'admin'), function () {

    Route::get('user/user/list', 'Lavalite\User\Http\Controllers\UserAdminController@lists');
    Route::get('/user/role/list', 'Lavalite\User\Http\Controllers\RoleAdminController@lists');
    Route::get('/user/permission/list', 'Lavalite\User\Http\Controllers\PermissionAdminController@lists');

    Route::resource('/user/permission', 'Lavalite\User\Http\Controllers\PermissionAdminController');
    Route::resource('/user/role', 'Lavalite\User\Http\Controllers\RoleAdminController');
    Route::resource('user/user', 'Lavalite\User\Http\Controllers\UserAdminController');
});
