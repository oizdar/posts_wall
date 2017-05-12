<?php
include 'autoload.php';

$db = \Wall\App\DbProvider::getInstance()->getConnection();

$sql = file_get_contents(__DIR__ . 'schema.sql');

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
