<?php
namespace Wall\App\Services;

use Wall\App\Core\DbProvider;

class User
{
    /** @var \PDO */
    protected $db;

    public function __construct()
    {
        $this->db = DbProvider::getInstance()->getConnection();
    }

    public function IsEmailExists($email) : bool
    {
        $sql = 'SELECT count(*) FROM `users` WHERE `email` = :email';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);

        return (bool)$stmt->fetchColumn();
    }

    public function IsUsernameExists($username) : bool
    {
        $sql = 'SELECT count(*) FROM `users` WHERE `username` = :username';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username]);

        return (bool)$stmt->fetchColumn();
    }

    public function addUser(string $email, string $username, string $password) : bool
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO `users` 
          SET 
            `email` = :email,
            `username` = :username,
            `password` = :passwordHash;
        ';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'email' => $email,
            'username' => $username,
            'passwordHash' => $passwordHash,
        ]);

        return (bool)$stmt->fetchColumn();
    }


}
