<?php 

namespace app\repositories;

use app\database\ORM;
class CategoryRepository extends ORM
{
	 protected string $table = 'categories';
}