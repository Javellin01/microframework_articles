<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;
use App\Domain\Factory\UserFactory;
use App\Domain\Storage\SQLLiteStorage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $this->storage = new SQLLiteStorage();
    }

    /**
     * @param int $id
     * @return User
     */
    public function get(int $id): ?User
    {
        $queryResult = $this->storage->find(self::ENTITY, $id);
        if (!$queryResult)
        {
            throw new NotFoundHttpException('No such user');
        }
        $user = UserFactory::createFromArray($queryResult);

        return ($user instanceof User) ? $user : null;
    }

    public function getBy(string $field, string $value): ?User
    {
        $user = null;
        $queryResult = $this->storage->findBy(self::ENTITY, $field, $value);

        if ($queryResult)
        {
            $user = UserFactory::createFromArray($queryResult);
        }

        return ($user instanceof User) ? $user : null;
    }

    public function all()
    {
        // TODO: Implement all() method.
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