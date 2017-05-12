<?php
namespace Wall\App\Exceptions;

class AuthorizationException extends \Exception
{
    public function __construct($message = "", $code = 403, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}