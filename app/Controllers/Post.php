<?php
namespace Wall\App\Controllers;

use Wall\App\AbstractController;
use Wall\App\Response;

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
    }
}