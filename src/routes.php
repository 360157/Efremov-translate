<?php

Route::group(['middleware' => config('translate.middleware', ['web']), 'prefix' => config('translate.url', '/admin').'/trans', 'namespace' => 'Sashaef\TranslateProvider\Controllers', 'as' => 'translate.'], function () {
    Route::get('/', 'GroupsController@index')->name('index');
    Route::get('/{type}', 'GroupsController@index')->name('groups.type')->where('type', 'interface|system');

    Route::group(['prefix' => 'translates', 'as' => 'translates.'], function () {
        Route::get('/', 'TranslateController@index')->name('index');
        Route::get('/get', 'TranslateController@get')->name('get');
        Route::post('/', 'TranslateController@store')->name('store');
        Route::patch('/', 'TranslateController@update')->name('update');
        Route::delete('/', 'TranslateController@destroy')->name('destroy');
    });

    Route::group(['prefix' => 'langs', 'as' => 'langs.'], function () {
        Route::get('/', 'LangsController@index')->name('index');
        Route::get('/get', 'LangsController@get')->name('get');
        Route::post('/', 'LangsController@store')->name('store');
        Route::patch('/', 'LangsController@update')->name('update');
        Route::delete('/', 'LangsController@destroy')->name('destroy');
    });

    Route::group(['prefix' => 'groups', 'as' => 'groups.'], function () {
        Route::get('/', 'GroupsController@index')->name('index');
        Route::get('/get', 'GroupsController@get')->name('get');
        Route::post('/', 'GroupsController@store')->name('store');
        Route::patch('/', 'GroupsController@update')->name('update');
        Route::delete('/', 'GroupsController@destroy')->name('destroy');
    });
});