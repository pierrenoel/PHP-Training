<?php

namespace app\database;

use app\helpers\ExceptionHelper;
use app\helpers\ObjectReflectionHelper;
use app\helpers\StringHelper;
use app\models\Post;
use Symfony\Component\Console\Helper\Helper;

abstract class ORM
{
    /**
     * @var string
     */
    protected string $table;

    /**
     * @return bool|array
     */
    public function findAll(?array $options = null): bool|array
    {
        $stmt = Database::getInstance()->query('SELECT * FROM ' . $this->table);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $table
     * @return array
     */
    private function getModelClass(string $table): array
    {
        $singular = StringHelper::singular($table);
        $final = ucfirst($singular);
        $modelClass = "\\app\\models\\" . $final;

        return ObjectReflectionHelper::getGetterMethodNames(new $modelClass());
    }

    /**
     * @param string $table
     * @return string
     */
    private function relationshipStrConstruction(string $table) : string
    {
        $str = "";
        $className = $this->getModelClass($table);

        foreach($className as $value)
        {
            $str .= "\"".$value ."\",$table.$value,";
        }

        return substr($str,1,-1);
    }

    /**
     * @param object $class
     * @param string $foreign_id
     * @param string $table
     * @return array|false
     */
    public function hasOne(string $foreign_key, string $table, ?int $id = null): bool|array
    {
        $foreign_table = StringHelper::singular($table);


        $stmt = Database::getInstance()->query(
            'SELECT '.$this->table.'.*, JSON_ARRAYAGG(JSON_OBJECT("'.$this->relationshipStrConstruction($table).')) AS '.$foreign_table.'
            FROM ' . $this->table . ' 
            INNER JOIN '.$table.' ON '.$this->table.'.'.$foreign_key.' = '.$table.'.id '
            . (isset($id) ? 'WHERE '.$this->table.'.id = '.$id : '') . '
            GROUP BY '.$this->table.'.id');

        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($results as &$result) {
            $result[$foreign_table] = json_decode($result[$foreign_table], true);
        }

        return $results;
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
        // TODO: This part should be separate - from here
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

        // Todo: to here

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
    public function delete(?int $id): bool
    {
        $deleteStmt = Database::getInstance()->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $deleteStmt->bindValue(':id', $id);
        return $deleteStmt->execute();
    }
}
