<?php

namespace app\database;

use PDO;

class Database
{
    /**
     * @var PDO|null
     */
    private ?PDO $PDOInstance = null;
    /**
     * @var Database|null
     */
    private static ?Database $instance = null;

    private function __construct()
    {
        $database = require 'config.php';
        $this->PDOInstance = new PDO('mysql:dbname=' . $database['database']['name'] . ';host=' . $database['database']['host'], $database['database']['user'], $database['database']['password']);
    }

    /**
     * @return Database|null
     */
    public static function getInstance(): ?Database
    {
        if (is_null(self::$instance)) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * @param $query
     * @return bool|\PDOStatement
     */
    public function query($query): bool|\PDOStatement
    {
        return $this->PDOInstance->query($query);
    }
}