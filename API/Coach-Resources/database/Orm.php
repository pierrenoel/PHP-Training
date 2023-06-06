<?php

namespace app\database;

use app\helpers\Validation;
use app\models\Post;

abstract class Orm
{
    /**
     * @var string
     */
    protected string $table;

    /**
     * @return bool|array
     */
    public function findAll() : bool|array
    {
        return $this->query('select * from '. $this->table);
    }

    /**
     * @param int $id
     * @return bool|array
     */
    public function show(int $id): bool|array
    {
        return $this->query('select * from '. $this->table . ' where id = ' .$id);
    }

    public function save(Object $object)
    {
       var_dump(get_class_methods($object));
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