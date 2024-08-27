<?php

use Src\Api\HttpHandler;
use Dotenv\Dotenv;
use Src\Db;

require_once 'vendor/autoload.php';
require_once 'src/Api/HttpHandler.php';

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$host = getenv('DB_HOST');
$dbName = getenv('DB_NAME');

$dbDriver = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
$db = new Db($dbDriver);

$httpHandler = new HttpHandler($db);
$httpHandler->handle();

$dbDriver = null;
