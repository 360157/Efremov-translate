<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInita00c6d446098de90536283f9a7ceae45
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Sashaef\\TranslateProvider\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Sashaef\\TranslateProvider\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInita00c6d446098de90536283f9a7ceae45::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInita00c6d446098de90536283f9a7ceae45::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}