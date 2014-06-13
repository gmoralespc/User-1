<?php

Route::group(array('prefix' => Localization::setLocale()), function () {

    Route::group(array('prefix' => 'admin', 'before' => 'auth.admin'), function () {
        Route::resource('user/group',  'Lavalite\User\Controllers\GroupAdminController');
        Route::resource('user/user', 'Lavalite\User\Controllers\UserAdminController');
        Route::controller('user/user', 'Lavalite\User\Controllers\UserAdminController');

    });


    Route::group(array('before' => 'auth.user'), function () {
        Route::get('user', 'Lavalite\User\Controllers\PublicController@viewProfile');
        Route::get('user/profile', 'Lavalite\User\Controllers\PublicController@getProfile');
        Route::post('user/profile', 'Lavalite\User\Controllers\PublicController@postProfile');

        Route::get('user/change', 'Lavalite\User\Controllers\PublicController@getChange');
        Route::post('user/change', 'Lavalite\User\Controllers\PublicController@postChange');
    });


    // Session Routes

    Route::resource('sessions', 'Lavalite\User\Controllers\SessionController', array('only' => array('create', 'store', 'destroy')));

    // User Routes
    Route::get('register', 'Lavalite\User\Controllers\PublicController@create');
    Route::post('register', 'Lavalite\User\Controllers\PublicController@store');
    Route::get('/checkActive', 'Lavalite\User\Controllers\PublicController@checkActive');

    Route::get('user/{id}/activate/{code}', 'Lavalite\User\Controllers\PublicController@activate')->where('id', '[0-9]+');

    Route::get('resend', 'Lavalite\User\Controllers\PublicController@getResend');
    Route::post('resend', 'Lavalite\User\Controllers\PublicController@resend');

    Route::get('forgot', 'Lavalite\User\Controllers\PublicController@getForgot');
    Route::post('forgot', 'Lavalite\User\Controllers\PublicController@forgot');

    Route::get('user/{id}/reset/{code}', 'Lavalite\User\Controllers\PublicController@reset')->where('id', '[0-9]+');

    // Route::get('user', 'Lavalite\User\Controllers\PublicController@index');

});
