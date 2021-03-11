<?php

//Access-Control-Allow-Origin : http://localhost:3000
//header("Access-Control-Allow-Origin: *");

//if (isset($_SERVER['HTTP_ORIGIN'])) {
//    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
//} else {
//    header('Access-Control-Allow-Origin: https://rest.lucasbrum.net');
//}

header('Access-Control-Allow-Origin: https://rest.lucasbrum.net');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, X-Auth-Token, Authorization, X-Requested-With');

require dirname(__DIR__) . '/vendor/autoload.php';

ini_set('display_errors', 'On');
error_reporting(E_ALL);

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('CORE', APP . 'Core' . DIRECTORY_SEPARATOR);
define('DB_FILE', ROOT . 'db' . DIRECTORY_SEPARATOR . 'database.sqlite');
define('SQL_FILE', ROOT . 'sql' . DIRECTORY_SEPARATOR . 'database.sql');

$app = new App\Core\Router();