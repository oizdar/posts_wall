<?php
namespace Wall\App\Helper;

use Wall\App\Core\DbProvider;
use Wall\App\Exceptions\AuthorizationException;

class Authorization
{
    /**
     * If (username/email) or password are invalid throws AuthorizationException
     *
     * @param $username string      Can be an e-mail or username
     * @param $password
     * @throws AuthorizationException
     * @return string  Username on success
     */
    public static function verify(string $username, string $password) : string
    {
        $db = DbProvider::getInstance()->getConnection();
        $sql = '
            SELECT * FROM `users` 
            WHERE `username` = :username
            OR `email` = :username
        ';
        $stmt = $db->prepare($sql);
        $stmt->execute(['username' => $username]);

        if($stmt->rowCount() !== 1 ) {
            throw new AuthorizationException('You must be logged');
        };
        $result = $stmt->fetch();

        if(!password_verify($password, $result['password'])) {
            throw new AuthorizationException('Invalid login or password');
        }

        return $result['username'];
    }
}
