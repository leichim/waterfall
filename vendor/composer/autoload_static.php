<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit77ae390311dde6c9f67aa0a6c3dbae1b
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'MakeitWorkPress\\WP_Updater\\' => 27,
            'MakeitWorkPress\\WP_Router\\' => 26,
            'MakeitWorkPress\\WP_Register\\' => 28,
            'MakeitWorkPress\\WP_Enqueue\\' => 27,
            'MakeitWorkPress\\WP_Custom_Fields\\' => 33,
            'MakeitWorkPress\\WP_Config\\' => 26,
            'MakeitWorkPress\\WP_Components\\' => 30,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'MakeitWorkPress\\WP_Updater\\' => 
        array (
            0 => __DIR__ . '/..' . '/makeitworkpress/wp-updater/src',
        ),
        'MakeitWorkPress\\WP_Router\\' => 
        array (
            0 => __DIR__ . '/..' . '/makeitworkpress/wp-router/src',
        ),
        'MakeitWorkPress\\WP_Register\\' => 
        array (
            0 => __DIR__ . '/..' . '/makeitworkpress/wp-register/src',
        ),
        'MakeitWorkPress\\WP_Enqueue\\' => 
        array (
            0 => __DIR__ . '/..' . '/makeitworkpress/wp-enqueue/src',
        ),
        'MakeitWorkPress\\WP_Custom_Fields\\' => 
        array (
            0 => __DIR__ . '/..' . '/makeitworkpress/wp-custom-fields/src',
        ),
        'MakeitWorkPress\\WP_Config\\' => 
        array (
            0 => __DIR__ . '/..' . '/makeitworkpress/wp-config/src',
        ),
        'MakeitWorkPress\\WP_Components\\' => 
        array (
            0 => __DIR__ . '/..' . '/makeitworkpress/wp-components/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit77ae390311dde6c9f67aa0a6c3dbae1b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit77ae390311dde6c9f67aa0a6c3dbae1b::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
