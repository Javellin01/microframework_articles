<?php

namespace App\Domain\Repository;

use App\Domain\Entity\User;

interface IUserRepository
{
    public function get(int $id);

    public function all();

    public function add(User $User);

    public function update(User $User);

    public function remove(int $id);
}