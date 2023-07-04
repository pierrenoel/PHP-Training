<?php

namespace app\helpers;

class Response
{
    /**
     * @var mixed
     */
    protected mixed $response;
    /**
     * @var array
     */
    protected array $array;

    /**
     *
     */
    public function __construct()
    {
        $this->response = app('response');
    }

    /**
     * @param array|bool $query
     * @param array|null $params
     * @return void
     */
    public function execute(array|bool $query, ?array $params): void
    {
  
        $title = (!empty($params['success_title'])) ? $params['success_title'] : 'message';
        $message = (!empty($params['success_message'])) ? $params['success_message'] : $query;
        $error_message = (!empty($params['error_message'])) ? $params['error_message'] : 'Oops, something is bad';
        $error_code = (!empty($params['error_code'])) ? $params['error_code'] : 404;

        if($query)
        {
            $this->response->setContent(json_encode([
                'response_code' => 200,
                $title => $message
            ]));

            http_response_code(200);
        }
        else
        {
            $this->response->setContent(json_encode([
                'response_code' => $error_code,
                'message' => $error_message
            ]));

            http_response_code($error_code);

        }

        $this->response->headers->set('Content-Type', 'application/json');

        echo $this->response->getContent();
    }

    /**
     * @param string $message
     * @param int $status
     * @return void
     */
    public function setError(string $message, int $status): void
    {
        http_response_code($status);

        $this->response->setContent(json_encode([
            'response_code' => $status,
            'message' => $message
        ]));

        $this->response->headers->set('Content-Type', 'application/json');

        echo $this->response->getContent();
    }
}

