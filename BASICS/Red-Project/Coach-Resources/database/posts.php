<?php


function getPost()
{
    $url = 'https://jsonplaceholder.typicode.com/posts';

    return file_get_contents($url);
}




