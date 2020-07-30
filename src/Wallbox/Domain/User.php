<?php

declare(strict_types=1);

namespace Wallbox\Domain;

use Doblio\Core\Messaging\Annotation\CommandHandler;
use Doblio\Core\ValueObject\DateTime\DateTime;
use Doblio\Core\ValueObject\Geography\CountryCode;
use Doblio\Core\ValueObject\Web\EmailAddress;
use Doblio\Domain\AggregateRoot;
use Doblio\Domain\AggregateRootTrait;
use Doblio\Domain\Behavior\Timestampable;
use Wallbox\Domain\Command\CreateUser;
use Wallbox\Domain\Command\UpdateUser;
use Wallbox\Domain\Event\UserCreated;
use Wallbox\Domain\Event\UserUpdated;

class User implements AggregateRoot
{
    use AggregateRootTrait;
    use Timestampable;

    private int $externalId;
    private string $name;
    private string $surname;
    private EmailAddress $email;
    private CountryCode $country;
    private int $chargerId;
    private DateTime $activatedAt;

    /**
     * @CommandHandler
     */
    public function __construct(CreateUser $command)
    {
        $this->recordThat(
            new UserCreated(
                $command->id(),
                $command->externalId(),
                $command->name(),
                $command->surname(),
                $command->email(),
                $command->country(),
                $command->chargerId(),
                $command->createdAt(),
                $command->activatedAt()
            )
        );
    }

    /**
     * @CommandHandler
     */
    public function update(UpdateUser $command)
    {
        $this->recordThat(
            new UserUpdated(
                $command->id(),
                $command->name(),
                $command->surname(),
                $command->email(),
                $command->country(),
                $command->chargerId()
            )
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    private function whenUserCreated(UserCreated $event)
    {
        $this->id = $event->id();
        $this->externalId = $event->externalId();
        $this->name = $event->name();
        $this->surname = $event->surname();
        $this->email = $event->email();
        $this->country = $event->country();
        $this->chargerId = $event->chargerId();

        $this->createdAt = $event->createdAt();
        $this->updatedAt = $event->createdAt();
        $this->activatedAt = $event->activatedAt();
    }

    private function whenUserUpdated(UserUpdated $event)
    {
        $this->name = $event->name();
        $this->surname = $event->surname();
        $this->email = $event->email();
        $this->country = $event->country();
        $this->chargerId = $event->chargerId();

        $this->updatedAt = DateTime::now();
    }
}
