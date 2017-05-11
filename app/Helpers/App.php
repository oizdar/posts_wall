<?php
namespace Wall\App\Helpers;

use Wall\App\Exceptions\PathException;
use Wall\App\Response;

class App
{
    protected const NAMESPACE_PREFIX = 'Wall\\App\\';

    public static function execute() : Response
    {
        $method = Request::getMethod();
        $path = Request::getPath();

        $path = explode('/', $path, 2);

        if($path[0] !== 'api') {
            throw new PathException('Page Not Found');
        }

        $action = explode('/', $path[1]);

        $pathsElements = simplexml_load_file(__DIR__ . '/../paths.xml');

        /** @var $configuredPath \SimpleXMLElement */
        foreach($pathsElements as $configuredPath) {
            if($method === strtoupper((string)$configuredPath->attributes()->method)) {
                $configuredAction = explode('/', $configuredPath->uri);
                $optionalVariables = static::comparePathArrays($action, $configuredAction);
                if(is_array($optionalVariables)) {
                    break;
                }
            };
        }
        if(!isset($optionalVariables) || !is_array($optionalVariables)) {
            throw new PathException('Route not found');
        }

        $controller = static::NAMESPACE_PREFIX . 'Controllers\\' . $configuredPath->controller;
        $controller = new $controller;

        return call_user_func_array([$controller, (string)$configuredPath->action], $optionalVariables);
    }

    protected static function comparePathArrays(array $pathToCompare, array $comparedPath)
    {
        $count = count($pathToCompare);
        if ($count !== count($comparedPath)) {
            return false;
        }

        $variables = [];
        for ($x = 0; $x < $count; $x++) {
            if (preg_match('/^{[a-zA-Z][a-zA-Z0-9]*}$/', $comparedPath[$x])) {
                $variables[] = $pathToCompare[$x];
                continue;
            }

            if ($pathToCompare[$x] !== $comparedPath[$x]) {
                return false;
            }
        }
        return $variables;
    }
}