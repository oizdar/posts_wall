<?php
namespace Wall\App\Helpers;

use Wall\App\Exceptions\AppException;

class Request
{
    public static function getMethod() : string
    {
        if(isset($_SERVER['REQUEST_METHOD'])) {
            return $_SERVER['REQUEST_METHOD'];
        }
        throw new AppException('Only HTTP requests.');
    }

    public static function getPath() : string
    {
        return explode('?', trim($_SERVER['REQUEST_URI'], '/'))[0];
    }

    public static function getParams()
    {
        return $_REQUEST;
    }

    public static function getParam(string $key)
    {
        if(isset($_POST[$key])) {
            return $_POST[$key];
        }
        return null;
    }

}