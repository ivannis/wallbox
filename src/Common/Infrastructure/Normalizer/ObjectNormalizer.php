<?php

namespace Common\Infrastructure\Normalizer;

use Hyperf\Utils\Collection;

abstract class ObjectNormalizer implements Normalizer
{
    protected $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    public static function make($object)
    {
        return (new static($object))->toArray();
    }

    public static function collection($collection): array
    {
        $collection = $collection instanceof Collection ? $collection : new Collection($collection);

        return (new CollectionNormalizer($collection, static::class))->toArray();
    }
}
