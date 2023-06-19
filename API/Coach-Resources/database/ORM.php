<?php

namespace app\database;

use app\helpers\ObjectReflectionHelper;
use app\helpers\StringHelper;

abstract class ORM
{
    /**
     * @var string
     */
    protected string $table;

    /**
     * @param array|null $options
     * @return bool|array
     */
    public function findAll(?array $options = null): bool|array
    {
        $stmt = Database::getInstance()->query('SELECT * FROM ' . $this->table);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $foreign_key
     * @param string $table
     * @param int|null $id
     * @return bool|array
     */
    public function getOne(string $foreign_key, string $table, ?int $id = null): bool|array
    {
        $foreign_table = StringHelper::singular($table);

        $stmt = Database::getInstance()->query(
            'SELECT '.$this->table.'.*, JSON_ARRAYAGG(JSON_OBJECT("'.$this->buildRelationshipOneString($table).')) AS '.$foreign_table.'
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
     * @param string $foreign_key
     * @param string $table
     * @param int $id
     * @return bool|array
     */
    public function getAll(string $foreign_key, string $table, int $id): bool|array
    {
        $stmt = Database::getInstance()->prepare('SELECT * FROM '. $table . ' where '.$foreign_key.' = :id');
        $stmt->bindValue(':id',$id);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
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
        $array = $this->processRequestData($existing, $request);

        $str = $this->constructUpdateQuery($this->getModelClass($this->table));

        $stmt = Database::getInstance()->prepare('UPDATE '.$this->table . ' SET ' . $str .' WHERE id='. $existing["id"]);

        $getMethodNames = $this->getModelClass($this->table);

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

    /**
     * @param array $existing
     * @param array $request
     * @return array
     */
    private function processRequestData(array $existing, array $request): array
    {
        $array = [];

        foreach($request as $key => $value)
        {
            empty($value) ? $array[$key] = $existing[$key] : $array[$key] = $value;
        }

        return $array;
    }

    /**
     * @param array $getMethodNames
     * @return string
     */
    private function constructUpdateQuery(array $getMethodNames): string
    {
        $str = "";

        foreach($getMethodNames as $value)
        {
            $str .= $value.'=:'.$value.',';
        }

        return substr_replace($str ,"", -1);
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
    private function buildRelationshipOneString(string $table) : string
    {
        $str = "";

        $className = $this->getModelClass($table);

        foreach($className as $value)
        {
            $str .= "\"".$value ."\",$table.$value,";
        }

        return substr($str,1,-1);
    }
}
