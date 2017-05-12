<?php
namespace Wall\App\Exceptions;

class InvalidArgumentException extends \Exception
{
    public function __construct($message = "", $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
