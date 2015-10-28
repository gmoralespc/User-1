<?php

// Admin routes for user
Route::group(array('prefix' =>'admin'), function ()
{
    Route::resource('/user/user', 'Lavalite\User\Http\Controllers\UserAdminController');
});


// Admin routes for role
Route::group(array('prefix' =>'admin'), function ()
{
    Route::get('/user/role/list', 'Lavalite\User\Http\Controllers\RoleAdminController@lists');
    Route::resource('/user/role', 'Lavalite\User\Http\Controllers\RoleAdminController');
});


// Admin routes for permission
Route::group(array('prefix' =>'admin'), function ()
{
    Route::get('/user/permission/list', 'Lavalite\User\Http\Controllers\PermissionAdminController@lists');
    Route::resource('/user/permission', 'Lavalite\User\Http\Controllers\PermissionAdminController');
});

