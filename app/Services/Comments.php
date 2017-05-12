<?php
namespace Wall\App\Services;

use Wall\App\Core\DbProvider;
use Wall\App\Exceptions\DatabaseException;

class Comments
{
    protected const DEFAULT_COMMENTS_LIMIT = 10;
    protected const SORT_ORDER = 'DESC';

    /** @var \PDO */
    protected $db;

    public function __construct()
    {
        $this->db = DbProvider::getInstance()->getConnection();
    }

    /** @throws DatabaseException */
    public function addComment(int $postId, string $username, string $content) : void
    {
        $sql = 'INSERT INTO `comments` 
            SET `post_id` = :postId, `content` = :content,`user` = :username
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute([
            'postId' => $postId,
            'content' => $content,
            'username' => $username
        ])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        };
    }

    public function getPostComments(int $postId, int $page = null, int $limit = null)
    {
        if($page === null) {
            $page = 1;
        }
        if($limit === null) {
            $limit = static::DEFAULT_COMMENTS_LIMIT;
        }
        $offset = ($page-1)*$limit;

        $sql = 'SELECT * FROM `comments`'
            . 'WHERE `post_id` = :postId'
            . ' ORDER BY `create_date` ' . static::SORT_ORDER
            . ' LIMIT ' . $limit
            . ' OFFSET ' . $offset ;

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['postId' => $postId])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        };

        $comments = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $comments;
    }
}
