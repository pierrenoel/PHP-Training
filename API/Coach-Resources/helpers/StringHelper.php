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

    /**
     * @param string $string
     * @return string
     */
    public static function addColonToFrontOfWords(string $string) : string
    {
        $words = explode(",", $string);

        $modifiedWords = array_map(function($word) {
            return ":" . $word;
        }, $words);

        return implode(",", $modifiedWords);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function plural(string $str): string
    {
        $lastChar = strtolower(substr($str, -1));

        switch ($lastChar) {
            case 's':
                return $str . 'es'; // e.g., bus -> buses
            case 'y':
                $secondLastChar = strtolower(substr($str, -2, 1));
                if (!in_array($secondLastChar, ['a', 'e', 'i', 'o', 'u'])) {
                    return substr($str, 0, -1) . 'ies'; // e.g., city -> cities
                }
                break;
        }

        return $str . 's';
    }

    /**
     * @param string $str
     * @return string
     */
    public static function singular(string $str) : string
    {
        $lastThreeChars = strtolower(substr($str, -3));
        $lastTwoChars = strtolower(substr($str, -2));
        $lastChar = strtolower(substr($str, -1));

        switch ($lastThreeChars) {
            case 'ies':
                return substr($str, 0, -3) . 'y'; // e.g., cities -> city
            case 'ses':
            case 'xes':
            case 'zes':
                return substr($str, 0, -2); // e.g., buses -> bus
            default:
                if ($lastChar === 's') {
                    return substr($str, 0, -1); // e.g., dogs -> dog
                } elseif ($lastTwoChars === 'es') {
                    return substr($str, 0, -1); // e.g., boxes -> box
                } else {
                    return $str; // singular form or irregular plural
                }
        }
    }
}