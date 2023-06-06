<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit5d6eca44e0c3a852928f4d429e56c0da
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInit5d6eca44e0c3a852928f4d429e56c0da', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit5d6eca44e0c3a852928f4d429e56c0da', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit5d6eca44e0c3a852928f4d429e56c0da::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}