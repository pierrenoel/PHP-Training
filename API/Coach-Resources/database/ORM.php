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

    /**
     * @param int|null $id
     * @return bool
     */
    public function delete(?int $id)
    {
        $deleteStmt = Database::getInstance()->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $deleteStmt->bindValue(':id', $id);
        return $deleteStmt->execute();
    }

    /**
     * @param string $foreign_table
     * @param string $foreign_name
     * @return array|bool
     */
    public function hasOne(string $foreign_table, string $foreign_name)
    {

        $called_table = $this->whatnameused($this->table,'x',true);
        $joined_table = $this->whatnameused($foreign_table,'y',false);

        return $this->query(
            'SELECT '.$called_table.','.$joined_table.' as description
             FROM '.$this->table.' x
             join '.$foreign_table.' y
             on x.'.$foreign_name.' = y.id');
    }

    /**
     * @param string $table
     * @param string $letter
     * @param bool $lastOne
     * @return string
     */
    private function whatnameused(string $table, string $letter, bool $lastOne): string
    {
        $tableOne =  $this->query('DESCRIBE '.$table);

        $array = [];

        foreach($tableOne as $key => $value)
        {
            $array[] = $letter .'.'.$value['Field'];
        }

        if($lastOne)
        {
            $removedVal = array_slice($array, 0, -1);
            $str = implode(',',$removedVal);
        }
        else
        {
            $str = implode(',',$array);
        }

        return $str;
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
