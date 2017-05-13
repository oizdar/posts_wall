<?php
namespace Wall\App\Services;

use Wall\App\Core\DbProvider;
use Wall\App\Exceptions\DatabaseException;
use Wall\App\Exceptions\InvalidArgumentException;

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

    /** @throws DatabaseException */
    public function isEditable(int $postId, int $commentId, string $username) : bool
    {
        $sql = 'SELECT COUNT(*) FROM `comments` 
          WHERE `id` = :id
          AND `post_id` = :postId
          AND `user` = :username;
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['postId' => $postId, 'id' => $commentId, 'username' => $username])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        }

        return (bool)$stmt->fetchColumn();
    }

    /** @throws DatabaseException */
    public function deleteComment(int $postId, int $commentId, string $username) : void
    {
        $sql = 'DELETE `comments` FROM `comments` 
          WHERE `id` = :id
          AND `post_id` = :postId
          AND `user` = :username;
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['postId' => $postId, 'id' => $commentId, 'username' => $username])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        }
    }

    /** @throws DatabaseException */
    public function isCommentExists($commentId) : bool
    {
        $sql = 'SELECT COUNT(*) FROM `comments` WHERE `id` = :commentId';
        $stmt = $this->db->prepare($sql);

        if(!$stmt->execute(['commentId' => $commentId])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        }

        return (bool)$stmt->fetchColumn();
    }

    /** @throws DatabaseException */
    public function likeComment($commentId, $username) : void
    {
        $this->db->beginTransaction();
        $sql = 'INSERT IGNORE INTO `users_likes_comments` 
          SET 
            `username` = :username,
            `comment_id` = :commentId;
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['username' => $username, 'commentId' => $commentId])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        }
        if($stmt->rowCount() === 0) {
            throw new InvalidArgumentException('You already like this comment.');
        }

        $sql = 'UPDATE `comments` 
            SET `likes` = `likes` + 1
            WHERE `id` = :commentId;
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['commentId' => $commentId])) {
            $this->db->rollBack();
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        }

        if(!$this->db->commit()) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        };
    }

    /** @throws DatabaseException */
    public function unlikeComment($commentId, $username) : void
    {
        $this->db->beginTransaction();
        $sql = 'DELETE FROM `users_likes_comments` 
          WHERE `username` = :username 
          AND `comment_id` = :commentId;
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['username' => $username, 'commentId' => $commentId])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        }
        var_dump($stmt->rowCount());
        if($stmt->rowCount() === 0) {
            $this->db->rollBack();
            throw new InvalidArgumentException('You can\'t unlike this comment.');
        }

        $sql = 'UPDATE `comments` 
            SET `likes` = `likes` - 1
            WHERE `id` = :commentId
            AND `likes` > 0;
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['commentId' => $commentId])) {
            $this->db->rollBack();
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        }

        if(!$this->db->commit()) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        };
    }
}
