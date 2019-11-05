<?php

Route::group(['middleware' => ['web'], 'prefix' => 'admin/trans', 'namespace' => 'Sashaef\TranslateProvider\Controllers', 'as' => 'translate.'], function () {
    Route::get('/', 'GroupsController@index')->name('groups.index');
    Route::get('/{type}', 'GroupsController@index')->name('groups.type')->where('type', 'interface|system');

    Route::group(['prefix' => 'translates', ], function () {
        Route::get('/', 'TranslateController@index')->name('translates.index');
        Route::post('/', 'TranslateController@store')->name('translates.store');
        Route::patch('/', 'TranslateController@update')->name('translates.update');
        Route::delete('/', 'TranslateController@destroy')->name('translates.destroy');
    });

    Route::resource('langs', 'LangsController');
    Route::resource('groups', 'GroupsController');
});