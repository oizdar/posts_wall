<?php
namespace Wall\App\Exceptions;

class PostNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 404, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
