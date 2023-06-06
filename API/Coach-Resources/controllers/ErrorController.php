<?php

namespace app\controllers;

class ErrorController extends Controller
{
    public function error_404()
    {
        http_send_status(404);
    }
}