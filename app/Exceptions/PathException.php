<?php
namespace Wall\App\Exceptions;

class PathException extends \Exception
{
    public function __construct($message = "", $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}