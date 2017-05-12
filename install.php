<?php
include 'autoload.php';

$db = \Wall\App\DbProvider::getInstance()->getConnection();

$sql = '
    CREATE TABLE IF NOT EXISTS `posts`
    (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `content` TEXT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    
    CREATE TABLE IF NOT EXISTS `comments`
    (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `post_id` INT UNSIGNED NOT NULL,
        `content` TEXT NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
';

$stmt = $db->prepare($sql);
echo "\n---------------------------------\n";

try {
    $stmt->execute();
} catch (\Exception $e) {
    $trace = json_encode($e->getTrace());

    echo "\n\t Error occurred: 
    \n\t Code: \"{$e->getCode()}\"
    \n\t Message: \"{$e->getMessage()}\"
    \n---------------------------------\n";
    exit();
};

echo "\n    Database tables successfully created.\n
    \n---------------------------------\n";
