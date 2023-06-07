<?php

namespace app\database;

use app\helpers\ExceptionHelper;
use app\helpers\ObjectReflectionHelper;
use app\helpers\StringHelper;

abstract class Orm
{
    /**
     * @var string
     */
    protected string $table;

    /**
     * @return bool|array|self
     */
    public function findAll() : bool|array|self
    {
        $query =  $this->query('SELECT * FROM '. $this->table);

        return ExceptionHelper::TryAndCatch($query,'The ' .$this->table . ' is missing');
    }

    /**
     * @param int $id
     * @return bool|array|self
     */
    public function show(int $id): bool|array|self
    {
        $query =  $this->query('SELECT * FROM '. $this->table . ' where id = ' .$id);

        return ExceptionHelper::TryAndCatch($query,'The ' .$this->table . ' with the id ' . $id . ' is missing ');
    }

    /**
     * @param Object $object
     * @return $this
     */
    public function save(Object $object) : self
    {
        // ARRAY
        $getMethodNames = ObjectReflectionHelper::getGetterMethodNames($object);

        // STRING
        $getMethodNamesString = implode(',',$getMethodNames);

        // STRING WITH COLON
        $getMethodNamesStringColon = StringHelper::addColonToFrontOfWords($getMethodNamesString);

        // ARRAY
        $getProtectedProperties = ObjectReflectionHelper::getProtectedProperties($object);

        // QUERY
        $database = Database::getInstance();
        $query = "INSERT INTO $this->table ($getMethodNamesString) VALUES ($getMethodNamesStringColon)" ;

        $stmt = $database->prepare($query);

        // ARRAY LOOP
        foreach($getMethodNames as $value)
        {
            $stmt->bindValue(":$value",$getProtectedProperties[$value]);
        }

        $stmt->execute();

        return $this;
    }

    /**
     * @param string $query
     * @return bool|array
     */
    private function query(string $query): bool|array
    {
        $database = Database::getInstance()->query($query);
        return $database->fetchAll(\PDO::FETCH_ASSOC);
    }
}