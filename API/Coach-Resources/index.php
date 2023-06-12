<?php

require_once './vendor/autoload.php';

use \Pierre\Router\Router;
use \Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$router = new Router();

// Router

$router->get('/posts', function() {
    (new \app\controllers\PostController())->index();
});

$router->get('/post/:id', function($id) {
    (new \app\controllers\PostController())->show($id);
});

$router->post('/post/add',function(){
    (new \app\controllers\PostController())->create($_POST);
});

$router->post('/post/edit/:id',function($id) use ($request){
    (new \app\controllers\PostController())->edit($id,$request);
});

$router->delete('/post/delete/:id',function ($id){
    (new \app\controllers\PostController())->destroy($id);
});

$router->run();



