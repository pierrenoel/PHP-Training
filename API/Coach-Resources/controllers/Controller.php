<?php

namespace app\controllers;

abstract class Controller
{

    public function toJson(array $array)
    {
        $response = app('response');

        $response->setContent(json_encode($array));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}