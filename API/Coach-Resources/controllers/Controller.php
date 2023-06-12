<?php

namespace app\controllers;

class Controller
{
    public function toJson(array $array): bool|string
    {
        return json_encode($array);
    }
}