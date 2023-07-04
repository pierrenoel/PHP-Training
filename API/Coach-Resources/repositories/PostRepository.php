<?php

namespace app\repositories;

use app\database\ORM;

class PostRepository extends ORM
{
    /**
     * @var string
     */
    protected string $table = 'posts';


}