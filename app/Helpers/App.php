<?php
namespace Wall\App\Helpers;

use Wall\App\Exceptions\PathException;

class App
{
    public static function getCommand() : Command
    {
        $method = Request::getMethod();
        $path = Request::getPath();

        $action = explode('/', $path);

        if($action[0] !== 'api') {
            throw new PathException('Invalid Route');
        }

        return new Command();
    }

}