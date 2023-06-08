<?php

namespace app\helpers;

class ExceptionHelper
{
    /**
     * @param mixed $mixed
     * @param $string
     * @return void
     * @throws \Exception
     */
    private static function ExceptionMessage(mixed $mixed, $string): void
    {
        if(empty($mixed)) throw new \Exception($string);
    }

    /**
     * @param mixed $mixed
     * @param string $message
     * @return mixed
     */
    public static function TryAndCatch(mixed $mixed, string $message, int $status = null): mixed
    {
        try {
            self::ExceptionMessage($mixed,$message);
            return $mixed;
        }catch(\Exception $e)
        {
            empty($status)
                ? http_response_code(404)
                : http_response_code($status);
            echo json_encode($e->getMessage());
        }

        return new self;
    }

}