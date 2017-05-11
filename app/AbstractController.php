<?php
namespace Wall\App;

use Wall\App\Helpers\Request;

class AbstractController
{
    protected $requestParams;

    /** @var \PDO */
    protected $pdo;

    public function __construct()
    {
        $this->requestParams = Request::getParams();
        $this->pdo = DbProvider::getInstance()->getConnection();
    }
}