<?php
namespace Wall\App;

use Wall\App\Helpers\Request;

class AbstractController
{
    protected $requestParams;

    public function __construct()
    {
        $this->requestParams = Request::getParams();
    }
}