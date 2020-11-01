<?php

namespace App\Character\Event;

use App\Util\EventSourcing\Event;

class CharacterCreated extends Event
{
    private string $firstname;

    private string $lastname;

    private string $nickname;

    private string $age;

    private bool $gender;

    // private string $background;
    // private array $characteristic;
    // private array $skills;/**

    public function __construct(string $firstname, string $lastname, string $nickname, string $age, bool $gender)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->nickname = $nickname;
        $this->age = $age;
        $this->gender = $gender;
    }
}