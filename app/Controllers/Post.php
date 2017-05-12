<?php
namespace Wall\App\Controllers;

use Wall\App\Core\AbstractController;
use Wall\App\Core\Response;
use Wall\App\Exceptions\InvalidArgumentException;
use Wall\App\Services\Post as PostService;

class Post extends AbstractController
{
    /** @var PostService */
    protected $postService;

    public function __construct()
    {
        $this->postService = new PostService();
        parent::__construct();
    }

    public function getList() : Response
    {
        $page = $this->request->getParam('page');
        $limit = $this->request->getParam('limit');

        $posts = $this->postService->getList($page, $limit);
        return new Response(200, $posts);
    }

    public function createPost() : Response
    {
        $username = $this->request->authenticateUser();
        $postContent = $this->request->getParam('content');

        if(empty($postContent)) {
            throw new InvalidArgumentException('Field "content" is required and should not be empty.');
        }

        $this->postService->addPost($username, $postContent);
        return new Response(201, ['message' => 'Post added.']);
    }

    public function updatePost($id) : Response
    {
        $username = $this->request->authenticateUser();

        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id === false) {
            throw new InvalidArgumentException('postId must be integer');
        }

        $postContent = $this->request->getParam('content');
        if(empty($postContent)) {
            throw new InvalidArgumentException('Field "content" is required and should not be empty.');
        }

        if(!$this->postService->isEditable($id, $username)) {
            throw new InvalidArgumentException('Update failed. Can update only own posts.');
        }

        $this->postService->updatePost($id, $username, $postContent);
        return new Response(200, ['message' => 'Post updated.']);
    }

    public function deletePost($id) : Response
    {
        $username = $this->request->authenticateUser();

        $id = filter_var($id, FILTER_VALIDATE_INT);
        if($id === false) {
            throw new InvalidArgumentException('postId must be integer');
        }

        if(!$this->postService->isEditable($id, $username)) {
            throw new InvalidArgumentException('Delete failed. Can delete only own posts.');
        }

        $this->postService->deletePost($id, $username);
        return new Response(200, ['message' => 'post successfully deleted']);

    }

}
