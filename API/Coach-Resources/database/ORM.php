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
        $query = $this->query('SELECT * FROM ' . $this->table);
        return ExceptionHelper::TryAndCatch($query, 'Oops, something went wrong!');
    }

    /**
     * @param int $id
     * @return array|null
     */
    public function find(int $id): ?array
    {
        $stmt = Database::getInstance()->prepare('SELECT * FROM '. $this->table . ' where id = :id');
        $stmt->bindValue(':id',$id);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return ExceptionHelper::TryAndCatch($result,'Oops, something is wrong!');
    }
    public function save(object $object)
    {
        $getMethodNames = ObjectReflectionHelper::getGetterMethodNames($object);
        $getMethodNamesString = implode(',', $getMethodNames);
        $getMethodNamesStringColon = StringHelper::addColonToFrontOfWords($getMethodNamesString);
        $getProtectedProperties = ObjectReflectionHelper::getProtectedProperties($object);

        $stmt = Database::getInstance()->prepare("INSERT INTO $this->table ($getMethodNamesString) VALUES ($getMethodNamesStringColon)");

        foreach ($getMethodNames as $value) {
            $stmt->bindValue(":$value", $getProtectedProperties[$value]);
        }

        $result = $stmt->execute();
        return ExceptionHelper::TryAndCatch($result, 'Oops, something went wrong!');
    }

    /**
     * @param array $existing
     * @param array $request
     * @return mixed
     */
    public function update(array $existing, array $request): mixed
    {
        $array = [];
        $str = "";

        foreach($request as $key => $value)
        {
            empty($value) ? $array[$key] = $existing[$key] : $array[$key] = $value;
        }

        $singular = StringHelper::singular($this->table);
        $final = ucfirst($singular);
        $modelClass = "\\core\\models\\" . $final;

        $getMethodNames = ObjectReflectionHelper::getGetterMethodNames(new $modelClass());

        // construct the query like name=:name, title=:title, ...
        foreach($getMethodNames as $value)
        {
            $str .= $value.'=:'.$value.',';
        }

        $str = substr_replace($str ,"", -1);

        // Making the sql
        $stmt = Database::getInstance()->prepare('UPDATE '.$this->table . ' SET ' . $str .' WHERE id='. $existing["id"]);

        foreach($getMethodNames as $value)
        {
            $stmt->bindValue(":$value",$array[$value]);
        }

        $result = $stmt->execute();

        return ExceptionHelper::TryAndCatch($result,'Oops, something is wrong!');
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id) : void
    {
        $stmt = Database::getInstance()->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $rowCount = $stmt->rowCount();

        if ($rowCount === 0) {
            ExceptionHelper::TryAndCatch($rowCount,'Oops, something is wrong!');
        }

        $deleteStmt = Database::getInstance()->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $deleteStmt->bindValue(':id', $id);
        $deleteStmt->execute();
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