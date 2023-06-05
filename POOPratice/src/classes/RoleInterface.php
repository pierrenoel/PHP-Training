<?php

namespace app\classes;

interface RoleInterface
{
    public function getName() : string;
    public function getPermissions() : array;
}