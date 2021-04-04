<?php

namespace App\Domain\Storage;

use App\Domain\Storage\Connection\Connection;
use PDO;

/**
 * Class MySQLStorage
 * @package App\Domain
 */
class MySQLStorage implements IStorage
{
    private $connection;

    /**
     * @param object $entity
     * @return array
     */
    public static function toArray(object $entity): array
    {
        $result = [];

        $arrEntity = (array) $entity;
        // TODO: добавить больше фильтров в зависимости от кодироки базы
        foreach ($arrEntity as $prop => $value) {
            $filteredKey = str_replace(
                get_class($entity),
                '',
                preg_replace('/[\x00-\x1F\x7F]/u', '', $prop)
            );
            $result[$filteredKey] = $value;
        }

        return $result;
    }

    /**
     * MySQLStorage constructor.
     */
    public function __construct()
    {
        $this->connection = Connection::getInstance();
    }

    /**
     * @param string $table
     * @param int $id
     * @return mixed
     */
    public function find(string $table, int $id)
    {
        $stm = $this->connection->prepare('SELECT * FROM ' . $table . ' WHERE id=?');
        $stm->execute([$id]);

        return $stm->fetch(PDO::FETCH_ASSOC);
    }


    /**
     * @param string $table
     * @param string $field
     * @param string $value
     * @return mixed
     */
    public function findBy(string $table, string $field, string $value)
    {
        $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $field . '=?';
        $stm = $this->connection->prepare($sql);
        $stm->execute([$value]);

        return $stm->fetch(PDO::FETCH_OBJ);
    }

    /**
     * @param string $table
     * @return array
     */
    public function findAll(string $table)
    {
        $stm = $this->connection->query('SELECT * FROM ' . $table);

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $table
     * @param object $entity
     */
    public function create(string $table, object $entity)
    {
        $arrEntity = self::toArray($entity);
        unset($arrEntity['id']);
        $propsList = array_keys($arrEntity);

        $sql = 'INSERT INTO ' . $table . ' (' . implode(',', $propsList) . ') VALUES (' .
            implode(
                ',',
                    array_map(function ($item) {
                    return ':' . $item;
                }, $propsList),
            ) . ')';

        $stm = $this->connection->prepare($sql);
        $stm->execute($arrEntity);

        return $this->connection->lastInsertId();
    }

    /**
     * @param string $table
     * @param object $entity
     * @return bool
     */
    public function update(string $table, object $entity)
    {
        $arrEntity = self::toArray($entity);
        $propsList = array_keys($arrEntity);
        $updateParams = [];

        foreach ($propsList as $property) {
            if ($property !== 'id')
            {
                $updateParams[] = "{$property}=:{$property}";
            }
        }

        $sql = 'UPDATE ' . $table . ' SET ' . implode(',', $updateParams) . ' WHERE id=:id';
        $stm = $this->connection->prepare($sql);

        return $stm->execute($arrEntity);
    }

    /**
     * @param string $table
     * @param int $id
     */
    public function delete(string $table, int $id)
    {
        $stm = $this->connection->prepare('DELETE FROM ' . $table . ' WHERE id=?');
        return $stm->execute([$id]);
    }
}