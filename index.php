<?php
use Wall\App\Helpers\Request;

include(__DIR__ . '/autoload.php');

// Check is development mode enabled
$dev = filter_var(getenv('DEVELOPMENT'), FILTER_VALIDATE_BOOLEAN);
if($dev) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}


$method = Request::getMethod();
$path = Request::getPath();

var_dump($method, $path);


