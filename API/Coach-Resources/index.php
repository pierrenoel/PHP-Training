<?php

require_once './vendor/autoload.php';

/*
Note about the router: make an easy router, not necessarily difficult one
*/


$uri =  $_SERVER['REQUEST_URI'];

switch ($uri)
{
    case '/posts' :
        (new \app\controllers\PostController())->index();
        break;
    case '/post':
        (new \app\controllers\PostController())->show(1);
        break;
}
