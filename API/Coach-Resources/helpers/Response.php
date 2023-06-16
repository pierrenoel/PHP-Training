<?php

namespace app\helpers;

class Response
{
    protected mixed $response;
    protected array $array;
    public function __construct()
    {
        $this->response = app('response');
    }

    public function execute(array|bool $query, ?array $params): void
    {
        $title = (!empty($params['success_title'])) ? $params['success_title'] : 'message';
        $message = (!empty($params['success_message'])) ? $params['success_message'] : $query;
        $error_message = (!empty($params['error_message'])) ? $params['error_message'] : 'Oops, something is bad';
        $error_code = (!empty($params['error_code'])) ? $params['error_code'] : 404;

        if($query)
        {
            http_response_code(200);

            $this->response->setContent(json_encode([
                'response_code' => 200,
                $title => $message
            ]));

        }
        else
        {
            http_response_code($error_code);

            $this->response->setContent(json_encode([
                'response_code' => $error_code,
                'message' => $error_message
            ]));
        }

        $this->response->headers->set('Content-Type', 'application/json');

        echo $this->response;
    }

    public function setError(string $message, int $status): void
    {
        http_response_code($status);

        $this->response->setContent(json_encode([
            'response_code' => $status,
            'message' => $message
        ]));

        $this->response->headers->set('Content-Type', 'application/json');

        echo $this->response;
    }
}
