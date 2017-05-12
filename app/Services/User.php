<?php
namespace Wall\App\Services;

use Wall\App\Core\DbProvider;
use Wall\App\Exceptions\DatabaseException;

class User
{
    /** @var \PDO */
    protected $db;

    public function __construct()
    {
        $this->db = DbProvider::getInstance()->getConnection();
    }

    /** @throws DatabaseException */
    public function IsEmailExists($email) : bool
    {
        $sql = 'SELECT count(*) FROM `users` WHERE `email` = :email';
        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute(['email' => $email])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');

        };

        return (bool)$stmt->fetchColumn();
    }

    /** @throws DatabaseException */
    public function IsUsernameExists($username) : bool
    {
        $sql = 'SELECT count(*) FROM `users` WHERE `username` = :username';
        $stmt = $this->db->prepare($sql);
        if($stmt->execute(['username' => $username])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        };

        return (bool)$stmt->fetchColumn();
    }

    /** @throws DatabaseException */
    public function addUser(string $email, string $username, string $password) : void
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO `users` 
          SET `email` = :email, `username` = :username, `password` = :passwordHash;
        ';

        $stmt = $this->db->prepare($sql);
        if(!$stmt->execute([
            'email' => $email,
            'username' => $username,
            'passwordHash' => $passwordHash,
        ])) {
            throw new DatabaseException('Database error occurred, try again later or contact administrator.');
        };
    }


}
