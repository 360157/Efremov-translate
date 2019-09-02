<?php

Route::get('translate-provider-hello', function(){
    echo 'Hello from the translate provider!';
});

Route::resource('langs', 'Sashaef\TranslateProvider\Controllers\LangsController');
Route::get('subtract/{a}/{b}', 'Sashaef\TranslateProvider\Controllers\TranslateController@subtract');