<?php
namespace Wall\App\Helper;

use Wall\App\Core\Response;

class ExceptionHandler
{
    public static function handler($exception)
    {
        $httpCode = $exception->getCode();
        $content = ['error' => $exception->getMessage()];

        //Prepare code string:
        $class =  explode('\\', get_class($exception));
        $code =  preg_replace( '/([a-z0-9])([A-Z])/', "$1_$2", end($class));

        echo new Response($httpCode, $content, $code);
    }
}