<?php

require_once './vendor/autoload.php';

use app\classes\User;
use app\classes\Admin;
use app\classes\Permission;

// Create some roles
$adminRole = new Admin();

// Create some permissions
$permissionOne = new Permission('one');
$permissionTwo = new Permission('two');

// Edit a permission
$permissionTwo->setName('two_updated');

// Set a permission to role
$adminRole->setPermissions([$permissionOne,$permissionTwo]);

// Create a new user
$user = new User('Pierre','pierrenoel@hotmail.be','password');

foreach($user->getRole()->getPermissions() as $permission)
{
    echo $permission->getName() . ' ';
}

