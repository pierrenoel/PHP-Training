<?php

namespace app\helpers;

class StringHelper
{
    /**
     * @param Object $className
     * @return string
     */
    public static function getClassName(Object $className): string
    {
        // 1. get the classname
        $className = explode('\\',$className::class);

        // 2. to lower case
        $className = strtolower($className[2]);

        // 3. to plural
        return self::plural($className);
    }

    public static function addColonToFrontOfWords(string $string) : string
    {
        $words = explode(",", $string);

        $modifiedWords = array_map(function($word) {
            return ":" . $word;
        }, $words);

        return implode(",", $modifiedWords);
    }

    public static function plural(string $str): string
    {
        // TODO: Implement a real function singular to plural
        return $str.'s';
    }
    public static function singular(string $str) : string
    {
        return rtrim($str,'s');
    }
}