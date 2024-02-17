<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2fc673e03a44c5c7ecfc8882e7ae1ad8
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Model\\' => 6,
        ),
        'E' => 
        array (
            'Exception\\' => 10,
        ),
        'C' => 
        array (
            'Core\\' => 5,
            'Controller\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Model\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/models',
        ),
        'Exception\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core/exceptions',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/core',
        ),
        'Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Mustache' => 
            array (
                0 => __DIR__ . '/..' . '/mustache/mustache/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2fc673e03a44c5c7ecfc8882e7ae1ad8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2fc673e03a44c5c7ecfc8882e7ae1ad8::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit2fc673e03a44c5c7ecfc8882e7ae1ad8::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit2fc673e03a44c5c7ecfc8882e7ae1ad8::$classMap;

        }, null, ClassLoader::class);
    }
}