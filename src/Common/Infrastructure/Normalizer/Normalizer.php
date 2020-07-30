<?php

namespace Common\Infrastructure\Normalizer;

interface Normalizer
{
    /**
     * @return mixed|array
     */
    public function toArray();
}
