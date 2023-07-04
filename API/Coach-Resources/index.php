<?php

header("Access-Control-Allow-Origin: *");

require_once './vendor/autoload.php';

function app(string $name)
{
    $container = require 'config/Services.php';
    return $container->resolve($name);
}

require_once 'routes.php';
