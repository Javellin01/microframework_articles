<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Storage\MySQLStorage;

/**
 * Class UserRepository
 * @package App\Domain
 */
class UserRepository implements IUserRepository
{
    const ENTITY = 'users';
    protected $storage;

    /**
     * UserRepository constructor.
     */
    public function __construct()
    {
        $this->storage = new MySQLStorage();
    }

    /**
     * @param int $id
     * @return User
     */
    public function get(int $id): User
    {
        $queryResult = $this->storage->find(self::ENTITY, $id);

        $result = new User();
        $result
            ->setId($queryResult->id)
            ->setTitle($queryResult->title)
            ->setText($queryResult->text);

        return $result;
    }

    public function getBy(string $field, string $value): ?User
    {
        $queryResult = $this->storage->findBy(self::ENTITY, $field, $value);

        $result = false;
        if ($queryResult) {
            $result = new User();
            $result
                ->setId($queryResult->id)
                ->setLogin($queryResult->login)
                ->setPassword($queryResult->password);
        }

        return $result;
    }


    /**
     * @return array
     */
    public function all(): array
    {
        $queryResult = $this->storage->findAll(self::ENTITY);
        $result = [];

        foreach ($queryResult as $resItem) {
            $User = new User();
            $User
                ->setId($resItem->id)
                ->setTitle($resItem->title)
                ->setText($resItem->text);
            $result[] = $User;
        }

        return $result;
    }

    public function add(User $user)
    {
        return $this->storage->create(self::ENTITY, $user);
    }

    /**
     * @param User $User
     * @return mixed
     */
    public function update(User $User)
    {
        return $this->storage->update(self::ENTITY, $User);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function remove(int $id)
    {
        return $this->storage->delete(self::ENTITY, $id);
    }

    public function getPasswordHash(int $userId): ?string
    {
        $user = $this->storage->find(self::ENTITY, $userId);

        return $user->password;
    }
}