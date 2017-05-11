<?php
namespace Wall\App\Helpers;

class Request
{
    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getPath()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getPost()
    {
        return $_POST;
    }


    public static function getParam(string $key)
    {
        if(isset($_POST[$key])) {
            return $_POST[$key];
        }
        if(isset($_GET[$key])) {
            return $_GET[$key];
        }
        return null;
    }

}