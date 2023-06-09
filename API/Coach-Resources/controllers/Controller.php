<?php

namespace app\controllers;

use Symfony\Component\HttpFoundation\Response;

class Controller
{
    public function toJson(array $array): bool|string
    {
        return json_encode($array);
    }
}