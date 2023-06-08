<?php

require_once './vendor/autoload.php';

/*
Note about the router: make an easy router, not necessarily difficult one
*/


$uri =  explode('/',$_SERVER['REQUEST_URI']);
$request_method = $_SERVER['REQUEST_METHOD'];

// /posts
if($uri[1] == 'posts')
    if($request_method == "GET") (new \app\controllers\PostController())->index();


// post/1
if($uri[1] == 'post' && !empty($uri[2]))
    if($request_method == "GET") (new \app\controllers\PostController())->show($uri[2]);

if($uri[1] == 'add-post')
{
    if($request_method == "POST") (new \app\controllers\PostController())->create($_POST);
}

if($uri[1] == 'delete' && !empty($uri[2]))
{
    if($request_method == "GET") (new \app\controllers\PostController())->destroy($uri[2]);
}
