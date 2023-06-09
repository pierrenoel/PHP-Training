<?php

// Implementing a routing (very easy at the beginning)

// Send a request /posts

$uri = $_SERVER['REQUEST_URI'];

switch ($uri)
{
    case  '/posts' :
        require 'controllers/PostController.php';
        break;
}


$url = 'https://jsonplaceholder.typicode.com/posts';

$json = file_get_contents($url);

$json = json_decode($json);

echo '<pre>';
var_dump($json[0]);
echo '</pre>';