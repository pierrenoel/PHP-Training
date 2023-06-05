<?php

namespace app\classes;

abstract class Role implements RoleInterface
{
    protected string $name;
    protected array $permissions = [];

    public function getName(): string
    {
        // TODO: Implement getName() method.
        return $this->name;
    }

    public function setPermissions(array $permissions) : self
    {
        $this->permissions = $permissions;
        return $this;
    }
    public function getPermissions() : array
    {
        return $this->permissions;
    }
}
