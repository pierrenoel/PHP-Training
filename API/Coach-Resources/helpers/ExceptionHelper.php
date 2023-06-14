<?php

namespace app\helpers;

class ExceptionHelper
{

    protected Response $reponse;

    public function __construct()
    {
        $this->reponse = app('response');
    }

    public static function getException(string $success_title, bool|array $query, array $error)
    {

        $response = app('response');

        if($query) {
            $response->setContent(json_encode([
                'response_code' => 200,
                $success_title => $query
            ]));
        }
        else
        {
            http_response_code($error['response_code']);
            $response->setContent(json_encode([
                'response_code' => $error['response_code'],
                'message' => $error['message']
            ]));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public static function postException(string $success_title, string $title, bool $query, array $error)
    {

        $response = app('response');

        if($query) {
            $response->setContent(json_encode([
                'response_code' => 200,
                $success_title => $title
            ]));
        }
        else
        {
            http_response_code($error['response_code']);
            $response->setContent(json_encode([
                'response_code' => $error['response_code'],
                'message' => $error['message']
            ]));
        }

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}