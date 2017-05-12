<?php
namespace Wall\App\Core;

class AbstractController
{
    protected $requestParams;

    /** @var \PDO */
    protected $pdo;

    public function __construct()
    {
        $this->request = Request::getRequest();
        $this->pdo = DbProvider::getInstance()->getConnection();
    }
}