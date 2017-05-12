<?php
namespace Wall\App\Services;

use Wall\App\Core\DbProvider;
use Wall\App\Exceptions\DatabaseException;

class Post
{
    protected const DEFAULT_POSTS_LIMIT = 10;
    protected const SORT_ORDER = 'DESC';

    /** @var \PDO */
    protected $db;

    public function __construct()
    {
        $this->db = DbProvider::getInstance()->getConnection();
    }

    /** @throws DatabaseException */
    public function addPost(string $username, string $content) : void
    {
        $sql = 'INSERT INTO `posts` 
            SET `content` = :content,`user` = :username
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['content' => $content, 'username' => $username])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        };

    }

    /** @throws DatabaseException */
    public function updatePost(int $postId, string $username, string $content) : void
    {
        $sql = 'UPDATE `posts` 
            SET `content` = :content
            WHERE `user` = :user
            AND `id` = :id
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['content' => $content, 'user' => $username, 'id' => $postId])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        };
    }

    /** @throws DatabaseException */
    public function isEditable(int $postId, string $username) : bool
    {
        $sql = 'SELECT COUNT(*) FROM `posts` 
          WHERE `id` = :id
          AND `user` = :username;
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['id' => $postId, 'username' => $username])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        }

        return (bool)$stmt->fetchColumn();
    }

    public function getList(int $page = null, int $limit = null)
    {
        if($page === null) {
            $page = 1;
        }
        if($limit === null) {
            $limit = static::DEFAULT_POSTS_LIMIT;
        }
        $offset = ($page-1)*$limit;

        $sql = 'SELECT * FROM `posts`'
            . ' ORDER BY `create_date` ' . static::SORT_ORDER
            . ' LIMIT ' . $limit
            . ' OFFSET ' . $offset ;

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute()) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        };

        $posts = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $posts;
    }
}
