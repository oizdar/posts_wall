<?php
namespace Wall\App\Core;

use Wall\App\Exceptions\AppException;
use Wall\App\Exceptions\AuthorizationException;
use Wall\App\Helper\Authorization;

class Request
{
    /** @var  Request */
    protected static $request;

    protected $method;
    protected $params;

    protected $authUser;
    protected $authPass;


    protected function __construct()
    {
        $this->checkMethod();
        $this->path = explode('?', trim($_SERVER['REQUEST_URI'], '/'))[0];
        $this->params = $_REQUEST;

        if(isset($_SERVER['PHP_AUTH_USER'])) {
            $this->authUser = $_SERVER['PHP_AUTH_USER'];
            $this->authPass = $_SERVER['PHP_AUTH_PW'];
        }
    }

    public static function getRequest()
    {
        if(!isset(self::$request)) {
            self::$request = new Request();
        }
        return self::$request;
    }

    public function checkMethod()
    {
        if(!isset($_SERVER['REQUEST_METHOD'])) {
            throw new AppException('Only HTTP requests.');
        }
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function getMethod() : string
    {
        return $this->method;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function getParams() : array
    {
        return $this->params;
    }

    public function getParam(string $key)
    {
        if(isset($this->params[$key])) {
            return $this->params[$key];
        }
        return null;
    }

    /**
     * @throws AuthorizationException
     */
    public function authenticateUser()
    {
        Authorization::verify($this->authUser, $this->authPass);
    }
}