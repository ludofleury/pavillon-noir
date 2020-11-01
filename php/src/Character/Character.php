<?php

namespace App\Character;

class Character
{
    private int $health;

    public function __construct()
    {
        $this->health = 10;
    }

    public function getHealth(): int
    {
        return $this->health;
    }
}