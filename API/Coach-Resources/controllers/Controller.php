<?php

namespace app\controllers;

use app\helpers\ExceptionHelper;

class Controller
{
    public function toJson(array $array): bool|string
    {
        return json_encode($array);
    }
}