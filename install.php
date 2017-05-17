<?php
include 'autoload.php';

$db = \Wall\App\Core\DbProvider::getInstance()->getConnection();

$sql = file_get_contents(__DIR__ . '/schema.sql');

$stmt = $db->prepare($sql);
echo "\n---------------------------------\n";

try {
    $stmt->execute();
    echo "\n    Database tables successfully created.\n";
} catch (\Exception $e) {
    $trace = json_encode($e->getTrace());

    echo "\n\t Error occurred: 
    \n\t Code: \"{$e->getCode()}\"
    \n\t Message: \"{$e->getMessage()}\"
    \n---------------------------------\n";
    exit();
};

echo "\n---------------------------------\n";

echo "\nDo you want to load also example data? Yes|No (default N):";
$handle = fopen ("php://stdin","r");
$line = strtolower(trim(fgets($handle)));

echo "\n---------------------------------\n";
if($line !== 'yes' && $line !== 'y'){
    echo "\n    Fixtures didn't loaded!
    \n---------------------------------\n";
    exit;
}


$sql = file_get_contents(__DIR__ . '/fixtures.sql');

$stmt = $db->prepare($sql);
try {
    $stmt->execute();
    echo "\n    Inserted example data. \n";
} catch (\Exception $e) {
    $trace = json_encode($e->getTrace());

    echo "\n\t Error occurred: 
    \n\t Code: \"{$e->getCode()}\"
    \n\t Message: \"{$e->getMessage()}\"
    \n---------------------------------\n";
    exit();
};

    echo "\n---------------------------------\n";
