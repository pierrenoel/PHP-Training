<?php

namespace app\helpers;

class ExceptionHelper
{

    private static function ExceptionMessage(mixed $mixed, string $string): void
    {
        if(empty($mixed)) throw new \Exception($string);
    }

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