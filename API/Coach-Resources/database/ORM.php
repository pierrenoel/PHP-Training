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

        // TODO: Transform that into a prepared statement

        $query =  $this->query('SELECT * FROM '. $this->table);

        // Check if the query is not empty, if empty => throw new error message with a 404 status
        return ExceptionHelper::TryAndCatch($query,'Oops, something is wrong!');
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id): mixed
    {
        $query =  $this->query('SELECT * FROM '. $this->table . ' where id = ' .$id);

        // Check if the query is not empty, if empty => throw new error message with a 404 status
        return ExceptionHelper::TryAndCatch($query,'Oops, something is wrong!');
    }

    /**
     * @param Object $object
     * @return mixed
     */
    public function save(object $object): mixed
    {

        // TODO: To improve this method

        // ARRAY
        $getMethodNames = ObjectReflectionHelper::getGetterMethodNames($object);

        // STRING
        $getMethodNamesString = implode(',',$getMethodNames);

        // STRING WITH COLON
        $getMethodNamesStringColon = StringHelper::addColonToFrontOfWords($getMethodNamesString);

        // ARRAY
        $getProtectedProperties = ObjectReflectionHelper::getProtectedProperties($object);

        // QUERY
        $stmt = $this->prepare("INSERT INTO $this->table ($getMethodNamesString) VALUES ($getMethodNamesStringColon)");

        // ARRAY LOOP
        foreach($getMethodNames as $value)
        {
            $stmt->bindValue(":$value",$getProtectedProperties[$value]);
        }

        $result = $stmt->execute();

        return ExceptionHelper::TryAndCatch($result,'Oops, something is wrong!');
    }

    public function delete(int $id) : bool
    {
        $current_id = $this->find($id);

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

    private function prepare(string $query): bool|\PDOStatement
    {
        return Database::getInstance()->prepare($query);
    }
}