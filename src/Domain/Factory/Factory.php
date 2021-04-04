<?php


namespace App\Domain\Factory;

use samdark\hydrator\Hydrator;

abstract class Factory implements IFactory
{
    /**
     * @param array $arr
     * @return object
     */
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

    /**
     * @param $entity
     * @return array
     */
    public static function getEntityProperties($entity): array
    {
        $result = [];
        $reflect = new \ReflectionClass($entity);

        foreach ($reflect->getProperties() as $property) {
            $result[] = $property->getName();
        }

        return $result;
    }

    /**
     * @return array
     */
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