<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf573a93cfbd7722101283f1b631f6ace
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mmo7amed2010\\Apiauth\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mmo7amed2010\\Apiauth\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf573a93cfbd7722101283f1b631f6ace::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf573a93cfbd7722101283f1b631f6ace::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf573a93cfbd7722101283f1b631f6ace::$classMap;

        }, null, ClassLoader::class);
    }
}
