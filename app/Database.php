<?php

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $host = '127.0.0.1';
        $dbname = 'biblioteca';
        $username = 'root';
        $password = '';
        
        $this->connection = new PDO(
            "mysql:host=$host;dbname=$dbname;charset=utf8",
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
