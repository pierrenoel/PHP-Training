<?php

namespace app\helpers;

use app\models\Post;

class ObjectReflectionHelper
{
    /**
     * @param Object $object
     * @return array
     */
    public static function getGetterMethodNames(Object $object): array
    {
        $array = [];

        foreach(get_class_methods($object) as $object)
        {
            $array[] = strtolower(substr($object,3));
        }

        return array_unique($array);
    }

    /**
     * @param Object $object
     * @return array
     */
    public static function getProtectedProperties(Object $object): array
    {
        $reflection = new \ReflectionObject($object);

        $properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);

        $postArray = [];

        foreach ($properties as $property) {

            $propertyName = $property->getName();

            $getterMethod = "get" . ucfirst($propertyName);

            if (method_exists($object, $getterMethod)) {

                $propertyValue = $object->$getterMethod();

                $postArray[$propertyName] = $propertyValue;
            }
        }

        return $postArray;
    }

    public static function getOrmDoc(string $model): array
    {
        $methods = [];
        $orm = [];

        $model = new $model;

        $reflection = new \ReflectionObject($model);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PROTECTED);

        foreach ($properties as $property) {

            $propertyName = $property->getName();

            $getterMethod = "get" . ucfirst($propertyName);

            $methods[] = $getterMethod;

        }

        foreach($methods as $method)
        {
            $result = $reflection->getMethod($method)->getDocComment();

            $pattern = '/@orm\s+(.*)/';

            if (preg_match($pattern, $result, $matches)) {
                $extractedText = $matches[1];
                $orm[$method] = $extractedText;
            }
        }

        return $orm;
    }
}