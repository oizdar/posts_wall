<?php
namespace Wall\App\Exceptions;

class UserAlreadyExistsException extends \Exception
{
    public function __construct($message = "", $code = 400, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
