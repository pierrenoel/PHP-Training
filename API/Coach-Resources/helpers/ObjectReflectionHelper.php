<?php

namespace app\helpers;

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
}