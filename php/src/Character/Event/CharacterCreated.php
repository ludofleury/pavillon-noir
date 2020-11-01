<?php

namespace App\Character\Event;

use App\Util\EventSourcing\Event;

class CharacterCreated implements Event
{
    private string $firstname;

    private string $lastname;

    private string $nickname;

    private int $age;

    private bool $gender;

    // private string $background;
    // private array $characteristics;
    // private array $skills;/**

    public function __construct(string $firstname, string $lastname, string $nickname, int $age, bool $gender)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->nickname = $nickname;
        $this->age = $age;
        $this->gender = $gender;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function isMale(): bool
    {
        return $this->gender;
    }

    public function isFemale(): bool
    {
        return !$this->gender;
    }

    public function getGender(): bool
    {
        return $this->gender;
    }

    public function toArray(): array
    {
        return  [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'nickname' => $this->nickname,
            'age' => $this->age,
            'gender' => $this->gender,
        ];
    }

    static public function fromArray(array $data): self
    {
        return new self(
            $data['firstname'],
            $data['lastname'],
            $data['nickname'],
            $data['age'],
            $data['gender'],
        );
    }

}