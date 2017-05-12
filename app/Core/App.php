<?php
namespace Wall\App\Core;

use Wall\App\Exceptions\RouteNotFoundException;

class App
{
    protected static $instance;

    /** @var  Request */
    protected $request;

    protected const NAMESPACE_PREFIX = 'Wall\\App\\';

    protected function __construct()
    {
        $this->request = Request::getRequest();
    }

    public static function init()
    {
        if(!self::$instance) {
            self::$instance = new App();
        }
        return self::$instance;
    }

    public function execute() : Response
    {
        $method = $this->request->getMethod();
        $path = $this->request->getPath();

        $path = explode('/', $path, 2);

        if($path[0] !== 'api') {
            throw new RouteNotFoundException('Invalid Route');
        }

        $action = explode('/', $path[1]);

        $pathsElements = simplexml_load_file(__DIR__ . '/../routes.xml');

        /** @var $configuredPath \SimpleXMLElement */
        foreach($pathsElements as $configuredPath) {
            if($method === strtoupper((string)$configuredPath->attributes()->method)) {
                $configuredAction = explode('/', $configuredPath->uri);
                $optionalVariables = $this->comparePathArrays($action, $configuredAction);
                if(is_array($optionalVariables)) {
                    break;
                }
            };
        }
        if(!isset($optionalVariables) || !is_array($optionalVariables)) {
            throw new RouteNotFoundException("Api route \"{$path[1]}\" not found");
        }

        $controller = static::NAMESPACE_PREFIX . 'Controllers\\' . $configuredPath->controller;
        $controller = new $controller;

        return call_user_func_array([$controller, (string)$configuredPath->action], $optionalVariables);
    }

    protected function comparePathArrays(array $pathToCompare, array $comparedPath)
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
