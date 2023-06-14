<?php

use app\core\Container;

$container = new Container();

$container->register('request',function($container){
    return \Symfony\Component\HttpFoundation\Request::createFromGlobals();
});

return $container;