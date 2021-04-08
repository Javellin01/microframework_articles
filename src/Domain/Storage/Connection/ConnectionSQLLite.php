<?php

namespace App\Domain\Storage\Connection;

use PDO;
use PDOException;

/**
 * Class Connection
 * @package App\Domain\Storage\Connection
 */
final class ConnectionSQLLite
{
    private static $instance;
    private static $dbInfo = [
        'database' => 'sqllidatabase',
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
                    'sqlite:' . BASEPATH . '/' .self::$dbInfo['database'] . '.db'
                );
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