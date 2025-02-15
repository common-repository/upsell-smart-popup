<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit786ba750bb3bc39aaa75edc3c6e9acea
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'P_USP\\App\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'P_USP\\App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit786ba750bb3bc39aaa75edc3c6e9acea::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit786ba750bb3bc39aaa75edc3c6e9acea::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit786ba750bb3bc39aaa75edc3c6e9acea::$classMap;

        }, null, ClassLoader::class);
    }
}
