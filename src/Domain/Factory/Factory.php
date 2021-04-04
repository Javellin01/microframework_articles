<?php


namespace App\Domain\Factory;

use samdark\hydrator\Hydrator;

abstract class Factory implements IFactory
{
    public static function createFromArray(array $arr)
    {
        $self = new static();

        $class = $self->getEntityClass();
        $new = new $class;
        $hydrator = new Hydrator($self->getHydrateMap());
        $entity = $hydrator->hydrateInto($arr, $new);

        unset($self);

        return $entity;
    }

    public static function getEntityProperties($entity): array
    {
        $result = [];
        $reflect = new \ReflectionClass($entity);

        foreach ($reflect->getProperties() as $property) {
            $result[] = $property->getName();
        }

        return $result;
    }

    protected function getHydrateMap(): array
    {
        $map = [];

        foreach ($this->getEntityProperties($this->getEntityClass()) as $property) {
            $map[$property] = $property;
        }

        return $map;
    }

    /**
     * @return string
     */
    abstract protected function getEntityClass();


}