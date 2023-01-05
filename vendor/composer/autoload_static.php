<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit127b9dd7fd6363b35073be1e4931a353
{
    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/',
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->fallbackDirsPsr4 = ComposerStaticInit127b9dd7fd6363b35073be1e4931a353::$fallbackDirsPsr4;
            $loader->classMap = ComposerStaticInit127b9dd7fd6363b35073be1e4931a353::$classMap;

        }, null, ClassLoader::class);
    }
}