<?php

namespace app\repository;

use app\database\Orm;

class PostRepository extends Orm
{
    protected string $table = 'posts';
}