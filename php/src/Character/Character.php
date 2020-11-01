<?php

namespace App\Character;

use App\Character\Event\CharacterCreated;
use App\Util\EventSourcing\AggregateRoot;

class Character extends AggregateRoot
{
    private string $firstname;

    private string $lastname;

    private string $nickname;

    private int $age;

    private bool $gender;

    private function __construct()
    {
    }

    public static function create(string $firstname, string $lastname, string $nickname, int $age, bool $gender): Character
    {
        $character = new self();
        $event = new CharacterCreated($character->nextSequence() ,$firstname, $lastname, $nickname, $age, $gender);
        $character->stream[] = $event;
        $character->applyCharacterCreated($event);

        return $character;
    }

    public function applyCharacterCreated(CharacterCreated $event)
    {
        $this->firstname = $event->getFirstname();
        $this->lastname = $event->getLastname();
        $this->nickname = $event->getNickname();
        $this->age = $event->getAge();
        $this->gender = $event->getGender();
    }
}