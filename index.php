<?php
use Wall\App\Helpers\App;

include(__DIR__ . '/autoload.php');

// Check is development mode enabled
$dev = filter_var(getenv('DEVELOPMENT'), FILTER_VALIDATE_BOOLEAN);
if($dev) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

$command = App::getCommand();

$response = $command->execute();

echo $response;



