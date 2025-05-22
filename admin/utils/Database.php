<?php 


namespace LH\Utils;

class Database{
     private static ?\PDO $instance = null;

    private function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=lhtask';
        $username = 'root';
        $password = '';

        self::$instance = new \PDO($dsn, $username, $password);
        self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): \PDO
    {
        if (!self::$instance) {
            new self();
        }
        return self::$instance;
    }
}