<?php

namespace App\Domain\Storage\Connection;

use PDO;
use PDOException;

/**
 * Class Connection
 * @package App\Domain\Storage\Connection
 */
final class Connection
{
    private static $instance;
    private static $dbInfo = [
        'host' => 'localhost',
        'port' => 33060,
        'database' => 'homestead',
        'user' => 'homestead',
        'pass' => 'secret',
//        'pass' => 'K2dt9D%wh9IL3bKO%uBB',
        'charset' => 'utf8',
    ];

    /**
     * @return PDO
     */
    public static function getInstance(): ?PDO
    {
        if(empty(self::$instance)) {
            try {
                self::$instance = new PDO(
                    "mysql:host=".self::$dbInfo['host'] . ';port='. self::$dbInfo['port'] . ';dbname='. self::$dbInfo['database'],
                    self::$dbInfo['user'],
                    self::$dbInfo['pass']);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
                self::$instance->query('SET NAMES ' . self::$dbInfo['charset']);
                self::$instance->query('SET CHARACTER SET ' . self::$dbInfo['charset']);
            } catch(PDOException $error) {
                echo $error->getMessage();
            }
        }
        return self::$instance;
    }
}