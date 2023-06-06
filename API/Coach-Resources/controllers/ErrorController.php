<?php

namespace app\controllers;

class ErrorController extends Controller
{
    public function error_404(): bool|int
    {
        return http_response_code(404);
    }
}