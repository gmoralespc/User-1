<?php

Route::group(array('prefix' => 'admin'), function () {

    Route::get('user/user/list', 'Lavalite\User\Http\Controllers\UserAdminController@lists');
    Route::resource('user/group',  'Lavalite\User\Http\Controllers\GroupAdminController');
    Route::resource('user/user', 'Lavalite\User\Http\Controllers\UserAdminController');
    Route::controller('user/user', 'Lavalite\User\Http\Controllers\UserAdminController');
});

    Route::get('/user/', 'Lavalite\User\Http\Controllers\PublicController@viewProfile');
    Route::get('/user/profile', 'Lavalite\User\Http\Controllers\PublicController@getProfile');
    Route::post('/user/profile', 'Lavalite\User\Http\Controllers\PublicController@postProfile');

    Route::get('/user/change', 'Lavalite\User\Http\Controllers\PublicController@getChange');
    Route::post('/user/change', 'Lavalite\User\Http\Controllers\PublicController@postChange');

    // Session Routes

    Route::resource('/sessions', 'Lavalite\User\Http\Controllers\SessionController', array('only' => array('create', 'store', 'destroy')));

    // User Routes
    Route::any('/user', 'Lavalite\User\Http\Controllers\PublicController@view');

    Route::get('/register', 'Lavalite\User\Http\Controllers\PublicController@create');
    Route::post('/register', 'Lavalite\User\Http\Controllers\PublicController@store');
    Route::get('/checkActive', 'Lavalite\User\Http\Controllers\PublicController@checkActive');

    Route::get('/user/{id}/activate/{code}', 'Lavalite\User\Http\Controllers\PublicController@activate')->where('id', '[0-9]+');

    Route::get('/resend', 'Lavalite\User\Http\Controllers\PublicController@getResend');
    Route::post('/resend', 'Lavalite\User\Http\Controllers\PublicController@resend');

    Route::get('/forgot', 'Lavalite\User\Http\Controllers\PublicController@getForgot');
    Route::post('/forgot', 'Lavalite\User\Http\Controllers\PublicController@forgot');

    Route::get('/user/{id}/reset/{code}', 'Lavalite\User\Http\Controllers\PublicController@reset')->where('id', '[0-9]+');

    Route::get('user/social/facebook', 'Lavalite\User\Http\Controllers\SocialController@facebook');
    Route::get('user/social/twitter', 'Lavalite\User\Http\Controllers\SocialController@twitter');
    Route::get('user/social/google', 'Lavalite\User\Http\Controllers\SocialController@google');
    Route::get('user/social/linkedin', 'Lavalite\User\Http\Controllers\SocialController@linkedin');

