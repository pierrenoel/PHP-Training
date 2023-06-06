<?php

namespace app\controllers;

class Controller
{
    public function toJson(array $array): bool|string
    {
        return !empty($array) ? json_encode($array) : 'There is nothing for your here';
    }
}