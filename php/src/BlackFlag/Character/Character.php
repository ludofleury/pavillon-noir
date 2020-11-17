<?php

namespace BlackFlag\Character;

use BlackFlag\Character\Event\CharacterCreated;
use EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class Character extends AggregateRoot
{
    private string $firstname;

    private string $lastname;

    private string $nickname;

    private int $age;

    private bool $gender;

    private Attributes $attributes;

    protected function __construct()
    {
    }

    public static function create(
        string $firstname,
        string $lastname,
        string $nickname,
        int $age,
        bool $gender,
        array $attributes
    ): Character {
        $character = new self();
        $character->id = Uuid::uuid4();

        $event = new CharacterCreated(
            $firstname,
            $lastname,
            $nickname,
            $age,
            $gender,
            $attributes
        );
        $character->apply($event);

        return $character;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    protected function applyCharacterCreated(CharacterCreated $event): void
    {
        $this->firstname = $event->getFirstname();
        $this->lastname = $event->getLastname();
        $this->nickname = $event->getNickname();
        $this->age = $event->getAge();
        $this->gender = $event->getGender();
        $this->attributes = new Attributes($this);
    }
}