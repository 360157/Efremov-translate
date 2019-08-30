<?php

Route::get('translate-provider-hello', function(){
    echo 'Hello from the translate provider!';
});

Route::get('add/{a}/{b}', 'Sashaef\TranslateProvider\TranslateController@add');
Route::get('subtract/{a}/{b}', 'Sashaef\TranslateProvider\TranslateController@subtract');