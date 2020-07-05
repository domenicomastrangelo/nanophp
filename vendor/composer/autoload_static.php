<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdebc08565d6002a8aacd2d0e61659d1f
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'NanoPHP\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'NanoPHP\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'NanoPHP\\Config' => __DIR__ . '/../..' . '/src/Config.php',
        'NanoPHP\\Controllers\\BaseController' => __DIR__ . '/../..' . '/src/Controllers/BaseController.php',
        'NanoPHP\\Controllers\\Home' => __DIR__ . '/../..' . '/src/Controllers/Home.php',
        'NanoPHP\\Library\\Database\\DatabaseInterface' => __DIR__ . '/../..' . '/src/Library/Database/DatabaseInterface.php',
        'NanoPHP\\Library\\Database\\Mysql' => __DIR__ . '/../..' . '/src/Library/Database/Mysql.php',
        'NanoPHP\\Models\\BaseModel' => __DIR__ . '/../..' . '/src/Models/BaseModel.php',
        'NanoPHP\\Models\\User' => __DIR__ . '/../..' . '/src/Models/User.php',
        'NanoPHP\\Router' => __DIR__ . '/../..' . '/src/Router.php',
        'NanoPHP\\Routes' => __DIR__ . '/../..' . '/src/Routes.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdebc08565d6002a8aacd2d0e61659d1f::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdebc08565d6002a8aacd2d0e61659d1f::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitdebc08565d6002a8aacd2d0e61659d1f::$classMap;

        }, null, ClassLoader::class);
    }
}
