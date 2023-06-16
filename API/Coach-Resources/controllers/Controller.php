<?php

namespace app\controllers;

use app\helpers\Response;

abstract class Controller
{
    protected mixed $response;
    protected mixed $request;

    public function __construct()
    {
        $this->response = new Response();
        $this->request = app('request')->request->all();
    }
}