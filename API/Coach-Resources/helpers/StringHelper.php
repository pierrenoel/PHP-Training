<?php

namespace app\helpers;

class StringHelper
{
    /**
     * @param Object $className
     * @return array
     */
    public static function getClassName(Object $className): string
    {
        // 1. get the classname
        $className = explode('\\',$className::class);

        // 2. to lower case
        $className = self::toLowerCase($className[2]);

        // 3. to plural
        return self::plural($className);
    }

    private static function toLowerCase(string $str): string
    {
        return strtolower($str);
    }

    private static function plural(String $str): string
    {
        // TODO: Implement a real function singular to plural
        return $str.'s';
    }
}