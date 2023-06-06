<?php

namespace app\classes;

class Permission
{
    public function __construct(
        protected string $name
    ){}

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}