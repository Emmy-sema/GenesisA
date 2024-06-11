<?php
// !change default creadentials
require_once __DIR__.'/vendor/autoload.php';
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$host = $_ENV['DB_HOST'];
$port =$_ENV['DB_PORT'];
$db_name = $_ENV['DB_NAME'];
$db_usserName = $_ENV['DB_USSERNAME'];
$db_password = '';
$support = $_ENV['SUPPORT'];
try{
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db_name",$db_usserName,$db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(Exception $e){
    $db_error = (Object)[
        'success' => false,
        'message' => "something is wrong with our servers, please try again later or contact support at $support"
    ];
    echo json_encode($db_error);
    exit;
}
