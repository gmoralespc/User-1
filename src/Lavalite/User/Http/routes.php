<?php


Route::get('/user/test', function () {
    $p = User::createPermission('package', 'Name');
    dd($p);
});


// Admin routes for user
Route::group(['prefix' => 'admin'], function () {
    Route::resource('/user/user', 'UserAdminController');
    Route::resource('/user/role', 'RoleAdminController');
    Route::resource('/user/permission', 'PermissionAdminController');
});
