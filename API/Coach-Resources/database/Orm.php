<?php

namespace app\database;
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