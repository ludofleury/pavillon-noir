<?php

namespace App\Character;

use App\Character\Event\CharacterCreated;

class Character
{
    private string $firstname;

    private string $lastname;

    private string $nickname;

    private int $age;

    private bool $gender;

    private array $_events;

    private function __construct()
    {
    }

    public static function createCharacter(string $firstname, string $lastname, string $nickname, int $age, bool $gender): Character
    {
        $character = new self();
        $event = new CharacterCreated($character->firstname, $character->lastname, $character->nickname, $character->age, $character->gender);
        $character->_events[] = $event;
        $character->applyCharacterCreated($event);

        return $character;
    }

    public function applyCharacterCreated(CharacterCreated $event)
    {
        $this->firstname = $event->getFirstname();
        $this->lastname = $event->getLastname();
        $this->nickname = $event->getNickname();
        $this->age = $event->getAge();
        $this->gender = $event->isGender();
    }
}