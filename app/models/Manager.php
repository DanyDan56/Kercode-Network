<?php 

namespace Knetwork\Models;

if($_SERVER['HTTP_HOST'] != "coffee-k6.herokuapp.com"){
    $dotenv = \Dotenv\Dotenv::createImmuTable("./");
    $dotenv->load();
}

class Manager
{
    protected static function connect(): \PDO
    {
        $servername = "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8";
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        
        try {
            $pdo = new \PDO($servername, $username, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            return $pdo;
        } catch (\Exception $e) {
            require 'app/views/front/error.php';
        }
    }

    protected function dbConnect(): \PDO
    {
        $servername = "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8";
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];
        
        try {
            $pdo = new \PDO($servername, $username, $password, array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            return $pdo;
        } catch (\Exception $e) {
            require 'app/views/front/error.php';
        }
    }
}
