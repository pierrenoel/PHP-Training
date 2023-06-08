<?php

namespace app\database;

use app\helpers\ExceptionHelper;
use app\helpers\ObjectReflectionHelper;
use app\helpers\StringHelper;

abstract class ORM
{
    /**
     * @var string
     */
    protected string $table;

    /**
     * @return mixed
     */
    public function findAll() : mixed
    {
        $query =  $this->query('SELECT * FROM '. $this->table);

        return ExceptionHelper::TryAndCatch($query,'Oops, something is wrong!');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        $stmt = Database::getInstance()->prepare('SELECT * FROM '. $this->table . ' where id = :id');
        $stmt->bindValue(':id',$id);
        $stmt->execute();

        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return ExceptionHelper::TryAndCatch($result,'Oops, something is wrong!');
    }

    /**
     * @param Object $object
     * @return mixed
     */
    public function save(object $object): mixed
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
        $stmt = Database::getInstance()->prepare("INSERT INTO $this->table ($getMethodNamesString) VALUES ($getMethodNamesStringColon)");

        // ARRAY LOOP
        foreach($getMethodNames as $value)
        {
            $stmt->bindValue(":$value",$getProtectedProperties[$value]);
        }

        $result = $stmt->execute();

        return ExceptionHelper::TryAndCatch($result,'Oops, something is wrong!');
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id) : bool
    {

        $stmt = Database::getInstance()->prepare('SELECT * FROM '. $this->table . ' where id = :id');
        $stmt->bindValue(':id',$id);
        $stmt->execute();

        $current_id = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if(!empty($current_id))  $query =  $this->query('DELETE FROM '. $this->table . ' where id = ' .$id);
        else return ExceptionHelper::TryAndCatch($current_id,'Oops, something is wrong!');

        return true;
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