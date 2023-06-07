<?php

namespace app\helpers;

class ExceptionHelper
{
    /**
     * @param mixed $mixed
     * @param $string
     * @return self
     * @throws \Exception
     */
    private static function ExceptionMessage(mixed $mixed, $string): self
    {
        if(empty($mixed)) throw new \Exception($string);
        return new self;
    }

    /**
     * @param mixed $mixed
     * @param string $message
     * @return mixed
     */
    public static function TryAndCatch(mixed $mixed, string $message): mixed
    {
        try {
            self::ExceptionMessage($mixed,$message);
            return $mixed;
        }catch(\Exception $e)
        {
            http_response_code(404);
            echo $e->getMessage();
        }

        return new self;
    }

}