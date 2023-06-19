<?php

use \Pierre\Router\Router;

$router = new Router();

// Router
$router->get('/posts', function() {
    (new \app\controllers\PostController())->index();
});

$router->get('/post/:id', function($id) {
    (new \app\controllers\PostController())->show($id);
});

$router->post('/post/add',function(){
    (new \app\controllers\PostController())->create();
});

$router->post('/post/edit/:id',function($id) {
    (new \app\controllers\PostController())->edit($id);
});

$router->delete('/post/delete/:id',function ($id){
    (new \app\controllers\PostController())->destroy($id);
});

// Categories
$router->get('/categories',function(){
    (new \app\controllers\CategoryController())->index();
});

$router->get('/category/:id',function($id){
    (new \app\controllers\CategoryController())->show($id);
});

$router->run();