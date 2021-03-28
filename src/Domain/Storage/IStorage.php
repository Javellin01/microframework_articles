<?php

namespace App\Domain\Storage;

interface IStorage
{
    public function find(string $table, int $id);

    public function findAll(string $table);

    public function create(string $table, object $entity);

    public function update(string $table, object $entity);

    public function delete(string $table, int $id);
}