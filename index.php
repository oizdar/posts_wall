<?php
// use declarations

include(__DIR__ . '/autoload.php');

$debug = filter_var(getenv('PHP_DEBUG'), FILTER_VALIDATE_BOOLEAN);
if($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

echo error_reporting();
