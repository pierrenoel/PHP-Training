<?php

namespace app\core;

use app\database\Database;
use app\helpers\ExceptionHelper;

class FieldAuth
{
    public function isAuth(string $access_token)
    {
        $stmt = Database::getInstance()->prepare('SELECT * FROM users where access_token = :access_token');
        $stmt->bindValue(':access_token',$access_token);
        $stmt->execute();

        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return ExceptionHelper::TryAndCatch($result,'You don\'t have the access, please contact the support');
    }
}