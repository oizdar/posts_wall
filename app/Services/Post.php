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

    /** @throws DatabaseException */
    public function getList(int $page = null, int $limit = null) : array
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

    /**
     * Deletes also related rows
     *
     * @throws DatabaseException
     */
    public function deletePost(int $postId, string $username) : void
    {
        $sql = 'SELECT *
            FROM `posts` AS `p`
            LEFT JOIN `comments` AS `c` ON `c`.`post_id` = `p`.`id`
            LEFT JOIN `users_likes_comments` AS `lc` ON `lc`.`comment_id` = c.`id`
            LEFT JOIN `users_likes_posts` AS `lp` ON `lp`.`post_id` = p.`id`
            WHERE `p`.`user` = :user AND `p`.`id` = :id;
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['user' => $username, 'id' => $postId])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        };
    }

    public function isPostExists(int $postId) : bool
    {
        $sql = 'SELECT COUNT(*) FROM `posts` WHERE `id` = :id';
        $stmt = $this->db->prepare($sql);

        if(!$stmt->execute(['id' => $postId])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        }

        return (bool)$stmt->fetchColumn();
    }
}
