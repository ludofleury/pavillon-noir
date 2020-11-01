<?php

namespace App\Character;

use App\Character\Event\CharacterCreated;
use App\Util\EventSourcing\AggregateRoot;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Character extends AggregateRoot
{
    private string $firstname;

    private string $lastname;

    private string $nickname;

    private int $age;

    private bool $gender;

    protected function __construct()
    {
    }

    public static function create(string $firstname, string $lastname, string $nickname, int $age, bool $gender): Character
    {
        $character = new self();
        $character->id = Uuid::uuid4();
        $event = new CharacterCreated($firstname, $lastname, $nickname, $age, $gender);
        $character->apply($event);

        return $character;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    protected function applyCharacterCreated(CharacterCreated $event)
    {
        $this->firstname = $event->getFirstname();
        $this->lastname = $event->getLastname();
        $this->nickname = $event->getNickname();
        $this->age = $event->getAge();
        $this->gender = $event->getGender();
    }
}