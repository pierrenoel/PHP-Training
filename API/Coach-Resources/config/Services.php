<?php

use app\core\Container;
use \Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$container = new Container();

$container->register('request',function($container){
    return Request::createFromGlobals();
});

$container->register('response',function($container){
   return new Response();
});

return $container;