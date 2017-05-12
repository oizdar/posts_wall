<?php
namespace Wall\App\Controllers;

use Wall\App\Core\AbstractController;
use Wall\App\Core\Response;
use Wall\App\Exceptions\InvalidArgumentException;
use Wall\App\Services\Comments as CommentsService;

class Comments extends AbstractController
{
    /** @var CommentsService */
    protected $commentsService;

    public function __construct()
    {
        $this->commentsService = new CommentsService();
        parent::__construct();
    }

    public function getPostComments($postId) : Response
    {
        $postId = filter_var($postId, FILTER_VALIDATE_INT);

        if($postId === false) {
            throw new InvalidArgumentException('postId must be integer');
        }
        $page = $this->request->getParam('page');
        $limit = $this->request->getParam('limit');

        $posts = $this->commentsService->getPostComments($postId, $page, $limit);
        return new Response(200, $posts);
    }

    public function addPostComment($postId) : Response
    {
        $username = $this->request->authenticateUser();

        $postId = filter_var($postId, FILTER_VALIDATE_INT);
        if($postId === false) {
            throw new InvalidArgumentException('postId must be integer');
        }

        $postContent = $this->request->getParam('content');

        if(empty($postContent)) {
            throw new InvalidArgumentException('Field "content" is required and should not be empty.');
        }

        $this->commentsService->addComment($postId, $username, $postContent);
        return new Response(201, ['message' => 'Comment added.']);
    }

    public function deletePostComment($postId, $commentId) : Response
    {
        $username = $this->request->authenticateUser();

        $postId = filter_var($postId, FILTER_VALIDATE_INT);
        if($postId === false) {
            throw new InvalidArgumentException('postId must be integer');
        }

        $commentId = filter_var($commentId, FILTER_VALIDATE_INT);
        if($commentId === false) {
            throw new InvalidArgumentException('commentId must be integer');
        }

        if(!$this->commentsService->isEditable($postId, $commentId, $username)) {
            throw new InvalidArgumentException('Delete failed. Can\'t delete chosen comment please check inserted data.');
        }

        $this->commentsService->deleteComment($postId, $commentId, $username);

        return new Response(200, ['message' => 'Comment successfully deleted.']);
    }
}
