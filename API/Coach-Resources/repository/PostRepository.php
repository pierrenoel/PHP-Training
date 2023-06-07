<?php

namespace app\repository;

use app\database\Orm;

class PostRepository extends Orm
{
    /**
     * @var string
     */
    protected string $table = 'posts';
}