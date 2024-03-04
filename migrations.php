<?php
use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

require_once __DIR__ .'/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();



$config = [//global env 
    'db'=>[
        'dsn'=>$_ENV['DB_DSN'],
        'usere'=>$_ENV['DB_USER'],
        'password'=>$_ENV['DB_PASSWORD'],
    ]
];


$app = new Application(__DIR__,$config);

$app->db->applyMigrations(); 