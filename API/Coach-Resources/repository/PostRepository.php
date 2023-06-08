<?php

namespace app\repository;

use app\database\ORM;

class PostRepository extends ORM
{
    /**
     * @var string
     */
    protected string $table = 'posts';
}