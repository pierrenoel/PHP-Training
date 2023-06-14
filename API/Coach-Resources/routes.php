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

$router->run();