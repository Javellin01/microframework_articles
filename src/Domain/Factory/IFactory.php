<?php


namespace App\Domain\Factory;


interface IFactory
{
    public static function createFromArray(array $arr);
}