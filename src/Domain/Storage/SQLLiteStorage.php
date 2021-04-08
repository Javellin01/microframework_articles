<?php

namespace App\Domain\Storage;
use App\Domain\Storage\Connection\ConnectionSQLLite;

class SQLLiteStorage extends MySQLStorage
{
    /**
     * SQLLiteStorage constructor.
     */
    public function __construct()
    {
        $this->connection = ConnectionSQLLite::getInstance();
    }
}