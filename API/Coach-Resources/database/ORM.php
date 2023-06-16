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
     * @return bool|array
     */
    public function findAll(): bool|array
    {
        return $this->query('SELECT * FROM ' . $this->table);
    }

    /**
     * @param int $id
     * @return bool|array
     */
    public function find(int $id) : bool|array
    {
        $stmt = Database::getInstance()->prepare('SELECT * FROM '. $this->table . ' where id = :id');
        $stmt->bindValue(':id',$id);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param object $object
     * @return bool
     */
    public function save(object $object): bool
    {
        $getMethodNames = ObjectReflectionHelper::getGetterMethodNames($object);
        $getMethodNamesString = implode(',', $getMethodNames);
        $getMethodNamesStringColon = StringHelper::addColonToFrontOfWords($getMethodNamesString);
        $getProtectedProperties = ObjectReflectionHelper::getProtectedProperties($object);

        $stmt = Database::getInstance()->prepare("INSERT INTO $this->table ($getMethodNamesString) VALUES ($getMethodNamesStringColon)");

        foreach ($getMethodNames as $value) {
            $stmt->bindValue(":$value", $getProtectedProperties[$value]);
        }

       return $stmt->execute();
    }

    /**
     * @param array $existing
     * @param array $request
     * @return bool
     */
    public function update(array $existing, array $request): bool
    {
        $array = [];
        $str = "";

        foreach($request as $key => $value)
        {
            empty($value) ? $array[$key] = $existing[$key] : $array[$key] = $value;
        }

        $singular = StringHelper::singular($this->table);
        $final = ucfirst($singular);
        $modelClass = "\\app\\models\\" . $final;

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

        return $stmt->execute();
    }

    public function delete(?int $id)
    {
        $deleteStmt = Database::getInstance()->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $deleteStmt->bindValue(':id', $id);
        return $deleteStmt->execute();
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