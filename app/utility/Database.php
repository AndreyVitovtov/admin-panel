<?php

namespace App\Utility;

use PDO;

class Database
{
    private $dbh;

    private static $inst = NULL;

    private function __construct()
    {
        $this->dbh = new PDO(
            "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8",
            DB_USERNAME,
            DB_PASSWORD,
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public function getDbh(): PDO
    {
        return $this->dbh;
    }

    public static function instance(): Database
    {
        if (self::$inst != NULL) return self::$inst;
        return self::$inst = new self();
    }
}

