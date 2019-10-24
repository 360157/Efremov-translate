<?php

Route::group(['middleware' => ['web'], 'prefix' => 'admin/trans', 'namespace' => 'Sashaef\TranslateProvider\Controllers'], function () {
    Route::get('/', 'GroupsController@showInterface')->name('groups.mainInterface');
    Route::get('system-trans', 'GroupsController@showSystem')->name('groups.mainSystems');
    Route::get('translate/show', 'GroupsController@showSystem')->name('groups.mainSystems');

    Route::group(['prefix' => 'translates', ], function () {
        Route::get('/', 'TranslateController@index')->name('translates.index');
        Route::get('list', 'TranslateController@list')->name('translates.list');
        Route::get('/{type}/{id}', 'TranslateController@show')->name('translates.show')->where('id', '[0-9]+');
        Route::post('/', 'TranslateController@store')->name('translates.store');
        Route::patch('/', 'TranslateController@update')->name('translates.update');
    });

    Route::resource('langs', 'LangsController');
    Route::resource('groups', 'GroupsController');

});