<?php
define("DB_NAME", "HTTPDB");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_HOST", "localhost");


define("_ROOT", "http://localhost/Htt/");


class Database
{
    private static $conn;

    public static function getConnection()
    {
        if (self::$conn === null) {
            $dsn = 'mysql:host=localhost;dbname=' . DB_NAME;
            self::$conn = new PDO($dsn, DB_USER, DB_PASSWORD);
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}
