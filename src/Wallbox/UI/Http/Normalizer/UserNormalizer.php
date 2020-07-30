<?php

declare(strict_types=1);

namespace Wallbox\UI\Http\Normalizer;

use Common\Infrastructure\Normalizer\ObjectNormalizer;
use Wallbox\Domain\View\User;

/**
 * @property User $object
 */
class UserNormalizer extends ObjectNormalizer
{
    public function __construct(User $object)
    {
        parent::__construct($object);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->object->externalId(),
            'name' => $this->object->name(),
            'surname' => $this->object->surname(),
            'email' => (string) $this->object->email(),
            'country' => (string) $this->object->country(),
            'createAt' => $this->object->createdAt()->format('Ymd'),
            'activateAt' => $this->object->activatedAt()->format('Ymd'),
            'chargerId' => $this->object->chargerId(),
        ];
    }
}
