<?php

abstract class Connection
{

    private static $connection;
    private const CONFIGURATION = [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => 'proyecto1',
        'port' => '3306',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL
        ]
    ];

    private static function connect()
    {
        try {
            $controller = self::CONFIGURATION['driver'];
            $server = self::CONFIGURATION['host'];
            $db_name = self::CONFIGURATION['database'];
            $port = self::CONFIGURATION['port'];
            $user = self::CONFIGURATION['username'];
            $password = self::CONFIGURATION['password'];
            $charset = self::CONFIGURATION['charset'];
            $options = self::CONFIGURATION['options'];

            $url = "{$controller}:host={$server}:{$port};"
                . "dbname={$db_name};charset={$charset}";

            self::$connection = new PDO($url, $user, $password, $options);
        } catch (PDOException $exc) {
            echo 'Error de conexion: ' . $exc->getMessage();
        }
    }

    public static function getConnection()
    {
        if (self::$connection === null) {
            self::connect();
        }
        return self::$connection;
    }
}

