<?php

namespace App\Domain\Entity;

use App\Domain\Repository\UserRepository;

class User
{
    private $id;
    private $login;
    private $password;
    private $email;
    private $remember;
    private $isAdmin;

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword(): string
    {
        return $this->password;
    }


    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemember()
    {
        return $this->remember;
    }

    /**
     * @param string $remember
     */
    public function setRemember(string $remember): self
    {
        $this->remember = $remember;

        return $this;
    }

    /**
     * @return boolean
     */
    public function checkPrivileges(): bool
    {
        return $this->isAdmin === '1';
    }


}