<?php
namespace Wall\App\Controllers;

use Wall\App\Core\AbstractController;
use Wall\App\Core\Response;

class Post extends AbstractController
{
    protected $sort = 'DESC';
    protected $limit = 10;

    public function getList() : Response
    {
        return new Response(200, ['arr' => 123]);
    }

    public function createPost() : Response
    {
        $this->request->authenticateUser();

        return new Response(200, ['test' => 'user authorized']);
    }
}