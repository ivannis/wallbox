<?php

namespace Common\Infrastructure\Normalizer;

use Hyperf\Utils\Collection;

class CollectionNormalizer implements Normalizer
{
    private Collection $collection;
    private string $className;

    public function __construct(Collection $collection, string $className)
    {
        $this->collection = $collection;
        $this->className = $className;
    }

    public function toArray(): array
    {
        return $this->collection->map(function ($item) {
            return (new $this->className($item))->toArray();
        })->values()->all();
    }
}
