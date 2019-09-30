<?php

Route::get('translate-provider-hello', function(){
    echo 'Hello from the translate provider!';
});

Route::group(['middleware' => ['web']], function () {

Route::resource('langs', 'Sashaef\TranslateProvider\Controllers\LangsController');
    Route::resource('groups', 'Sashaef\TranslateProvider\Controllers\GroupsController');
    Route::resource('translate', 'Sashaef\TranslateProvider\Controllers\TranslateController');
Route::get('interface-trans', 'Sashaef\TranslateProvider\Controllers\GroupsController@showInterface')->name('groups.mainInterface');
    Route::get('system-trans', 'Sashaef\TranslateProvider\Controllers\GroupsController@showSystem')->name('groups.mainSystems');
    Route::get('translate/show', 'Sashaef\TranslateProvider\Controllers\GroupsController@showSystem');

});