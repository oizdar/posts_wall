<?php
namespace Wall\App\Exceptions;

class RouteNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}