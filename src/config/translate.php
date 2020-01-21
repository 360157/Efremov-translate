<?php
return [
    'url' => [
        'admin' => '/admin',
    ],
    'middleware' => ['web', 'auth'],
    'layout' => 'layouts.admin',
    'show_full_key' => true,
    'lang_path' => [
        'interface' => resource_path() . '/themes/default/views/tickets-vue/src/i18n'
    ],
    'country' => [
        '*' => 'en',
        'UA' => 'uk',
        'RU' => 'ru',
        'US' => 'en',
    ]
];
