<?php

require_once './vendor/autoload.php';

$router = new \Pierre\Router\Router();

$router->get('/posts', function() {
    (new \app\controllers\PostController())->index();
});

$router->get('/post/:id', function($id) {
    (new \app\controllers\PostController())->show($id);
});

$router->post('/post/add',function(){
    (new \app\controllers\PostController())->create($_POST);
});

$router->delete('/post/delete/:id',function ($id){
    (new \app\controllers\PostController())->destroy($id);
});

$router->run();
