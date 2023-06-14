<?php

namespace app\core;

class Container
{
    /**
     * @var array
     */
    private array $services = [];

    /**
     * @param string $name
     * @param $factory
     * @return void
     */
    public function register(string $name, $factory): void
    {
        $this->services[$name] = $factory;
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function resolve(string $name): mixed
    {
        if(!isset($this->services[$name])) throw new Exception("Service '$name' not found in the container.");

        $factory = $this->services[$name];

        return $factory($this);
    }
}